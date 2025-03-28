// vite.config.mjs
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import ViteSvgSpriteWrapper from 'vite-svg-sprite-wrapper';
import viteImagemin from 'vite-plugin-imagemin';
import fs from 'fs';

// Define entry points for JavaScript and CSS
const entries = [
    'assets/scripts/main.js',
    'assets/scripts/editor.js',
    'assets/styles/styles.css',
    'assets/styles/editor-styles.css',
];

// Setup config
export default defineConfig(({ command }) => {
    if (command === 'serve') {
        const hmrFile = path.resolve('.hmr-enabled');
    
        // Create .hmr-enabled file
        fs.writeFileSync(hmrFile, '');

        const cleanup = () => {
            if (fs.existsSync(hmrFile)) {
                fs.unlinkSync(hmrFile);
            }
          process.exit();
        };

        process.on('SIGINT', cleanup);   // Ctrl+C
        process.on('SIGTERM', cleanup);  // kill
        process.on('exit', cleanup);     // other exits
    }

    return {
        plugins: [
            tailwindcss(),
            ViteSvgSpriteWrapper({
                icons: 'assets/icons/**/*.svg',
                outputDir: 'build/images/icons',
                typeFileName: 'svg-icons',
            }),
            viteImagemin({
                svgo: {
                    plugins: [
                        { name: 'removeViewBox', active: false }
                    ],
                },
                optipng: {
                    optimizationLevel: 6,
                },
                pngquant: {
                    quality: [0.8, 1],
                    speed: 2,
                },
                mozjpeg: {
                    quality: 80,
                },
            }),
            viteStaticCopy({
                targets: [
                    {
                        src: 'assets/images/logo.svg',
                        dest: 'images',
                    }
                ],
            }),
        ],
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'assets'),
            },
        },
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
            manifest: true, // Generate manifest.json
            emptyOutDir: true, // Clear build folder before building
            outDir: path.resolve(__dirname, 'build'),
            rollupOptions: {
                input: entries,
                output: {
                    entryFileNames: 'scripts/[name]-[hash].js',
                    chunkFileNames: 'scripts/[name]-[hash].js',
                    assetFileNames: (assetInfo) => {
                        const fileName = assetInfo.name || assetInfo.names[0] || '';
                        
                        console.log('- Processing ' + fileName);

                        // Hash styles inside styles folder
                        if (fileName.endsWith('.css')) {
                            return 'styles/[name]-[hash][extname]';
                        }

                        // Hash scripts inside scripts folder
                        if (fileName.endsWith('.js')) {
                            return 'scripts/[name]-[hash][extname]';
                        }

                        // Skip sprite file
                        if (fileName.includes('sprite') && fileName.endsWith('.svg')) {
                            return 'images/icons/sprite.svg';
                        }

                        // Images without hash
                        if (/\.(png|jpe?g|svg)$/i.test(fileName)) {
                            return 'images/[name][extname]';
                        }

                        // Default
                        return '[name][extname]'; 
                    },
                },
            },
        }
    }
});