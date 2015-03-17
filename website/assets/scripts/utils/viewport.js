var EventEmitter = require('events').EventEmitter;
var inherits = require('inherits');

var config = require('../app/config').viewport;
config = config || {};

var isMobileState;

inherits(Viewport, EventEmitter);

function Viewport() {
  EventEmitter.call(this);

  this.mobileBreakpoint = config.mobileBreakpoint || 768;
  this.$window = $(window);

  // check / listen width
  this.onResize();
  this.$window.resize(this.onResize.bind(this));
}

Viewport.prototype.isMobile = function() {
  return this.$window.width() < this.mobileBreakpoint;
};

Viewport.prototype.onResize = function() {
  var isMobile = this.isMobile();

  if (isMobileState === isMobile) {
    return;
  }

  isMobileState = isMobile;
  this.emit('isMobile', isMobile);
};

module.exports = new Viewport();
