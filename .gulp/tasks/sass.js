var gulp = require('gulp');
var gutil = require('gulp-util');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');
var handleErrors = require('../utils/handleErrors');
var config = require('../config').sass;

gulp.task('sass', function() {
  return gulp.src(config.src + '/*.scss')
      .pipe(sourcemaps.init())
      .pipe(plumber({
        errorHandler: handleErrors
      }))
      .pipe(sass(config.options))
      .pipe(autoprefixer(config.autoprefixer))
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(config.dest));
});
