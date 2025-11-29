@props(['icon' => 'inbox', 'title' => 'Nada por aqui', 'text' => null])

<div class="p-8 text-center text-gray-500">
    <i data-lucide="{{ $icon }}" class="w-10 h-10 mx-auto mb-3 text-gray-400"></i>
    <p class="font-medium text-gray-700">{{ $title }}</p>
    @if($text)<p class="text-sm">{{ $text }}</p>@endif
    @if(trim($slot))
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
