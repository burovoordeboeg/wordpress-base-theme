/**
 * Gulpfile
 *
 * Builds the theme
 *
 * @author     Justin Streuper
 * @copyright  2020 Buro voor de Boeg
 * @license    GPL License
 * @version    2.1.0
 * @link       https://www.burovoordeboeg.nl
 * @since      File available since Release 0.1.0
 */

const autoprefixer = require('autoprefixer');
const browsersync = require('browser-sync');
const cleanCSS = require('gulp-clean-css');
const cache = require('gulp-cache');
const concat = require('gulp-concat');
const del = require('del');
const eslint = require('gulp-eslint');
const fs = require('fs');
const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const loadTextFile = require('load-text-file');
const path = require('path');
const pkg = require('./package');
const postcss = require('gulp-postcss');
const sass = require('gulp-sass');
const sassLinter = require('gulp-sass-lint');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');

// Set build parameter
let buildParam = 'development';

// Set the locations
const directories = {
	'node': './node_modules',
	'src': './dev',
	'dest': './dist',
	'blocks': './views/blocks/'
};

const vendors = [

];


// ======================================================================
// Directory mapping

function getDirectories(dir) {
	return fs.readdirSync(dir)
		.filter(function (file) {
			return fs.statSync(path.join(dir, file)).isDirectory();
		});
}

// ======================================================================
// Get and set the sourcemap state

function getSourcemapState() {
	return buildParam;
}

function setSourcemapStateToDevelopment(done) {
	buildParam = 'development';
	done();
}

function setSourcemapStateToProduction(done) {
	buildParam = 'production';
	done();
}

// ======================================================================
// BrowserSync

function browserSync(done) {
	browsersync.init({
		files: [
			'./**.php',
			'./**/**.php',
			'./**/**.twig',
			'./dist/js/**.js',
			'./views/blocks/**/dist/js/**.js'
		],
		watchEvents: ['change', 'add', 'unlink', 'addDir', 'unlinkDir'],
		proxy: 'http://localhost:8000',
		ghostMode: {
			clicks: false,
			location: false,
			scroll: false
		},
		reloadDelay: 200
	});
	done();
}


// ======================================================================
// SASS

function sassLint() {
	return gulp.src([
		directories.src + '/**/*.scss',
		directories.blocks + '/**/dev/sass/*.scss'
	])
		.pipe(sassLinter({ configFile: '.sasslintrc' }))
		.pipe(sassLinter.format())
		.pipe(sassLinter.failOnError())
}

function compileSass(fileSrc, fileDest, fileIncludes = []) {
	const plugins = [
		autoprefixer()
	];

	// Development
	if (getSourcemapState() === 'development') {
		return gulp.src(fileSrc)
			.pipe(sourcemaps.init())
			.pipe(sass({ includePaths: fileIncludes }).on('error', sass.logError))
			.pipe(postcss(plugins))
			.pipe(cleanCSS())
			.pipe(sourcemaps.write('./'))
			.pipe(gulp.dest(fileDest))
			.pipe(browsersync.stream());
	}

	// Production
	else {
		return gulp.src(fileSrc)
			.pipe(sass({ includePaths: fileIncludes }).on('error', sass.logError))
			.pipe(postcss(plugins))
			.pipe(cleanCSS())
			.pipe(gulp.dest(fileDest))
			.pipe(browsersync.stream());
	}
}

// Function to compile the base sass for development
function compileThemeSass(done) {
	// Compile the theme sass
	compileSass(
		directories.src + '/sass/styles.scss',
		directories.dest + '/css',
		[
			directories.src + '/base',
			directories.src + '/components',
			directories.src + '/layout',
			directories.src + '/templates'
		]
	);

	// Compile the editor sass
	compileSass(
		directories.src + '/sass/editor-styles.scss',
		directories.dest + '/css',
		[]
	);

	done();
}

