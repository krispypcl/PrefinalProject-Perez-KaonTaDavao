<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaon Ta! Davao – Perez's Food Guide</title>

    {{-- Tailwind CSS and JS are loaded through Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-amber-50 text-gray-800 min-h-screen flex flex-col">

    <header class="bg-orange-700 text-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <a href="{{ route('home') }}" class="text-xl font-bold">Kaon Ta! Davao – Perez's Food Guide</a>

            {{-- navigation links (partial) --}}
            @include('partials.nav')
        </div>
    </header>

    <main class="max-w-6xl mx-auto w-full px-4 py-6 flex-1">
        {{-- success messages like "Eatery added." (partial) --}}
        @include('partials.flash')

        {{-- each page puts its content here --}}
        @yield('content')
    </main>

    <footer class="text-center text-sm text-gray-500 py-4">
        Kaon Ta! Davao &middot; Chris Roldan Perez &middot; 2026
    </footer>

</body>
</html>
