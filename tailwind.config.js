module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Http/Livewire/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                "iqrain-pink": "#F387A9",
                "iqrain-yellow": "#FFC801",
                "iqrain-blue": "#56B1F3",
                "iqrain-dark-blue": "#234275",
            },
        },
    },
    plugins: [],
};
