const gulp        = require('gulp');
const cleanCss    = require('gulp-clean-css');
const sass        = require('gulp-sass')(require('sass'));
const terser      = require('gulp-terser');
const sourcemaps  = require('gulp-sourcemaps');
const plumber     = require('gulp-plumber');
const notify      = require('gulp-notify');
const concat      = require('gulp-concat');
const rename      = require('gulp-rename');
const browserSync = require('browser-sync').create();

// ─── Config ────────────────────────────────────────────────────────────────────

const domain = 'til.test';

const paths = {
    sass: {
        src:  'app/scss/**/*.scss',
        dest: 'public/css',
    },
    css: {
        src:  'app/css/**/*.css',
        dest: 'public/css',
    },
    js: {
        src: [
            // Libs — order matters
            'node_modules/jquery/dist/jquery.js',
            'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
            // 'node_modules/gsap/dist/all.js',
            'node_modules/gsap/dist/gsap.js',
            // 'node_modules/gsap/dist/DrawSVGPlugin.js',
            // 'node_modules/gsap/dist/MorphSVGPlugin.js',
            // 'node_modules/gsap/dist/CustomEase.js',
            // 'node_modules/gsap/dist/SplitText.js',
            // App code last
            'app/js/main.js',
        ],
        dest: 'public/js',
    },
    ss: {
        watch: 'app/templates/**/*.ss',
    },
};

// ─── Error handler ─────────────────────────────────────────────────────────────

const onError = function (err) {
    notify.onError({
        title:   'Gulp error in <%= error.plugin %>',
        message: '<%= error.message %>',
        sound:   'Basso',
    })(err);
    this.emit('end'); // keep watch alive on error
};

// ─── Tasks ─────────────────────────────────────────────────────────────────────

function css() {
    return gulp.src(paths.css.src)
        .pipe(plumber({ errorHandler: onError }))
        .pipe(cleanCss())
        .pipe(gulp.dest(paths.css.dest))
        .pipe(browserSync.stream());
}

function sassTask() {
    return gulp.src(paths.sass.src, { sourcemaps: true })
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sourcemaps.init())
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.sass.dest))
        .pipe(browserSync.stream({ match: '**/*.css' }));
}

function js() {
    return gulp.src(paths.js.src, { allowEmpty: true })
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sourcemaps.init())
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest(paths.js.dest))
        .pipe(rename('scripts.min.js'))
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.js.dest))
        .pipe(browserSync.stream());
}

function serve() {
    browserSync.init({
        proxy:  `https://${domain}`,
        host:   domain,
        https: {
            key:  './localhost+2-key.pem',
            cert: './localhost+2.pem',
        },
        port:   3000,
        notify: false,
        open:   true,
    });

    gulp.watch(paths.sass.src,  sassTask);
    gulp.watch(paths.css.src,   css);
    gulp.watch(paths.js.src,    js);
    gulp.watch(paths.ss.watch).on('change', browserSync.reload);
}

// ─── Exports ───────────────────────────────────────────────────────────────────

const build = gulp.parallel(sassTask, css, js);

exports.sass  = sassTask;
exports.css   = css;
exports.js    = js;
exports.build = build;
exports.serve = gulp.series(build, serve);
exports.default = exports.serve;




/*
to install local ssl cert - run this on terminal in the site dir:
mkcert localhost 127.0.0.1 ::1

browserSync.init({
  https: {
    key: './localhost+2-key.pem',
    cert: './localhost+2.pem'
  },
  ...
 */
