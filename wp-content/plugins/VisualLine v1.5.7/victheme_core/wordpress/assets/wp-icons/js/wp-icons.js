/**
 * jQuery assets for handling the WpIconSet
 * preview elements
 *
 * @author jason.xie@victheme.com
 */
(function ($) {

  if (typeof window.VTCore == 'undefined') {
    window.VTCore = {};
  }

  window.VTCore.WpIconsetPreviewer = function (element) {
    this.$element = $(element);
    this.$preview = this.$element.find('[data-icon-preview]');
    this.$inputs = this.$element.find('input, select, textarea');
    this.$picker = this.$element.find('.form-icons-iconpicker');
    this.$icon = this.$element.find('.form-icon-picker');

    this.icon = {
      prefix: this.$picker.data('prefix') || '',
      base: this.$picker.data('base') || '',
      element: this.$picker.data('element') || 'i'
    };

    this.markup = '<div class="wp-icons-wrapper">' +
    '<span class="wp-icons-effect">' +
    '<##Tag class="wp-icons ##Icon" />' +
    '</span>' +
    '</div>';


  }

  window.VTCore.WpIconsetPreviewer.prototype = {
    init: function() {
      this.bind();
      this.build();
      return this;
    },
    destroy: function () {
      this.$preview.empty();
      this.$inputs.off('change.wpiconset blur.wpiconset');
      return this;
    },
    getActive: function () {
      return this.$icon.val();
    },
    build: function () {
      if (this.$preview.children().length == 0) {
        this.$preview.append(this.markup.replace('##Tag', this.icon.element).replace('##Icon', this.icon.base + ' ' + this.icon.prefix + this.getActive()));
      }
      return this;
    },
    bind: function () {
      var that = this;
      this.$inputs.on('change.wpiconset blur.wpiconset', function () {
        that.change($(this));
      });
      return this;
    },
    change: function ($element) {

      var name = $element.attr('name'), that = this;

      // Flip Options
      if (name.indexOf('[flip]') != -1) {
        that.$preview.find('.wp-icons-wrapper').removeClass('horizontal vertical').addClass($element.val());
      }

      // Spin Options
      else if (name.indexOf('[spin]') != -1) {
        if ($element.val() == '0') {
          that.$preview.find('.wp-icons-wrapper').removeClass('spin');
        }
        else {
          that.$preview.find('.wp-icons-wrapper').addClass('spin');
        }
      }

      // Position Options
      else if (name.indexOf('[position]') != -1) {
        that.$preview.find('.wp-icons-wrapper').removeClass('text-center text-left text-right').addClass($element.val());
      }

      // Shape options
      else if (name.indexOf('[shape]') != -1) {
        var allShapes = '';
        $element.find('option').each(function () {
          allShapes += ' ' + $(this).attr('value');
        });

        that.$preview.find('.wp-icons-wrapper').removeClass(allShapes).addClass($element.val());
      }

      // Rotate Options
      else if (name.indexOf('[rotate]') != -1) {
        if (!$element.val()) {
          that.$preview.find('.wp-icons').css({
            transform: ''
          });
        }
        else {
          that.$preview.find('.wp-icons').css({
            '-webkit-transform' : 'rotate('+ $element.val() +'deg)',
            '-moz-transform' : 'rotate('+ $element.val() +'deg)',
            '-ms-transform' : 'rotate('+ $element.val() +'deg)',
            '-o-transform' : 'rotate('+ $element.val() +'deg)',
            'transform' : 'rotate('+ $element.val() +'deg)'
          });
        }
      }

      // LineHeight Options
      else if (name.indexOf('[lineheight]') != -1) {
        that.$preview.find('.wp-icons').css({
          lineHeight: $element.val()
        });
      }

      // Color Options
      else if (name.indexOf('[color]') != -1
              && name.indexOf('[border][color]') == -1) {
        that.$preview.find('.wp-icons').css({
          color: $element.val()
        });
      }

      // Size options
      else if (name.indexOf('[size]') != -1) {
        that.$preview.find('.wp-icons').css({
          fontSize: $element.val()
        });
      }

      // Padding Options
      else if (name.indexOf('[padding]') != -1) {
        that.$preview.find('.wp-icons-effect').css({
          padding: $element.val()
        });
      }

      // Margin Options
      else if (name.indexOf('[margin]') != -1) {
        that.$preview.find('.wp-icons-effect').css({
          margin: $element.val()
        });
      }

      // Background Options
      else if (name.indexOf('[background]') != -1) {
        that.$preview.find('.wp-icons-effect').css({
          backgroundColor: $element.val()
        });
      }

      // Border Width Options
      else if (name.indexOf('[border][width]') != -1) {
        that.$preview.find('.wp-icons-effect').css({
          borderWidth: $element.val()
        });
      }

      // Border Style Options
      else if (name.indexOf('[border][style]') != -1) {
        that.$preview.find('.wp-icons-effect').css({
          borderStyle: $element.val()
        });
      }

      // Border Color Options
      else if (name.indexOf('[border][color]') != -1) {
        that.$preview.find('.wp-icons-effect').css({
          borderColor: $element.val()
        });
      }

      // Border Radius Options
      else if (name.indexOf('[border][radius]') != -1) {
        that.$preview.find('.wp-icons-effect').css({
          borderRadius: $element.val()
        });
      }

      // Icon Element
      else if (name.indexOf('[icon]') != -1) {
        var remove = '',
            current = that.$preview.find('.wp-icons').attr('class').split(' '),
            iconClass = that.icon.base + ' ' + that.icon.prefix + $element.val();

        $.each(current, function(key, value) {
          if (value.indexOf(that.icon.base) !== -1) {
            remove += ' ' + value;
          }
          else if (value.indexOf(that.icon.prefix) !== -1) {
            remove += ' ' + value;
          }
        })

        that.$preview.find('.wp-icons').removeClass(remove).addClass(iconClass);

      }

      return this;
    },
    refresh: function() {
      var that = this;
      this.$inputs.each(function(key, element) {
        that.change($(element));
      });
      return this;
    }
  }

  $(document)
    .on('ready.wpiconset-build ajaxComplete.wpiconset-build', function() {
      if ($('.form-wpiconset.with-preview').length != 0) {
        $('.form-wpiconset.with-preview').each(function () {
          if (typeof $(this).data('wpiconset') == 'undefined') {
            $(this).data('wpiconset', new window.VTCore.WpIconsetPreviewer($(this)));
            $(this).data('wpiconset').init().refresh();
            $(this).addClass('processed');
          }
        });
      }
    })
    .on('wpajax:replace.wpiconset-refresh', function(event, element) {
      var self = $(element);
      if (self.length != 0 && self.hasClass('form-icons-iconpicker')) {
        var parent = self.closest('.form-wpiconset.with-preview');
        if (parent.length && parent.data('wpiconset')) {
          parent.data('wpiconset').destroy();
          parent.removeData('wpiconset').removeClass('processed');
        }
      }
    });

})(jQuery);