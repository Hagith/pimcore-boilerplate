var viewport = require('../utils/viewport');
var router = require('../app/router');

function Page() {
  if (!(this instanceof Page)) return new Page();

  viewport.on('isMobile', this.init.bind(this));
  router.on('route', function(ctx) {
    if (ctx.canonicalPath.match('page')) {
      this.init(viewport.isMobile());
    }
  }.bind(this));
}

Page.prototype = {
  init: function(isMobile) {
    isMobile = (isMobile !== undefined) ? isMobile : viewport.isMobile();
    console.log('Page init, isMobile: ' + isMobile);
  }
};

module.exports = new Page();
