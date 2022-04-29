module.exports = {
  content: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    container: {
      center: true,
    },
    extend: {
        colors: {
            'primary-red': '#c81e1c',
            'secondary-blue': "#79abd2"
        },
    },
  },
  plugins: [],
}
