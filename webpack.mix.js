const path = require('path');
const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss')

const webpack = {
    resolve: {
        alias: {
            '@': path.resolve() + '//resources/app'
        },
    },
    devServer: {
        clientLogLevel: 'error'
    },
}

mix.webpackConfig(webpack)
mix.js('resources/app/app.js', 'app.js')
mix.sass('resources/app/app.scss', 'app.css')

mix.options({
    processCssUrls: false,
    postCss: [tailwindcss()],
})


