@extends('layouts.app')

@section('content')
    <h1 class="font-display mb-6 text-4xl font-bold">Add Eatery</h1>

    <form method="POST" action="{{ route('eateries.store') }}" class="card p-6">
        @csrf

        @include('eateries._form')

        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn btn-primary">Save Eatery</button>
            <a href="{{ route('eateries.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
@endsection
