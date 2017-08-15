/**
 * Javascript for enabling tree like elements for wptermsboxes
 * @see VTCore_Wordpress_Form_WpTermBoxes
 * @author jason.xie@victheme.com
 */
(function($) {

  if (!window.VT) {
    window.VT = {};
  }

  /** Registering to global VT **/
  VT.WPTermBoxes = function(element) {
    this.$el = element;
    this.$triggers = this.$el.find('[data-term-trigger]');
    this.$targets = this.$el.find('[data-term-parent]');
    this.init();
  }

  VT.WPTermBoxes.prototype = {

    /**
     * Booting object
     */
    init: function() {
      this.cleanTrigger().detectToggleState();
      return this;
    },

    /**
     * Cleaning unused triggers
     */
    cleanTrigger: function() {
      var that = this;
      $.each(this.$triggers, function(key, trigger) {
        var $trigger = $(trigger);
        if (that.getTarget($trigger.data('term-trigger')).length == 0) {
          $trigger.removeAttr('data-term-trigger');
          delete that.$triggers[key];
        }
      });
      return this;
    },

    /**
     * Return the target object, use the data-term-trigger
     * value as the trigger ID
     */
    getTarget: function(triggerID) {
      return this.$targets.find('[data-term-parent="' + triggerID + '"]');
    },


    /**
     * Get the target object, use data-term-target as the
     * value for the target ID
     */
    getTrigger: function(targetID) {
      return this.$triggers.find('[data-term-trigger="' + targetID + '"]');
    },


    /**
     * Toggle the visibility of the term hierarchy set
     * Use jQuery object with data-term-trigger as the
     * trigger object param
     */
    toggle: function(trigger) {
      this.active = trigger.data('term-trigger');
      trigger.toggleClass('active');
      this.$targets.filter('[data-term-parent="' + this.active + '"]').slideToggle();
      return this;
    },


    /**
     * Detecting whether to open or close hierarchy level and its children
     * Use only during init!
     */
    detectToggleState: function() {
      var that = this;
      $.each(this.$targets, function(key, target) {
        var $target = $(target),
          $trigger = $(that.getTrigger($target.data('term-parent')));

        if ($target.find('input:checked').length != 0) {
            $trigger.addClass('active');
        }
      });

      // Delay the actual closing to give time for the previous loop
      // to finish
      // @todo use queue for this.
      setTimeout(function() {
        $.each(that.$targets, function(key, target) {
          var $target = $(target),
            $trigger = $(that.getTrigger($target.data('term-parent')));

          if (!$trigger.hasClass('active')) {
            $target.slideUp();
          }
        });
      }, 100);

      return this;
    }
  }


  $(document)

    // Binding object initialization during document ready
    // or ajaxComplete events.
    .on('ready.wptermboxes ajaxComplete.wptermboxes', function() {
      $('.wp-terms-group:not(.initialized)').each(function() {
        $(this).data('wp-term-boxes', new VT.WPTermBoxes($(this)));
        $(this).addClass('initialized');
      });
    })

    // Bind the trigger element click event.
    .on('click.wptermboxes', '[data-term-trigger]', function() {
      $(this).closest('.wp-terms-group').data('wp-term-boxes').toggle($(this));
    })

})(jQuery);