{{-- error summary, shared by the eatery form and the review form --}}
@if ($errors->any())
    <div class="mb-6 rounded border border-red-300 bg-red-50 p-4 text-sm text-red-700 motion-safe:animate-fade-in dark:border-red-800 dark:bg-red-950 dark:text-red-300">
        <p class="font-semibold">Please fix the following errors:</p>
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
