@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit {{ $eatery->name }}</h1>

    {{-- HTML forms can only send GET or POST.
         @method('PUT') adds a hidden _method field so Laravel treats it as PUT (eateries.update). --}}
    <form method="POST" action="{{ route('eateries.update', $eatery) }}" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        @include('eateries._form')

        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded bg-orange-700 px-5 py-2 text-white hover:bg-orange-800">Update Eatery</button>
            <a href="{{ route('eateries.show', $eatery) }}" class="rounded border border-gray-300 px-5 py-2 hover:bg-gray-100">Cancel</a>
        </div>
    </form>
@endsection
