/**
 * 
 * Integrating to VisualComposer
 * 
 * @author jason.xie@victheme.com
 */
(function ($) {

  $(window)
    .on('vc_ready', function() {

      // Registering custom vc historyline building caller
      // @see wp-visualcomposer-front.js
      vc.vtcore.historyLine= {
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
              .find('.pointer-canvas')
              .each(function() {
                delete(this);
                $(this).remove();
              });

            delete FrameObject;
            FrameObject = null;

            // Build using jQuery instead of backbone!
            $(model.view.$el).find('.point-connector').pointConnect();

            clearTimeout(model.timer);

          }, 50);
        }
      }

      /**
       * Bind custom events to act on vc events.
       */
      vc.events
        .on('shortcodeView:ready:history', function(model) {
          vc.vtcore.historyLine.build(model);
          vc.vtcore.fixGridClass(model, model.view.$el.find('.history-elements'));
          vc.vtcore.registerGridContainer(model, 'vtcore-history');
        })
        .on('shortcodes:update:history', function(model) {
          vc.vtcore.historyLine.build(model);
        })
        .on('shortcodeView:ready:historysimple', function(model) {
          vc.vtcore.historyLine.build(model);
        })
        .on('shortcodeView:ready:historyinner', function(model) {

          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.historyLine.build(parent);

          vc.vtcore.fixGridClass(model, model.view.$el.find('.history-content'));
          vc.vtcore.registerGridContainer(model, 'vc_element-container');
        })
        .on('shortcodes:historyinner:destroy', function(model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.historyLine.build(parent);
        });
    });

 })(window.jQuery);