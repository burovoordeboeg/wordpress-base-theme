/**
 * Gulpfile
 *
 * Builds the theme
 *
 * @author     Justin Streuper
 * @copyright  2019 VisualMasters
 * @license    GPL License
 * @version    1.1.0
 * @link       https://www.visualmasters.nl
 * @since      File available since Release 0.1.0
 */

const autoprefixer = require('autoprefixer');
const babel = require('gulp-babel');
const browsersync = require('browser-sync');
const cleanCSS = require('gulp-clean-css');
const cache = require('gulp-cache');
const concat = require('gulp-concat');
const del = require('del');
const eslint = require('gulp-eslint');
const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const pkg = require('./package');
const postcss = require('gulp-postcss');
const replace = require('gulp-replace');
const sass = require('gulp-sass');
const sassLinter = require('gulp-sass-lint');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');


// Set the locations
const directories = {
    'node': './node_modules',
    'src': './dev',
    'dest': './dist'
};

const vendors = [

];


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

function sassLint() {
    return gulp.src(directories.src + '/**/*.scss')
        .pipe(sassLinter({ configFile: '.sasslintrc' }))
        .pipe(sassLinter.format())
        .pipe(sassLinter.failOnError())
}

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
                directories.src + '/partials'
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
                directories.src + '/partials'
            ]
        }))
        .pipe(postcss(plugins))
        .pipe(cleanCSS())
        .pipe(gulp.dest(directories.dest + '/css'))
        .pipe(browsersync.stream());
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

// Compile the theme javascript files and vendors for development
function jsThemeDevelopment(done) {
    // Compile theme JS
    gulp.src([
        directories.src + '/js/**/*.js',
        '!' + directories.src + '/js/plugins/*.js'
    ])
        .pipe(sourcemaps.init())
        .pipe(concat('scripts.js'))
        .pipe(babel({
            presets: ['@babel/env']
        }))
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
    console.error('----------------------------------------'); // eslint-disable-line no-console
    console.error('There was an error compiling ' + functionName + ' in ' + filename); // eslint-disable-line no-console
    console.error(errorMesssage); // eslint-disable-line no-console
    console.error('----------------------------------------'); // eslint-disable-line no-console
}

// Build function for the style.css and update.json for setting
// the correct theme version number from the package.json file
function buildTheme(done) {
    const version = pkg.version;
    gulp.src(['style.css'])
        .pipe(replace(/[0-9]\.[0-9]\.[0-9]/g, version))
        .pipe(gulp.dest('./'));
    done();
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
    jsLint,
    jsThemeDevelopment,
    moveFonts,
    minifyImages,
    browserSync,
    watchFiles
]);

// Export linters
exports.sassLint = gulp.task(sassLint);
exports.jsLint = gulp.task(jsLint);

// Export theme compilation
exports.sassTheme = gulp.task(sassThemeDevelopment);
exports.jsTheme = gulp.task(jsThemeDevelopment);

// Export assets compilation
exports.minifyImages = gulp.task(minifyImages);
exports.moveFonts = gulp.task(moveFonts);

// Setup the watcher
exports.watchFiles = gulp.task(watchFiles);

// Use the buildTheme option for version setting in the style.css (first run npm version command)
exports.build = gulp.series([
    cleanupDist,
    clearCache,
    sassThemeDevelopment,
    jsLint,
    jsThemeDevelopment,
    moveFonts,
    minifyImages,
    buildTheme
]);

// Use the buildTheme option for version setting in the style.css (first run npm version command)
exports.buildProd = gulp.series([
    cleanupDist,
    clearCache,
    sassThemeProduction,
    jsLint,
    jsThemeProduction,
    moveFonts,
    minifyImages,
    buildTheme
]);
