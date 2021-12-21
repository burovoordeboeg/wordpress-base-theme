module.exports = {
	content: [
		'./views/**/*.twig'
	],
	theme: {
		container: {
			padding: {
				DEFAULT: '1rem',
				sm: '2rem',
			},
			center: true,
		},
		extend: {},
	},
	plugins: [
		require('@tailwindcss/typography'),
		require('@tailwindcss/forms'),
		require('@tailwindcss/line-clamp'),
		// require('@tailwindcss/aspect-ratio'),
	],
}
