/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
      './storage/framework/views/*.php',
      './resources/js/**/*.vue',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
