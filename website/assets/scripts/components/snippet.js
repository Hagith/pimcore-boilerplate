var bus = require('../utils/eventbus');
//var viewport = require('../utils/viewport');
var Vue = require('vue');

var Snippet = Vue.extend({
  el: function() {
    return '[data-component="snippet"]';
  },
  data: function () {
    return {
      isMobile: undefined,
      background: undefined,
      msg: 'Hello! I\'m snippet!'
    }
  },
  created: function() {
    this.background = (this.isMobile) ? 'green' : 'yellow';
    bus.on('viewport.isMobile', function(isMobile) {
      this.background = (isMobile) ? 'green' : 'yellow';
    }.bind(this));
  },
  ready: function() {

    setTimeout(function() {
      this.msg = 'I like Vue!'
    }.bind(this), 2000);
  }
});

Vue.component('snippet', Snippet);

module.exports = Snippet;
