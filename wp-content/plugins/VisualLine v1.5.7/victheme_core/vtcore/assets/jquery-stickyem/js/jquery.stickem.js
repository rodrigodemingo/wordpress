/**
 * @name jQuery Stick 'em
 * @author Trevor Davis
 * @version 1.4.1
 *
 *    $('.container').stickem({
 *		item: '.stickem',
 *		container: '.stickem-container',
 *		stickClass: 'stickit',
 *		endStickClass: 'stickit-end',
 *		offset: 0,
 *		onStick: null,
 *		onUnstick: null
 *	});
 */

;
(function ($, window, document, undefined) {

  var Stickem = function (elem, options) {
    this.elem = elem;
    this.$elem = $(elem);
    this.options = options;
    this.metadata = this.$elem.data("stickem-options");
    this.$win = $(window);
  };

  Stickem.prototype = {
    defaults: {
      item: '.stickem',
      container: '.stickem-container',
      stickClass: 'stickit',
      endStickClass: 'stickit-end',
      start: 0,
      end: 0,
      onTopStick: null,
      onMiddleStick: null,
      onBottomStick: null
    },

    init: function () {
      var _self = this;

      //Merge options
      _self.config = $.extend({}, _self.defaults, _self.options, _self.metadata);
      _self.config.start += parseInt($('html').css('margin-top'));

      _self.setWindowHeight();
      _self.getItems();
      _self.bindEvents();

      return _self;
    },

    bindEvents: function () {
      var _self = this;

      _self.$win.on('scroll.stickem', $.proxy(_self.handleScroll, _self));
      _self.$win.on('resize.stickem', $.proxy(_self.handleResize, _self));
    },

    destroy: function () {
      var _self = this;

      _self.$win.off('scroll.stickem');
      _self.$win.off('resize.stickem');
    },

    getItem: function (index, element) {
      var _self = this;
      var $this = $(element);
      var item = {
        $elem: $this,
        elemHeight: $this.outerHeight(),
        $container: $this.closest(_self.config.container),
        isStuck: false
      };

      //If the element is smaller than the window
      if (_self.windowHeight > item.elemHeight) {
        item.containerInnerHeight = item.$container.innerHeight();
        item.containerStart = item.$container.offset().top + _self.config.start;
        item.scrollFinish = item.$container.offset().top + item.containerInnerHeight + _self.config.end - item.elemHeight;

        //If the element is smaller than the container
        if (item.containerInnerHeight > item.elemHeight) {
          _self.items.push(item);
        }
      }
      else {
        item.$elem.removeClass(_self.config.stickClass + ' ' + _self.config.endStickClass);
      }

    },

    getItems: function () {
      var _self = this;

      _self.items = [];

      _self.$elem.find(_self.config.item).each($.proxy(_self.getItem, _self));
    },

    handleResize: function () {
      var _self = this;

      _self.getItems();
      _self.setWindowHeight();
    },

    handleScroll: function () {
      var _self = this;

      if (_self.items.length > 0) {
        var pos = _self.$win.scrollTop();

        for (var i = 0, len = _self.items.length; i < len; i++) {
          var item = _self.items[i];

          // Over the top
          if (pos < item.containerStart) {

            // Reset mode
            item.$elem.removeClass(_self.config.stickClass).removeClass(_self.config.endStickClass);
            item.isStuck = false;

            //if supplied fire the onStick callback
            if (_self.config.onTopStick) {
              _self.config.onTopStick(item);
            }

            // Trigger jQuery event
            $(document).trigger('stickem-top', item);
          }

          // In between scrolling
          else if (pos > item.containerStart && pos < item.scrollFinish) {

            // Stick mode
            item.$elem.removeClass(_self.config.endStickClass).addClass(_self.config.stickClass);

            //if supplied fire the onStick callback
            if (_self.config.onMiddleStick) {
              _self.config.onMiddleStick(item);
            }

            // Trigger jQuery event
            $(document).trigger('stickem-middle', item);
          }

          // Over the bottom
          else {

            // Stick at bottom mode
            item.$elem.removeClass(_self.config.stickClass).addClass(_self.config.endStickClass);
            item.isStuck = false;

            //if supplied fire the onUnstick callback
            if (_self.config.onBottomStick) {
              _self.config.onBottomStick(item);
            }

            // Trigger jQuery event
            $(document).trigger('stickem-bottom', item);
          }
        }
      }
    },

    setWindowHeight: function () {
      var _self = this;

      _self.windowHeight = _self.$win.height();
    }
  };

  Stickem.defaults = Stickem.prototype.defaults;

  $.fn.stickem = function (options) {
    //Create a destroy method so that you can kill it and call it again.
    this.destroy = function () {
      this.each(function () {
        new Stickem(this, options).destroy();
      });
    };

    return this.each(function () {
      new Stickem(this, options).init();
    });
  };

})(jQuery, window, document);

// Auto boot
(function ($) {

  /**
   * Autobooting stickem element.
   * all element must follow these markup rules :
   *
   * <div data-stickem="true">
   *  <div class="stickem-container"> // This is where the height will be retrieved
   *    <div class="stickem"> // this is the floating item
   *    </div>
   *  </div>
   * </div>
   *
   */
  $('[data-stickem="true"]').each(function () {
    $(this).stickem({
      item: '.stickem',
      container: '.stickem-container',
      stickClass: 'stickit',
      endStickClass: 'stickit-end'
    });
  })

})(jQuery);