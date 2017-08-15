/**
  Controller function for building
  range slider using nouislider
  @author jason.xie@victheme.com
  **/
(function($) {

  if (typeof noUiSlider == 'undefined') {
    return;
  }

  $(document)
    .on('ready.bootstrap-range ajaxComplete.bootstrap-range', function() {
      $('[data-trigger="bootstrap-range"]:not(.processed)').each(function() {
        var Inputs = $(this).closest('.bootstrap-range').find('input');

        noUiSlider.create(this, $(this).data('slider-options'));
        this.noUiSlider.on('change', function(values, handle) {
          $.each(values, function(delta, value) {
            Inputs.eq(delta).val(value).trigger('change');
          });
        });

        $(this).addClass('processed');
      });
    });

})(jQuery);