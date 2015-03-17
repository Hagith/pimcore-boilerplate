'use strict';

window.jQuery = window.$ = require('jquery');
require('bootstrap-sass');


var config = require('./app/config');
var Viewport = require('./utils/viewport')(config.viewport);
//var viewport = new Viewport(config.viewport);
//var router = require('director');

// bind all links beginning with "/" to be routed by director
//$('body').on('click', 'a[href^="/"]:not(.btn-sell)', function(e) {
//  e.preventDefault();
//  var $el = $(e.currentTarget);
//  var href = $el.attr('href');
//  href = href.replace(/^\//, '');
//
//  // launch route handle when href not changed (index 2 == '#/' before href)
//  if (2 === window.location.hash.indexOf(href)) {
//    this.router.dispatch('on', '/' + href);
//  }
//  this.router.setRoute(href);
//}.bind(this));
