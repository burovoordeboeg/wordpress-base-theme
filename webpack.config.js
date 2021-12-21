const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const ImageMinimizerPlugin = require("image-minimizer-webpack-plugin");

module.exports = {
	mode: 'development',
	entry: {
		'./js/scripts': './src/javascript/index.js',
	},
	output: {
		path: path.resolve(__dirname, 'dist'),
		filename: '[name].js',
		assetModuleFilename: 'images/[hash][ext][query]',
		clean: true,
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env']
					}
				}
			},
			{
				test: /\.(sa|sc|c)ss$/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader
					},
					{
						loader: "css-loader",
					},
					{
						loader: "postcss-loader"
					}
				]
			},
			{
				test: /\.jpeg/,
				type: 'asset/resource'
			},
		]
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: "css/styles.css"
		}),
		new BrowserSyncPlugin({
			host: 'localhost',
			port: 3000,
			proxy: 'http://localhost:8000',
		}),
		new ImageMinimizerPlugin({
			minimizer: {
				implementation: ImageMinimizerPlugin.squooshMinify,
				options: {
					mozjpeg: {
						// That setting might be close to lossless, but it’s not guaranteed
						// https://github.com/GoogleChromeLabs/squoosh/issues/85
						quality: 100,
					},
					webp: {
						lossless: 1,
					},
					avif: {
						// https://github.com/GoogleChromeLabs/squoosh/blob/dev/codecs/avif/enc/README.md
						cqLevel: 0,
					},
				},
			},
		})
	],
	watch: true
};