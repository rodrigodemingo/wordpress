/**
 * Simple javascript for hiding / showing
 * the label element in a bootstrap form
 * when the form group input has value.
 *
 * @author jason.xie@victheme.com
 */
(function($) {

  function VTCoreBSLabelToggle(options) {
    this.options = $.extend({
      object: false,
      parent: 'form-group',
      active: 'bs-toggle-active'
    }, options);

    this.init();
  };

  VTCoreBSLabelToggle.prototype = {
    init: function () {

      this.activeClass = this.options.active;

      this.registerElement();
      this.fixPlaceholder();
      this.toggleParentClass();

      this.element.addClass('bs-toggle-element');
      this.parent.addClass('bs-toggle-processed');

      return this;
    },
    registerElement: function () {
      var that = this;
      this.parent = this.options.object;
      this.label = this.parent.find('label');
      this.element = this.parent.find('input, select, textarea').not(':checkbox, :radio, :submit, :reset, .jvprocessed');
      this.element.each(function() {
        var element = $(this);
        if (!element.data('bstoggle-link')) {
          element.data('bstoggle-link', []);
        }
        element.data('bstoggle-link').push(that);
      });

      return this;
    },
    fixPlaceholder: function () {
      var that = this;
      this.label.length && this.element.each(function() {
        var element = $(this);
        !element.attr('placeholder') && element.attr('placeholder', that.label.text());
      });

      return this;
    },
    toggleParentClass: function () {
      var show = false;
      this.element.each(function() {
        if ($(this).val().length) {
          show = true;
          return false;
        }
      });

      show ? this.parent.addClass(this.activeClass) : this.parent.removeClass(this.activeClass);

      return this;
    }
  }

  // Bind events via jQuery
  $(document)
    .on('ready.bs-toggle-label ajaxComplete.bs-toggle-label', function() {

      // CSS styling need the js class markup!
      $('html').removeClass('no-js').addClass('js');

      $('[data-toggle-label]:not(.bs-toggle-processed)').each(function() {
        var options = $(this).data('toggle-label');
            options.object = $(this);
        $(this).data('bstoggle', new VTCoreBSLabelToggle(options));
      });
    })
    .on('keyup.bs-toggle-label blur.bs-toggle-label change.bs-toggle-label', '.bs-toggle-element', function() {
      if ($(this).data('bstoggle-link')) {
        $.each($(this).data('bstoggle-link'), function(key, element) {
          element.toggleParentClass();
        });
        $(this).trigger('bs-toggle-change', $(this));
      }
    })

})(jQuery);
