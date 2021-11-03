module.exports = {
	mode: 'jit',
	purge: {
		content: ['views/**/*.twig'],
		safelist: ['is--active']
	},
	darkMode: false, // or 'media' or 'class'
	theme: {
		container: {
			center: true,
			padding: '2rem'
		},
		screens: {
			sm: '640px',
			// => @media (min-width: 640px) { ... }

			md: '768px',
			// => @media (min-width: 768px) { ... }

			lg: '1024px',
			// => @media (min-width: 1024px) { ... }

			xl: '1280px',
			// => @media (min-width: 1280px) { ... }
		},
		extend: {
			fontFamily: {
				display: 'Helvetica, Arial, sans-serif',
				sans: 'myriad-pro, Helvetica, Arial, sans-serif'
			},
			colors: {
				primary: {
					100: '#ffe0cc',
					200: '#ffc299',
					300: '#ffa366',
					400: '#ff8533',
					500: '#ff6600',
					600: '#cc5200',
					700: '#993d00',
					800: '#662900',
					900: '#331400'
				},
			},
			// This will effect styles within a prose class.
			// Mainly usefull to set defaults that will be rendered from wysiwyg blocks
			// https://github.com/tailwindlabs/tailwindcss-typography
			// DEFAULT STYLES https://github.com/tailwindlabs/tailwindcss-typography/blob/master/src/styles.js
			typography: (theme) => ({
				// DEFAULT: {
				//     css: {
				//         a: {
				//             color: theme('colors.primary.500'),
				//             textDecoration: 'none',
				//             fontWeight: '300'
				//         },
				//         h1: {
				//             color: theme('colors.primary.500'),
				//             fontFamily: theme('fontFamily.display')
				//         },
				//         h2: {
				//             color: theme('colors.primary.500'),
				//             fontFamily: theme('fontFamily.display')
				//         },
				//         h3: {
				//             color: theme('colors.primary.500'),
				//             fontFamily: theme('fontFamily.display')
				//         },
				//         h4: {
				//             color: theme('colors.primary.500'),
				//             fontFamily: theme('fontFamily.display')
				//         },
				//         h5: {
				//             color: theme('colors.primary.500'),
				//             fontFamily: theme('fontFamily.display')
				//         },
				//         h6: {
				//             color: theme('colors.primary.500'),
				//             fontFamily: theme('fontFamily.display')
				//         }
				//     }
				// }
			})
		}
	},
	variants: {
		extend: {}
	},
	plugins: [
		require('@tailwindcss/typography'),
		require('@tailwindcss/forms'),
		require('@tailwindcss/line-clamp'),
		require('@tailwindcss/aspect-ratio')
	]
};
