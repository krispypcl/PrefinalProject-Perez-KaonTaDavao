{{-- Usage: <x-eatery-card :eatery="$eatery" />
     The controller must load district, features, reviews_avg_rating and reviews_count
     (with(), withAvg(), withCount()) so this card does not run extra queries. --}}
@props(['eatery'])

<div class="card card-hover flex flex-col gap-2 p-5">
    <div class="flex items-start justify-between gap-2">
        <a href="{{ route('eateries.show', $eatery) }}" class="link font-display text-lg font-semibold">
            {{ $eatery->name }}
        </a>

        @if (! $eatery->is_open)
            <span class="badge-closed">Closed</span>
        @endif
    </div>

    <div class="text-muted text-sm">
        <a href="{{ route('districts.show', $eatery->district) }}" class="link-subtle">{{ $eatery->district->name }}</a>
        {{-- price range as peso signs --}}
        &middot; <span class="font-semibold text-price">{{ ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'][$eatery->price_range] }}</span>
    </div>

    @if ($eatery->specialty)
        <p class="text-sm">Specialty: {{ $eatery->specialty }}</p>
    @endif

    {{-- each feature badge links to the list filtered by that feature --}}
    <div class="flex flex-wrap gap-1">
        @foreach ($eatery->features as $feature)
            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="badge">{{ $feature->name }}</a>
        @endforeach
    </div>

    <div class="mt-auto pt-2 text-sm">
        <x-rating :value="$eatery->reviews_avg_rating" :count="$eatery->reviews_count" />
    </div>
</div>
