import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    
    // mode: 'production',
    // build: {
    //     target: 'es2015', 
    //     minify: 'terser', 
    // },

    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
            
            // extract: true,
        }),
    ],
});
