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
			colors: {
				primary: {
					100: "#fbfbff",
					200: "#f8f6ff",
					300: "#f4f2fe",
					400: "#f1edfe",
					500: "#ede9fe",
					600: "#bebacb",
					700: "#8e8c98",
					800: "#5f5d66",
					900: "#2f2f33"
				},
			},
			// Here you can set widths you use in wp blocks
			screens: {
				'wp-none': '768px',
				'wp-wide': '1200px',
				'wp-full': '100%',
			},
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
