var gutil = require('gulp-util');

var paths = {};
paths.base = 'website';
paths.src = paths.base + '/assets';
paths.build = paths.src + '/build';
paths.images = paths.src + '/images';
paths.sass = paths.src + '/sass';
paths.scripts = paths.src + '/scripts';
paths.views = paths.base + '/views/';
paths.vendor = 'node_modules';

//console.log(gutil.env);
//if (gutil.env.dev === true) {
//}

module.exports = {
  paths: paths,

  browserify: {
    bundles: [{
      entries: './' + paths.scripts + '/index.js',
      dest: paths.build,
      outputName: 'site.js'
    }]
  },

  clean: [
    paths.build + '/*'
  ],

  sass: {
    src: paths.sass,
    dest: paths.build,
    options: {
      includePaths: [
        paths.vendor + '/bootstrap-sass/assets/stylesheets',
        paths.vendor + '/font-awesome/scss'
      ]
    },
    autoprefixer: {
      browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1'],
      cascade: false
    }
  },

  sprites: {
    src: paths.images + '/sprites/*.png',
    dest: {
      css: paths.build,
      image: paths.build
    },
    options: {
      cssName: '_sprites.scss',
      imgName: 'sprites.png',
      imgPath: '/' + paths.build + '/sprites.png',
      cssVarMap: function(sprite) {
        sprite.name = 'sprite-' + sprite.name;
      }
    }
  }
};
