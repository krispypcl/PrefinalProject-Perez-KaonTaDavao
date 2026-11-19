@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Districts</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($districts as $district)
            <a href="{{ route('districts.show', $district) }}" class="bg-white rounded-lg shadow p-5 hover:bg-orange-50">
                <p class="text-lg font-semibold text-orange-800">{{ $district->name }}</p>
                <p class="text-sm text-gray-600">
                    {{ $district->eateries_count }} {{ $district->eateries_count == 1 ? 'eatery' : 'eateries' }}
                </p>
            </a>
        @endforeach
    </div>
@endsection
