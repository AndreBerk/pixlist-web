@props([
    'as' => 'div',
    'padding' => 'p-6',
    'hover' => false,
])

<{{ $as }} {{ $attributes->class([
    "bg-white rounded-xl shadow-lg border border-gray-100 {$padding}",
    "transition hover:shadow-xl hover:-translate-y-[1px]" => $hover,
]) }}>
    {{ $slot }}
</{{ $as }}>
