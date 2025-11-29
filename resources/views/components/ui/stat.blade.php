@props(['icon' => 'circle', 'label' => '', 'value' => '', 'tone' => 'emerald'])

@php
$iconBg = [
 'emerald' => 'bg-emerald-100 text-emerald-600',
 'blue'    => 'bg-blue-100 text-blue-600',
 'amber'   => 'bg-amber-100 text-amber-600',
 'gray'    => 'bg-gray-100 text-gray-600',
][$tone] ?? 'bg-gray-100 text-gray-600';
@endphp

<x-ui.card>
  <div class="flex items-center gap-3 mb-2">
      <div class="w-10 h-10 {{ $iconBg }} rounded-lg flex items-center justify-center">
          <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
      </div>
      <h3 class="text-lg font-semibold text-gray-700">{{ $label }}</h3>
  </div>
  <p class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-1">
      {!! $value !!}
  </p>
</x-ui.card>
