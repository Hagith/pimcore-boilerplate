var eventbus = require('./eventbus');

var isMobileState;

var Viewport = function(options) {
  if (!(this instanceof Viewport)) return new Viewport(options);

  this.mobileBreakpoint = options.mobileBreakpoint || 768;
  this.$window = $(window);

  // check / listen width
  this.onResize();
  this.$window.resize(this.onResize.bind(this));
};

Viewport.prototype = {
  isMobile: function() {
    return this.$window.width() < this.mobileBreakpoint;
  },

  onResize: function() {
    var isMobile = this.isMobile();

    if (isMobileState === isMobile) {
      return;
    }

    isMobileState = isMobile;
    eventbus.emit('viewport.isMobile', isMobile);
  }
};

module.exports = Viewport;
