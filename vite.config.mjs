import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

const entries = {
    main: 'assets/scripts/main.js',
    styles: 'assets/styles/styles.css',
};

export default defineConfig({
    plugins: [tailwindcss()],
    server: {
        port: 3002,
        cors: true,
        strictPort: true,
        proxy: {
            '/@vite/': {
                target: 'http://127.0.0.1:3002',
                ws: true,
                changeOrigin: true,
            },
            '/': {
                target: 'http://127.0.0.1:8000',
                changeOrigin: true,
            },
        },
    },
    build: {
        outDir: resolve(__dirname, 'build'),
        manifest: true,
        emptyOutDir: true,
        rollupOptions: {
            input: entries,
            output: {
                entryFileNames: 'scripts/[name]-[hash].js',
                chunkFileNames: 'scripts/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'styles/[name]-[hash][extname]';
                    }
                    return '[name]-[hash][extname]';
                },
            },
        },
    },
});