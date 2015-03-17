'use strict';

window.jQuery = window.$ = require('jquery');
require('bootstrap-sass');

var config = require('./app/config');
var viewport = require('./utils/viewport')(config.viewport);
var Vue = require('vue');

// vue components
require('./components/snippet');

var root = new Vue({
  el: 'body',
  data: {
    title: 'Hello Browserify & Vue.js!'
  },

  beforeCompile: function() {
    // load vue components found in page content
    var components = $(this.$el).find('[data-component]');
    var name, ctor, component;
    $.each(components, function(i, el) {
      name = $(el).data('component');
      ctor = Vue.component(name);
      if (ctor) {
        component = new ctor({
          data: {
            isMobile: viewport.isMobile()
          }
        });
      }
    }.bind(this));
  }
});

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
