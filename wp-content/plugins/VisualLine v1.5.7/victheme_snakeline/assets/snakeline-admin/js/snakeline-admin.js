/**
 * 
 * Integrating to VisualComposer
 * 
 * @author jason.xie@victheme.com
 */
(function ($) {

  $(window)

    .on('vc_ready', function() {

      // Registering custom vc snakeline building caller
      // @see wp-visualcomposer-front.js
      vc.vtcore.snakeLine = {
        build: function(model) {
          if (typeof model == 'undefined') {
            return;
          }

          model.timer && clearTimeout(model.timer);

          model.timer = setTimeout(function () {
            // Access frame object instead model view!
            var FrameObject = $(vc.frame_window.document)
              .find('[data-model-id="' + model.get('id') + '"]');

            FrameObject
              .find('.snakeline-canvas')
              .each(function () {
                delete(this);
                $(this).remove();
              });

            delete FrameObject;
            FrameObject = null;

            // Build using jQuery instead of backbone!
            $(model.view.$el).find('.snakeline-connector').snakeLineConnect();
            clearTimeout(model.timer);

          }, 50);
        }
      }

      /**
       * Bind custom events to act on vc events.
       */
      vc.events
        .on('shortcodeView:ready:snakelinesimple', function(model) {
          vc.vtcore.snakeLine.build(model);
        });

    });

 })(window.jQuery);
