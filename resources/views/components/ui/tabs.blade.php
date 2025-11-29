@props(['tabs' => [] /* [['id'=>'tab1','label'=>'…'], …] */, 'active' => null])

@php $active = $active ?? ($tabs[0]['id'] ?? null); @endphp

<div x-data="{tab:'{{ $active }}'}" x-cloak>
  <nav class="-mb-px flex gap-4 border-b border-gray-200">
    @foreach($tabs as $t)
      <button type="button"
              @click="tab='{{ $t['id'] }}'"
              :class="tab==='{{ $t['id'] }}' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
              class="border-b-2 px-1 py-3 text-sm font-medium">
        {{ $t['label'] }}
      </button>
    @endforeach
  </nav>

  <div class="pt-4">
    {{ $slot }}
  </div>
</div>
