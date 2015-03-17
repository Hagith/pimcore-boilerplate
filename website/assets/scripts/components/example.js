var eventbus = require('../utils/eventbus');

var Example = function() {
  eventbus.on('viewport', function() {
    console.log('example on viewport');
  });
};

module.exports = Example;
