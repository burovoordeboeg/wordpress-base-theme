
let mix = require('laravel-mix');
const fs = require('fs');

mix.setPublicPath('build')
	.js('assets/scripts/scripts.js', 'scripts')
	.js('assets/scripts/editor.js', 'scripts')
	.postCss('assets/styles/app.css', 'styles', [
		require('tailwindcss'),
	])
	.version()
	.postCss('assets/styles/editor-style.css', 'styles', [
		require('tailwindcss'),
	]);

// Watch files
if (fs.existsSync('browsersync.config.js')) {
	const config = require('./browsersync.config');
	mix.browserSync(config);
}