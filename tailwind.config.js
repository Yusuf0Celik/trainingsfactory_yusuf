/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.{vue,js,ts,jsx,tsx}",
        "./templates/**/*.{html,twig}",
    ],
    theme: {
        extend: {
            colors: {
                white: '#fff',
                black: '#000',
                grey: '#D3D3D3',
                primary: '#2E8B57',
                primaryDark: '#20633f',
            },
            backgroundImage: {
                // 'header': "url('/img/header-1.jpg')",
            },
        },
        plugins: [],
    },
}