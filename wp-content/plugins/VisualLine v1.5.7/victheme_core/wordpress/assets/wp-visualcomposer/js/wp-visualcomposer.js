/**
 *
 * VisualComposer Backend editor doesn't provide
 * any trigger to notify when the backend is fully loaded
 * thus we create this centralized script to prevent
 * VTCore related visual composer integration to create
 * plethora of setInterval function and rely on one single
 * vc_backend_build trigger on window element instead when
 * registering their own backend logic.
 *
 * @author jason.xie@victheme.com
 */
(function ($) {

  var VTCoreVisualComposerTimer = setInterval(function () {

    if (typeof vc != "undefined"
        && typeof vc.shortcode_view != 'undefined') {

      clearInterval(VTCoreVisualComposerTimer);
      VTCoreVisualComposerTimer = null;

      $(window).trigger('vc_backend_build');

      // Extending the view controller
      // @bugfix The original selector bleeds into child elements
      // causing parent, children and self configuration modal
      // invoked when user click on a single button.
      window.VTCoreContainer = window.vc.shortcode_view.extend({
        events:{
          'click > .controls > .column_delete':'deleteShortcode',
          'click > .controls > .column_add':'addElement',
          'click > .controls > .column_edit':'editElement',
          'click > .controls > .column_clone':'clone',
          'click > .vc_controls > .column_delete':'deleteShortcode',
          'click > .vc_controls > .column_add':'addElement',
          'click > .vc_controls > .column_edit':'editElement',
          'click > .vc_controls > .column_clone':'clone'
        }
      });

    }

  }, 100);

})(window.jQuery);