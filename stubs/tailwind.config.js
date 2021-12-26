const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

const customColors = {

};

module.exports = {
    presets: [],
    content: [
        './resources/js/**/*.js',
        './resources/views/**/*.blade.php',
        './resources/css/safelist.txt',
    ],
    safelist: [],
    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            colors: customColors,
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
        require('tailwindcss-debug-screens'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio')
    ],
}
