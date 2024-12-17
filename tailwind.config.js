/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src//*.{html,js,php}"],
  theme: {
    extend: {
        backgroundImage: {
            'homeBack': "url('./img/background.jpg')",
          }
    },
  },
  plugins: [],
}

