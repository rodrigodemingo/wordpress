/**
 * jQuery assets for handling the WpGradient element
 * events and preview.
 * 
 * @todo clean and test for multiple element at one page speed
 * @author jason.xie@victheme.com
 */
(function($) {


  /**
   * Bind the events to document root
   */
  $(document)
    .on('ready', function() {
      $('.wp-gradient-picker-controller select').trigger('change');
    })
    .off('change', '.wp-gradient-picker select')
    .on('change', '.wp-gradient-picker select', function() {
      $(this).VTCoreGradientToggle();
      $(this).VTCoreRefreshGradientReview();
    })
    .off('change', '.wp-gradient-picker input[type="text"]')
    .on('change', '.wp-gradient-picker input[type="text"]', function() {
      $(this).VTCoreRefreshGradientReview();
    })
    .off('changeColor', '.wp-gradient-picker .bootstrap-colorpicker')
    .on('changeColor', '.wp-gradient-picker .bootstrap-colorpicker', function() {
      $(this).VTCoreRefreshGradientReview();
    })
    .off('change', '.wp-gradient-picker input[type="checkbox"]')
    .on('change', '.wp-gradient-picker input[type="checkbox"]',  function() {
      $(this).VTCoreRefreshGradientReview();
    })
    .on('tablemanager-removerow', function() {
      $('.wp-gradient-picker-controller select').trigger('change');
    });



  /**
   * Update and refresh the preview elements
   */
  $.fn.VTCoreRefreshGradientReview = function() {
    var el = $(this),
    parent = el.closest('.wp-gradient-picker');
    var options = {
        type: parent.find('[name$="[type]"]').val(),
        repeat: parent.find('[type="checkbox"][name$="[repeat]"]').is(':checked'),
        settings: {
          direction: parent.find('[name$="[direction]"]').val(),
          size: parent.find('[name$="[size]"]').val(),
          shape: parent.find('[name$="[shape]"]').val(),
          position: parent.find('[name$="[position]"]').val()
        },
        colors: []
    };

    parent.find('tbody tr').each(function() {
      var row = $(this);
      options.colors.push({
        stop: row.find('[name$="[stop]"]').val(),
        color: row.find('[name$="[color]"]').val()
      });
      
      row = null;
    });

    parent.find('.wp-gradient-picker-preview').VTCoreGradient(options);

    // Customizer mode
    if (parent.data('gradient-customizer') == true) {
      var values = parent.find('input[type="text"], select').serializeArray();
      

      parent.find('[type="checkbox"], [type="radio"]').each(function() {
        var child = {
          "name" : $(this).attr('name'),
          "value" : ($(this).attr('checked') == 'checked') ? true : false
        };
        
        values.push(child);
        child = null;
      });
      
      $('[data-customize-setting-link="' + parent.data('gradient-target') + '"]').val(JSON.stringify(values)).trigger('change');
      values = null;
    }
    
    parent = null;
    el = null;
    

  }



  /**
   * Toggle gradient dependencies form elements
   */
  $.fn.VTCoreGradientToggle = function() {
    var el = $(this),
    deps = el.parent().data('gradient-pairing'),
    parent = el.closest('.wp-gradient-picker'),
    value = el.val();

    if (typeof deps == 'undefined') {
      return;
    }

    parent
      .find('[data-gradient-pairing-active]')
      .fadeOut();

    // Toggle show / hide deps
    if (typeof deps[value] != 'undefined') {

      // @bugfix paired element won't show due browser is still hiding the element
      setTimeout(function() {
        parent
          .find('[data-gradient-pairing-active="' + deps[value] + '"]')
          .fadeIn();
      }, 10);
    }
  }




  /**
   * Build the gradient strings
   * @todo move this to standalone assets?
   */
  $.fn.VTCoreGradient = function(options) {

    var defaults = {
        type: 'linear',
        repeat: false,
        settings: {
          direction: 'top',
          size: '',
          shape: '',
          position: ''
        },
        colors: [{
          stop: '',
          color: ''
        }]
    },
    prefixes = [];

    
    // Test and build prefixes
    div = document.createElement( "div" ),
    css = "background-image:gradient(linear,left top,right bottom, from(#9f9), to(white));background-image:-webkit-gradient(linear,left top,right bottom,from(#9f9),to(white));background-image:-moz-gradient(linear,left top,right bottom,from(#9f9),to(white));background-image:-o-gradient(linear,left top,right bottom,from(#9f9),to(white));background-image:-ms-gradient(linear,left top,right bottom,from(#9f9),to(white));background-image:-khtml-gradient(linear,left top,right bottom,from(#9f9),to(white));background-image:linear-gradient(left top,#9f9, white);background-image:-webkit-linear-gradient(left top,#9f9, white);background-image:-moz-linear-gradient(left top,#9f9, white);background-image:-o-linear-gradient(left top,#9f9, white);background-image:-ms-linear-gradient(left top,#9f9, white);background-image:-khtml-linear-gradient(left top,#9f9, white);";    
    div.style.cssText = css;
    
    if (div.style.backgroundImage.indexOf( "-moz-linear-gradient" )  > -1) {
      prefixes.push('-moz-');
    }
    
    else if (div.style.backgroundImage.indexOf( "-o-linear-gradient" )  > -1) {
      prefixes.push('-o-');
    }
    
    else if (div.style.backgroundImage.indexOf( "-webkit-linear-gradient" )  > -1) {
      prefixes.push('-webkit-');
    }
    
    else if (div.style.backgroundImage.indexOf( "-ms-linear-gradient" )  > -1) {
      prefixes.push('-ms-');
    }
    
    else if (div.style.backgroundImage.indexOf( "linear-gradient" )  > -1) {
      prefixes.push('');
    }
     
    
    // Merge defaults and options into the one settings object
    options = $.extend({}, defaults, options);

    var repeat = (options.repeat == true || options.repeat == 'true') ? 'repeating-' : '';

    return this.each(function() {
      var $this = $(this),
          colors = [];

      $.each(options.colors, function(key, colorData) {
        if (colorData.color || colorData.stop) {
          colors.push(colorData.color + ' ' + colorData.stop);
        }
      });

      switch (options.type) {

      case 'linear':

        var setting = ($.isNumeric(options.settings.direction)) ? options.settings.direction + 'deg' : options.settings.direction;
        $.each(prefixes, function(key, prefix) {
          $this.css('background', prefix + repeat + 'linear-gradient(' + setting + ', ' + colors.join(', ') + ')');
        });

        break;

      case 'radial':

        if (options.settings.position != '') {
          options.settings.position += ',';
        }

        var setting = options.settings.position + ' ' + options.settings.shape + ' ' + options.settings.size;

        $.each(prefixes, function(key, prefix) {
          $this.css('background', prefix + repeat + 'radial-gradient(' + setting + ', ' + colors.join(', ') + ')'); 
        });
        break;
      }

    });
  }

})(jQuery);