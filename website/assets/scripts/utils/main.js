(function(global) {

  var Website = function(options) {
    this.isMobile = undefined;
    this.opts = options;
    this.$global = $(global);

    this.pages = {};

    // check / listen width
    this.onResize();
    this.$global.resize(this.onResize.bind(this));
  };

  Website.prototype = {
    onResize: function() {
      var isMobile = this.$global.width() < this.opts.mobileBreakpoint;

      if (this.isMobile === isMobile) {
        return;
      }

      $('body').toggleClass('mobile', isMobile);

      this.isMobile = isMobile;
      $.publish('website.isMobile', [this.isMobile]);
    }
  };

  global.website = new Website({
    mobileBreakpoint: 768
  });

}(window));
