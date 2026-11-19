<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaon Ta! Davao – Perez's Food Guide</title>

    {{-- Google Fonts: Fraunces for headings, Plus Jakarta Sans for normal text --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap">

    {{-- Apply the saved theme right away (before the page is drawn) so dark mode does not flash white.
         If nothing is saved yet, follow the computer's setting. --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (localStorage.getItem('theme') === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    {{-- Tailwind CSS and JS are loaded through Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-amber-50 text-gray-800 transition-colors duration-300 dark:bg-stone-900 dark:text-stone-300">

    {{-- sticky: the header stays at the top while scrolling --}}
    <header class="sticky top-0 z-40 bg-orange-700 text-white shadow dark:bg-orange-950 dark:text-orange-100">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-4 md:flex-row md:items-center md:justify-between">
            <a href="{{ route('home') }}" class="font-display text-2xl font-bold transition-opacity hover:opacity-85">Kaon Ta! Davao – Perez's Food Guide</a>

            <div class="flex items-center gap-2">
                {{-- navigation links (partial) --}}
                @include('partials.nav')

                {{-- Dark / light mode button (the click is handled in resources/js/theme.js).
                     dark:hidden and dark:block swap the moon and sun icons without any JavaScript. --}}
                <button type="button" id="theme-toggle" title="Toggle dark mode" aria-label="Toggle dark mode"
                        class="group cursor-pointer rounded-full p-2 transition-colors duration-200 hover:bg-white/15">
                    {{-- moon (shown in light mode) --}}
                    <svg class="size-5 transition-transform duration-200 group-hover:scale-110 dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                    </svg>
                    {{-- sun (shown in dark mode) --}}
                    <svg class="hidden size-5 transition-transform duration-200 group-hover:scale-110 dark:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4"/>
                        <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    {{-- the whole page fades in a little when it loads --}}
    <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-6 motion-safe:animate-fade-in">
        {{-- success messages like "Eatery added." (partial) --}}
        @include('partials.flash')

        {{-- each page puts its content here --}}
        @yield('content')
    </main>

    <footer class="muted py-4 text-center text-sm">
        Kaon Ta! Davao &middot; Chris Roldan Perez &middot; 2026
    </footer>

</body>
</html>
