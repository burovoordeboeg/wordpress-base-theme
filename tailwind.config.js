
// Read the theme JSON
const fs = require('fs')
const themeJson = fs.readFileSync('./theme.json')
const theme = JSON.parse(themeJson)

// Setup colors from theme JSON
const colorPalette = theme.settings.color.palette.reduce((result, item) => {
	const [color, number] = item.slug.split('-')

	// If there is a number identifier, make this an object
	if (undefined !== number) {
		if (!result[color]) {
			result[color] = {}
		}
		result[color][number] = item.color
	} else {
		result[color] = item.color
	}

	return result

}, {});

// Add additional colors that don't exist in the theme.json.
// Define the colors that you ONLY want to use within tailwind.
const additionalColors = {
	'lightgrey': '#FF3679'
}

// Merge objects to bundle all colors safelisted in Tailwind.
const colors = Object.assign(colorPalette, additionalColors);

// Make colorlist array for adding variants to safelist
const colorList = Object.keys(colors);

// Start typekit config
const tailwindconfig = {
	content: [
		'./templates/**/*.twig',
		'./blocks/**/*.twig',
	],
	safelist: [
		'text-2xl',
		'text-3xl'
	],
	theme: {
		container: {
			padding: '2rem',
			center: true,
		},
		screens: {
			'sm': '640px',
			'md': '768px',
			'lg': '1024px',
			'xl': '1280px'
		},
		extend: {
			fontFamily: {
				'sans': ['Open Sans'],
			},
			// Here you can set widths you use in wp blocks
			screens: {
				'wp-none': '768px',
				'wp-wide': '1200px',
				'wp-full': '1660px',
			},
			colors
		},
	},
	corePlugins: {
		aspectRatio: false,
	},
	plugins: [
		require('@tailwindcss/typography'),
		require('@tailwindcss/aspect-ratio'),
	],
}

// Create hover states for the safelist
colorList.forEach((color) => {
	tailwindconfig.safelist.push('hover:bg-' + color);
	tailwindconfig.safelist.push('bg-' + color);
	tailwindconfig.safelist.push('text-' + color);
	tailwindconfig.safelist.push('border-' + color);
});

// Export the config as module
module.exports = tailwindconfig;
