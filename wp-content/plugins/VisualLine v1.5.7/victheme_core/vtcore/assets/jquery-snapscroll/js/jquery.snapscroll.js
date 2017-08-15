/*!
 * jQuery.scrollTo
 * Copyright (c) 2007-2015 Ariel Flesler - aflesler<a>gmail<d>com | http://flesler.blogspot.com
 * Licensed under MIT
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 * @projectDescription Lightweight, cross-browser and highly customizable animated scrolling with jQuery
 * @author Ariel Flesler
 * @version 2.1.1
 */
;(function(factory) {
  'use strict';
  if (typeof define === 'function' && define.amd) {
    // AMD
    define(['jquery'], factory);
  } else if (typeof module !== 'undefined' && module.exports) {
    // CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Global
    factory(jQuery);
  }
})(function($) {
  'use strict';

  var $scrollTo = $.scrollTo = function(target, duration, settings) {
    return $(window).scrollTo(target, duration, settings);
  };

  $scrollTo.defaults = {
    axis:'xy',
    duration: 0,
    limit:true
  };

  function isWin(elem) {
    return !elem.nodeName ||
    $.inArray(elem.nodeName.toLowerCase(), ['iframe','#document','html','body']) !== -1;
  }

  $.fn.scrollTo = function(target, duration, settings) {
    if (typeof duration === 'object') {
      settings = duration;
      duration = 0;
    }
    if (typeof settings === 'function') {
      settings = { onAfter:settings };
    }
    if (target === 'max') {
      target = 9e9;
    }

    settings = $.extend({}, $scrollTo.defaults, settings);
    // Speed is still recognized for backwards compatibility
    duration = duration || settings.duration;
    // Make sure the settings are given right
    var queue = settings.queue && settings.axis.length > 1;
    if (queue) {
      // Let's keep the overall duration
      duration /= 2;
    }
    settings.offset = both(settings.offset);
    settings.over = both(settings.over);

    return this.each(function() {
      // Null target yields nothing, just like jQuery does
      if (target === null) return;

      var win = isWin(this),
        elem = win ? this.contentWindow || window : this,
        $elem = $(elem),
        targ = target,
        attr = {},
        toff;

      switch (typeof targ) {
        // A number will pass the regex
        case 'number':
        case 'string':
          if (/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(targ)) {
            targ = both(targ);
            // We are done
            break;
          }
          // Relative/Absolute selector
          targ = win ? $(targ) : $(targ, elem);
          if (!targ.length) return;
        /* falls through */
        case 'object':
          // DOMElement / jQuery
          if (targ.is || targ.style) {
            // Get the real position of the target
            toff = (targ = $(targ)).offset();
          }
      }

      var offset = $.isFunction(settings.offset) && settings.offset(elem, targ) || settings.offset;

      $.each(settings.axis.split(''), function(i, axis) {
        var Pos	= axis === 'x' ? 'Left' : 'Top',
          pos = Pos.toLowerCase(),
          key = 'scroll' + Pos,
          prev = $elem[key](),
          max = $scrollTo.max(elem, axis);

        if (toff) {// jQuery / DOMElement
          attr[key] = toff[pos] + (win ? 0 : prev - $elem.offset()[pos]);

          // If it's a dom element, reduce the margin
          if (settings.margin) {
            attr[key] -= parseInt(targ.css('margin'+Pos), 10) || 0;
            attr[key] -= parseInt(targ.css('border'+Pos+'Width'), 10) || 0;
          }

          attr[key] += offset[pos] || 0;

          if (settings.over[pos]) {
            // Scroll to a fraction of its width/height
            attr[key] += targ[axis === 'x'?'width':'height']() * settings.over[pos];
          }
        } else {
          var val = targ[pos];
          // Handle percentage values
          attr[key] = val.slice && val.slice(-1) === '%' ?
          parseFloat(val) / 100 * max
            : val;
        }

        // Number or 'number'
        if (settings.limit && /^\d+$/.test(attr[key])) {
          // Check the limits
          attr[key] = attr[key] <= 0 ? 0 : Math.min(attr[key], max);
        }

        // Don't waste time animating, if there's no need.
        if (!i && settings.axis.length > 1) {
          if (prev === attr[key]) {
            // No animation needed
            attr = {};
          } else if (queue) {
            // Intermediate animation
            animate(settings.onAfterFirst);
            // Don't animate this axis again in the next iteration.
            attr = {};
          }
        }
      });

      animate(settings.onAfter);

      function animate(callback) {
        var opts = $.extend({}, settings, {
          // The queue setting conflicts with animate()
          // Force it to always be true
          queue: true,
          duration: duration,
          complete: callback && function() {
            callback.call(elem, targ, settings);
          }
        });
        $elem.animate(attr, opts);
      }
    });
  };

  // Max scrolling position, works on quirks mode
  // It only fails (not too badly) on IE, quirks mode.
  $scrollTo.max = function(elem, axis) {
    var Dim = axis === 'x' ? 'Width' : 'Height',
      scroll = 'scroll'+Dim;

    if (!isWin(elem))
      return elem[scroll] - $(elem)[Dim.toLowerCase()]();

    var size = 'client' + Dim,
      doc = elem.ownerDocument || elem.document,
      html = doc.documentElement,
      body = doc.body;

    return Math.max(html[scroll], body[scroll]) - Math.min(html[size], body[size]);
  };

  function both(val) {
    return $.isFunction(val) || $.isPlainObject(val) ? val : { top:val, left:val };
  }

  // Add special hooks so that window scroll properties can be animated
  $.Tween.propHooks.scrollLeft =
    $.Tween.propHooks.scrollTop = {
      get: function(t) {
        return $(t.elem)[t.prop]();
      },
      set: function(t) {
        var curr = this.get(t);
        // If interrupt is true and user scrolled, stop animating
        if (t.options.interrupt && t._last && t._last !== curr) {
          return $(t.elem).trigger('scrollInterrupted').stop(true, true);
        }
        var next = Math.round(t.now);
        // Don't waste CPU
        // Browsers don't render floating point scroll
        if (curr !== next) {
          $(t.elem)[t.prop](next);
          t._last = this.get(t);
        }
      }
    };

  // AMD requirement
  return $scrollTo;
});

