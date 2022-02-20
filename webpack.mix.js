
let mix = require('laravel-mix');
const fs = require('fs');


mix.setPublicPath('dist')
	.js('src/scripts/scripts.js', 'scripts')
	.js('src/scripts/editor.js', 'scripts')
	.postCss('src/styles/app.css', 'styles', [
		require('tailwindcss'),
	])
	.version()
	.postCss('src/styles/editor-style.css', 'styles', [
		require('tailwindcss'),
	]);

// Watch files
if (fs.existsSync('browsersync.config.js')) {
	const config = require('./browsersync.config');
	mix.browserSync(config);
}