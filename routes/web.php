<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ListConfigController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\PublicListController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController; // Import correto

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS (Visitantes)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/lista/{list}/{slug?}', [PublicListController::class, 'show'])
     ->name('list.public.show');

Route::post('/lista/{list}/rsvp', [RsvpController::class, 'store'])
     ->name('list.public.rsvp');

Route::post('/pagar/{gift}', [PublicListController::class, 'pay'])
    ->name('public.gift.pay');


/*
|--------------------------------------------------------------------------
| ROTAS DE AUTENTICAÇÃO (Login, Cadastro)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ROTAS PRIVADAS - PARTE 1 (Acesso Básico)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Onboarding
    Route::get('/onboarding', [OnboardingController::class, 'create'])->name('onboarding.create');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Paywall / Plano
    Route::get('/plano', function() {
        $user = auth()->user();
        $list = $user->list ?? null;

        // Lógica de acesso atualizada
        $planoAtivo = false;
        if ($list) {
            $planoAtivo = $list->plano_pago &&
                          $list->plano_expires_at &&
                          \Carbon\Carbon::parse($list->plano_expires_at)->isFuture();
        }

        if ($planoAtivo) {
            return redirect()->route('dashboard');
        }

        return view('plano.index', ['list' => $list]);
    })->name('plano.index');

    Route::get('/plano/pagar', [PaymentController::class, 'createPayment'])->name('plano.pagar');
    Route::get('/plano/sucesso', [PaymentController::class, 'paymentSuccess'])->name('plano.sucesso');
});

/*
|--------------------------------------------------------------------------
| WEBHOOKS (sem auth/CSRF)
|--------------------------------------------------------------------------
*/
Route::post('/webhook/mercadopago', [PaymentController::class, 'handleWebhook'])
    ->name('webhook.mercadopago');

/*
|--------------------------------------------------------------------------
| ROTAS PRIVADAS - PARTE 2 (Painel Admin Completo)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'checklist'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/dismiss-tutorial', [DashboardController::class, 'dismissTutorial'])
         ->name('dashboard.dismiss-tutorial');

    // --- RSVP (Admin) ---
    Route::get('/rsvp', [RsvpController::class, 'index'])->name('rsvp.index');
    Route::post('/rsvp', [RsvpController::class, 'adminStore'])->name('rsvp.admin.store');
    Route::resource('rsvp', RsvpController::class)
        ->only(['edit','update','destroy'])
        ->names('rsvp');

        // --- RSVP (Admin) ---
    Route::get('/rsvp', [RsvpController::class, 'index'])->name('rsvp.index');

    // [NOVA LINHA]
    Route::get('/rsvp/exportar-pdf', [RsvpController::class, 'exportPdf'])->name('rsvp.export.pdf');
    // [FIM DA NOVA LINHA]

    Route::post('/rsvp', [RsvpController::class, 'adminStore'])->name('rsvp.admin.store');
    Route::resource('rsvp', RsvpController::class)
        ->only(['edit','update','destroy'])
        ->names('rsvp');

    // --- Restante do painel ---
    Route::get('/configuracoes', [ListConfigController::class, 'edit'])->name('list.config.edit');
    Route::post('/configuracoes', [ListConfigController::class, 'update'])->name('list.config.update');

    Route::resource('presentes', GiftController::class);

    // Extrato e Aprovação de Mensagens
    Route::get('/extrato', [TransactionController::class, 'index'])->name('extrato.index');
    Route::post('/extrato/approve/{transaction}', [TransactionController::class, 'approve'])
         ->name('extrato.approve');

    // Compartilhar
    Route::get('/compartilhar', function () {
        $list = auth()->user()->list;
        return view('compartilhar', ['list' => $list]);
    })->name('list.share');

    // [ROTAS DE FEEDBACK - LUGAR CORRETO]
    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

});
// Rota para ZERAR o banco de dados
Route::get('/zerar-tudo-perigo', function () {
    // O comando migrate:fresh apaga todas as tabelas e cria de novo
    // O comando --force é necessário porque estamos em produção
    Illuminate\Support\Facades\Artisan::call('migrate:fresh --force');

    return 'Banco de dados zerado e reconstruído com sucesso! Pode criar sua conta agora.';
});
