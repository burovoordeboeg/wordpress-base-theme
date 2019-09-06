/*eslint-disable*/

/**
 * Gulpfile
 *
 * Builds the theme 
 *
 * @author     Justin Streuper
 * @copyright  2019 VisualMasters
 * @license    GPL License
 * @version    1.0.2
 * @link       https://www.visualmasters.nl
 * @since      File available since Release 0.1.0
 */

// Set the dependencies
var del = require('del');
var browsersync = require('browser-sync');

var gulp = require('gulp');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var cleanCSS = require('gulp-clean-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var replace = require('gulp-replace');

var cache = require('gulp-cache');
var imagemin = require('gulp-imagemin');

var pkg = require("./package");

// Set the locations
var directories = {
    'node': './node_modules',
    'src': './dev',
    'dest': './dist',
    'blocks': './views/blocks'
};

var vendors = [

];


// ======================================================================
// BrowserSync

function browserSync(done) {
    browsersync.init({
        proxy: 'http://localhost:8000',
        ghostMode: {
            clicks: false,
            location: false,
            scroll: false
        }
    });
    done();
}

function browserSyncReload(done) {
    cache.clearAll();
    browsersync.reload({ stream: true });
    done();
}


// ======================================================================
// SASS

// Function to compile the base sass
function sassTheme() {
    var plugins = [
        autoprefixer()
    ];

    return gulp.src(directories.src + '/sass/styles.scss')
        .pipe(sass({
            includePaths: [
                directories.src + '/base',
                directories.src + '/components',
                directories.src + '/layout',
            ]
        }))
        .pipe(postcss(plugins))
        .pipe(cleanCSS())
        .pipe(gulp.dest(directories.dest + '/css'))
        .pipe(browsersync.stream());
}

// ======================================================================
// Scripts

// Compile the theme javascript files and vendors
function jsTheme(done) {
    // Compile theme JS
    gulp.src(directories.src + '/js/**/*.js')
        .pipe(concat('scripts.js'))
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
            interlaced: true,
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
    console.log('----------------------------------------');
    console.error('There was an error compiling ' + functionName + ' in ' + filename);
    console.error(errorMesssage);
    console.log('----------------------------------------');
}

// Build function for the style.css and update.json for setting 
// the correct theme version number from the package.json file
function buildTheme(done) {
    var version = pkg.version;
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
    gulp.watch('./dev/sass/**/*.scss', sassTheme);
    gulp.watch('./dev/js/**/*.js', jsTheme);
    gulp.watch('./dist/js/*.js', browserSyncReload);
    gulp.watch('./*.php', browserSyncReload);
    gulp.watch('./**/*.php', browserSyncReload);
    gulp.watch('./dev/img/*', minifyImages);
    done();
}


/* -------
  Export the Gulp tasks
------- */
exports.default = gulp.series([
    cleanupDist,
    clearCache,
    sassTheme,
    jsTheme,
    moveFonts,
    minifyImages,
    browserSync,
    watchFiles,
]);

// Export theme compilation
exports.sassTheme = gulp.task(sassTheme);
exports.jsTheme = gulp.task(jsTheme);

// Export assets compilation
exports.minifyImages = gulp.task(minifyImages);
exports.moveFonts = gulp.task(moveFonts);

// Setup the watcher
exports.watchFiles = gulp.task(watchFiles);

// Use the buildTheme option for version setting in the style.css (first run npm version command)
exports.build = gulp.series([
    cleanupDist,
    clearCache,
    sassTheme,
    jsTheme,
    moveFonts,
    minifyImages,
    buildTheme
]);
