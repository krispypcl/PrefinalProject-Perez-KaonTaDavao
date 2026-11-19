@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Add Eatery</h1>

    <form method="POST" action="{{ route('eateries.store') }}" class="bg-white rounded-lg shadow p-6">
        @csrf

        @include('eateries._form')

        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded bg-orange-700 px-5 py-2 text-white hover:bg-orange-800">Save Eatery</button>
            <a href="{{ route('eateries.index') }}" class="rounded border border-gray-300 px-5 py-2 hover:bg-gray-100">Cancel</a>
        </div>
    </form>
@endsection
