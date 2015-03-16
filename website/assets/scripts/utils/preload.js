/**
 * jQuery.preload
 *
 * Preload images using the promise pattern.
 *
 * Usage:
 *
 *     $.preload(img_uri, img_uri, ...).done(function(img, img, ...) {
 *       // Do stuff with the arguments
 *     });
 *
 * Since $.preload returns a jQuery.Deferred[1] promise, you can attach
 * callbacks the same way you'll attach them to an AJAX request
 *
 * If you preload multiple images the script will wait until all of them are
 * loaded usign $.when.
 *
 * [1]: http://api.jquery.com/category/deferred-object/
 */

;
(function($, window) {
  "use strict";

  /**
   * Image preloader
   * @return {jQuery.Deferred.promise}
   */
  $.preload = function() {
    var images = arguments.length > 1 ? arguments : arguments[0];

    // Use $.when to recursively preload multiple images
    if ($.isArray(images)) {
      return $.when.apply(window, $.map(images, function(image) {
        return $.preload(image);
      }));
    }

    // Single image
    var def = $.Deferred();
    var img = new Image();

    img.onload = function() {
      def.resolve(img);
    };
    img.onerror = function() {
      def.reject(img);
    };

    img.src = images;

    return def.promise();
  };

})(jQuery, window);
