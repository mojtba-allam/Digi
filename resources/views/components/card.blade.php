@props([
    'title' => null,
    'subtitle' => null,
    'padding' => true
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100']) }}>
    @if($title || $subtitle)
        <div class="px-6 py-5 border-b border-gray-100">
            @if($title)
                <h3 class="text-xl font-bold text-gray-900">{{ $title }}</h3>
            @endif
            @if($subtitle)
                <p class="mt-2 text-sm text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    <div @class(['p-6' => $padding])>
        {{ $slot }}
    </div>
</div>