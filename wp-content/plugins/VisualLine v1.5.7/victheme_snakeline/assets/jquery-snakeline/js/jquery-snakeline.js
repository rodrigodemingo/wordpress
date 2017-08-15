/**
 * Simple script for drawing lines connecting snakeline
 * content
 *
 * @author jason.xie@victheme.com
 */
(function($) {

  /**
   * Object for detecting and storing coordinates for
   * each dots. use this on each snake line child entry.
   *
   * @param element
   *   the snake child jQuery object
   *
   * @param canvas
   *   the designated canvas object
   *
   * @constructor
   */
  var SnakeLinesDot = function(element, container, delta) {
    this.$parent = element;
    this.$el = element.find('[data-snakeline-dot]');
    this.$container = container;
    this.delta = delta;
  }



  /**
   * Snake line dot methods.
   * @type {{setCanvas: Function, setPosition: Function, setOffsets: Function, setDotPosition: Function, drawDots: Function}}
   */
  SnakeLinesDot.prototype = {

    setLine: function() {
      this.line = this.$container.data('line');
      this.line.width = parseInt(this.line.width);
      return this;
    },

    setDot: function() {

      this.dotStart = {
        x: this.$parent.offset().left - this.$container.offset().left,
        y: this.$el.offset().top - this.$container.offset().top + this.$el.height() /2
      };

      this.dotEnd = {
        x: this.$parent.offset().left - this.$container.offset().left + this.$parent.outerWidth(),
        y: this.$el.offset().top - this.$container.offset().top + this.$el.height() /2
      };

      this.arc = {
        x: this.$el.offset().left - this.$container.offset().left + this.$el.width() /2,
        y: this.$el.offset().top - this.$container.offset().top + this.$el.height() /2,
        radius: (this.$parent.outerWidth() / 2),
        startAngle: (this.delta & 1) ? Math.PI : 0,
        endAngle: (this.delta & 1) ? 0 : Math.PI,
        counter: false
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
   * Object for grouping all the snake line child elements
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
  var SnakeLinesConnector = function(element, canvas, children) {
    this.$el = element;
    this.$canvas = canvas;
    this.$children = children;
    return this;
  }


  /**
   * Collection of object methods
   * @type {{setCanvas: Function, setSource: Function, setTarget: Function, addDot: Function, getDot: Function, checkHorizontal: Function, setRadius: Function, setDirection: Function, setArc: Function, clearCanvas: Function, drawLine: Function, drawCurve: Function, drawMode: Function, drawConnector: Function, drawObject: Function}}
   */
  SnakeLinesConnector.prototype = {

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

    drawArc: function(dot, line) {
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

      this.ctx.arc(dot.x, dot.y, dot.radius, dot.startAngle, dot.endAngle, dot.reverse);
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

      this.$children.first().addClass('first-child');
      this.$children.last().addClass('last-child');

      this.$children.each(function(delta, element) {

        var Source = new SnakeLinesDot($(this), that.$el, delta);

        Source.process();

        // Draw the half circle
        Source && that.drawArc(Source.arc, Source.line);

        if ($(this).next().length) {
          var Target = new SnakeLinesDot($(this).next(), that.$el, delta);
          Target.process();
        }

        // Draw connector when we got 2 dot points
        Source && Target && that.drawLine(Source.dotEnd, Target.dotStart, Source.line);

        Source = null;
        delete Source;

        if (Target) {
          Target = null;
          delete Target;
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

      this.totalWidth += 60;

      return this;
    },
    buildScrollbar: function() {
      this.calculate();
      this.$el.customScrollbar({
        skin: 'snakeline-skin',
        vScroll: false,
        updateOnWindowResize: true,
        fixedThumbHeight: 24,
        fixedThumbWidth: 24
      });

      this.$el.find('.viewport').height(this.totalHeight);
      this.$el.find('.overview').width(this.totalWidth);
      this.$el.customScrollbar('resize', true);
      return this;
    },
    destroy: function() {
      this.$children.css({"width":"", "height":""});
      this.$el.customScrollbar('remove', true);
      return this;
    }
  }


  /**
   * jQuery method for calling the object
   * @param options
   * @returns {*}
   */
  $.fn.snakeLineConnect = function(options) {

    return this.each(function() {

      var SnakeLine = $(this),
          Children = SnakeLine.find('.snakeline-content'),
          Canvas = $('<canvas class="snakeline-canvas" />')
          maxHeight = 0;

      Children.find('.snakeline-wrapper').each(function() {
        if ($(this).outerHeight() > maxHeight) {
          maxHeight = $(this).outerHeight();
        }
      });


      Children.css({ height: maxHeight * 2 +'px'});
      Children.filter(':odd').css({paddingTop: maxHeight + 'px'});
      Children.filter(':even').css({paddingBottom: maxHeight + 'px'});

      SnakeLine.css('position', 'relative');
      Children.css({zIndex: 3});
      Canvas
        .attr('width', SnakeLine.width())
        .attr('height', SnakeLine.height())
        .css({
          position: 'absolute',
          left:  0,
          top: 0,
          zIndex: 1
        })
        .prependTo(SnakeLine);


      var SnakeLineObject = new SnakeLinesConnector(SnakeLine, Canvas, Children);
      SnakeLineObject.buildScrollbar().drawObject();

      Canvas.data('snake-line-object', SnakeLineObject);

      delete SnakeLine;
      delete SnakeLineObject;
      delete Canvas;

      SnakeLine = null;
      SnakeLineObject = null;
      Canvas = null;

    });
  };


  $.fn.snakeLineDestroy = function() {
    return this.each(function() {
      var LineObject = $(this).find('.snakeline-canvas').data('snake-line-object');
      LineObject && LineObject.destroy();
      delete LineObject;
      LineObject = null;
      $(this).find('.snakeline-canvas').remove();
    });
  }


  var SnakeLineHelper = {
    wwidth: $(window).width(),
    timer: false
  }


  if ($('#page').length && $('#page').hasClass('animsition')) {
    $(window)
      .on('animsitionPageIn.snakeline', function() {
        $('.snakeline-connector').snakeLineDestroy().snakeLineConnect();

        $(window)
          .on('sortupdate.snakeline', function() {
            $('.snakeline-connector').snakeLineDestroy().snakeLineConnect();
          })
          .on('resize.snakeline', function() {
            if (SnakeLineHelper.wwidth != $(window).width()) {
              clearTimeout(SnakeLineHelper.timer);
              SnakeLineHelper.timer = setTimeout(function() {
                SnakeLineHelper.wwidth = $(window).width();

                $('.snakeline-connector').snakeLineDestroy();
                setTimeout(function() {
                  $('.snakeline-connector').snakeLineConnect();
                }, 10);

              }, 50);
            }
          });

      });
  }
  else {
    $(window)
      .on('load.snakeline sortupdate.snakeline', function () {
        $('.snakeline-connector').snakeLineDestroy().snakeLineConnect();
      })
      .on('resize.snakeline', function() {
        if (SnakeLineHelper.wwidth != $(window).width()) {
          clearTimeout(SnakeLineHelper.timer);
          SnakeLineHelper.timer = setTimeout(function() {
            SnakeLineHelper.wwidth = $(window).width();

            $('.snakeline-connector').snakeLineDestroy();
            setTimeout(function() {
              $('.snakeline-connector').snakeLineConnect();
            }, 10);

          }, 50);
        }
      });
  }

})(jQuery)
