var notify = require('gulp-notify');

module.exports = function(error) {
  notify.onError(error.stack).apply(this, arguments);
  // Keep gulp from hanging on this task
  this.emit('end');
};
