var events = require('events');

var defaults = {
  mobileBreakpoint: 768
};

var Viewport = function(options) {
  this.opts = $.extend({}, defaults, options);

  this.isMobile = undefined;
  this.$window = $(window);

  // check / listen width
  this.onResize();
  this.$window.resize(this.onResize.bind(this));
};

Viewport.prototype = {
  onResize: function() {
    var isMobile = this.$window.width() < this.opts.mobileBreakpoint;

    if (this.isMobile === isMobile) {
      return;
    }

    $('body').toggleClass('mobile', isMobile);

    this.isMobile = isMobile;
    $.publish('website.isMobile', [this.isMobile]);
  }
};

//global.website = new Mobile({
//  mobileBreakpoint: 768
//});

module.exports = Viewport;
