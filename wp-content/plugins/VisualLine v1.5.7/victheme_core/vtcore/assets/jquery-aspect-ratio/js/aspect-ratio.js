/**
 * Simple plugin for reformatting element to match
 * its aspect ratio.
 * 
 * Set the aspect ration via data-aspect-ratio attributes
 * in the form of width:height ratio.
 * 
 * if no data-aspect-ratio configured it will use the 16:9
 * aspect ratio by default.
 * 
 * Any element that has data-aspect="true" will be automatically
 * reformatted.
 * 
 * Supports resize_end events and will reformat element with
 * data-aspect="true" on resize_end events.
 */
(function($){
  
  $.fn.VTCoreAspectRatio = function() {

    return this.each(function() {
      var self = $(this),
          size = self.data('aspect-ratio'),
          width = self.width(),
          ratio = 1;
      
      if (typeof size == 'undefined') {
        ratio = 16 / 9;
      }
      else {
        size = size.split(':');
        ratio = size[0] / size[1];
      }
      
      if (typeof self.data('aspect-max-width') != 'undefined' && self.data('aspect-max-width') < width) {
        width = self.data('aspect-max-width');
      }
      
      var proposedHeight = Math.ceil(width / ratio);
      
      if (self.height() != proposedHeight && proposedHeight > 0) {
        self.height(Math.ceil(width / ratio));
        
        
        // Callback to isotope element parent to force relayout the element
        var IsotopeParent = self.closest('.js-isotope').not('.aspect-ratio-processing');
        
        if ($.isFunction($.fn.isotope)
            && IsotopeParent.length != 0) {
          
          IsotopeParent.addClass('aspect-ratio-processing');
          
          setTimeout(function() {
            
            IsotopeParent.data('isotope') || IsotopeParent.isotope(IsotopeParent.data('isotope-options'));
            
            IsotopeParent.isotope('layout');
            IsotopeParent.removeClass('aspect-ratio-processing');
          }, 1);
        }
      }
    });
  }
  
  
  $(document)
    .on('ajaxComplete', function() {
      $('[data-aspect="true"]').VTCoreAspectRatio();  
    })
    .on('layoutComplete', function() {
      $('[data-aspect="true"]').VTCoreAspectRatio();  
    });
  
  // Support for dynamic resizing but only for
  // resize_end events for performance reasons.
  $(window)
    
    .on('load', function() {
      $('[data-aspect="true"]').VTCoreAspectRatio();    
      
    })
    
    .on('resize_end', function() {
      $('[data-aspect="true"]').VTCoreAspectRatio();
    
    });
  
})(jQuery);