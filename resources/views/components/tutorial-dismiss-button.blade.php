@props(['fullWidth' => false])

{{-- Botão Discreto (Ghost Style) para não competir com a ação principal --}}
<form method="POST" action="{{ route('tutorial.dismiss') }}" class="{{ $fullWidth ? 'w-full' : '' }}">
    @csrf
    <button type="submit"
        class="group flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
        {{ $fullWidth
            ? 'w-full bg-slate-100 text-slate-600 hover:bg-slate-200'
            : 'bg-transparent text-slate-400 hover:text-slate-600 hover:bg-slate-50'
        }}">

        <i data-lucide="x" class="w-4 h-4"></i>
        <span>Dispensar guia</span>
    </button>
</form>
