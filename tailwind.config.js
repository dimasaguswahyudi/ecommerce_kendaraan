import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    100: "#C5F6D4",
                    200: "#8EEEB5",
                    300: "#51CC8F",
                    400: "#269A6C",
                    500: "#00573D",
                    600: "#004A3B",
                    700: "#003E38",
                    800: "#003232",
                    900: "#002529",
                },
                secondary: {
                    100: "#f3fdfc",
                    200: "#e7faf8",
                    300: "#dbf7f4",
                    400: "#c4f1ec",
                    500: "#2dd4bf",
                    600: "#27b5a7",
                    700: "#1c7f72",
                    800: "#155f55",
                    900: "#0e3f39",
                },
                accent: {
                    100: "#fee5eb",
                    200: "#fecbd8",
                    300: "#fea2b9",
                    400: "#fd7493",
                    500: "#e11d48",
                    600: "#c61a41",
                    700: "#93122e",
                    800: "#6e0d22",
                    900: "#490815",
                },
                neutral: {
                    100: "#f7f9fa",
                    200: "#edf1f3",
                    300: "#d3d9dd",
                    400: "#aab1b8",
                    500: "#3d4451",
                    600: "#353b44",
                    700: "#25282d",
                    800: "#191b1f",
                    900: "#0c0d0f",
                },
            },
        },
    },

    plugins: [forms, require("daisyui")],
    daisyui: {
        themes: [
            {
                light: {
                    primary: "#00573d",
                    secondary: "#2dd4bf",
                    accent: "#e11d48",
                    neutral: "#3d4451",
                    "base-100": "#ffffff",
                },
            },
        ],
        darkTheme: false,
    },
};
