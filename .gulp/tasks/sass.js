var gulp = require('gulp');
var gutil = require('gulp-util');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var config = require('../config').sass;

gulp.task('sass', function() {
  return gulp.src(config.src + '/*.scss')
      .pipe(sourcemaps.init())
      .pipe(sass(config.options))
      .pipe(autoprefixer(config.autoprefixer))
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(config.dest));
});
