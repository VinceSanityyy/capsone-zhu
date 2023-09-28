import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    // server: {
    //     hmr: {
    //         host: 'localhost',
    //     },
    // },
    resolve: {
        alias: {
            ziggy: 'vendor/tightenco/ziggy/dist/vue.es.js',
            // 'vendor/tightenco/ziggy/dist/vue.es.js' if using the Vue plugin
        },
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
