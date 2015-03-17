'use strict';

window.jQuery = window.$ = require('jquery');
require('bootstrap-sass');

var Vue = require('vue');
var page = require('page');

var config = require('./app/config');
var router = require('./app/router');
var viewport = require('./utils/viewport');

// routes
require('./routes/page');

// vue components
require('./components/snippet');

var app = new Vue({
  el: 'body',
  data: {
    title: 'Hello Browserify & Vue.js!'
  },

  created: function() {
    router.init();
  },

  beforeCompile: function() {
    // load vue components found in page content
    var components = $(this.$el).find('[data-component]');
    var name, ctor, component;
    for (var i = 0, max = components.length; i < max; i++) {
      name = $(components[i]).data('component');
      component = Vue.component(name);
      if (component) {
        new component();
      }
    }
  }
});
