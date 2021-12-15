const tailwindcss = require('tailwindcss');

const postcssConfig = {
	plugins: [
		tailwindcss,
		require('autoprefixer'),
	],
};

if (process.env.NODE_ENV === 'production') {
	postcssConfig.plugins.push(
		require('cssnano')()
	);
}

module.exports = postcssConfig;