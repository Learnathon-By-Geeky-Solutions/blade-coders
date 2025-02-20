import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        fontFamily: {
            sans: ['"Inter", sans-serif'],
        },
        fontSize: {
            sm: "0.75rem",
            base: "0.875rem",
            lg: "1.125rem",
            xl: "1.5rem",
            "2xl": "1.875rem",
            "3xl": "2.25rem",
            "4xl": "2.441rem",
            "5xl": "3.052rem",
        },

        extend: {
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        color: "#637381",
                        a: {
                            color: "#637381",
                            "&:hover": {
                                color: "#624BFF",
                            },
                        },
                    },
                },
            }),

            colors: {
                gray: {
                    100: "#f1f5f9",
                    200: "#f4f6f8",
                    300: "#dfe3e8",
                    400: "#c4cdd5",
                    500: "#919eab",
                    600: "#637381",
                    700: "#454f5b",
                    800: "#212b36",
                    900: "#161c24",
                },
                indigo: {
                    600: "#624bff",
                    800: "#5340d9",
                },
            },
        },
    },

    plugins: [forms({
        strategy: "base",
    }), typography],
};
