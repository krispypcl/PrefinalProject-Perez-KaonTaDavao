@extends('layouts.app')

@section('content')
    {{-- ===== Eatery details ===== --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-orange-800">
                    {{ $eatery->name }}
                    @if (! $eatery->is_open)
                        <span class="ml-2 align-middle rounded bg-gray-700 px-2 py-0.5 text-sm font-semibold text-white">Closed</span>
                    @endif
                </h1>

                <p class="text-gray-600 mt-1">
                    <a href="{{ route('districts.show', $eatery->district) }}" class="hover:underline">{{ $eatery->district->name }}</a>
                    &middot; {{ $eatery->address }}
                </p>
            </div>

            {{-- Edit link + Delete form (delete must be a form with @csrf, never a GET link) --}}
            <div class="flex gap-2 shrink-0">
                <a href="{{ route('eateries.edit', $eatery) }}" class="rounded bg-orange-700 px-4 py-2 text-white hover:bg-orange-800">Edit</a>

                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}" onsubmit="return confirm('Delete this eatery?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700">Delete</button>
                </form>
            </div>
        </div>

        <dl class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
            <div>
                <dt class="text-gray-500">Price range</dt>
                <dd class="font-semibold text-green-700">{{ $eatery->priceSigns() }} ({{ $eatery->price_range }})</dd>
            </div>
            <div>
                <dt class="text-gray-500">Specialty</dt>
                <dd>{{ $eatery->specialty ?? 'None' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Rating</dt>
                <dd>
                    @if ($eatery->reviews_count > 0)
                        <x-rating :value="$eatery->reviews_avg_rating" />
                        {{ number_format($eatery->reviews_avg_rating, 1) }} ★ ({{ $eatery->reviews_count }} {{ $eatery->reviews_count == 1 ? 'review' : 'reviews' }})
                    @else
                        No reviews yet
                    @endif
                </dd>
            </div>
        </dl>

        {{-- feature badges --}}
        <div class="mt-4 flex flex-wrap gap-1">
            @foreach ($eatery->features as $feature)
                <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                   class="rounded-full bg-orange-100 px-3 py-1 text-xs text-orange-800 hover:bg-orange-200">
                    {{ $feature->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 flex flex-col gap-6">
            {{-- ===== Dishes ===== --}}
            <section class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-3">Dishes</h2>

                <ul class="divide-y">
                    @forelse ($eatery->dishes as $dish)
                        <li class="flex justify-between py-2">
                            <span>
                                {{ $dish->name }}
                                @if ($dish->is_bestseller)
                                    <span class="ml-1 rounded bg-amber-200 px-2 py-0.5 text-xs font-semibold text-amber-900">Bestseller</span>
                                @endif
                            </span>
                            <span class="font-semibold">₱{{ number_format($dish->price, 2) }}</span>
                        </li>
                    @empty
                        <li class="py-2 text-gray-500">No dishes listed yet.</li>
                    @endforelse
                </ul>
            </section>

            {{-- ===== Reviews (newest first, loaded in the controller) ===== --}}
            <section class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-3">Reviews</h2>

                <div class="flex flex-col gap-4">
                    @forelse ($eatery->reviews as $review)
                        <div class="border-b pb-3">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <a href="{{ route('reviewers.show', $review->user) }}" class="font-semibold text-orange-800 hover:underline">
                                    {{ $review->user->name }}
                                </a>
                                <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <x-rating :value="$review->rating" /> <span class="text-sm">{{ $review->rating }}/5</span>
                            <p class="mt-1">{{ $review->body }}</p>

                            {{-- delete review: POST form + @method('DELETE') --}}
                            <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="mt-2" onsubmit="return confirm('Delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500">No reviews yet.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <aside class="flex flex-col gap-6">
            {{-- ===== Permit box (hasOne) ===== --}}
            <section class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-3">Business Permit</h2>

                @if ($eatery->permit)
                    <p class="text-sm text-gray-500">Permit number</p>
                    <p class="font-mono font-semibold">{{ $eatery->permit->permit_no }}</p>

                    <p class="text-sm text-gray-500 mt-2">Expires on</p>
                    <p class="font-semibold">{{ $eatery->permit->expires_on->format('F d, Y') }}</p>

                    {{-- expires_on is cast to a date, so we can compare it with today() --}}
                    @if ($eatery->permit->expires_on->lt(today()))
                        <p class="mt-2 font-bold text-red-600">Permit expired</p>
                    @endif
                @else
                    <p class="text-gray-500">No permit on file.</p>
                @endif
            </section>

            {{-- ===== Review form (only for open eateries) ===== --}}
            <section class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-3">Write a Review</h2>

                @if ($eatery->is_open)
                    {{-- error summary --}}
                    @if ($errors->any())
                        <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-sm text-red-700">
                            <p class="font-semibold">Please fix the following errors:</p>
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="flex flex-col gap-4">
                        @csrf

                        {{-- Reviewer (there is no login, so we pick a seeded user) --}}
                        <div>
                            <label for="user_id" class="block font-medium mb-1">Reviewer</label>
                            <select id="user_id" name="user_id" class="w-full rounded border border-gray-300 px-3 py-2">
                                <option value="">-- Choose a reviewer --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Rating --}}
                        <div>
                            <label for="rating" class="block font-medium mb-1">Rating</label>
                            <select id="rating" name="rating" class="w-full rounded border border-gray-300 px-3 py-2">
                                <option value="">-- Choose a rating --</option>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }} {{ $i == 1 ? 'star' : 'stars' }}</option>
                                @endfor
                            </select>
                            @error('rating')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Body --}}
                        <div>
                            <label for="body" class="block font-medium mb-1">Review</label>
                            <textarea id="body" name="body" rows="4" class="w-full rounded border border-gray-300 px-3 py-2">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="rounded bg-orange-700 px-4 py-2 text-white hover:bg-orange-800">Post Review</button>
                    </form>
                @else
                    <p class="text-gray-600">This eatery is closed. Reviews are paused.</p>
                @endif
            </section>
        </aside>
    </div>
@endsection
