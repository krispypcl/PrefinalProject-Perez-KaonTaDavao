{{-- Usage:
     <x-rating :value="$review->rating" />                     just the 5 stars
     <x-rating :value="$average" :count="$reviewCount" />      stars + "4.3 ★ (7 reviews)" or "No reviews yet" --}}
@props(['value' => 0, 'count' => null])

@if ($count !== null && $count == 0)
    <span class="text-gray-500">No reviews yet</span>
@else
    {{-- gold star while $i is within the rounded rating, gray for the rest --}}
    <span class="tracking-tight">@for ($i = 1; $i <= 5; $i++)<span class="{{ $i <= round($value) ? 'text-amber-500' : 'text-gray-300' }}">★</span>@endfor</span>

    @if ($count !== null)
        <span>{{ number_format($value, 1) }} ★ ({{ $count }} {{ Str::plural('review', $count) }})</span>
    @endif
@endif
