import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js', // Ensure this alias is set
        },
    },
    build: {
        rollupOptions: {
            output: {
                entryFileNames: `build-app.js`,
                chunkFileNames: `build-app.js`,
                assetFileNames: `build-app.[ext]`,
            },
        },
    },
});
