<!DOCTYPE html>
<html>
<head>
    <title>Pagamento Confirmado</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        
        <h1 style="color: #059669; text-align: center;">Pagamento Recebido! 🎉</h1>
        
        <p style="font-size: 16px; color: #333;">Olá, <strong>{{ $list->user->name }}</strong>!</p>
        
        <p style="font-size: 16px; color: #555; line-height: 1.5;">
            Temos ótimas notícias. O pagamento da taxa de ativação da sua lista <strong>"{{ $list->display_name }}"</strong> foi confirmado.
        </p>

        <div style="background-color: #ecfdf5; border: 1px solid #a7f3d0; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
            <p style="margin: 0; color: #065f46; font-weight: bold;">Status: PLANO ATIVO (1 ANO)</p>
            <p style="margin: 5px 0 0 0; color: #065f46; font-size: 14px;">Válido até: {{ \Carbon\Carbon::parse($list->plano_expires_at)->format('d/m/Y') }}</p>
        </div>

        <p style="font-size: 16px; color: #555;">
            Sua lista já está pública e pronta para receber presentes dos seus convidados.
        </p>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('dashboard') }}" style="background-color: #059669; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px;">
                Acessar meu Painel
            </a>
        </div>

        <hr style="margin-top: 40px; border: none; border-top: 1px solid #eee;">
        
        <p style="font-size: 12px; color: #999; text-align: center;">
            Se você não reconhece este pagamento, entre em contato conosco.<br>
            Equipe Pixlist.
        </p>
    </div>
</body>
</html>