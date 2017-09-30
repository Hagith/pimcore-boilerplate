# Pimcore 4 boilerplate

**[Pimcore](http://www.pimcore.org) boilerplate on steroids for rapid project development.**

[![pimcore release](https://img.shields.io/badge/pimcore-4.6.2-brightgreen.svg)](https://packagist.org/packages/rafalgalka/pimcore-boilerplate)
[![Dependency Status](https://david-dm.org/Hagith/pimcore-boilerplate.svg)](https://david-dm.org/Hagith/pimcore-boilerplate)
[![devDependency Status](https://david-dm.org/Hagith/pimcore-boilerplate/dev-status.svg)](https://david-dm.org/Hagith/pimcore-boilerplate#info=devDependencies)

## About

Fully featured development environment powered by awesome tools:
- docker image (Apache, PHP 7, composer)
- docker-compose (mysql, nginx proxy, node.js)
- webpack (ES6, SASS) with browser-sync

## Usage

TODO

## TODO
- docker image that meets all pimcore requirements  
  https://github.com/pimcore/docker-pimcore-demo-standalone  
  https://github.com/Riodigital-de/docker-compose-pimcore-demo/tree/master/php/alpine
- webpack-hot-middleware  
  https://github.com/glenjamin/webpack-hot-middleware  
  https://matmunn.me/post/webpack-browsersync-php/
- production assets optimization (UglifyJS, CSSNano)
- split docker-compose environments (development, production)
