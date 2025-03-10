document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const darkBtn = document.getElementById('dark-btn');
    const lightBtn = document.getElementById('light-btn');

    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'light-mode') {
        body.classList.add('light-mode');
        darkBtn.classList.remove('d-none');
        lightBtn.classList.add('d-none');
    } else {
        body.classList.add('dark-mode');
        lightBtn.classList.remove('d-none');
        darkBtn.classList.add('d-none');
    }

    darkBtn.addEventListener('click', function () {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark-mode');

        darkBtn.classList.add('d-none');
        lightBtn.classList.remove('d-none');
    });

    lightBtn.addEventListener('click', function () {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        localStorage.setItem('theme', 'light-mode');

        lightBtn.classList.add('d-none');
        darkBtn.classList.remove('d-none');
    });
});