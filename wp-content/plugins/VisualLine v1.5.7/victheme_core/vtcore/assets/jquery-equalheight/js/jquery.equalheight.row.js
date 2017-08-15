(function($) {
   
  /**
   * Equalheight per row plugin taken from http://css-tricks.com
   */
  $.fn.EqualHeight = function() {   
    $(this.get()).each(function() {
      var self = $(this),
          currentTallest = 0,
          currentRowStart = 0,
          currentItem = 0,
          currentDiv = 0,
          rowDivs = new Array(),
          $el,
          items = self.equalHeightFirstLevel(' .items'),
          count = items.length,
          column = 0,
          i = 0;

      // Don't process if we got only 1 element
      if (count <= 1) {
        return;
      }
      
      currentRowStart = Math.floor(items.eq(currentItem).position().top);
      
      // Determine what is the maximum column number
      for (currentItem = 0 ; currentItem < count ; currentItem++) {
        
        if (Math.floor(items.eq(currentItem).position().top) != currentRowStart) {
          break;
        }
         
        column = currentItem;
      }
      
      

      for (currentItem = 0 ; currentItem < count ; currentItem++) {
        
        $el = items.eq(currentItem);

        // Reset column counter
        if (column < i) {
          i = 0;
        }

        // Entering new row
        if (i==0) {
          // we just came to a new row. Set all the heights on the completed row
          for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
            var mode = rowDivs[currentDiv].data('rowmode');
            if (typeof mode == 'undefined') {
              mode = 'min-height';
            }
            
            rowDivs[currentDiv].css(mode, currentTallest + 'px');
          }
          
          // set the variables for the new row
          rowDivs = new Array(); // empty the array
          currentTallest = Math.ceil($el.innerHeight() + 1);
          rowDivs.push($el);
          
          // Clear floats
          rowDivs[0].css('clear', 'both');
  
        } 
        
        // No more items left force resizing
        else if (items.eq(currentItem + 1).length == 0) {
          
          rowDivs.push($el);
          currentTallest = (currentTallest < $el.innerHeight()) ? ($el.innerHeight()) : (currentTallest);
          
          for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
            var mode = rowDivs[currentDiv].data('rowmode');
            if (typeof mode == 'undefined') {
              mode = 'min-height';
            }
            
            rowDivs[currentDiv].css(mode, currentTallest + 'px');
          }
        }
        
        // Still got child just record tallest and register el
        else {
          
	        // another div on the current row. Add it to the list and check if
	        // it's taller
	        rowDivs.push($el);
	        currentTallest = (currentTallest < $el.innerHeight()) ? ($el.innerHeight()) : (currentTallest);
	      }
          
        i++;
        
      }
    });
    
    return this;
  }; 
   
  /**
   * Reset The equalheight
   */
  $.fn.resetEqualHeight = function(timeout) {
    var VTEqualHeight = {
        $el: $(this),
        is_safari : navigator.userAgent.indexOf("Safari") > -1,
        queue: $({}),
        timout: timeout,
        init: function() {

          var that = this;

          this.queue
            .queue('equalheight', function(next) {
              that.$el.trigger('equalheight-reset');
              next();
            })
            .queue('equalheight', function(next) {
              that.destroy();
              next();
            })
            .queue('equalheight', function(next) {
              that.$el.trigger('equalheight-start');
              setTimeout(function() {
                next();
              }, that.timeout);
            })
            .queue('equalheight', function(next) {
              that.reposition();
              next();
            })
            .queue('equalheight', function(next) {
              that.$el.trigger('equalheight-complete');
              next()
            });

          this.queue.dequeue('equalheight');

          return this;
        },
        destroy: function() {
          this.$el.find('.items').css('min-height', '').css('height', '').css('clear', 'none');
          return this;
        },
        reposition: function() {
          this.$el.EqualHeight();
          return this;
        }
      };

    VTEqualHeight.init();
    
    return this;
  }
  
  
  $.fn.equalHeightFirstLevel = function(sel) {
    var obj = $(this);
    if (obj.selector != sel) {
        obj = obj.find(sel);
    }
    obj = obj.not(obj.find(sel));

    return obj;
  }
  
  /**
   * Autoloading equalheight
   */  
  $(window)
    .on('load.equalheightrow resize_end.equalheightrow resize.equalheightrow', function() {
      $('.equalheightRow').resetEqualHeight(800);
    });
  
  $(document)
    .on('ajaxComplete animsitionPageIn.equalheightRow', function() {
      $('.equalheightRow').resetEqualHeight(800);
    });
  
})(jQuery);