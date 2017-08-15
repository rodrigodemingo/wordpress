/**
 * Additional javascript for integrationg
 * VicTheme Core assets into wordpress widget
 * administration screen.
 *
 * @author jason.xie@victheme.com
 */
(function($) {

  $(document)
    .on('widget-added.vtcore-widgets', function(events, widget) {

      var Widget = $(widget);
      // Remove useless bs select element
      Widget.length
        && Widget.find('.bootstrap-select').length
        && Widget.find('.bootstrap-select').remove();

      // Booting select picker
      if (typeof $.fn.selectpicker == 'function') {
        Widget.length
          && Widget.find('select.selectpicker').length
          && Widget.find('select.selectpicker').selectpicker();
      }
    });

})(jQuery);