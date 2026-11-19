{{-- Usage: <x-rating :value="4.3" />
     Shows 5 stars: gold stars for the (rounded) rating, gray stars for the rest. --}}
@props(['value' => 0])

@php
    $filled = (int) round($value);
@endphp

<span {{ $attributes->merge(['class' => 'tracking-tight']) }} title="{{ number_format($value, 1) }} out of 5">@for ($i = 1; $i <= 5; $i++)<span class="{{ $i <= $filled ? 'text-amber-500' : 'text-gray-300' }}">★</span>@endfor</span>
