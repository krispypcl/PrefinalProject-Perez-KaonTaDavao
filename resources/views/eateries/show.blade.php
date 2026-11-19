@extends('layouts.app')

@section('content')
    {{-- ===== Eatery details ===== --}}
    <div class="card mb-6 p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
            <div>
                <h1 class="font-display text-4xl font-bold text-orange-800 dark:text-orange-300">
                    {{ $eatery->name }}
                    @if (! $eatery->is_open)
                        <span class="badge-closed ml-2 align-middle font-sans text-sm">Closed</span>
                    @endif
                </h1>

                <p class="muted mt-1">
                    <a href="{{ route('districts.show', $eatery->district) }}" class="hover:underline">{{ $eatery->district->name }}</a>
                    &middot; {{ $eatery->address }}
                </p>
            </div>

            {{-- Edit link + Delete form (delete must be a form with @csrf, never a GET link) --}}
            <div class="flex shrink-0 gap-2">
                <a href="{{ route('eateries.edit', $eatery) }}" class="btn btn-primary">Edit</a>

                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}" onsubmit="return confirm('Delete this eatery?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>

        <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-3">
            <div>
                <dt class="muted">Price range</dt>
                <dd class="font-semibold text-green-700 dark:text-green-400">{{ ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'][$eatery->price_range] }} ({{ $eatery->price_range }})</dd>
            </div>
            <div>
                <dt class="muted">Specialty</dt>
                <dd>{{ $eatery->specialty ?? 'None' }}</dd>
            </div>
            <div>
                <dt class="muted">Rating</dt>
                <dd>
                    {{-- the reviews are already loaded for the list below,
                         so the average and count come from that collection (no extra query) --}}
                    <x-rating :value="$eatery->reviews->avg('rating')" :count="$eatery->reviews->count()" />
                </dd>
            </div>
        </dl>

        {{-- feature badges --}}
        <div class="mt-4 flex flex-wrap gap-1">
            @foreach ($eatery->features as $feature)
                <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="badge">{{ $feature->name }}</a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="flex flex-col gap-6 lg:col-span-2">
            {{-- ===== Dishes ===== --}}
            <section class="card p-6">
                <h2 class="font-display mb-3 text-2xl font-bold">Dishes</h2>

                <ul class="divide-y divide-gray-200 dark:divide-stone-700">
                    @forelse ($eatery->dishes as $dish)
                        <li class="-mx-2 flex justify-between rounded px-2 py-2 transition-colors hover:bg-amber-50 dark:hover:bg-stone-700/50">
                            <span>
                                {{ $dish->name }}
                                @if ($dish->is_bestseller)
                                    <span class="ml-1 rounded bg-amber-200 px-2 py-0.5 text-xs font-semibold text-amber-900 dark:bg-amber-900 dark:text-amber-100">Bestseller</span>
                                @endif
                            </span>
                            <span class="font-semibold">₱{{ number_format($dish->price, 2) }}</span>
                        </li>
                    @empty
                        <li class="muted py-2">No dishes listed yet.</li>
                    @endforelse
                </ul>
            </section>

            {{-- ===== Reviews (newest first, loaded in the controller) ===== --}}
            <section class="card p-6">
                <h2 class="font-display mb-3 text-2xl font-bold">Reviews</h2>

                <div class="flex flex-col gap-4">
                    @forelse ($eatery->reviews as $review)
                        <div class="border-b border-gray-200 pb-3 dark:border-stone-700">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <a href="{{ route('reviewers.show', $review->user) }}" class="link font-semibold">{{ $review->user->name }}</a>
                                <span class="muted text-sm">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <x-rating :value="$review->rating" /> <span class="text-sm">{{ $review->rating }}/5</span>
                            <p class="mt-1">{{ $review->body }}</p>

                            {{-- delete review: POST form + @method('DELETE') --}}
                            <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="mt-2" onsubmit="return confirm('Delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cursor-pointer text-sm text-red-600 hover:underline dark:text-red-400">Delete</button>
                            </form>
                        </div>
                    @empty
                        <p class="muted">No reviews yet.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <aside class="flex flex-col gap-6">
            {{-- ===== Permit box (hasOne) ===== --}}
            <section class="card p-6">
                <h2 class="font-display mb-3 text-2xl font-bold">Business Permit</h2>

                @if ($eatery->permit)
                    <p class="muted text-sm">Permit number</p>
                    <p class="font-mono font-semibold">{{ $eatery->permit->permit_no }}</p>

                    <p class="muted mt-2 text-sm">Expires on</p>
                    <p class="font-semibold">{{ $eatery->permit->expires_on->format('F d, Y') }}</p>

                    {{-- expires_on is cast to a date, so we can compare it with today() --}}
                    @if ($eatery->permit->expires_on->lt(today()))
                        <p class="mt-2 font-bold text-red-600 dark:text-red-400">Permit expired</p>
                    @endif
                @else
                    <p class="muted">No permit on file.</p>
                @endif
            </section>

            {{-- ===== Review form (only for open eateries) ===== --}}
            <section class="card p-6">
                <h2 class="font-display mb-3 text-2xl font-bold">Write a Review</h2>

                @if ($eatery->is_open)
                    @include('partials.errors')

                    <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="flex flex-col gap-4">
                        @csrf

                        {{-- Reviewer (there is no login, so we pick a seeded user) --}}
                        <div>
                            <label for="user_id" class="form-label">Reviewer</label>
                            <select id="user_id" name="user_id" class="form-input">
                                <option value="">-- Choose a reviewer --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Rating --}}
                        <div>
                            <label for="rating" class="form-label">Rating</label>
                            <select id="rating" name="rating" class="form-input">
                                <option value="">-- Choose a rating --</option>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }} {{ Str::plural('star', $i) }}</option>
                                @endfor
                            </select>
                            @error('rating')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Body --}}
                        <div>
                            <label for="body" class="form-label">Review</label>
                            <textarea id="body" name="body" rows="4" class="form-input">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Post Review</button>
                    </form>
                @else
                    <p class="muted">This eatery is closed. Reviews are paused.</p>
                @endif
            </section>
        </aside>
    </div>
@endsection
