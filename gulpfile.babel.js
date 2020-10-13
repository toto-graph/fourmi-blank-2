import gulp from 'gulp';

const theme = './www/wp-content/themes/fourmi-theme';
const src = `${theme}/assets`;
const dist = `${theme}/dist`;
const vendors = [
    './node_modules/swiper/swiper-bundle.js',
];

const P = require("gulp-load-plugins")({
    pattern: ['gulp-*', 'gulp.*'],
    replaceString: /\bgulp[\-.]/
});

var log = require('fancy-log');

// ====================================================
// JS Vendor : Bower
// ====================================================
gulp.task('vendors', (done) => {
    gulp.src(vendors)
        .pipe(P.babel({
            presets: ['@babel/env']
        }))
        .pipe(P.concat('vendors.js'))
        .pipe(gulp.dest(`${dist}/js`))
        .pipe(P.rename('vendors.min.js'))
        .pipe(P.uglify())
        .on('error', log)
        .pipe(gulp.dest(`${dist}/js`));
    done();
});

// ====================================================
// JS Scripts
// ====================================================
gulp.task('scripts', (done) => {
    gulp.src([`${src}/js/*/*.js`, `${src}/js/*.js`])
        .pipe(P.babel({
            presets: ['@babel/env']
        }))
        .pipe(P.concat('scripts.js'))
        .pipe(gulp.dest(`${dist}/js`))
        .pipe(P.rename('scripts.min.js'))
        .pipe(P.uglify())
        .on('error', log)
        .pipe(gulp.dest(`${dist}/js`));
    done();
});

// ====================================================
// SASS Styles > CSS
// ====================================================
gulp.task('styles', (done) => {
    gulp.src([`${src}/sass/style.scss`])
        .pipe(P.dartSass({
            outputStyle: 'expanded',
            includePaths: [`${src}/sass`]
        }).on('error', P.dartSass.logError))
        .pipe(P.autoprefixer())
        .pipe(P.rename('style.css'))
        .pipe(gulp.dest(`${dist}/css`))
        .pipe(P.rename('style.min.css'))
        .pipe(P.uglifycss())
        .pipe(gulp.dest(`${dist}/css`));
    done();
});

// ====================================================
// Fonts
// ====================================================
gulp.task('fonts', (done) => {
    gulp.src([`${src}/fonts/*.ttf`])
        .pipe(gulp.dest(`${src}/fonts`));

    gulp.src([`${src}/fonts/*.ttf`]) 
        .pipe(P.ttf2eot())
        .pipe(gulp.dest(`${dist}/fonts`));

    gulp.src([`${src}/fonts/*.ttf`]) 
        .pipe(P.ttf2woff())
        .pipe(gulp.dest(`${dist}/fonts`));

    gulp.src([`${src}/fonts/*.ttf`]) 
        .pipe(P.ttfSvg())
        .pipe(gulp.dest(`${dist}/fonts`));

    gulp.src([`${src}/fonts/*.ttf`]) 
        .pipe(P.ttf2woff2())
        .pipe(gulp.dest(`${dist}/fonts`));
    done();
});

// ====================================================
// Images
// ====================================================
gulp.task('images', (done) => {
    gulp.src(`${src}/img/**`)
        .pipe(P.newer(`${dist}/img`))
        .pipe(P.imagemin([
            P.imagemin.gifsicle({interlaced: true}),
            P.imagemin.mozjpeg({progressive: true}),
            P.imagemin.optipng({optimizationLevel: 5}),
            P.imagemin.svgo()
        ]))
        .pipe(gulp.dest(`${dist}/img`));
    done();
});

// ====================================================
// WATCH
// ====================================================
gulp.task('watch:scripts', (done) => {
    P.watch([
        `${src}/js/**`,
    ], gulp.series('scripts'));
    done();
});

gulp.task('watch:styles', (done) => {
    P.watch([
        `${src}/sass/**`,
    ], gulp.series('styles'));
    done();
});

gulp.task('watch:images', (done) => {
    P.watch([
        `${src}/img/**`,
    ], gulp.series('images'));
    done();
});

// ====================================================
// BUILD
// ====================================================
export const watch = gulp.parallel('watch:scripts', 'watch:styles', 'watch:images');
export const build = gulp.parallel('vendors', 'scripts', 'styles', 'images', 'fonts');
export const prod = gulp.series(build, watch);
export default prod;