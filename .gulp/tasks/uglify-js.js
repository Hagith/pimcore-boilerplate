var gulp = require('gulp');
var config = require('../config');
var size = require('gulp-size');
var uglify = require('gulp-uglify');

gulp.task('uglify-js', ['browserify'], function() {
  return gulp.src(config.paths.build + '/*.js')
      .pipe(uglify())
      .pipe(gulp.dest(config.paths.build))
      .pipe(size())
      .pipe(size({gzip: true}));
});
