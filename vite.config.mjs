// vite.config.mjs
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';
import { viteStaticCopy } from 'vite-plugin-static-copy';

// Define entry points for JavaScript and CSS
const entries = [
    'assets/scripts/main.js',
    'assets/styles/styles.css',
];

// Define build output directory
const BUILD_DIR = resolve(__dirname, 'build');

export default defineConfig({
    plugins: [
        tailwindcss(),
        viteStaticCopy({
            targets: [
                {
                    src: 'assets/images/*', // Copy all files in images
                    dest: 'images', // Add them to the images folder in the build folder
                },
            ],
        }),
    ],
    server: {
        cors: true,
        strictPort: true,
        port: 3002,
        https: false,
        hmr: {
            host: 'localhost',
        },
    },
    build: {
        assetsDir: '', // Keep assets in the root of the build folder
        manifest: true, // Generate manifest.json
        emptyOutDir: true, // Clear build folder before building
        outDir: BUILD_DIR,
        rollupOptions: {
            input: entries,
            output: {
                entryFileNames: 'scripts/[name]-[hash].js', // Save JS files in scripts/
                chunkFileNames: 'scripts/[name]-[hash].js', // Save chunks in scripts/
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'styles/[name]-[hash][extname]'; // Save CSS files in styles/
                    }
                    return '[name]-[hash][extname]'; // Default for other assets
                },
            },
        },
    },
});