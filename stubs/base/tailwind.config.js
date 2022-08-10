const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');
const plugin = require("tailwindcss/plugin");

const customColors = {};

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
    ],
    darkMode: 'class',
    safelist: [],
    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            colors: {
                // ...customColors
            },
            fontFamily: {
                sans: ['Rubik', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: theme => ({
                // 'hero': "url('../assets/hero.png')",
            })
        },
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('tailwindcss-debug-screens'),

        plugin(function ({addBase, theme}) {
            addBase({
                ":root": {
                    // Fluid typography from 1 rem to 1.15 rem with fallback to 16px.
                    fontSize: "16px",
                    "font-size": "clamp(1rem, 1.6vw, 1.15rem)",
                    // Safari resize fix.
                    minHeight: "0vw",
                },
                // Used to hide alpine elements before being rendered.
                "[x-cloak]": {
                    display: "none !important",
                },
                // Implement the focus-visible polyfill: https://github.com/WICG/focus-visible
                ".js-focus-visible :focus:not(.focus-visible)": {
                    outline: "none",
                },
                // Disable scroll e.g. when a modal is open. Should be used on the <body>
                ".no-scroll": {
                    height: "100%",
                    overflow: "hidden",
                },
            });
        }),
    ],
}
