@props(['title', 'subtitle' => null, 'actions' => null])

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-4">
    <div>
        <h3 class="text-xl md:text-2xl font-extrabold text-gray-900">{{ $title }}</h3>
        @if($subtitle)
            <p class="text-sm text-gray-600 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    @if($actions)
        <div class="flex items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>
