document.addEventListener('DOMContentLoaded', function () {
    console.log('Theme script loaded');
    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    var themeToggleBtn = document.getElementById('theme-toggle');

    // Check if elements exist to avoid errors on pages without the toggle
    if (!themeToggleBtn || !themeToggleDarkIcon || !themeToggleLightIcon) {
        console.error('Theme toggle elements not found', { themeToggleBtn, themeToggleDarkIcon, themeToggleLightIcon });
        return;
    }

    console.log('Current theme:', localStorage.theme);

    // Change the icons inside the button based on previous settings
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
        document.documentElement.classList.add('dark');
        console.log('Applied dark theme on load');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
        document.documentElement.classList.remove('dark');
        console.log('Applied light theme on load');
    }

    themeToggleBtn.addEventListener('click', function () {
        console.log('Theme toggle button clicked');
        // toggle icons inside button
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // if set via local storage previously
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
            console.log('Switched to light theme');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
            console.log('Switched to dark theme');
        }
    });
});
