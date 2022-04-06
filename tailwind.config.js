module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        fontFamily: {
            display: ["Inter", "system-ui", "sans-serif"],
            body: ["Inter", "system-ui", "sans-serif"],
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
