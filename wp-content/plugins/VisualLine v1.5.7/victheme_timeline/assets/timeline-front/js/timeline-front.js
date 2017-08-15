(function($) {

  var VTTimeLine = function($el) {
    this.$el = $el;
    this.$children = this.$el.find('[data-timeline="items"]');
    this.$parent = this.$el.closest('[data-timeline="wrapper"]');
    this.$icon = this.$el.find('[data-timeline="icon"]');
    this.$bar = this.$parent.find('[data-timeline="bar"]');
    this.destroy();
    this.init();
    return this;
  }
  VTTimeLine.prototype = {
    init: function() {
      this
        .calculate()
        .adjustHeight()
        .adjustPosition()
        .adjustParent()
        .adjustLine()
        .buildScrollbar();

      return this;

    },
    adjustLine: function() {

      // Need better solution, use offset?
      this.offset = parseInt(this.$el.css('marginTop').replace('px', '')) + parseInt(this.$el.css('paddingTop').replace('px', ''));

      this.$icon.css({
        top: this.maxHeightBottom + 'px'
      });

      this.$bar.css({
        top: this.maxHeightBottom + this.offset + 'px'
      });
      return this;
    },
    adjustParent: function() {
      this.$el.css({
        height: this.totalHeight + 'px',
        width: this.totalWidth + 'px'
      });
      return this;
    },
    adjustHeight: function() {
      this.$children.css({
        height: this.totalHeight + 'px'
      });
      return this;
    },
    adjustPosition: function() {
      var that = this;
      this.$children.each(function() {
        switch ($(this).data('direction')) {
          case 'top' :
            $(this).css({
              paddingTop: that.maxHeightBottom + 'px'
            });

            break;
          case 'bottom' :
            $(this).css({
              paddingBottom: that.maxHeightTop + 'px'
            });

            // Check for gaps and push the child down
            if ($(this).children().innerHeight() < that.maxHeightBottom) {
              $(this).children().css({
                marginTop: that.maxHeightBottom - $(this).children().innerHeight() + 'px'
              });
            }
            break;
          case 'center' :
            $(this).css({
              paddingTop: that.maxHeightBottom + 'px'
            });
            $(this).children().css({
              marginTop: '-' + $(this).children().innerHeight() / 2 + 'px'
            })
            break;
        }
      });
      return this;
    },
    calculate: function() {

      // Reset
      this.maxHeightTop = 0;
      this.maxHeightBottom = 0;
      this.maxHeightCenter = 0;
      this.totalWidth = 0;

      var that = this;

      this.$children.each(function() {

        that.direction = $(this).data('direction');

        $(this).children().each(function() {
          that.innerHeight = $(this).innerHeight();
          switch (that.direction) {
            case 'top' :
              if (that.maxHeightTop < that.innerHeight) {
                that.maxHeightTop = that.innerHeight;
              }
              break;
            case 'bottom' :
              if (that.maxHeightBottom < that.innerHeight) {
                that.maxHeightBottom = that.innerHeight;
              }
              break;
            case 'center' :
              if (that.maxHeightCenter < that.innerHeight) {
                that.maxHeightCenter = that.innerHeight;
              }
              break;
          }
        });

        that.totalWidth += $(this).outerWidth(true);
      });

      this.totalHeight = this.maxHeightTop + this.maxHeightBottom;
      if (this.maxHeightCenter > this.totalHeight) {
        this.totalHeight = this.maxHeightCenter;
      }

      return this;
    },
    buildScrollbar: function() {
      this.$parent.customScrollbar({
        skin: 'timeline-skin',
        vScroll: false,
        updateOnWindowResize: false,
        fixedThumbHeight: 24,
        fixedThumbWidth: 48
      });

      this.$parent.find('.viewport').height(this.totalHeight);

      return this;
    },
    destroy: function() {
      this.$el.removeAttr('style');
      this.$children.removeAttr('style');
      this.$parent.customScrollbar('remove', true);

      return this;
    },
    refresh: function() {
      this.destroy();
      this.init();
    }
  }

  
  /**
   * Build the time line element
   */
  $.fn.VTCoreHorizontalTimeline = function() {
    return this.each(function() {
      $(this).find('[data-timeline="element"]').removeData('timeline').data('timeline', new VTTimeLine($(this).find('[data-timeline="element"]')));
    });
  }


  var TimeLineHelper = {
    wwidth: $(window).width(),
    timer: false
  }


  // VC needs load event for this to work properly!.
  if ($('#page').length && $('#page').hasClass('animsition')) {
    $(window)
      .on('animsitionPageIn.timeline', function() {

        $('[data-timeline="wrapper"]').filter('[data-layout="horizontal"]').VTCoreHorizontalTimeline();

        $(window)
          .on('load.timeline sortupdate.timeline', function () {
            $('[data-timeline="wrapper"]').filter('[data-layout="horizontal"]').VTCoreHorizontalTimeline();
          })
          .on('resize.timeline', function() {
            if (TimeLineHelper.wwidth != $(window).width()) {
              clearTimeout(TimeLineHelper.timer);
              TimeLineHelper.timer = setTimeout(function() {
                $('[data-timeline="wrapper"]').filter('[data-layout="horizontal"]').VTCoreHorizontalTimeline();
                TimeLineHelper.wwidth = $(window).width();
              }, 50);
            }
          });
      });
  }
  else {
    $(window)
      .on('load.timeline sortupdate.timeline', function () {
        $('[data-timeline="wrapper"]').filter('[data-layout="horizontal"]').VTCoreHorizontalTimeline();
      })
      .on('resize.timeline', function() {
        if (TimeLineHelper.wwidth != $(window).width()) {
          clearTimeout(TimeLineHelper.timer);
          TimeLineHelper.timer = setTimeout(function() {
            $('[data-timeline="wrapper"]').filter('[data-layout="horizontal"]').VTCoreHorizontalTimeline();
            TimeLineHelper.wwidth = $(window).width();
          }, 50);
        }
      });
  }
 
  
})(window.jQuery);