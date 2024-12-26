document.addEventListener('DOMContentLoaded', () => {
    const burger = document.getElementById('burger');
    const navMenu = document.getElementById('nav-menu');

    burger.addEventListener('click', () => {
        burger.classList.toggle('active');
        navMenu.classList.toggle('open');
    });
});