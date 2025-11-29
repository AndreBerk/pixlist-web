@props([
  'variant' => 'primary', // primary | secondary | outline | danger
  'size' => 'md',         // sm | md | lg
  'icon' => null,
])

@php
$base  = 'inline-flex items-center justify-center gap-2 font-semibold rounded-lg transition focus:outline-none focus-visible:ring';
$sizes = [
  'sm' => 'px-3 py-2 text-sm',
  'md' => 'px-4 py-2.5 text-sm',
  'lg' => 'px-5 py-3 text-base',
][$size];

$variants = [
 'primary'   => 'bg-emerald-600 text-white hover:bg-emerald-700 focus-visible:ring-emerald-300',
 'secondary' => 'bg-gray-800 text-white hover:bg-gray-900 focus-visible:ring-gray-300',
 'outline'   => 'border border-gray-300 text-gray-700 hover:bg-gray-50 focus-visible:ring-emerald-300',
 'danger'    => 'bg-red-600 text-white hover:bg-red-700 focus-visible:ring-red-300',
][$variant];
@endphp

<button {{ $attributes->class("$base $sizes $variants") }}>
  @if($icon)<i data-lucide="{{ $icon }}" class="w-4 h-4 -mt-[1px]"></i>@endif
  {{ $slot }}
</button>
