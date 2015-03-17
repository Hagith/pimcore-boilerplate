var viewport = require('../utils/viewport');
var Vue = require('vue');

var Snippet = Vue.extend({
  name: 'snippet',

  el: function() {
    return '[data-component="snippet"]';
  },
  data: function () {
    return {
      background: viewport.isMobile() ? 'green' : 'yellow',
      msg: 'Hello! I\'m snippet!'
    }
  },
  created: function() {
    viewport.on('isMobile', function(isMobile) {
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
