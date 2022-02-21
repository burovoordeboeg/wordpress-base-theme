module.exports = {
  content: [
    './templates/**/*.twig',
	'./blocks/**/*.twig',
  ],
  safelist:[
    'is-style-indent',
	'lulkoek',
    {
      pattern: /grid-cols-(1|2|3|4|5|6)/,
      variants: ['lg', 'md', 'sm'],
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
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
