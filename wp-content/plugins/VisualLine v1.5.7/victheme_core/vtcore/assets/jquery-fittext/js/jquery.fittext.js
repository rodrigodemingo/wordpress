/*global jQuery */
/*!
* FitText.js 1.2
*
* Copyright 2011, Dave Rupert http://daverupert.com
* Released under the WTFPL license
* http://sam.zoy.org/wtfpl/
*
* Date: Thu May 05 14:23:00 2011 -0600
*/

(function( $ ){

  $.fn.fitText = function( kompressor, options ) {

    // Setup options
    var compressor = kompressor || 1,
        settings = $.extend({
          'minFontSize' : Number.NEGATIVE_INFINITY,
          'maxFontSize' : Number.POSITIVE_INFINITY
        }, options);

    return this.each(function(){
      
      // Store the object
      var $this = $(this), 
          wlength = $this.text().length || 1,
          size = ($this.width() / wlength / compressor < $this.height() / compressor) ? $this.width() / wlength / compressor : $this.height() / compressor;
      
      if ($this.data('maxfontsize')) {
        settings.maxFontSize = $this.data('maxfontsize');
      }
      
      if ($this.data('minfontsize')) {
        settings.minFontSize = $this.data('minfontsize');
      }

      // Resizer() resizes items based on the object width divided by 
      // total font size (the total letters found in the element) / the compressor (the total text line)
      var resizer = function () {
        $this.css('font-size', Math.max(Math.min(size, parseFloat(settings.maxFontSize)), parseFloat(settings.minFontSize)));
      };

      // Call once to set.
      resizer();

      // Call on resize. Opera debounces their resize by default.
      $(window)
        .on('resize.fittext orientationchange.fittext', resizer)
        .on('resize_end', resizer);

    });

  };
  
  $(window)
    .on('load', function() {
      $('.fittext').each(function() {
        $(this).fitText();
      });
    });
  
  $('.fittext').on('equalheight-complete', function() {
    $(this).fitText();
  }); 

})( jQuery );
