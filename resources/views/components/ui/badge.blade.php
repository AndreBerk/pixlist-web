@props(['tone' => 'gray']) {{-- gray | emerald | blue | amber | red | purple --}}
@php
$tones = [
  'gray'    => 'bg-gray-100 text-gray-700',
  'emerald' => 'bg-emerald-50 text-emerald-700',
  'blue'    => 'bg-blue-50 text-blue-700',
  'amber'   => 'bg-amber-50 text-amber-700',
  'red'     => 'bg-red-50 text-red-700',
  'purple'  => 'bg-purple-50 text-purple-700',
];
@endphp

<span {{ $attributes->class("inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {$tones[$tone]}") }}>
  {{ $slot }}
</span>
