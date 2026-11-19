{{-- shows the message sent with ->with('success', '...') in the controller --}}
@if (session('success'))
    <div class="mb-6 rounded border border-green-300 bg-green-100 px-4 py-3 text-green-800 motion-safe:animate-fade-in dark:border-green-800 dark:bg-green-950 dark:text-green-200">
        {{ session('success') }}
    </div>
@endif
