/**
 *
 * Triggering Script for triggering
 * custom vc_ready event when visualcomposer
 * is ready.
 *
 * @author jason.xie@victheme.com
 */
(function ($) {

  var VTCoreVisualComposerFrameTimer = setInterval(function() {

    if (typeof vc.FrameView != 'undefined') {

      clearInterval(VTCoreVisualComposerFrameTimer);
      VTCoreVisualComposerFrameTimer = null;

      // Extend the vc_iframe.setSortable here to avoid recursion error!
      vc.FrameView = vc.FrameView.extend({
        setSortable: function() {
          vc.frame_window.vc_iframe.setSortableExtended( vc.app );
        }
      });

      // Register global method for other plugin to use.
      vc.vtcore = {
        checkEmpty: function(model) {
          if (model.view.$content.children().length == 0) {
            model.view.$el.addClass('vc_empty');
            model.view.$content.addClass('vc_empty-element');
          }
          else {
            model.view.$el.removeClass('vc_empty');
            model.view.$content.removeClass('vc_empty-element');
          }
        },
        strpos: function(haystack, needle, offset) {
          var i = (haystack+'').indexOf(needle, (offset || 0));
          return i === -1 ? false : i;
        },
        fixGridClass: function(model, source) {
          var cols = '',
            cssClass = source.attr('class'),
            arrayClass = [],
            classTarget = 'col-';

          if (cssClass) {
            // Detect VC grid
            if (cssClass.indexOf('vc_col-') !== -1) {
              classTarget = 'vc_col-';
            }

            $.each(cssClass.split(' '), function (key, value) {
              if (value.indexOf(classTarget) !== -1) {
                arrayClass.push(value);
              }
            });
            cols = arrayClass.join(' ');

            // Need to transfer the col class to the parent container for
            // sane drag pointer position
            source.removeClass(cols);
            model.view.$el.addClass(cols);

            cols = null;
          }

        },
        registerGridContainer: function(model, connector) {
          if (typeof model == 'undefined') {
            return;
          }
          model.view.$content.addClass('vtcore-grid-container ' + connector).attr('data-connect-with', '.' + connector);
          vc.frame_window.vc_iframe.setGridSortable();
        }
      }


      $(window).trigger('vc_frame_ready');
    }

  }, 1000);

  var VTCoreVisualComposerFrontTimer = setInterval(function () {

    if (typeof window.InlineShortcodeView != 'undefined'
        && typeof window.InlineShortcodeViewContainer != 'undefined') {

      clearInterval(VTCoreVisualComposerFrontTimer);
      VTCoreVisualComposerFrontTimer = null;

      /**
       * Extending the inline shortcode view to piggy back our
       * before update events. remove this when vc
       * has actual before update events.
       */
      window.InlineShortcodeView = window.InlineShortcodeView.extend({
        beforeUpdate: function() {
          vc.events.trigger("shortcodeView:beforeUpdate", this.model);
          vc.events.trigger("shortcodeView:beforeUpdate:" + this.model.get("shortcode"), this.model);
          vc.events.trigger("shortcodeView:beforeUpdate:" + this.model.get("id"), this.model);
        }
      });

      $(window).trigger('vc_ready');

    }

  }, 1000);

})(window.jQuery);