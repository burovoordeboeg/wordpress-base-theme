module.exports = {
  content: [
    './templates/**/*.twig',
	'./blocks/**/*.twig',
  ],
  safelist:[
	{
		pattern:/wp-block-.+/,
	}
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
    },
	typography: {
		default: {
		  	css: {
				maxWidth: '840px',
		  	},
		},
	},
  },
  
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
