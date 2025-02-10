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
                    400: "#006547",
                    500: "#00573D",
                    600: "#004A3B",
                    700: "#003E38",
                    800: "#003232",
                    900: "#002529",
                },
                secondary: {
                    100: "#FFFBDB",
                    200: "#FFF7B7",
                    300: "#FFF293",
                    400: "#FFEC78",
                    500: "#FFE44B",
                    600: "#DBC036",
                    700: "#B79D25",
                    800: "#937B17",
                    900: "#7A630E",
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
                error: {
                    100: "#FBDCD2",
                    200: "#F7B3A6",
                    300: "#E97E76",
                    400: "#D45154",
                    500: "#B82132",
                    600: "#9E1833",
                    700: "#841032",
                    800: "#6A0A2F",
                    900: "#58062D",
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
