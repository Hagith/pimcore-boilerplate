var gulp = require('gulp');
var spritesmith = require('gulp.spritesmith');
var config = require('../config').sprites;

gulp.task('sprites', function() {

  var spriteData = gulp
      .src(config.src)
      .pipe(spritesmith(config.options));

  spriteData.img.pipe(gulp.dest(config.dest.image));
  spriteData.css.pipe(gulp.dest(config.dest.css));

  return spriteData;
});
