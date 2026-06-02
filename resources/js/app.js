import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-toggle="dropdown"]').forEach((el) => {
        el.addEventListener('click', (e) => {
            e.stopPropagation();
            const target = document.querySelector(el.dataset.target);
            if (target) {
                target.classList.toggle('hidden');
            }
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('[data-dropdown-menu]').forEach((m) => m.classList.add('hidden'));
    });

    document.querySelectorAll('[data-flash]').forEach((el) => {
        setTimeout(() => el.classList.add('opacity-0'), 4000);
        setTimeout(() => el.remove(), 4500);
    });
});
