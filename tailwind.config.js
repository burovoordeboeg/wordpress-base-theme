module.exports = {
	content: [
		'./templates/**/*.twig'
	],
	safelist: [
		// 'bg-red-500',
		'aligncenter',
		'alignwide',
		'alignfull',
		'is-style-lead',
		{
			pattern: /wp-block/
		}
	],
	theme: {
		container: {
			padding: {
				DEFAULT: 'var(--wp--custom--spacing--small)',
				sm: 'var(--wp--custom--spacing--medium)'
			},
			center: true
		},
		extend: {
			colors: {
				primary: 'var(--wp--preset--color--black)',
				'dark-blue': 'var(--wp--preset--color--dark-blue)',
				'rotterdam-cta-oranje': 'var(--wp--preset--color--rotterdam-cta-oranje)',
				'rotterdam-groen': 'var(--wp--preset--color--rotterdam-groen)'
			},
			spacing: {
				'small': 'var(--wp--custom--spacing--small)',
				'medium': 'var(--wp--custom--spacing--medium)',
				'large': 'var(--wp--custom--spacing--large)',
				'xlarge': 'var(--wp--custom--spacing--xlarge)'
			},
			fontFamily: {
				'fa': ['"Font Awesome 5 Free"']
			}
		}
	},
	plugins: [
		require('@tailwindcss/typography'),
		require('@tailwindcss/forms'),
		require('@tailwindcss/line-clamp')
	],
	corePlugins: {
		preflight: false
	}
}
