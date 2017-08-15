/**
 * 
 * Integrating to VisualComposer
 * 
 * @author jason.xie@victheme.com
 */
(function ($) {

  $(window)

    .on('vc_ready', function() {

      // Registering custom vc bubbleline building caller
      // @see wp-visualcomposer-front.js
      vc.vtcore.bubbleLine = {
        build: function(model) {
          if (typeof model == 'undefined') {
            return;
          }

          model.timer && clearTimeout(model.timer);

          model.timer = setTimeout(function() {
            // Access frame object instead model view!
            var FrameObject = $(vc.frame_window.document)
              .find('[data-model-id="' + model.get('id') + '"]');

            FrameObject
              .find('.bubbleline-canvas')
              .each(function() {
                delete(this);
                $(this).remove();
              });

            delete FrameObject;
            FrameObject = null;

            // Build using jQuery instead of backbone!
            $(model.view.$el).find('.bubbleline-connector').bubbleLineConnect();
            clearTimeout(model.timer);

          }, 50);
        }
      }

      /**
       * Bind custom events to act on vc events.
       */
      vc.events
        .on('shortcodeView:ready:bubblelinesimple', function(model) {
          vc.vtcore.bubbleLine.build(model);
        });

    });

 })(window.jQuery);
