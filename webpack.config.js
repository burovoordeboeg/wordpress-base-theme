const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const ImageMinimizerPlugin = require("image-minimizer-webpack-plugin");



module.exports = {
	entry: './src/javascript/index.js',
	output: {
		path: path.resolve(__dirname, 'dist'),
		publicPath: '',
		filename: 'js/scripts.js',
		assetModuleFilename: 'images/[hash][ext][query]'
	},
	mode: 'development',
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
					},
					{
						loader: "sass-loader",
						options: {
							implementation: require("sass")
						}
					}
				]
			},
			{
				test: /\.jpeg/,
				type: 'asset/resource'
			},
			{
				test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
				use: [
					{
						loader: "file-loader",
						options: {
							outputPath: 'fonts/'
						}
					}
				]
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
		}),
	],
	watch: true
};