// Function to compile block styles
function compileBlockSass(done) {
	// Get the blocks inside the block directory in a loop
	var blockDirs = getDirectories(directories.blocks).map(function (blocktype) {
		if (blocktype.length) {
			var blockpath = directories.blocks + '/' + blocktype;

			// Delete the dist folder if available
			if (fs.existsSync(blockpath + '/dist/css')) {
				del(blockpath + '/dist/css/*');
			}

			// Check if dev folder exists
			if (fs.existsSync(blockpath + '/dev/sass')) {
				compileSass(
					blockpath + '/dev/sass/**.scss',
					blockpath + '/dist/css',
					[]
				);
			}
		}
	})

	blockDirs;
	done();
}


// ======================================================================
// Scripts

function jsLint() {
	return gulp.src([
		'**/*.js',
		'!node_modules/**',
		'!dist/**',
		'!**/plugins/**',
		'!vendor/**'
	])
		.pipe(eslint())
		.pipe(eslint.format())
		.pipe(eslint.failAfterError());
}

function compileJs(fileSrc, fileDest, fileName) {
	// Development
	if (getSourcemapState() === 'development') {
		gulp.src(fileSrc)
			.pipe(sourcemaps.init())
			.pipe(concat(fileName + '.js'))
			.pipe(uglify().on('error', function (uglify) {
				throwError('Theme JavaScript error: ', '', uglify.cause);
			}))
			.pipe(sourcemaps.write('./'))
			.pipe(gulp.dest(fileDest));
	}

	// Production
	else {
		gulp.src(fileSrc)
			.pipe(concat(fileName + '.js'))
			.pipe(uglify().on('error', function (uglify) {
				throwError('Theme JavaScript error: ', '', uglify.cause);
			}))
			.pipe(gulp.dest(fileDest));
	}
}

// Compile the theme javascript files and vendors
function compileThemeJs(done) {
	// Compile theme JS
	compileJs(
		[
			directories.src + '/js/**/*.js',
			'!' + directories.src + '/js/plugins/*.js'
		],
		directories.dest + '/js',
		'scripts'
	);

	// Compile the plugins
	compileJs(
		directories.src + '/js/plugins/*.js',
		directories.dest + '/js',
		'plugins'
	);

	// Compile the vendors
	if (vendors.length > 0) {
		compileJs(
			vendors,
			directories.dest + '/js',
			'vendor'
		);
	}
	done();
}

// Compile the block JS
function compileBlockJs(done) {
	// Get the blocks inside the block directory in a loop
	var blockDirs = getDirectories(directories.blocks).map(function (blocktype) {
		if (blocktype.length) {
			var blockpath = directories.blocks + '/' + blocktype;

			// Delete the dist folder if available
			if (fs.existsSync(blockpath + '/dist/js')) {
				del(blockpath + '/dist/js/*');
			}

			// Check if dev folder exists
			if (fs.existsSync(blockpath + '/dev/js')) {
				compileJs(
					blockpath + '/dev/js/**.js',
					blockpath + '/dist/js',
					'scripts'
				);
			}
		}
	});

	blockDirs;
	done();
}


// ======================================================================
// Images

function minifyImages(done) {
	gulp.src(directories.src + '/img/**/*.+(png|jpg|jpeg|gif|svg)')
		.pipe(cache(imagemin({
			interlaced: true
		})))
		.pipe(gulp.dest(directories.dest + '/img'));
	done();
}

function minifyBlockImages(done) {
	// Get the blocks inside the block directory in a loop
	var blockDirs = getDirectories(directories.blocks).map(function (blocktype) {
		if (blocktype.length) {
			var blockpath = directories.blocks + '/' + blocktype;

			// Delete the dist folder if available
			if (fs.existsSync(blockpath + '/dist/img')) {
				del(blockpath + '/dist/img/*');
			}

			// Check if dev folder exists
			if (fs.existsSync(blockpath + '/dev/img')) {
				gulp.src(blockpath + '/dev/img/**/*.+(png|jpg|jpeg|gif|svg)')
					.pipe(cache(imagemin({
						interlaced: true
					})))
					.pipe(gulp.dest(blockpath + '/dist/img'));
			}
		}
	});

	blockDirs;
	done();


	done();
}


