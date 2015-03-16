# pimcore boilerplate

[pimcore](http://www.pimcore.org) boilerplate on steroids for rapid project development.

[![pimcore release](https://img.shields.io/packagist/v/rafalgalka/pimcore-boilerplate.svg?style=flat)](https://packagist.org/packages/rafalgalka/pimcore-boilerplate)

## Getting started

Clone this repo or use [composer](https://getcomposer.org/download/)
```sh
php composer.phar create-project rafalgalka/pimcore-boilerplate [my-project] dev-master
```

Inside project root:
```sh
npm install
gulp
gulp publish
gulp deploy
```

Gulp tasks:
 * ```gulp``` - build development files and start watching changes
 * ```gulp publish``` - compress and optimize files (in progress)
 * ```gulp deploy``` - rsync files with your server (in progress)

## Steroids used (alphabetic order)
 * [bootstrap-sass](https://github.com/twbs/bootstrap-sass)
 * [browserify](https://github.com/substack/node-browserify)
 * [font-awesome](https://github.com/FortAwesome/Font-Awesome)
 * [gulp](https://github.com/gulpjs/gulp)
 * [gulp-autoprefixer](https://github.com/sindresorhus/gulp-autoprefixer)
 * [gulp-livereload](https://github.com/vohof/gulp-livereload)
 * [gulp-sass](https://github.com/dlmanning/gulp-sass)
 * [gulp-sourcemaps](https://github.com/floridoo/gulp-sourcemaps)
 * [gulp-spritesmith](https://github.com/twolfson/gulp.spritesmith)
 * [npm](https://www.npmjs.com/)
 * [sass](http://sass-lang.com/)
 * [spritesmith](https://github.com/Ensighten/spritesmith)
 * [watchify](https://github.com/substack/watchify)

# TODO
 * install script for ```composer create-project```
