
const fs = require('fs')

const themeJson = fs.readFileSync('./theme.json')
const theme = JSON.parse(themeJson)


const colors = theme.settings.color.palette.reduce((acc, item) => {
	const [color, number] = item.slug.split('-')

	// If there is a number identifier, make this an object
	if (undefined !== number) {
		if (!acc[color]) {
			acc[color] = {}
		}
		acc[color][number] = item.color
	} else {
		acc[color] = item.color
	}

	return acc

}, {});

// TODO make single line function with reduce
let colorList = [];
for (color in colors) {
	colorList.push(color);
}



module.exports = {
	content: [
		'./templates/**/*.twig',
		'./blocks/**/*.twig',
	],
	safelist: [
		'text-2xl',
		'text-3xl',
		{
			pattern: /^object-/,
			variants: ['lg', 'hover', 'focus', 'lg:hover'],
		},
		{
			pattern: /^bg-/,
			variants: colorList,
		},
		{
			pattern: /^text-/,
			variants: colorList,
		},
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
