import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import livewire from '@defstudio/vite-livewire-plugin';
import {homedir} from "os";
import {resolve} from "path";

let host = "example.test";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
                // 'app/Forms/Components/**',
            ],
        }),
        livewire({
            refresh: ['resources/css/app.css'],
        })
    ],
    server: {
        host,
        hmr: { host },
        https: {
            key: resolve(homedir(), `.config/valet/Certificates/${host}.key`),
            cert: resolve(homedir(), `.config/valet/Certificates/${host}.crt`),
        },
    },
});


