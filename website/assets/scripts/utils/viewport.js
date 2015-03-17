var eventbus = require('./eventbus');

var defaults = {
  mobileBreakpoint: 768
};

var Viewport = function(options) {
  if (!(this instanceof Viewport)) return new Viewport(options);

  this.opts = $.extend({}, defaults, options);

  this.isMobile = undefined;
  this.$window = $(window);

  // check / listen width
  console.log(this);
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
    eventbus.emit('viewport', this.isMobile);
    //$.publish('website.isMobile', [this.isMobile]);
  }
};

//global.website = new Mobile({
//  mobileBreakpoint: 768
//});

module.exports = Viewport;
