// Dark / light mode toggle.
// The choice is saved in localStorage so it stays after reloading the page.
// (The <head> of layouts/app.blade.php applies the saved theme before the page is drawn.)
const themeToggle = document.getElementById('theme-toggle');

themeToggle.addEventListener('click', () => {
    // toggle() adds the class if missing, removes it if present, and returns true if it was added
    const isDark = document.documentElement.classList.toggle('dark');

    localStorage.setItem('theme', isDark ? 'dark' : 'light');
});
