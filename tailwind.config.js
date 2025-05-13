/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/**/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                gold: "#C8A655",
                cream: "#F8F6F1",
                rosegold: "#E0C3B6",
                footergold: "#A67C24",
                theme: "var(--color-theme)",
                "theme-light": "var(--color-theme-light)",
            },
        },
    },
    plugins: [],
};
