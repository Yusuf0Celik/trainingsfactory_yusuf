/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        extend: {},
        colors: {
            white: '#fff',
            black: '#000',
            grey: '#D3D3D3',
            primary: '#2E8B57',
        },
        backgroundImage: {
            'header': "url('/img/header-1.jpg')",
        },
    },
    plugins: [],
}