/**
 * Simple script for allowing form to have a dependencies children that can be
 * shown / hidden based on the parent form element value.
 *
 * Currently it will look for bootstrap input-group or form-group class
 * as the target to hide / show.
 *
 * Usage :
 * put data-dependency="json_object" in the parent trigger for all dependent children
 *
 * Json Object example :
 *
 * {
   *  this_is_input_name[some_other_name] : somevalue
   *  this_another_input_name[some_other_name] : somevalue
   * }
 *
 * when value matches the dependent will be shown and if it doesn't match
 * it will get hidden;
 *
 * @author jason.xie@victheme.com
 *
 */
(function($) {

  if (!window.VT) {
    window.VT = {};
  }

  VT.BsToggleDependency = function(element) {
    this.init(element);
  }

  VT.BsToggleDependency.prototype = {
    init: function(element) {
      this.element = element;
      this.dependent = this.element.data('dependency');
      this.storedDependent = [];
      this.findDependent();
    },
    sanitizeInput: function(text) {
      return text.replace(/\W+/g, "-");
    },
    findDependent: function() {
      var that = this;
      this.dependent && $.each(this.dependent, function(inputName, checkValue) {

        var maybeDependent = $('[name="' + inputName + '"]');
        if (maybeDependent.length) {
          // Try form-group
          var maybeParent = maybeDependent.closest('.form-group');

          // try input-group
          if (maybeParent.length == 0) {
            maybeParent = maybeDependent.closest('.input-group');
          }

          if (maybeParent.length != 0) {
            that.storedDependent[that.sanitizeInput(inputName)] = maybeParent;
          }
          delete(maybeParent);
        }
      })
    },
    toggle: function(element) {

      if (element.attr('name') != this.element.attr('name')) {
        this.init(element);
      }

      if (this.element.attr('type') == 'checkbox'
          || this.element.attr('type') == 'radio') {

        this.elVal = 'false';
        if (this.element.attr('checked') == 'checked') {
          this.elVal = 'true';
        }
      }
      else {
        this.elVal = this.element.val();
      }

      var that = this;
      this.dependent && $.each(this.dependent, function(inputName, targetValue) {
        var maybeTarget = that.storedDependent[that.sanitizeInput(inputName)], arrayKey = that.sanitizeInput(inputName);

        if (that.elVal == targetValue) {
          that.storedDependent[arrayKey] && that.storedDependent[arrayKey].show();
        }
        else {
          that.storedDependent[arrayKey] && that.storedDependent[arrayKey].hide();
        }
      });
    }
  }

  $(document)
    .on('ready.bs-toggle-dependency ajaxComplete.bs-toggle-dependency', function() {
      $('[data-dependency]:not(.bs-toggle-dependency-processed)').each(function() {
        $(this).data('bs-toggle-dependency', new VT.BsToggleDependency($(this)));
        $(this).data('bs-toggle-dependency').toggle($(this));
        $(this).addClass('bs-toggle-dependency-processed');
      });
    })
    .on('change.bs-toggle-dependency', '[data-dependency]', function() {
      if (!$(this).data('bs-toggle-dependency')) {
        $(this).data('bs-toggle-dependency', new VT.BsToggleDependency($(this)));
      }

      $(this).data('bs-toggle-dependency').toggle($(this));
    });

})(jQuery);