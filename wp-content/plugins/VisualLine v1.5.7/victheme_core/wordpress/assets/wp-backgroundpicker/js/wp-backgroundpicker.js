/**
 * jQuery assets for handling the WpBackground element
 * events and preview.
 * 
 * @todo Link this to customizer when we are ready to upgrade the 
 *       Zeus Schema systems.
 * @todo clean and test for multiple element at one page speed
 * @author jason.xie@victheme.com
 */
(function($) {


  /**
   * Bind the events to document root
   */
  $(document)
    .on('ready', function() {
      $('.wp-background-picker select').trigger('change');
    })
    .off('change', '.wp-background-picker select')
    .on('change', '.wp-background-picker select', function() {
      $(this).VTCoreRefreshBackgroundReview();
    })
    .off('change', '.wp-background-picker input[type="text"]')
    .on('change', '.wp-background-picker input[type="text"]', function() {
      $(this).VTCoreRefreshBackgroundReview();
    })
    .off('changeColor', '.wp-background-picker .bootstrap-colorpicker')
    .on('changeColor', '.wp-background-picker .bootstrap-colorpicker', function() {
      $(this).VTCoreRefreshBackgroundReview();
    })
    .on('tablemanager-removerow', function() {
      $('.wp-background-picker select').trigger('change');
    });



  /**
   * Update and refresh the preview elements
   */
  $.fn.VTCoreRefreshBackgroundReview = function() {
    var el = $(this),
        parent = el.closest('.wp-background-picker'),
        keys = ['image', 'position', 'repeat', 'size', 'attachment'];

    var options = {
        color: parent.find('[name$="[color]"]').val(),
        image: parent.find('[name$="[image][]"]').val(),
        position: parent.find('[name$="[position][]"]').val(),
        repeat: parent.find('[name$="[repeat][]"]').val(),
        size: parent.find('[name$="[size][]"]').val(),
        attachment: parent.find('[name$="[attachment][]"]').val()
    };


    parent.find('.wp-background-picker-preview').css('background-color', parent.find('[name$="[color]"]').val());

    // Building masking preview
    parent.find('.wp-background-picker-masking').css('background-color', parent.find('[name$="[masking]"]').val());
    
    $.each(keys, function(delta, key) {
      var css = [];
      
      parent.find('[name$="[' + key + '][]"]').each(function() {

        if ($(this).attr('name').indexOf('[keyframe]') === -1) {    
          var value = $(this).val();
          
          if (key == 'image' && value) {
            if ($(this).parent().find('img').attr('src')) {
              value = "url('" + $(this).parent().find('img').attr('src') + "')"; 
            }
          }
  
          if (value != '' && typeof value != 'undefined') {
            css.push(value);
          }
        }
      });
      
      parent.find('.wp-background-picker-preview').css('background-' + key, css.join(','));
      
      css = null;
      
    });
    
    
    // Building parallax
    // @todo modify jquery-parallax to honour scroll for iframe window scroll
    if ($.isFunction($.fn.parallax) && parent.find('[name$="[parallax]"]').val() != 'none') {
      parent.find('.wp-background-picker-preview').parallax({
        transitionType: parent.find('[name$="[parallax]"]').val()
      });
    }

    // Building Animation
    var animationName = parent.find('[name*="[animation][name]"]').val();
    parent.find('[name*="[animation]"]').each(function() {
      
      var prefixes = ['-webkit-', '-moz-', '-o-', ''],
          self = $(this);
      
      $.each(prefixes, function(key, prefix) {
        parent.find('.wp-background-picker-preview').css(prefix + 'animation-' + self.parent().data('animation-type'), self.val());
      });  
      
      self = null;
    });
    
    
    
    
    // Build Keyframes
    var from = [];
    parent.find('[name*="[keyframe][frames][from]"]').each(function() {
      if ($.trim($(this).val()).length) {
        from.push($(this).val());
      }
    });
    
    var to = [];
    parent.find('[name*="[keyframe][frames][to]"]').each(function() {
      if ($.trim($(this).val()).length) {
        to.push($(this).val());
      }
    });
    
    // reset the old styles first
    parent.find('.wp-background-picker-preview style').remove();

    if (from.length != 0 
        && to.length != 0
        && animationName.length != 0) {
      
      var keyframe = '<style type="text/css" class="wp-background-picker-keyframe">',
          prefixes = ['-webkit-', '-moz-', '-o-', ''];
      
      $.each(prefixes, function(key, prefix) {
        keyframe += "@" + prefix + 'keyframes ' + animationName + "{ from { background-position: " + from.join(', ').trim() + "; } to { background-position: " + to.join(', ').trim() + "; }}";
      });
      keyframe += '</style>';
      
      parent.find('.wp-background-picker-preview').append(keyframe);
      keyframe = null;
    }

    
    to = null;
    from = null;
    parent = null;

  };

})(jQuery);