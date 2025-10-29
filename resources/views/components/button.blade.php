@props([
    'url' => '#',
    'type' => 'primary', // primary, secondary, danger, success, etc.
    'size' => 'md', // sm, md, lg
    'icon' => null,
])

@php
    $base = 'inline-flex items-center justify-center font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2';

    $types = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300 focus:ring-gray-400',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
    ];

    $classes = "{$base} " . ($types[$type] ?? $types['primary']) . " " . ($sizes[$size] ?? $sizes['md']);
@endphp

<a href="{{ $url }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class="fa fa-{{ $icon }} mr-2"></i>
    @endif
    {{ $slot }}
</a>
