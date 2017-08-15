/**
 * 
 * Integrating to VisualComposer
 * 
 * @author jason.xie@victheme.com
 */
(function ($) {


  $(window)
    .on('vc_ready', function() {

      // Registering custom vc centerline building caller
      // @see wp-visualcomposer-front.js
      vc.vtcore.centerLine = {
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
              .find('.centerline-canvas')
              .each(function() {
                delete(this);
                $(this).remove();
              });

            FrameObject
              .find('.centerline-image:gt(0)')
              .each(function() {
                $(this)
                  .closest('.wpb_single_image')
                  .remove();
              });

            delete FrameObject;
            FrameObject = null;

            // Build using jQuery instead of backbone!
            $(model.view.$el).find('.centerline-connector').centerLineConnect();
            clearTimeout(model.timer);

          }, 50);
        }
      }

      /**
       * Bind custom events to act on vc events.
       */
      vc.events

        // Centerline Simple element
        .on('shortcodeView:ready:centerlinesimple', function(model) {
          vc.vtcore.centerLine.build(model);
        })

        // Centerline element
        .on('shortcodeView:ready:centerline', function(model) {
          vc.vtcore.centerLine.build(model);
          vc.vtcore.fixGridClass(model, model.view.$el.find('.centerline-elements'));
          vc.vtcore.registerGridContainer(model, 'vtcore-centerline');
        })


        // CenterLine Image element
        .on('shortcodeView:ready:centerlineimage', function(model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.centerLine.build(parent);
          vc.vtcore.fixGridClass(model, model.view.$el.find('.centerline-centerpoint'));
          vc.vtcore.registerGridContainer(model, 'vc_element-container');
        })

        .on('shortcodes:centerlineimage:destroy', function(model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.centerLine.build(parent);
        })


        // CenterLine Inner element
        .on('shortcodeView:ready:centerlineinner', function(model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.centerLine.build(parent);
          vc.vtcore.fixGridClass(model, model.view.$el.find('.centerline-wrapper'));
          vc.vtcore.registerGridContainer(model, 'vc_element-container');
        })

        .on('shortcodes:centerlineinner:destroy', function(model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.centerLine.build(parent);
        });
    });


 })(window.jQuery);


