module.exports = {
    darkMode: 'class',
    content: ['./views/**/*.{html,js,ts,jsx,tsx,php}', './index.php'],
    // content: ['./**/*.php', './**/*.html', './**/*.js'],
    theme: {
        extend: {},
    },
    plugins: [require('daisyui')],
};
