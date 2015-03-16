/**
 * browserify task
 * ---------------
 * Bundle javascript things with browserify!
 *
 * This task is set up to generate multiple separate bundles, from
 * different sources, and to use Watchify when run from the watch task.
 * See browserify.bundles in .gulp/config.js
 *
 * Source: https://github.com/greypants/gulp-starter/tree/2.0
 */
var gulp = require('gulp');
var watchify = require('watchify');
var browserify = require('browserify');
var source = require('vinyl-source-stream');
var _ = require('lodash');

var bundleLogger = require('../utils/bundleLogger');
var handleErrors = require('../utils/handleErrors');
var config = require('../config').browserify;

var task = function(callback, watch) {

  var bundleQueue = config.bundles.length;

  var browserifyThis = function(bundleConfig) {

    // Passing these options directly to Browserify has been
    // unreliable, so we'll apply them manually through the API
    var optionList = ['transform', 'plugin', 'require', 'external'];
    var options = _.pick(bundleConfig, optionList);
    bundleConfig = _.omit(bundleConfig, optionList);

    if (watch) {
      // Add watchify args and debug (sourcemaps) option
      _.extend(bundleConfig, watchify.args, {debug: true});
    }

    var b = browserify(bundleConfig);

    // Apply additional browserify options
    for (var key in options)
      b[key](options[key]);

    var bundle = function() {
      bundleLogger.start(bundleConfig.outputName);

      return b.bundle()
          .on('error', handleErrors)
          .pipe(source(bundleConfig.outputName))
          .pipe(gulp.dest(bundleConfig.dest))
          .on('end', reportFinished);
    };

    if (watch) {
      // Wrap with watchify and rebundle on changes
      b = watchify(b);
      b.on('update', bundle);
      bundleLogger.watch(bundleConfig.outputName);
    }

    var reportFinished = function() {
      bundleLogger.end(bundleConfig.outputName);

      if (bundleQueue) {
        bundleQueue--;
        if (bundleQueue === 0) {
          // If all bundles have been bundled, tell gulp the task is complete.
          // https://github.com/gulpjs/gulp/blob/master/docs/API.md#accept-a-callback
          callback();
        }
      }
    };

    return bundle();
  };

  // Start bundling with Browserify for each bundle
  config.bundles.forEach(browserifyThis);
};

gulp.task('browserify', task);

// Exporting the task so we can call it directly in our watch task, with the 'watch' option
module.exports = task;
