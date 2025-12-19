@props(['status'])

@if($status === 'paid')
    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
        <i data-lucide="check-circle" class="w-3 h-3"></i> Pago
    </span>
@elseif($status === 'partial')
    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
        <i data-lucide="pie-chart" class="w-3 h-3"></i> Parcial
    </span>
@else
    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
        <i data-lucide="clock" class="w-3 h-3"></i> Pendente
    </span>
@endif
