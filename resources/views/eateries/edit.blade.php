@extends('layouts.app')

@section('content')
    <h1 class="font-display mb-6 text-4xl font-bold">Edit {{ $eatery->name }}</h1>

    {{-- HTML forms can only send GET or POST.
         @method('PUT') adds a hidden _method field so Laravel treats it as PUT (eateries.update). --}}
    <form method="POST" action="{{ route('eateries.update', $eatery) }}" class="card p-6">
        @csrf
        @method('PUT')

        @include('eateries._form')

        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn btn-primary">Update Eatery</button>
            <a href="{{ route('eateries.show', $eatery) }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
@endsection
