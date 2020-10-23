const {watch, parallel, src, dest} = require('gulp'),
    sass = require('gulp-sass'),
    browserSync = require('browser-sync'),
    rename = require('gulp-rename'),
    autoprefixer = require('gulp-autoprefixer'),
    cleancss = require('gulp-clean-css'),
    sourcemaps = require('gulp-sourcemaps'),
    notify = require('gulp-notify'),
    babel = require('gulp-babel'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat');

sass.compiler = require('node-sass');

function server() {
    browserSync.init({
        proxy : "localhost/trashApp/",
        notify : false
    });
}

function refresh() {
    watch('./assets/css/src/**/*.scss', parallel(styles));
    watch('./assets/js/src/**/*.js', parallel(scripts));
    watch(['**/*.php']).on('change', browserSync.reload);
}

function scripts() {
    return src(['./assets/js/src/**/*.js',])
    .pipe(babel({presets : ['@babel/env']}))
    .pipe(uglify())
    .pipe(dest('./assets/js/dist'))
    .pipe(browserSync.stream());
}

function styles() {
    return src('./assets/css/src/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle : 'compressed'}).on('error', notify.onError()))
    .pipe(rename({suffix : '.min', prefix: ''}))
    .pipe(autoprefixer(['last 15 versions']))
    .pipe(cleancss({level : {1 : {specialComments: 0}}}))
    .pipe(sourcemaps.write())
    .pipe(dest('./assets/css/dist'))
    .pipe(browserSync.stream());
};

exports.build = parallel(scripts, styles);
exports.default = parallel(server, refresh);