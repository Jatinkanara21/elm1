import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
            },
        },
        rollupOptions: {
            output: {
                manualChunks: {
                    alpine: ['alpinejs'],
                    axios: ['axios'],
                },
            },
        },
        sourcemap: false,
        reportCompressedSize: false,
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: '0.0.0.0',
        },
        allowedHosts: 'all',
        middlewareMode: false,
    },
    ssr: {
        external: ['laravel-vite-plugin'],
    },
});
