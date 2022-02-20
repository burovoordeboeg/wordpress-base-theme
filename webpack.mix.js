
let mix = require('laravel-mix');
const fs = require('fs');


mix.setPublicPath('dist')
	.js('src/scripts/scripts.js', 'dist')
	.js('src/scripts/editor.js', 'dist')
	.postCss('src/styles/app.css', 'dist', [
		require('tailwindcss'),
	])
	.version()
	.postCss('src/styles/editor-style.css', 'dist', [
		require('tailwindcss'),
	]);

// Watch files
if (fs.existsSync('browsersync.config.js')) {
	const config = require('./browsersync.config');
	mix.browserSync(config);
}