// Generated by CoffeeScript 1.6.1
// usage: $('.container').snapscroll({'scrollOptions':{'axis':'y'}});
// for scrollOptions refer to https://github.com/flesler/jquery.scrollTo
(function($, window, document, undefined_) {
  var Plugin, defaults, pluginName,autoscrolling;
  autoscrolling = false;
  pluginName = "snapscroll";
  defaults = {
    child: '.js-deckmode',
    botPadding: 100,
    topPadding: 100,
    scrollSpeed: 600,
    scrollEndSpeed: 300,
    scrollOptions: {
      axis:'xy',
      interrupt: true
    }
  };
  Plugin = function(element, options) {
    this.container = $(element);
    this.options = $.extend({}, defaults, options);
    return this.init();
  };
  Plugin.prototype = {
    init: function() {
      return this.snapping();
    },
    snapping: function() {
      var $children, prev_position, scroll_end_speed, scroll_speed, timer, scroll_options, _this = this;

      $children = this.container.find(this.options.child);
      scroll_speed = this.options.scrollSpeed;
      scroll_end_speed = this.options.scrollEndSpeed;
      scroll_options = this.options.scrollOptions;
      prev_position = $(document).scrollTop();
      timer = null;


      return $(window)
        .off('scrollInterrupted.snapscroll')
        .on('scrollInterrupted.snapscroll', function() {
          var $child, cur_position, direction;

          cur_position = $(document).scrollTop();
          direction = _this.getDirection(prev_position, cur_position);
          $child = _this.getTargetChild($children, direction, cur_position);

          if ($child) $child.removeClass("ss-active");
          if (autoscrolling) autoscrolling = false;
          if (timer != null) clearTimeout(timer);


        })
        .off("scroll.snapscroll")
        .on("scroll.snapscroll", function(e) {

          var $child, cur_position, direction;

          if (!autoscrolling && $(window).height() > 480) {
            cur_position = $(document).scrollTop();
            direction = _this.getDirection(prev_position, cur_position);
            $child = _this.getTargetChild($children, direction, cur_position);
            if ($child) {
              clearTimeout(timer);
              timer = setTimeout(function() {
                $(window).scrollTo($child, scroll_speed, scroll_options);
                $child.siblings(".ss-active").removeClass("ss-active");
                $child.addClass("ss-active");
                autoscrolling = true;
                return setTimeout(function() {
                  prev_position = $(document).scrollTop();
                  return autoscrolling = false;
                }, scroll_speed + 20);
              }, scroll_end_speed);
            }
            return prev_position = cur_position;
          }
        });
    },
    getDirection: function(a, b) {
      if (a > b) {
        return "up";
      } else {
        return "down";
      }
    },
    getTargetChild: function($children, direction, position) {
      var $target, bottom_position, fc_top, lc_bottom, options, window_height;
      options = this.options;
      window_height = $(window).height();
      bottom_position = position + window_height;
      fc_top = $children.first().offset().top;
      lc_bottom = $children.last().offset().top + window_height;
      $target = null;
      if (fc_top < position + options.topPadding) {
        $children.not(".ss-active").each(function(i) {
          var object_bot, object_top;
          object_top = $(this).offset().top;
          object_bot = object_top + $(this).height();
          if (direction === "down") {
            if (object_top < bottom_position && object_bot > position) {
              $target = $(this);
              return false;
            }
          } else {
            if (object_top < position && position < object_bot) {
              return $target = $(this);
            }
          }
        });
      }
      return $target;
    }
  };
  return $.fn[pluginName] = function(options) {
    return this.each(function() {
      if (!$.data(this, "plugin_" + pluginName)) {
        return $.data(this, "plugin_" + pluginName, new Plugin(this, options));
      }
    });
  };
})(jQuery, window, document);
