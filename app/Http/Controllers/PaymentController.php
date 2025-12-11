<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail; // Importante para o E-mail
use App\Mail\PlanActivated;          // Importante para o E-mail

// Mercado Pago SDK
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;

class PaymentController extends Controller
{
    /**
     * PASSO 1: Criar o pagamento PIX e mostrar pro usuário
     */
    public function createPayment(Request $request)
    {
        $list = $request->user()->list;

        // Se já pagou, manda pro dashboard
        if ($list->plano_pago) {
            return redirect()
                ->route('dashboard')
                ->with('status', 'Seu plano já está ativo!');
        }

        $paymentAmount = 39.90;// Valor do Plano

        try {
            // 1. Configurar credencial
            MercadoPagoConfig::setAccessToken(config('mercadopago.access_token'));

            // 2. Criar client
            $client = new PaymentClient();

            // 3. Montar dados do pagamento
            $paymentData = [
                'transaction_amount' => $paymentAmount,
                'description'        => 'Ativação Pixlist: ' . $list->display_name,
                'payment_method_id'  => 'pix',
                'payer' => [
                    'email' => $request->user()->email,
                    'first_name' => $request->user()->name,
                    // Alguns bancos pedem identificação
                    'identification' => [
                        'type' => 'CPF',
                        'number' => '19100000000' // CPF Genérico para facilitar, ou peça no cadastro
                    ]
                ],
                'notification_url' => route('webhook.mercadopago'),
                'external_reference' => (string) $list->id,
            ];

            // 4. Criar pagamento na API
            $payment = $client->create($paymentData);

            // 5. Pegar QR Code
            $pixData = $payment->point_of_interaction->transaction_data;
            $qrCodeBase64 = $pixData->qr_code_base64;
            $qrCodeCopyPaste = $pixData->qr_code;

            // 6. Mostrar tela
            return view('plano.show_pix', [
                'qrCodeBase64'    => $qrCodeBase64,
                'qrCodeCopyPaste' => $qrCodeCopyPaste,
                'list'            => $list,
                'amount'          => $paymentAmount,
            ]);

        } catch (MPApiException $e) {
            // Erros da API do MP
            $apiResponse = $e->getApiResponse();
            $content = $apiResponse ? $apiResponse->getContent() : null;
            Log::error('Erro API MP:', ['msg' => $e->getMessage(), 'body' => $content]);

            return redirect()->route('plano.index')->withErrors(['msg' => 'Erro ao conectar com Mercado Pago. Tente novamente.']);

        } catch (\Exception $e) {
            // Erros gerais
            Log::error('Erro Geral Pagamento: '.$e->getMessage());
            return redirect()->route('plano.index')->withErrors(['msg' => 'Ocorreu um erro inesperado.']);
        }
    }

    /**
     * PASSO 2: Webhook (Recebe o aviso, ativa plano e manda e-mail)
     */
    public function handleWebhook(Request $request)
    {
        // --- Validação de Segurança (Assinatura) ---
        $xSignature = $request->header('x-signature');
        $xRequestId = $request->header('x-request-id');

        // Separa ts e v1
        $parts = explode(',', $xSignature);
        $ts = null; $v1 = null;
        foreach ($parts as $part) {
            $item = explode('=', $part);
            if (trim($item[0]) === 'ts') $ts = trim($item[1]);
            if (trim($item[0]) === 'v1') $v1 = trim($item[1]);
        }

        $secret = config('mercadopago.webhook_secret');
        $manifest = "id:{$request->input('data.id')};request-id:$xRequestId;ts:$ts;";
        $hmac = hash_hmac('sha256', $manifest, $secret);

        // Nota: Em produção rigorosa, descomente o IF abaixo para bloquear ataques.
        // if ($v1 !== $hmac) { Log::warning('Assinatura inválida'); return response()->json(['error' => 'Invalid'], 403); }

        // --- Processamento ---
        $topic = $request->input('type') ?? $request->input('topic');
        $paymentId = $request->input('data.id') ?? $request->input('id');

        // Se for um pagamento
        if (($topic === 'payment' || $topic === 'ipn') && $paymentId) {
            try {
                MercadoPagoConfig::setAccessToken(config('mercadopago.access_token'));
                $client = new PaymentClient();
                $payment = $client->get($paymentId);

                // Verifica se APROVADO e valor correto
                if ($payment->status === 'approved' && (float)$payment->transaction_amount >= 39.90) {

                    $listId = $payment->external_reference;
                    $list = ListModel::with('user')->find($listId); // Carrega user para o e-mail

                    // Se a lista existe e ainda não está paga
                    if ($list && !$list->plano_pago) {

                        // 1. ATIVA NO BANCO
                        $list->update([
                            'plano_pago' => true,
                            'plano_expires_at' => now()->addYear()
                        ]);

                        Log::info("Plano #{$listId} ATIVADO via Webhook.");

                        // 2. ENVIA O E-MAIL DE BOAS-VINDAS
                        try {
                            Mail::to($list->user->email)->send(new PlanActivated($list));
                            Log::info("E-mail enviado para: " . $list->user->email);
                        } catch (\Exception $e) {
                            Log::error("Falha ao enviar e-mail: " . $e->getMessage());
                            // Não paramos o fluxo, o importante é ter ativado o plano.
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Erro Webhook: '.$e->getMessage());
            }
        }

        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * PASSO 3: Tela de Sucesso (Acessada se o JS recarregar a página)
     */
    public function paymentSuccess(Request $request)
    {
        $list = $request->user()->list;

        if ($list->plano_pago) {
            return view('plano.sucesso');
        }

        return redirect()->route('plano.index')->with('status', 'pagamento-processando');
    }
}
