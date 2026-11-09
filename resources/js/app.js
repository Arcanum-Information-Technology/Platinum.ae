import './bootstrap';
import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
window.lucide = { createIcons, icons };

window.renderIcons = () => {
    try {
        createIcons({ icons });
    } catch (e) {
        console.warn('Lucide icon error', e);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    window.renderIcons();
});

Alpine.start();
