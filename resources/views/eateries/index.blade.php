@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Eateries</h1>

    {{-- One GET form for all filters, so they can be combined.
         request('...') puts the chosen values back into the form. --}}
    <form method="GET" action="{{ route('eateries.index') }}" class="bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or specialty"
               class="rounded border border-gray-300 px-3 py-2">

        <select name="district" class="rounded border border-gray-300 px-3 py-2">
            <option value="">All districts</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(request('district') == $district->id)>{{ $district->name }}</option>
            @endforeach
        </select>

        <select name="feature" class="rounded border border-gray-300 px-3 py-2">
            <option value="">All features</option>
            @foreach ($features as $feature)
                <option value="{{ $feature->name }}" @selected(request('feature') == $feature->name)>{{ $feature->name }}</option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 rounded bg-orange-700 px-4 py-2 text-white hover:bg-orange-800">Filter</button>
            <a href="{{ route('eateries.index') }}" class="rounded border border-gray-300 px-4 py-2 text-center hover:bg-gray-100">Clear</a>
        </div>
    </form>

    @if ($eateries->isEmpty())
        <p class="text-gray-600">No eateries match your filters.</p>
    @else
        {{-- 1 column on phones, 2 on tablets (md), 3 on desktop (lg) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>

        <div class="mt-6">
            {{ $eateries->links() }}
        </div>
    @endif
@endsection
