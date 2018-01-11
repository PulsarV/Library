'use strict';

var gulp = require('gulp'),
    watch = require('gulp-watch'),
    uglify = require('gulp-uglify'),
    sourcemaps = require('gulp-sourcemaps'),
    cleancss = require('gulp-clean-css'),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    del = require('del'),
    plumber = require('gulp-plumber')
;

var paths = {
  web: {
    js: 'web/js/',
    css: 'web/css/',
    images: 'web/images/',
    fonts: 'web/fonts/'
  },
  src: {
    js: 'web-src/js/**/*.*',
    jsLib: [
      'bower_components/bootstrap/dist/js/bootstrap.min.js',
      'bower_components/jquery/dist/jquery.min.js',
      'bower_components/chosen/chosen.jquery.min.js'
    ],
    css: 'web-src/css/**/*.*',
    cssLib: [
      'bower_components/bootstrap/dist/css/bootstrap.min.css',
      'bower_components/chosen/chosen.min.css'
    ],
    images: 'web-src/images/**/*.*',
    imagesLib: 'bower_components/chosen/chosen-sprite*.png',
    fontsLib: [
      'bower_components/bootstrap/dist/fonts/*.eot',
      'bower_components/bootstrap/dist/fonts/*.svg',
      'bower_components/bootstrap/dist/fonts/*.ttf',
      'bower_components/bootstrap/dist/fonts/*.woff',
      'bower_components/bootstrap/dist/fonts/*.woff2'
    ]
  },
  watch: {
    js: 'web-src/js/**/*.js',
    css: 'web-src/style/**/*.css',
    img: 'web-src/images/**/*.*'
  }
};

gulp.task('clean', function() {
  return del([
    paths.web.css,
    paths.web.js,
    paths.web.images,
    paths.web.fonts
  ]);
});

gulp.task('css', function() {
  return gulp.src(paths.src.css)
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(cleancss())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(paths.web.css));
});

gulp.task('css-lib', function() {
  return gulp.src(paths.src.cssLib)
    .pipe(plumber())
    .pipe(gulp.dest(paths.web.css));
});

gulp.task('js', function() {
  return gulp.src(paths.src.js)
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(paths.web.js));
});

gulp.task('js-lib', function() {
  return gulp.src(paths.src.jsLib)
    .pipe(plumber())
    .pipe(gulp.dest(paths.web.js));
});

gulp.task('img', function() {
  return gulp.src(paths.src.images)
    .pipe(imagemin({
      progressive: true,
      svgoPlugins: [{removeViewBox: false}],
      use: [pngquant()],
      interlaced: true
    }))
    .pipe(gulp.dest(paths.web.images));
});

gulp.task('img-lib', function() {
  return gulp.src(paths.src.imagesLib)
    .pipe(gulp.dest(paths.web.images));
});

gulp.task('font-lib', function() {
  return gulp.src(paths.src.fontsLib)
    .pipe(gulp.dest(paths.web.fonts));
});

gulp.task('default', gulp.series(['clean', 'css-lib', 'js-lib', 'css', 'js', 'img', 'img-lib', 'font-lib']));

gulp.task('watch', function() {
  gulp.watch(paths.src.css, gulp.series('css'));
  gulp.watch(paths.src.js, gulp.series('js'));
  gulp.watch(paths.src.img, gulp.series('img'));
});