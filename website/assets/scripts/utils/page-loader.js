/**
 * Page loader - resolves when all images found in content are loaded
 * @return {jQuery.Deferred.promise}
 */

'use strict';

var $ = require('jquery');

var pageLoad = function(url) {
  var def = $.Deferred();

  $.get(url, function(content) {
    var $content = $(content);
    var images = $content.find('img');
    if (!images.length) {
      def.resolve($content);
    }

    var srcs = [];
    $.each(images, function() {
      srcs.push($(this).attr('src'));
    });

    $.preload(srcs).done(function() {
      def.resolve($content);
    });
  });

  return def.promise();
};

module.exports = pageLoad;
