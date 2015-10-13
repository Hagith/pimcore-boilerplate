var gulp = require('gulp');
var _ = require('lodash');
var Stream = require('merge-stream');
var config = require('../config').fonts;

gulp.task('fonts', function() {
  var stream = new Stream();

  _.each(config.vendors, function(path, name) {
    stream.add(gulp.src(path)
        .pipe(gulp.dest(config.dest + '/' + name)));
  });

  return stream;
});
