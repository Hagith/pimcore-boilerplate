var notify = require('gulp-notify');
var gutil = require('gulp-util');

module.exports = function(error) {
  notify.onError(error.toString()).apply(this, arguments);
  gutil.log(error.stack);
  // Keep gulp from hanging on this task
  this.emit('end');
};
