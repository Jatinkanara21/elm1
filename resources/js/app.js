import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Defer Alpine initialization until DOM is ready to improve initial page render
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        Alpine.start();
    });
} else {
    Alpine.start();
}
