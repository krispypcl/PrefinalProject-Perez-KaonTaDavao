<nav class="flex flex-wrap items-center gap-4 text-sm font-medium">
    <a href="{{ route('home') }}" class="transition-opacity hover:underline hover:opacity-80">Home</a>
    <a href="{{ route('eateries.index') }}" class="transition-opacity hover:underline hover:opacity-80">Eateries</a>
    <a href="{{ route('districts.index') }}" class="transition-opacity hover:underline hover:opacity-80">Districts</a>
    <a href="{{ route('eateries.create') }}" class="btn bg-white px-3 py-1 text-orange-700 hover:bg-orange-100 dark:bg-orange-700 dark:text-orange-50 dark:hover:bg-orange-600">Add Eatery</a>
</nav>
