@extends('layouts.app')

@section('content')
    <h1 class="font-display mb-6 text-4xl font-bold">Districts</h1>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($districts as $district)
            <a href="{{ route('districts.show', $district) }}" class="card card-hover group p-5">
                <p class="font-display text-lg font-semibold text-orange-800 transition-colors group-hover:text-orange-600 dark:text-orange-300 dark:group-hover:text-orange-200">{{ $district->name }}</p>
                <p class="muted text-sm">
                    {{ $district->eateries_count }} {{ Str::plural('eatery', $district->eateries_count) }}
                </p>
            </a>
        @endforeach
    </div>
@endsection
