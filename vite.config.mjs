//vite.config.mjs
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';


// Get the main.js where all your JavaScript files are imported
const entries = [
	'assets/scripts/main.js',
]

// Define where the compiled and minified JavaScript files will be saved
const BUILD_DIR = resolve(__dirname, 'build');

export default defineConfig({
	plugins: [
		tailwindcss(),
	],
	server: {
		cors: true,
		strictPort: true,
		port: 3002,
		https: false,
		hmr: {
		  	host: 'localhost',
		}
	},
    build: {
        assetsDir: '', // Will save the compiled JavaScript files in the root of the dist folder
        manifest: true, // Generate manifest.json file (for caching)
        emptyOutDir: true, // Empty the dist folder before building
        outDir: BUILD_DIR,
        rollupOptions: {
            input: entries,
        },
    },
});
