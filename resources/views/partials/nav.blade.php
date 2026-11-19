{{-- @class adds nav-link-active only to the link of the page we are on --}}
<nav class="flex flex-wrap items-center gap-1 text-sm font-medium">
    <a href="{{ route('home') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('home')])>Home</a>
    <a href="{{ route('eateries.index') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('eateries.index', 'eateries.show', 'eateries.edit')])>Eateries</a>
    <a href="{{ route('districts.index') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('districts.*')])>Districts</a>
    <a href="{{ route('eateries.create') }}" class="btn ml-2 bg-white px-3 py-1.5 text-orange-700 hover:bg-orange-100 dark:bg-orange-700 dark:text-orange-50 dark:hover:bg-orange-600">Add Eatery</a>
</nav>
