/**
 * Simple script for drawing lines connecting bubbleline
 * content
 *
 * @author jason.xie@victheme.com
 */
(function($) {

  /**
   * Object for detecting and storing coordinates for
   * each dots. use this on each bubble line child entry.
   *
   * @param element
   *   the bubble child jQuery object
   *
   * @param canvas
   *   the designated canvas object
   *
   * @constructor
   */
  var BubbleLinesDot = function(element, container) {
    this.$parent = element;
    this.$el = element.find('[data-connector-line]');
    this.$container = container
  }



  /**
   * Bubble line dot methods.
   * @type {{setCanvas: Function, setPosition: Function, setOffsets: Function, setDotPosition: Function, drawDots: Function}}
   */
  BubbleLinesDot.prototype = {

    setLine: function() {
      this.line = this.$parent.data('line');
      return this;
    },

    setDot: function() {

      this.dot = {
        x: this.$el.offset().left - this.$container.offset().left + this.$el.width() /2,
        y: this.$el.offset().top - this.$container.offset().top + this.$el.height() /2
      };

      return this;
    },

    process: function() {
      this
        .setLine()
        .setDot();

      return this;
    }
  }


  /**
   * Object for grouping all the bubble line child elements
   * and building the dots and lines
   *
   * @param element
   *   jQuery object for the main wrapper element
   *
   * @param canvas
   *   jQuery object for the canvas element
   *
   * @param children
   *   jQuery object for group of children elements
   *   use jQuery find to get all the element and pass
   *   it to the object
   *
   * @constructor
   */
  var BubbleLinesConnector = function(element, canvas, children) {
    this.$el = element;
    this.$canvas = canvas;
    this.$children = children;
    return this;
  }


  /**
   * Collection of object methods
   * @type {{setCanvas: Function, setSource: Function, setTarget: Function, addDot: Function, getDot: Function, checkHorizontal: Function, setRadius: Function, setDirection: Function, setArc: Function, clearCanvas: Function, drawLine: Function, drawCurve: Function, drawMode: Function, drawConnector: Function, drawObject: Function}}
   */
  BubbleLinesConnector.prototype = {

    setCanvas: function() {
      this.totalWidth || this.calculate();
      this.$canvas.attr('width', this.totalWidth + 'px');
      this.ctx = this.$canvas.get(0).getContext('2d');
      return this;
    },

    clearCanvas: function() {
      this.ctx || this.setCanvas();
      this.ctx.clearRect(0, 0, this.$canvas.width(), this.$canvas.height());
      return this;
    },

    drawLine: function(start, end, line) {
      this.ctx || this.setCanvas();
      this.ctx.globalCompositeOperation = 'destination-over';
      this.ctx.beginPath();
      this.ctx.lineCap = 'round';
      line.width = parseInt(line.width);

      switch (line.type) {
        case 'solid' :
          this.ctx.setLineDash([line.width, 0]);
          break;
        case 'dashed' :
          this.ctx.setLineDash([line.width + 10, line.width + 20]);
          break;
        case 'dotted' :
          this.ctx.setLineDash([1, line.width + 10]);
          break;
      }

      this.ctx.moveTo(start.x, start.y);
      this.ctx.lineTo(end.x, end.y);
      this.ctx.lineWidth = line.width;
      this.ctx.lineCap = line.height;
      this.ctx.miterLimit = line.width;
      this.ctx.strokeStyle = line.color;
      this.ctx.stroke();
      this.ctx.globalCompositeOperation = 'source-over';

      return this;
    },


    drawObject: function() {
      var that = this;

      this.$children.each(function(delta, element) {

        if ($(this).next().length) {
          var Target = new BubbleLinesDot($(this).next(), that.$el),
              Source = new BubbleLinesDot($(this), that.$el);

          Target.process();
          Source.process();

          // Draw connector when we got 2 dot points
          Source && Target && that.drawLine(Source.dot, Target.dot, Source.line);

          Target = null;
          Source = null;
          delete Target;
          delete Source;
        }
      });

      return this;

    },
    calculate: function() {
      var that = this;
      that.totalHeight = 0;
      that.totalWidth = 0;
      this.$children.each(function() {
        if ($(this).outerHeight(true) > that.totalHeight) {
          that.totalHeight = $(this).outerHeight(true);
        }
        that.totalWidth += $(this).outerWidth(true);
      });

      return this;
    },
    buildScrollbar: function() {
      this.calculate();
      this.$el.customScrollbar({
        skin: 'bubbleline-skin',
        vScroll: false,
        updateOnWindowResize: true,
        fixedThumbHeight: 24,
        fixedThumbWidth: 48
      });

      this.$el.find('.viewport').height(this.totalHeight);

      return this;
    },
    destroy: function() {
      this.$el.customScrollbar('remove', true);
      return this;
    }
  }


  /**
   * jQuery method for calling the object
   * @param options
   * @returns {*}
   */
  $.fn.bubbleLineConnect = function(options) {

    return this.each(function() {

      var BubbleLine = $(this),
          Children = BubbleLine.find('.bubbleline-content'),
          Canvas = $('<canvas class="bubbleline-canvas" />');

      BubbleLine.css('position', 'relative');
      Children.css({zIndex: 3});
      Canvas
        .attr('width', BubbleLine.width())
        .attr('height', BubbleLine.height())
        .css({
          position: 'absolute',
          left:  0,
          top: 0,
          zIndex: 1
        })
        .prependTo(BubbleLine);


      var BubbleLineObject = new BubbleLinesConnector(BubbleLine, Canvas, Children);
      BubbleLineObject.buildScrollbar().drawObject();

      Canvas.data('bubble-line-object', BubbleLineObject);

      delete BubbleLine;
      delete BubbleLineObject;
      delete Canvas;

      BubbleLine = null;
      BubbleLineObject = null;
      Canvas = null;
    });
  };


  var BubbleLineHelper = {
    wwidth: $(window).width(),
    timer: false
  }

  $.fn.bubbleLineDestroy = function() {
    return this.each(function() {
      var LineObject = $(this).find('.bubbleline-canvas').data('bubble-line-object');
      LineObject && LineObject.destroy();
      delete LineObject;
      LineObject = null;
      $(this).find('.bubbleline-canvas').remove();
    });
  }

  if ($('#page').length && $('#page').hasClass('animsition')) {
    $(window)
      .on('animsitionPageIn.bubbleline', function() {
        $('.bubbleline-connector').bubbleLineDestroy().bubbleLineConnect();

        $(window)
          .on('sortupdate.bubbleline', function() {
            $('.bubbleline-connector').bubbleLineDestroy().bubbleLineConnect();
          })
          .on('resize.bubbleline', function() {
            if (BubbleLineHelper.wwidth != $(window).width()) {
              clearTimeout(BubbleLineHelper.timer);
              BubbleLineHelper.timer = setTimeout(function() {
                $('.bubbleline-connector').bubbleLineDestroy().bubbleLineConnect();
                BubbleLineHelper.wwidth - $(window).width();
              }, 50);
            }
          });

      });
  }
  else {
    $(window)
      .on('load.bubbleline sortupdate.bubbleline', function () {
        $('.bubbleline-connector').bubbleLineDestroy().bubbleLineConnect();
      })
      .on('resize.bubbleline', function() {
        if (BubbleLineHelper.wwidth != $(window).width()) {
          clearTimeout(BubbleLineHelper.timer);
          BubbleLineHelper.timer = setTimeout(function() {
            $('.bubbleline-connector').bubbleLineDestroy().bubbleLineConnect();
            BubbleLineHelper.wwidth - $(window).width();
          }, 50);
        }
      });
  }

})(jQuery)
