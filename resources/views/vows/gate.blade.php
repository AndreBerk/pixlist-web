<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Restrito - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-dots { background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 20px 20px; }
    </style>
</head>
<body class="h-screen w-full flex items-center justify-center bg-slate-50 relative overflow-hidden">

    {{-- Fundo Decorativo --}}
    <div class="absolute inset-0 bg-dots opacity-40"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-indigo-200/30 rounded-full blur-[100px] -mt-20 pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-pink-200/30 rounded-full blur-[100px] pointer-events-none"></div>

    {{-- Cartão Central --}}
    <div class="relative z-10 w-full max-w-md p-6">

        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 p-8 md:p-10 text-center relative overflow-hidden">

            {{-- Barra de topo colorida --}}
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

            {{-- Ícone --}}
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-inner ring-4 ring-white">
                <i data-lucide="lock" class="w-8 h-8"></i>
            </div>

            <h1 class="text-2xl font-black text-slate-800 tracking-tight mb-2">
                Área Restrita
            </h1>

            <p class="text-slate-500 text-sm leading-relaxed mb-6">
                O documento <strong>"{{ $title }}"</strong> é confidencial. <br>
                Digite o PIN de 4 dígitos para desbloquear.
            </p>

            {{-- Formulário --}}
            <form method="POST" action="{{ url()->current() }}" class="space-y-6" autocomplete="off">
                @csrf

                <div class="space-y-2">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="key-round" class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input
                            type="password"
                            name="pin"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            maxlength="4"
                            placeholder="• • • •"
                            required
                            autofocus
                            class="block w-full rounded-xl border-gray-200 bg-gray-50/50 pl-12 pr-4 py-4 text-center text-3xl font-bold tracking-[0.5em] text-slate-800 placeholder-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none"
                        >
                    </div>

                    {{-- Botão Esqueci a senha --}}
                    <div class="text-right">
                        <button type="button" onclick="enviarCodigo()" id="btnEsqueci" class="text-xs font-semibold text-indigo-500 hover:text-indigo-700 transition underline underline-offset-2">
                            Esqueci meu PIN
                        </button>
                    </div>
                </div>

                {{-- Exibe erro se houver --}}
                @if($errors->any())
                    <div class="p-3 bg-red-50 text-red-600 text-xs font-bold rounded-lg flex items-center justify-center gap-2 animate-pulse">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        <span>PIN incorreto. Tente novamente.</span>
                    </div>
                @endif

                <button type="submit" class="w-full py-4 bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                    <i data-lucide="unlock" class="w-5 h-5"></i>
                    <span>Desbloquear Documento</span>
                </button>
            </form>

            {{-- AVISO DE SEGURANÇA E BEM-ESTAR --}}
            <div class="mt-8 w-full bg-amber-50 border border-amber-100 rounded-xl p-4 text-left">
                <div class="flex items-start gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-amber-600 mt-0.5 shrink-0"></i>
                    <div class="text-xs text-amber-800 space-y-2">
                        <p>
                            <strong>Sobre a recuperação:</strong> O código será enviado para o <u>e-mail principal da conta</u> (o e-mail de login do site).
                        </p>
                        <p class="pt-2 border-t border-amber-200/60">
                            <strong class="text-amber-700">❤️ Mantenha a magia:</strong>
                            Por favor, não use esta função para espiar os votos do parceiro. Confiança é a base de tudo!
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <a href="{{ route('vows.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-indigo-600 transition-colors">
                    <i data-lucide="arrow-left" class="w-3 h-3"></i>
                    Voltar para Meus Votos
                </a>
            </div>
        </div>

        {{-- Footer simples --}}
        <p class="text-center text-slate-400 text-xs mt-6 font-medium">
            Protegido por criptografia segura.
        </p>
    </div>

    {{-- Script no final para não bloquear renderização --}}
    <script>
        lucide.createIcons();

        function enviarCodigo() {
            const btn = document.getElementById('btnEsqueci');
            const originalText = btn.innerText;

            // O controller passa a variável $role para a view 'gate'. Usamos ela aqui.
            const role = "{{ $role }}";

            btn.innerText = 'Enviando código...';
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');

            fetch('{{ route("vows.send_code") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ role: role })
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '{{ url("votos/verificar") }}/' + role;
                } else {
                    throw new Error('Falha no envio');
                }
            })
            .catch(error => {
                alert('Erro ao enviar e-mail. Tente novamente em instantes.');
                btn.innerText = originalText;
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        }
    </script>
</body>
</html>
