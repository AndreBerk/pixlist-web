@props(['percent' => 0, 'sr' => null])

<div>
  <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
      <div class="bg-emerald-600 h-3 rounded-full" style="width: {{ max(0,min(100,$percent)) }}%"></div>
  </div>
  @if($sr)
    <p class="sr-only">{{ $sr }}</p>
  @endif
</div>
