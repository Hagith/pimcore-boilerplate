var EventEmitter = require('events').EventEmitter;
var inherits = require('inherits');
var page = require('page');

var config = require('../app/config').router;

inherits(Router, EventEmitter);

function Router() {
  EventEmitter.call(this);
}

Router.prototype.init = function() {
  page('*', this.onRoute.bind(this));
  page(config);

  var route = $('[data-route]:not(a):first').data('route');

  if (undefined !== config.click && !config.click) {
    // bind all links with data-route attribute to be routed on client-side
    $('body').on('click', 'a[data-route]', function(e) {
      e.preventDefault();
      page('#' + $(this).data('route'));
    });
  }

  if (undefined !== config.dispatch && !config.dispatch && route) {
    // initial dispatch disabled - use route defined in page content
    // only dispatch callback, don't change url
    page.show(route, null, true, false);
  }
};

Router.prototype.onRoute = function(ctx) {
  console.log(ctx);
  this.emit('route', ctx);
};

module.exports = new Router();