// ======================================================================
// Utils

// Clean the dist folder
function cleanupDist() {
	return del(directories.dest);
}

// Error function to throw the console error
function throwError(functionName, filename, errorMesssage) {
	/* eslint-disable */
	console.error('----------------------------------------');
	console.error('There was an error compiling ' + functionName + ' in ' + filename);
	console.error(errorMesssage);
	console.error('----------------------------------------');
	/* eslint-enable */
}

// Build function for the style.css and update.json for setting
// the correct theme version number from the package.json file
function buildTheme(done) {
	const version = pkg.version;

	loadTextFile('style.css').then((text) => {
		let styleCss = text.split('\n');
		let styleCssRows = [];
		styleCss.forEach((item) => {
			let rowContent = item.split(': ');

			if (rowContent[0] !== 'Version') {
				styleCssRows.push(item);
			} else {
				styleCssRows.push(rowContent[0] + ': ' + version);
			}
		});

		// Set the new version file
		newStyleCss = styleCssRows.join('\n');

		fs.writeFile('style.css', newStyleCss, done);
	});
}

// Move font folder to dist
function moveFonts(done) {
	gulp.src(directories.src + '/font/**')
		.pipe(gulp.dest(directories.dest + '/font'));
	done();
}

function clearCache(done) {
	cache.clearAll();
	done();
}


// ======================================================================
// Watcher

function watchFiles(done) {
	gulp.watch('dev/sass/**/*.scss', compileThemeSass);
	gulp.watch('dev/js/**/*.js', compileThemeJs);
	gulp.watch('views/blocks/**/dev/sass/*.scss', compileBlockSass);
	gulp.watch('views/blocks/**/dev/js/*.js', compileBlockJs);
	gulp.watch('dev/img/*', minifyImages);
	done();
}


// ======================================================================
// Export the Gulp tasks

// Export linters
exports.sassLint = gulp.task(sassLint);
exports.jsLint = gulp.task(jsLint);

// Export theme compilation
exports.compileThemeSass = gulp.task(compileThemeSass);
exports.compileThemeJs = gulp.task(compileThemeJs);

// Export blocks compilation
exports.compileBlockSass = gulp.task(compileBlockSass);
exports.compileBlockJs = gulp.task(compileBlockJs);

// Export assets compilation
exports.minifyImages = gulp.task(minifyImages);
exports.minifyBlock = gulp.task(minifyBlockImages);
exports.moveFonts = gulp.task(moveFonts);

// Setup the watcher
exports.watchFiles = gulp.task(watchFiles);

// Export buildtheme
exports.buildTheme = gulp.task(buildTheme);

// Export the default gulp action
exports.default = gulp.series([
	setSourcemapStateToDevelopment,
	cleanupDist,
	clearCache,
	sassLint,
	compileThemeSass,
	compileBlockSass,
	jsLint,
	compileThemeJs,
	compileBlockJs,
	moveFonts,
	minifyImages,
	minifyBlockImages,
	browserSync,
	watchFiles
]);

// Use the buildTheme option for version setting in the style.css (first run npm version command)
exports.build = gulp.series([
	setSourcemapStateToDevelopment,
	cleanupDist,
	clearCache,
	compileThemeSass,
	compileBlockSass,
	compileThemeJs,
	compileBlockJs,
	moveFonts,
	minifyImages,
	minifyBlockImages,
	buildTheme
]);

// Use the buildTheme option for version setting in the style.css (first run npm version command)
exports.buildProduction = gulp.series([
	setSourcemapStateToProduction,
	cleanupDist,
	clearCache,
	compileThemeSass,
	compileBlockSass,
	compileThemeJs,
	compileBlockJs,
	moveFonts,
	minifyImages,
	minifyBlockImages,
	buildTheme
]);
