@props(['method'])

@if($method == 'credit_card')
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">
        <i data-lucide="credit-card" class="w-3 h-3"></i> Cartão
    </span>
@elseif($method == 'pix')
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
        <i data-lucide="qr-code" class="w-3 h-3"></i> PIX
    </span>
@elseif($method == 'cash')
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-green-50 text-green-700 border border-green-100">
        <i data-lucide="banknote" class="w-3 h-3"></i> Dinheiro
    </span>
@elseif($method == 'transfer')
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
        <i data-lucide="arrow-right-left" class="w-3 h-3"></i> Ted/Doc
    </span>
@elseif($method == 'boleto')
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-50 text-gray-700 border border-gray-100">
        <i data-lucide="barcode" class="w-3 h-3"></i> Boleto
    </span>
@else
    <span class="text-xs text-slate-400">-</span>
@endif
