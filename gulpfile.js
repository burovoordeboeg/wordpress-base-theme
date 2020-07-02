/**
 * Gulpfile
 *
 * Builds the theme
 *
 * @author     Justin Streuper
 * @copyright  2020 Buro voor de Boeg
 * @license    GPL License
 * @version    2.0.0
 * @link       https://www.burovoordeboeg.nl
 * @since      File available since Release 0.1.0
 */

const autoprefixer = require('autoprefixer');
const browsersync = require('browser-sync');
const cleanCSS = require('gulp-clean-css');
const cache = require('gulp-cache');
const concat = require('gulp-concat');
const del = require('del');
const fs = require('fs');
const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const loadTextFile = require('load-text-file');
const path = require('path');
const pkg = require('./package');
const postcss = require('gulp-postcss');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');


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
// BrowserSync

function browserSync(done) {
	browsersync.init({
		files: [
			'./**.php',
			'./**/**.php',
			'./**/**.twig',
			'./dist/js/**.js'
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

// Function to compile the base sass for development
function sassThemeDevelopment() {
	const plugins = [
		autoprefixer()
	];

	return gulp.src(directories.src + '/sass/styles.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({
			includePaths: [
				directories.src + '/base',
				directories.src + '/components',
				directories.src + '/layout',
				directories.src + '/templates'
			]
		}))
		.pipe(postcss(plugins))
		.pipe(cleanCSS())
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(directories.dest + '/css'))
		.pipe(browsersync.stream());
}

// Function to compile the base sass for production
function sassThemeProduction() {
	const plugins = [
		autoprefixer()
	];

	return gulp.src(directories.src + '/sass/styles.scss')
		.pipe(sass({
			includePaths: [
				directories.src + '/base',
				directories.src + '/components',
				directories.src + '/layout',
				directories.src + '/templates'
			]
		}))
		.pipe(postcss(plugins))
		.pipe(cleanCSS())
		.pipe(gulp.dest(directories.dest + '/css'))
		.pipe(browsersync.stream());
}

// Function to compile block styles
function sassBlocksDevelopment(done) {
	var plugins = [
		autoprefixer()
	];

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
				gulp.src(blockpath + '/dev/sass/**.scss')
					.pipe(sourcemaps.init())
					.pipe(sass())
					.pipe(postcss(plugins))
					.pipe(cleanCSS())
					.pipe(sourcemaps.write('./'))
					.pipe(gulp.dest(blockpath + '/dist/css'))
					.pipe(browsersync.stream());
			}
		}
	})

	blockDirs;
	done();
}

// Function to compile block styles
function sassBlocksProduction(done) {
	var plugins = [
		autoprefixer()
	];

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
				gulp.src(blockpath + '/dev/sass/**.scss')
					.pipe(sass())
					.pipe(postcss(plugins))
					.pipe(cleanCSS())
					.pipe(gulp.dest(blockpath + '/dist/css'))
					.pipe(browsersync.stream());
			}
		}
	})

	blockDirs;
	done();
}

// ======================================================================
// Scripts

