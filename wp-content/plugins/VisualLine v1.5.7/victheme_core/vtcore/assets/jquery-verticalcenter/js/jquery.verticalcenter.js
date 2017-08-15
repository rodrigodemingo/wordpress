/**
 * Small set of functions for centering element vertically.
 * 
 * element that wishes to be vertically centered must have 
 * these markups:
 * 
 * <div class="vertical-center">
 *  <div class="vertical-target" data-offset="xxx"></div>
 * </div>
 * 
 * Where the vertical target doesn't have to be direct
 * children of the parent.
 * 
 * The parent must have definite height and properly cleared
 * in order for the js to pickup the height properly.
 * 
 * Accepted options :
 *  data-vertical-animate : (boolean) set if we should animate the margin adjustment process
 *  data-vertical-offset  : (number)  the additional offset needed for the element margin top
 *  
 * CSS Class
 *  vertical-lg-center    : only do vertical centering on screen larger than 768px
 *  vertical-target       : the target element to be centered
 *  vertical-center       : the wrapper element to get the height from
 * 
 * @author jason.xie@victheme.com
 */
(function($) {
  
  /**
   * Center the element
   */
  $.fn.vertCentCentering = function(target, offset, animate) {
    var height = $(this).innerHeight(),
        elHeight = target.outerHeight(),
        margin = (height- elHeight) / 2;

    if (animate == true || typeof animate == 'undefined') {
      target.stop().animate({
        marginTop : margin + offset
      }, 600);
    }
    else {
      target.css({
        marginTop: margin + offset
      });
    }
    
    return this;
  }
  
  
  /**
   * Load all selectors
   */
  $.fn.vertCentInit = function() {
    
    var wwidth = $(window).width();
    
    return this.each(function() {
      var self = $(this);
      
      self.find('.vertical-target').each(function() {
        var target = $(this),
            offset = target.data('vertical-offset') || 0,
            animate = target.data('vertical-animate');
        
        // Reset the margin if this is a single row elements
        if (self.innerWidth() == target.outerWidth(true) 
            && self.data('vertical-force') != true) {
          
          target.css('margin-top', '');
          return true;
        }
        
        // Stop process on small screen
        if (self.hasClass('vertical-lg-center') && wwidth < 768) {
          return true;
        }

        // Allow time for browser to reset the 
        // container height first
        setTimeout(function() {
          self.vertCentCentering(target, offset, animate);
        }, 300);
        
      });      
    });    
  }
 
  /**
   * Bind events
   */
  $(document)
    .on('resize pageready ready ajaxComplete wp-loop-ajax-processed', function() {
      $('.vertical-center').vertCentInit();
    })
    
    // Need patch in the jquery.isotope.js for this event to trigger
    .on('layoutStart', function(events, items) {
      // Nuke the previously set margin top for sane centering
      $(items.element).find('.vertical-target:not(.vertical-no-reset)').css('margin-top', '');
    })
    .on('layoutComplete', function(events, items) {
      // recenter the element
      $(items.element).parent().hasClass('vertical-center') && $(items.element).parent().vertCentInit();
      $(items.element).hasClass('vertical-center') && $(items.element).vertCentInit();
      $(items.element).find('.vertical-center').vertCentInit();
    });
  
  $(window)
    .on('load', function() {
      $('.vertical-center').vertCentInit();
    })
    .on('resize_end', function() {
      $('.vertical-center').vertCentInit();
    });
  
})(jQuery);