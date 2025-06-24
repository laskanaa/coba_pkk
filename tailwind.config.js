/** @type {import('tailwindcss').Config} */
export default {
    content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    ],
    safelist: [
        'bg-red-100', 'bg-yellow-100', 'bg-green-100',
        'bg-blue-100', 'bg-purple-100', 'bg-pink-100',
        'bg-gray-100'
      ],
    theme: {
        extend: {
          colors: {
            accent: '#3b82f6', // misalnya warna biru
            'accent-foreground': '#ffffff'
          }
        }
      },
    plugins: [],
};
