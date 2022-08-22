
let mix = require('laravel-mix');
const fs = require('fs');

// Copy images from assest image folder
mix.copy('assets/images/', 'build/images');

mix.options({ // Do not process URLs anymore
	processCssUrls: false
});

mix.setPublicPath('build')
	.js('assets/scripts/scripts.js', 'scripts')
	.js('assets/scripts/editor.js', 'scripts')
	.postCss('assets/styles/styles.css', 'styles', [
		require('tailwindcss'),
		require('tailwindcss/nesting'),
	])
	.version()
	.postCss('assets/styles/editor-styles.css', 'styles', [
		require('tailwindcss'),
		require('tailwindcss/nesting'),
	]);

mix.autoload({
	jquery: ['$', 'window.jQuery']
});
// Watch files
if (fs.existsSync('browsersync.config.js')) {
	const config = require('./browsersync.config');
	mix.browserSync(config);
}
