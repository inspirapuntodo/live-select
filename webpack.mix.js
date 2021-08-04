const mix = require('laravel-mix');

mix.js('resources/js/liveselect.js', 'public/')
    .postCss("resources/css/liveselect.css", "public/", [
        require("tailwindcss"),
    ]);