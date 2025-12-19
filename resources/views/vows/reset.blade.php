<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Segurança</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 h-screen flex items-center justify-center font-['Inter']">

    <div class="bg-white p-8 rounded-3xl shadow-xl max-w-sm w-full text-center border border-gray-100 relative overflow-hidden">

        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-emerald-400 to-cyan-500"></div>

        <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i data-lucide="mail-check" class="w-8 h-8"></i>
        </div>

        <h2 class="text-xl font-bold text-gray-900 mb-2">Verifique seu E-mail</h2>
        <p class="text-sm text-gray-500 mb-6">
            Enviamos um código de 6 dígitos para <strong>{{ auth()->user()->email }}</strong>.
        </p>

        <form action="{{ route('vows.reset_with_code') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            {{-- Input do Código --}}
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Código de Segurança</label>
                <input type="text" name="code" maxlength="6" placeholder="000000" required autofocus
                    class="w-full text-center text-3xl font-bold tracking-[0.3em] py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 outline-none transition text-slate-700">
            </div>

            {{-- Novo PIN --}}
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 mt-4">Novo PIN (4 dígitos)</label>
                <input type="text" name="new_pin" maxlength="4" placeholder="••••" required
                    class="w-full text-center text-xl font-bold tracking-widest py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 outline-none transition text-slate-700">
            </div>

            @if($errors->any())
                <p class="text-red-500 text-xs font-bold">{{ $errors->first() }}</p>
            @endif

            <button type="submit" class="w-full py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                Redefinir PIN
            </button>
        </form>

        <a href="{{ route('vows.index') }}" class="block mt-6 text-xs text-gray-400 hover:text-gray-600">Cancelar</a>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
