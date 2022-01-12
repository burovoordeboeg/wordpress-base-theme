const tailwindcss = require('tailwindcss');

const postcssConfig = {
	plugins: [
		require('postcss-import'),
		require('tailwindcss/nesting'),
		require('tailwindcss'),
		require('autoprefixer')
	]
};

if (process.env.NODE_ENV === 'production') {
	postcssConfig.plugins.push(
		require('cssnano')()
	);
}

module.exports = postcssConfig;