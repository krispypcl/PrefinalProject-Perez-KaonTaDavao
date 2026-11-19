{{-- @class adds nav-link-active only to the link of the page we are on --}}
<nav class="flex flex-wrap items-center gap-1 text-sm font-medium">
    <a href="{{ route('home') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('home')])>Home</a>
    <a href="{{ route('eateries.index') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('eateries.index', 'eateries.show', 'eateries.edit')])>Eateries</a>
    <a href="{{ route('districts.index') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('districts.*')])>Districts</a>
    <a href="{{ route('eateries.create') }}" class="btn btn-header ml-2">Add Eatery</a>
</nav>
