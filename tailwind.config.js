module.exports = {
	mode: 'jit',
	purge: ['views/**/*.twig'],
	darkMode: false, // or 'media' or 'class'
	options: {
		safelist: ['is--active']
	},
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

			xl: '1280px'
			// => @media (min-width: 1280px) { ... }
		},
		extend: {
			fontFamily: {
				// display: '"Open Sans, Helvetica, Arial, sans-serif',
				// sans: 'myriad-pro, Helvetica, Arial, sans-serif'
			},
			fontSize: {
				// '5xl': '2.5rem'
			},
			colors: {
				// primary: {
				//     DEFAULT: '#0071B9',
				//     50: '#E6F1F8',
				//     100: '#86D0FF',
				//     200: '#53BCFF',
				//     300: '#20A8FF',
				//     400: '#0090EC',
				//     500: '#0071B9',
				//     600: '#005286',
				//     700: '#003353',
				//     800: '#001420',
				//     900: '#000000'
				// }
			},
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
