// /** @type {import('tailwindcss').Config} */
// export default {
//   darkMode: 'class',
//   // darkMode: ['attribute', 'class'], // agar bisa pakai dua-duanya
//   content: [
//     './resources/**/*.blade.php',
//     './resources/**/*.js',
//     './resources/**/*.vue',
//   ],
//   theme: {
//     extend: {},
//   },
//   plugins: [],
// }

import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import scrollbarHide from 'tailwind-scrollbar-hide';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/**/*.js',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },

  // plugins: [forms, require('tailwind-scrollbar-hide'),],
  plugins: [forms, require('tailwind-scrollbar'),],
  // plugins: [forms, scrollbarHide],
  // darkMode: 'selector'
  // darkMode: ['class', '[data-theme="dark"]'],
  darkMode: 'class',
};
