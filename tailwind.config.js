/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./templates/**/*.twig", "./blocks/**/*.twig"],
  theme: {
    container: {
      center: true,
      padding: "1rem",
    },
    extend: {},
  },
  plugins: [
    require("@tailwindcss/typography"),
    // require("@tailwindcss/aspect-ratio"),
  ],
};
