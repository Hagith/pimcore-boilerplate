var bus = require('../utils/eventbus');

var Example = function() {
  if (!(this instanceof Example)) return new Example();

  this.viewportListener = function(isMobile) {
    this.init(isMobile);
  }.bind(this);

  bus.on('viewport.isMobile', this.viewportListener);
};

Example.prototype = {
  init: function(isMobile) {
    console.log('example init, isMobile: ' + isMobile);
  }
};

module.exports = Example;
