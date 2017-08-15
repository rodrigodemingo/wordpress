/**
 * 
 * Integrating to VisualComposer
 * 
 * @author jason.xie@victheme.com
 */
(function ($) {

  $(window)
    .on('vc_ready', function() {

      vc.vtcore.timeLine = {
        simpleBuild: function(model) {

          if (typeof model == 'undefined') {
            return;
          }
          _.defer(function() {
            model.horizontal = model.view.$el.find('[data-layout="horizontal"]');

            if (model.horizontal.length) {
              model.horizontal.VTCoreHorizontalTimeline();
            }

          }, this);
        },
        build: function (model) {

          if (typeof model == 'undefined') {
            return;
          }
          _.defer(function() {
            model.horizontal = model.view.$el.find('[data-layout="horizontal"]');

            if (model.horizontal.length) {
              model.view.$content.attr('data-grid-override', true);
              model.horizontal.VTCoreHorizontalTimeline();
            }

            // Need to invoke this manually! otherwise
            // the drag placeholder will not use actual element size.
            vc.frame_window.vc_iframe.setGridSortable();
          }, this);
        }
      }

      vc.events
        .on('shortcodeView:ready:timeline', function (model) {
          vc.vtcore.registerGridContainer(model, 'vtcore-timeline');
          vc.vtcore.timeLine.build(model);
        })
        .on('shortcodeView:ready:timelinequery', function (model) {
          vc.vtcore.timeLine.simpleBuild(model);
        })
        .on('shortcodeView:ready:timelinesimple', function (model) {
          vc.vtcore.timeLine.simpleBuild(model);
        })
        .on('shortcodeView:ready:timemajor', function (model) {
          vc.vtcore.registerGridContainer(model, 'vc_element-container');
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.timeLine.build(parent);
        })
        .on('shortcodes:timemajor:destroy', function (model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.timeLine.build(parent);
        })
        .on('shortcodeView:ready:timestart', function (model) {
          vc.vtcore.registerGridContainer(model, 'vc_element-container');
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.timeLine.build(parent);
        })
        .on('shortcodes:timestart:destroy', function (model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.timeLine.build(parent);
        })
        .on('shortcodeView:ready:timeend', function (model) {
          vc.vtcore.registerGridContainer(model, 'vc_element-container');
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.timeLine.build(parent);
        })
        .on('shortcodes:timeend:destroy', function (model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.timeLine.build(parent);
        })
        .on('shortcodeView:ready:timeevents', function (model) {
          vc.vtcore.registerGridContainer(model, 'vc_element-container');
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.timeLine.build(parent);
        })
        .on('shortcodes:timeevents:destroy', function (model) {
          var parent = vc.shortcodes.get(model.get('parent_id'));
          vc.vtcore.timeLine.build(parent);
        });

    });

  // Make sure we are on the right window
  if ($(document).find('#vc_ui-panel-edit-element').length) {

    $(document)

      // Bind the extra dependencies inside the param group that
      // visualcomposer dont support yet, remove this when
      // VC has native support.
      .on('change.timeline_events blur.timeline_events', '[name="contentargs_timetype"]', function() {
        var value = $(this).val(),
            target = $(this).closest('.vc_param').find(
              '[data-vc-shortcode-param-name="contentargs_direction"], ' +
              '[data-vc-shortcode-param-name="contentargs_icon"], ' +
              '[data-vc-shortcode-param-name="contentargs_day"], ' +
              '[data-vc-shortcode-param-name="contentargs_month"], ' +
              '[data-vc-shortcode-param-name="contentargs_date"], ' +
              '[data-vc-shortcode-param-name="contentargs_year"], ' +
              '[data-vc-shortcode-param-name="contentargs_image"], ' +
              '[data-vc-shortcode-param-name="contentargs_style"], ' +
              '[data-vc-shortcode-param-name="contentargs_size"], ' +
              '[data-vc-shortcode-param-name="contentargs_text"]');

        if (value == 'events') {
          target.show();
        }
        else {
          target.hide();
        }

      })

      // Dont allow vertical to have left and right and horizontal to have top and bottom
      .on('change.timeline_direction blur.timeline_direction', '.js-timeline-layout [name="layout"]', function() {
        var value = $(this).val(),
            target = $(this).closest('.vc_edit_form_elements').find('[data-vc-shortcode-param-name="contentargs_direction"]');

        target.find('option').show();
        if (value == 'vertical') {
          target.find('option.top, option.bottom').hide();
        }
        else {
          target.find('option.left, option.right').hide();
        }

      })

      // Dont allow vertical to have left and right and horizontal to have top and bottom
      .on('change.timeline_query_direction blur.timeline_query_direction', '.js-timeline-layout [name="layout"]', function() {
        var value = $(this).val(),
          target = $(this).closest('.vc_edit_form_elements').find('[data-vc-shortcode-param-name="align"]');

        target.find('option').show();
        if (value == 'vertical') {
          target.find('option.top, option.bottom').hide();
        }
        else {
          target.find('option.left, option.right').hide();
        }

      })

      // Initial loading trigger the change events
      .on('ajaxComplete', function() {
        $('#vc_ui-panel-edit-element [name="contentargs_timetype"]')
          .each(function() {
            $(this).trigger('change.timeline_events');
          });
      });

    $('.js-timeline-layout [name="layout"], .js-timeline-layout [name="layout"], [name="contentargs_timetype"]').trigger('change');
  }


})(window.jQuery);
