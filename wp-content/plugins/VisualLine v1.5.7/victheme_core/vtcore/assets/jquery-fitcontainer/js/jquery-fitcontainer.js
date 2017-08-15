/**
 * Simple Script for forcing element
 * to have the same width and height as the
 * parent container
 * 
 * @author jason.xie@victheme.com
 */
(function($){
    
  $.fn.VTCoreFitContainer = function() {
    
    return this.each(function() {

      $(this).css('width', '').css('height', '');
      
      var _ = {
          $el: $(this),
          mode: $(this).data('fit-container-mode') || 'height',
          height: $(this).parent().innerHeight(),
          width: $(this).parent().innerWidth()
      }
      
      if (_.mode == 'height' || _.mode == 'both') {
        _.$el.height(_.height);
      }
      
      if (_.mode == 'width' || _.mode == 'both') {
        _.$el.width(_.width);
      }
    });
  };
  
  
  $(window)
  
    .on('load', function() {
      $('.fit-container').VTCoreFitContainer();
    })
    
    .on('resize_end resize', function() {
      $('.fit-container').VTCoreFitContainer();
    })
    
    .on('equalheight-reset', function() {
      $('.fit-container').css('width', '').css('height', '');
    })
    
    .on('equalheight-start', function() {
      $('.fit-container').css('width', '').css('height', '');
    })
    .on('equalheight-complete', function() {

      setTimeout(function() {
        $('.fit-container').VTCoreFitContainer();
      }, 300);
      
    });
    

  $(document)
    .on('layoutComplete', function(isotope, items) {
      $(items.element).find('.fit-container').VTCoreFitContainer();
    });
  
})(jQuery);