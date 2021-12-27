const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

const customColors = {

};

module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'css',
    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            colors:{
                // ...customColors
            },
            fontFamily: {
                'sans': ['Rubik', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: theme => ({
                // 'hero': "url('/images/hero.png')",
            })
        },
    },
    variants: {
        extend: {}
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('tailwindcss-debug-screens'),
    ],
}
