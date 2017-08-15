/**
 * 
 * Integrating to VisualComposer
 * 
 * @author jason.xie@victheme.com
 */
(function ($) {

  $(window)

    .on('vc_ready', function() {

      // Registering custom vc memoryline building caller
      // @see wp-visualcomposer-front.js
      vc.vtcore.memoryLine = {
        build: function(model) {

          model.timer && clearTimeout(model.timer);

          model.timer = setTimeout(function() {
            // Access frame object instead model view!
            var FrameObject = $(vc.frame_window.document)
              .find('[data-model-id="' + model.get('id') + '"]');

            FrameObject
              .find('.memoryline-canvas')
              .each(function () {
                delete(this);
                $(this).remove();
              });

            delete FrameObject;
            FrameObject = null;

            // Build using jQuery instead of backbone!
            $(model.view.$el).find('.memoryline-connector').memoryLineConnect();

            clearTimeout(model.timer);

          }, 50);
        },
        fixDots: function(model) {
          model.view.$el.attr('data-new-row', model.view.$el.children().data('new-row'));
          model.view.$el.attr('data-dot-direction', model.view.$el.children().data('dot-direction'));
        }
      }

      /**
       * Bind custom events to act on vc events.
       */
      vc.events
        .on('shortcodeView:ready:memoryline', function(model) {
          vc.vtcore.memoryLine.build(model);
          vc.vtcore.fixGridClass(model, model.view.$el.find('.memoryline-elements'));
          vc.vtcore.registerGridContainer(model, 'vtcore-memoryline');
        })
        .on('shortcodeView:ready:memorylinesimple', function(model) {
          vc.vtcore.memoryLine.build(model);
        })
        .on('shortcodeView:ready:memorylineinner', function(model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.memoryLine.build(parent);
          vc.vtcore.fixGridClass(model, model.view.$el.children());
          vc.vtcore.registerGridContainer(model, 'vc_element-container');
          vc.vtcore.memoryLine.fixDots(model);
        })
        .on('shortcodes:memorylineinner:destroy', function(model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.memoryLine.build(parent);
        });

    });

 })(window.jQuery);
