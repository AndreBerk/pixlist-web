@props(['expense'])

{{-- Botão Pagar --}}
<button
    x-data
    @click="$dispatch('open-payment-modal', {
        id: '{{ $expense->id }}',
        description: '{{ $expense->description }}',
        total: {{ $expense->amount }},
        paid: {{ $expense->amount_paid }}
    })"
    class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition"
    title="Registrar Pagamento">
    <i data-lucide="banknote" class="w-4 h-4"></i>
</button>

{{-- Botão Editar --}}
<button
    x-data
    @click="$dispatch('open-edit-expense-modal', {
        id: '{{ $expense->id }}',
        description: '{{ $expense->description }}',
        category: '{{ $expense->category }}',
        amount: {{ $expense->amount }},
        payment_method: '{{ $expense->payment_method }}',
        due_date: '{{ $expense->due_date ? $expense->due_date->format('Y-m-d') : '' }}'
    })"
    class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
    title="Editar">
    <i data-lucide="pencil" class="w-4 h-4"></i>
</button>

{{-- Botão Excluir --}}
<form action="{{ route('despesas.destroy', $expense) }}" method="POST" onsubmit="return confirm('Tem certeza?')" class="inline">
    @csrf @method('DELETE')
    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Excluir">
        <i data-lucide="trash-2" class="w-4 h-4"></i>
    </button>
</form>
