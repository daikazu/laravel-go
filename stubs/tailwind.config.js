const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

const customColors = {
    ...colors,
};

module.exports = {
    mode: 'jit',
    purge: {
        enabled: (process.env.APP_ENV === 'production'),
        content: [
            './resources/views/**/*.blade.php',
            './resources/css/safelist.txt',
        ],
        options: {
            safelist: []
        },
        preserveHtmlElements: true,
    },
    darkMode: false,
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
            }),
            aspectRatio: {},
            //region Typography (.prose)
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        maxWidth: theme('maxWidth["7xl"]'),
                        figure: {
                            img: {
                                borderRadius: theme('borderRadius.md'),
                                boxShadow: theme('boxShadow.DEFAULT')
                            }
                        },
                        a: {
                            color: theme('colors.gray.900', defaultTheme.colors.gray[900]),
                            textDecoration: theme('textDecoration.no-underline'),
                            fontWeight: '500',
                            '&:hover': {
                                color: theme('colors.gray.600'),
                                textDecoration: 'underline',
                            },
                        },
                        table: {
                            fontSize: theme('fontSize.lg'),
                            borderRadius: '50px',
                        },

                        thead: {
                            backgroundColor: theme('colors.gray.500'),
                            color: theme('colors.white'),
                            borderBottomWidth: '1px',
                            borderBottomColor: theme('colors.gray.600'),

                            '& tr th': {
                                textAlign: 'center',
                                padding: theme('spacing[2]'),
                            }
                        },
                        'tbody': {
                            backgroundColor: theme('colors.white'),
                        },
                        'tbody tr': {
                            borderBottomWidth: '1px',
                            borderBottomColor: theme('colors.gray.200'),
                            padding: theme('spacing[2]'),
                            '&:nth-child(even)': {
                                backgroundColor: theme('colors.gray.100'),
                            },

                            '& td:first-child': {
                                backgroundColor: theme('colors.gray.500'),
                                color: theme('colors.white'),
                                fontWeight: '600',
                                padding: theme('spacing[2]')
                            },

                        },
                        'tbody td': {
                            verticalAlign: 'middle',
                            '& sup': {
                                color: theme('colors.gray[400]'),
                            }
                        },
                        tfoot: {
                            backgroundColor: theme('colors.gray.800'),
                            color: theme('colors.white'),
                            textAlign: 'center',
                            '& tr th': {
                                padding: theme('spacing[1]')
                            },
                        },
                    }
                }
            }),
            //endregion
        },
    },
    variants: {
        extend: {}
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio')
    ],
}
