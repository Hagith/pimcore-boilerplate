var path = require('path');

var dirs = {};
dirs.fonts = 'fonts';
dirs.images = 'images';
dirs.scripts = 'scripts';
dirs.styles = 'styles';
dirs.views = 'views';

var paths = {};
paths.base = 'website';
paths.src = paths.base + '/assets';
paths.build = paths.src + '/build';

paths.fonts = path.join(paths.src, dirs.fonts);
paths.images = path.join(paths.src, dirs.images);
paths.scripts = path.join(paths.src, dirs.scripts);
paths.styles = path.join(paths.src, dirs.styles);
paths.views = path.join(paths.base, dirs.views);
paths.vendor = 'node_modules';

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
    src: paths.styles,
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
  },

  fonts: {
    dest: path.join(paths.build, dirs.fonts),
    vendors: {
      'bootstrap': paths.vendor + '/bootstrap-sass/assets/fonts/bootstrap/*',
      'font-awesome': paths.vendor + '/font-awesome/fonts/*'
    }
  }
};
