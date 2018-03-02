let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
	.scripts([
	'resources/assets/js/jquery-3.3.1.js',//*1webpack.mix
	'resources/assets/js/bootstrap.js',//*2webpack.mix
	'resources/assets/js/toastr.js',//*3webpack.mix
	'resources/assets/js/vue.js',//
	'resources/assets/js/axios.js',//*4webpack.mix
	'resources/assets/js/app.js',//

	], 'public/js/app.js')

	.styles([
	'resources/assets/css/bootstrap.css',//*5webpack.mix
	'resources/assets/css/toastr.css',

	],'public/css/app.css')//*6webpack.mix

	;