// Compile the theme javascript files and vendors for development
function jsThemeDevelopment(done) {
	// Compile theme JS
	gulp.src([
		directories.src + '/js/**/*.js',
		'!' + directories.src + '/js/plugins/*.js'
	])
		.pipe(sourcemaps.init())
		.pipe(concat('scripts.js'))
		.pipe(uglify().on('error', function (uglify) {
			throwError('jsTheme', '', uglify.cause);
		}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(directories.dest + '/js'));

	// Compile the plugins
	gulp.src(directories.src + '/js/plugins/*.js')
		.pipe(sourcemaps.init())
		.pipe(concat('plugins.js'))
		.pipe(uglify().on('error', function (uglify) {
			throwError('jsTheme', '', uglify.cause);
		}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(directories.dest + '/js'));

	// Compile the vendors
	if (vendors.length > 0) {
		gulp.src(vendors)
			.pipe(sourcemaps.init())
			.pipe(concat('vendor.js'))
			.pipe(uglify().on('error', function (uglify) {
				throwError('jsTheme', '', uglify.cause);
			}))
			.pipe(sourcemaps.write('./'))
			.pipe(gulp.dest(directories.dest + '/js'));
	}

	done();
}

// Compile the theme javascript files and vendors for production
function jsThemeProduction(done) {
	// Compile theme JS
	gulp.src([
		directories.src + '/js/**/*.js',
		'!' + directories.src + '/js/plugins/*.js'
	])
		.pipe(concat('scripts.js'))
		.pipe(uglify().on('error', function (uglify) {
			throwError('jsTheme', '', uglify.cause);
		}))
		.pipe(gulp.dest(directories.dest + '/js'));

	// Compile the plugins
	gulp.src(directories.src + '/js/plugins/*.js')
		.pipe(concat('plugins.js'))
		.pipe(uglify().on('error', function (uglify) {
			throwError('jsTheme', '', uglify.cause);
		}))
		.pipe(gulp.dest(directories.dest + '/js'));

	// Compile the vendors
	if (vendors.length > 0) {
		gulp.src(vendors)
			.pipe(concat('vendor.js'))
			.pipe(uglify().on('error', function (uglify) {
				throwError('jsTheme', '', uglify.cause);
			}))
			.pipe(gulp.dest(directories.dest + '/js'));
	}

	done();
}

// Compile the block JS
function jsBlocksDevelopment(done) {
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
				gulp.src(blockpath + '/dev/js/**.js')
					.pipe(sourcemaps.init())
					.pipe(concat('scripts.js'))
					.pipe(uglify().on('error', function (uglify) {
						throwError('jsTheme', '', uglify.cause);
					}))
					.pipe(sourcemaps.write('./'))
					.pipe(gulp.dest(blockpath + '/dist/js'));
			}
		}
	});

	blockDirs;
	done();
}

// Compile the block JS for production
function jsBlocksProduction(done) {
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
				gulp.src(blockpath + '/dev/js/**.js')
					.pipe(concat('scripts.js'))
					.pipe(uglify().on('error', function (uglify) {
						throwError('jsTheme', '', uglify.cause);
					}))
					.pipe(gulp.dest(blockpath + '/dist/js'));
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
	gulp.watch('dev/sass/**/*.scss', sassThemeDevelopment);
	gulp.watch('dev/js/**/*.js', jsThemeDevelopment);
	gulp.watch('dev/img/*', minifyImages);
	done();
}


/* -------
  Export the Gulp tasks
------- */
exports.default = gulp.series([
	cleanupDist,
	clearCache,
	sassThemeDevelopment,
	jsThemeDevelopment,
	moveFonts,
	minifyImages,
	browserSync,
	watchFiles
]);

// Export theme compilation
exports.sassTheme = gulp.task(sassThemeDevelopment);
exports.jsTheme = gulp.task(jsThemeDevelopment);

// Export blocks compilation
exports.sassBlocks = gulp.task(sassBlocksDevelopment);
exports.jsBlocks = gulp.task(jsBlocksDevelopment);

// Export assets compilation
exports.minifyImages = gulp.task(minifyImages);
exports.moveFonts = gulp.task(moveFonts);

// Setup the watcher
exports.watchFiles = gulp.task(watchFiles);

// Export buildtheme
exports.buildTheme = gulp.task(buildTheme);

// Use the buildTheme option for version setting in the style.css (first run npm version command)
exports.build = gulp.series([
	cleanupDist,
	clearCache,
	sassThemeDevelopment,
	sassBlocksDevelopment,
	jsThemeDevelopment,
	jsBlocksDevelopment,
	moveFonts,
	minifyImages,
	buildTheme
]);

// Use the buildTheme option for version setting in the style.css (first run npm version command)
exports.buildProd = gulp.series([
	cleanupDist,
	clearCache,
	sassThemeProduction,
	sassBlocksProduction,
	jsThemeProduction,
	jsBlocksProduction,
	moveFonts,
	minifyImages,
	buildTheme
]);
