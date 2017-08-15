/**
 * jQuery assets for handling the WpFonts 
 * chained events, specially for helping user
 * on selecting the right options for google
 * fonts.
 * 
 * @author jason.xie@victheme.com
 */
(function($) {
return;
  var FontCSSRules = function(rule, value) {
    this.rule = rule;
    this.value = value;
    this.rules = {
      size: 'font-size',
      family: 'font-family',
      weight: 'font-weight',
      style: 'font-style',
      variant: 'font-variant',
      color: 'color',
      line: 'line-height',
      letter: 'letter-spacing',
      shadow: 'text-shadow'
    }
  }

  FontCSSRules.prototype = {
    getCSS: function () {
      var string = '';
      if (typeof this.rules[this.rule] != 'undefined'
        && this.value.length) {
        string = this.rules[this.rule] + ': ' + this.value + ';';
      }
      return string;
    },
    getRule: function () {
      if (typeof this.rules[this.rule] != 'undefined') {
        return this.rules[this.rule];
      }
      return '';
    },
    getValue: function () {
      return this.value;
    },
    loadFont: function (fonts) {

      if (typeof fonts.family == 'undefined'
        || fonts.family == false
        || fonts.family == '') {

        return false;
      }

      var font = fonts.family;

      if (typeof fonts.weight != 'undefined'
        && fonts.weight != false
        && fonts.weight != '') {

        font += ':' + fonts.weight;
      }

      if (typeof fonts.style != 'undefined'
        && fonts.style != false
        && fonts.style != '') {

        font += fonts.style;
      }

      if (!this.fonts) {
        this.fonts = {};
      }


      if (typeof this.fonts[font] == 'undefined') {
        this.fonts[font] = fonts;
        $('<link media="all" type="text/css" href="http://fonts.googleapis.com/css?family=' + font + '&subset=latin,cyrillic-ext,cyrillic,greek-ext,greek,vietnamese,latin-ext" rel="stylesheet"/>')
          .prependTo('.wp-font-styles');
      }
    }
  }

  $(document)
    
    // Initialize first time
    .on('ready', function() {
      $('.wp-fonts [data-font="family"]').trigger('change');
    })

    // Bind previewer
    .on('change', '[data-font]', function() {
      var self = $(this),
          Type = self.data('font'),
          Font = new FontCSSRules(Type, self.val()),
          Form = self.closest('.wp-fonts');

      Form.find('.wp-font-picker-preview').css(Font.getRule(), Font.getValue());

      switch(Type) {
        case 'family' :
        case 'weight' :
        case 'style' :
          Font.loadFont({
            family: Form.find('[data-font="family"]').val(),
            style: Form.find('[data-font="style"]').val(),
            weight: Form.find('[data-font="weight"]').val()
          });
          break;
      }

    })
    
    // Bind on change events
    .off('change', '.wp-fonts [data-font="family"]')
    .on('change', '.wp-fonts [data-font="family"]', function() {
      
      // Build simple object
      var fontObject = {
            parent : $(this).closest('.wp-fonts'),
            value : $(this).val(),
            option : $(this).find('[value="' + $(this).val() + '"]'),
            tweight : $(this).closest('.wp-fonts').find('[data-font="weight"]'),
            tstyle : $(this).closest('.wp-fonts').find('[data-font="style"]'),
            weight : [], 
            style : []
          };
      
      // Reset weight
      fontObject
        .tweight
        .find('option')
        .removeAttr('disabled')
        .show();
      
      // Reset style
      fontObject
        .tstyle
        .find('option')
        .removeAttr('disabled')
        .show();
      
      // Only proceed if we got valid variants
      if (fontObject.option.data('variants')) {
        
        // Loop and process the variants
        $.each(fontObject.option.data('variants'), function(key, val) {
          
          // Change regular to valid weight
          if (val == 'regular') {
            val = '400';
          }
          
          // Catch italic, in the future if google fonts
          // support more style add the logic here.
          if (val.indexOf('italic') != -1) {
            fontObject.style.push('[value="italic"]');
            val.replace('italic', '');
          }
          
          // Store all catched logic
          fontObject.weight.push('[value="' + val + '"]');
        });
        
        // Disable and hide not supported google fonts weight
        if (fontObject.weight.length) {
          fontObject.weight.push('[value=""]');
          fontObject
            .tweight
            .find('option:not(' + fontObject.weight.join(', ') + ')')
            .attr('disabled', true)
            .hide();
          fontObject
            .tweight
            .val('')
            .find('option')
            .removeAttr('selected');
        }
        
        // Disable and hide not supported google fonts style
        if (fontObject.style.length) {
          fontObject.style.push('[value=""]');
          fontObject
            .tstyle
            .find('option:not(' + fontObject.style.join(', ') + ')')
            .attr('disabled', true)
            .hide();  
          fontObject
            .tstyle
            .val('')
            .find('option')
            .removeAttr('selected');
        }
      }
      
      // Free up object
      delete fontObject;
    });
  

})(jQuery);