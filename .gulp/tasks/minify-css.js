var gulp = require('gulp');
var config = require('../config');
var minify = require('gulp-minify-css');
var size = require('gulp-size');

gulp.task('minify-css', ['sass'], function() {
  return gulp.src(config.paths.build + '/*.css')
      .pipe(minify({keepBreaks: true}))
      .pipe(gulp.dest(config.paths.build))
      .pipe(size())
      .pipe(size({gzip: true}));
});
