import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/components/collapse.css',
                'resources/css/components/dropdown.css',
                'resources/css/components/nav.css',
                'resources/css/components/navbar.css',
                'resources/css/components/offcanvas.css',
                'resources/css/components/prism.css',
                'resources/css/components/toast.css',
                'resources/css/components/tooltips.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
