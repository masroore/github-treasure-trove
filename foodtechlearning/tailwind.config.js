const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
    mode: process.env.NODE_ENV ? 'jit' : undefined,
    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    500: "#FD7924",
                    600: "#E21B32"
                },
                secondary: {
                    500: "#FFD53D"
                }
            }

        },
    },
    variants: {
        extend: {
        }
    },
    purge: [
        './app/**/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.twig',
        './storage/framework/views/*.php',
    ],
    whitelistPatterns: [/^media-library/],
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
