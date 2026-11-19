@extends('layouts.app')

@section('content')
    <h1 class="font-display mb-6 text-4xl font-bold">Eateries</h1>

    {{-- One GET form for all filters, so they can be combined.
         request('...') puts the chosen values back into the form. --}}
    <form method="GET" action="{{ route('eateries.index') }}" class="card mb-6 grid grid-cols-1 gap-3 p-4 md:grid-cols-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or specialty" class="form-input">

        <select name="district" class="form-input" data-dropdown>
            <option value="">All districts</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(request('district') == $district->id)>{{ $district->name }}</option>
            @endforeach
        </select>

        <select name="feature" class="form-input" data-dropdown>
            <option value="">All features</option>
            @foreach ($features as $feature)
                <option value="{{ $feature->name }}" @selected(request('feature') == $feature->name)>{{ $feature->name }}</option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button type="submit" class="btn btn-primary flex-1">Filter</button>
            <a href="{{ route('eateries.index') }}" class="btn btn-outline">Clear</a>
        </div>
    </form>

    @if ($eateries->isEmpty())
        <p class="text-muted">No eateries match your filters.</p>
    @else
        {{-- 1 column on phones, 2 on tablets (md), 3 on desktop (lg) --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>

        {{-- page links using our own themed view (partials/pagination.blade.php) --}}
        <div class="mt-6">
            {{ $eateries->links('partials.pagination') }}
        </div>
    @endif
@endsection
