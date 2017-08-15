/**
 * Simple script for drawing lines connecting memoryline
 * content
 *
 * @author jason.xie@victheme.com
 */
(function($) {

  /**
   * Object for detecting and storing coordinates for
   * each dots. use this on each memory line child entry.
   *
   * @param element
   *   the memory child jQuery object
   *
   * @param container
   *   the designated container for svg object
   *
   * @constructor
   */
  var MemoryLinesDot = function(element, container) {
    this.$el = element;
    this.$container = container;
  }



  /**
   * Memory line dot methods.
   * @type {{setCanvas: Function, setPosition: Function, setOffsets: Function, setDotPosition: Function, drawDots: Function}}
   */
  MemoryLinesDot.prototype = {

    setDirection: function(direction) {
      this.direction = this.$el.data('dot-direction') || direction || 'forward';
      return this;
    },

    setOffset: function() {
      this.offset = {
        x: this.$el.data('dot-offset-x') || this.$container.data('dot-offset-x') || 0,
        y: this.$el.data('dot-offset-y') || this.$container.data('dot-offset-y') || 0
      }

      return this;
    },

    setLine: function() {
      this.line = {
        color: this.$el.data('line-color') || this.$container.data('line-color') || '#f0f0f0',
        width: this.$el.data('line-width') || this.$container.data('line-width') || 10,
        type: this.$el.data('line-type') || this.$container.data('line-type') || 'round',
        time: this.$el.data('line-time') || this.$container.data('line-time') || 600,
        animate: Boolean(this.$el.data('animation')) || Boolean(this.$container.data('animation')) || false,
        dash: this.$el.data('line-dash') || this.$container.data('line-dash') || 'line'
      }

      if (!this.line.animate) {
        this.line.time = 1;
      }

      return this;
    },

    setDot: function() {

      this.dot = {
        $el: this.$el,
        radius: this.$el.data('dot-radius') || this.$container.data('dot-radius') || 8,
        color: this.$el.data('dot-color') || this.$container.data('dot-color') || '#ff6c00',
        time: this.$el.data('dot-time') || this.$container.data('dot-time') || 100,
        animate: Boolean(this.$el.data('animation')) || Boolean(this.$container.data('animation')) || false
      }

      if (!this.dot.animate) {
        this.dot.time = 1;
      }

      this.dot.x = this.$el.offset().left - this.$container.offset().left + this.offset.x + this.dot.radius;
      this.dot.y = this.$el.offset().top - this.$container.offset().top + this.offset.y - this.dot.radius /2;

      this.checkBoundary();

      return this;
    },

    setDotMobile: function() {
      this.dot = {
        $el: this.$el,
        radius: this.$el.data('dot-radius') || this.$container.data('dot-radius') || 8,
        color: this.$el.data('dot-color') || this.$container.data('dot-color') || '#ff6c00',
        time: this.$el.data('dot-time') || this.$container.data('dot-time') || 100,
        animate: Boolean(this.$el.data('animation')) || Boolean(this.$container.data('animation')) || false
      }

      if (!this.dot.animate) {
        this.dot.time = 1;
      }

      this.dot.x = this.$el.offset().left - this.$container.offset().left - this.dot.radius;
      this.dot.y = this.$el.offset().top - this.$container.offset().top + this.dot.radius /2;
      this.offset.x = 0;
      this.offset.y = 0;
    },

    checkBoundary: function() {
      // consider as inner padding of canvas
      this.gap = 20;

      if (this.dot.x < this.dot.radius + this.gap) {
        this.dot.x = this.dot.radius + this.gap;
      }
      else if (this.dot.x > this.$container.innerWidth() + this.gap- this.dot.radius) {
        this.dot.x = this.$container.innerWidth() + this.gap - this.dot.radius;
      }

      if (this.dot.y < this.dot.radius + this.gap) {
        this.dot.y = this.dot.radius + this.gap;
      }
      else if (this.dot.y > this.$container.innerHeight() + this.gap - this.dot.radius) {
        this.dot.y = this.$container.innerHeight() - this.dot.radius + this.gap;
      }

      return this;
    },

    process: function() {
      this
        .setDirection()
        .setOffset()
        .setLine()
        .setDot();

      return this;
    }
  }


  /**
   * Object for grouping all the memory line child elements
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
  var MemoryLinesConnector = function(element, canvas, children) {
    this.$el = element;
    this.$canvas = canvas;
    this.$children = children;

    this.dots = {};

    this.line = {
      color: this.$el.data('line-color') || '#f0f0f0',
      width: this.$el.data('line-width') || 10,
      type: this.$el.data('line-type') || 'round',
      time: this.$el.data('dot-time') || 600,
      animate: Boolean(this.$el.data('animation')) || false
    }

    if (!this.line.animate) {
      this.time = 1;
    }

    this.offset = {
      x: this.$el.data('line-offset-x') || 0,
      y: this.$el.data('line-offset-y') || 2
    }

    this.strokeJoin = 'miter';
    this.strokeDash = false;

    this.svg = [];
    this.timer = 100;

    return this;
  }


  /**
   * Collection of object methods
   * @type {{setCanvas: Function, setSource: Function, setTarget: Function, addDot: Function, getDot: Function, checkHorizontal: Function, setRadius: Function, setDirection: Function, setArc: Function, clearCanvas: Function, drawLine: Function, drawCurve: Function, drawMode: Function, drawConnector: Function, drawObject: Function}}
   */
  MemoryLinesConnector.prototype = {

    setSource: function(dot) {
      this.source = dot;
      return this;
    },

    setTarget: function(dot) {
      this.target = dot;
      return this;
    },

    addDot: function(delta, dot) {
      this.dots[delta] = dot;
      return this;
    },

    getDot: function(delta) {
      return this.dots[delta] || false;
    },

    checkHorizontal: function() {

      // Only do horizontal mode if the target is aligned
      // horizontally with source and both width is equal
      // to canvas width
      if ((this.source.$el.outerWidth(true) == this.$el.innerWidth())
          && (this.target.$el.outerWidth(true) == this.$el.innerWidth())
          && this.source.dot.x == this.target.dot.x) {

        this.setDirection('horizontal')
      }

      // Target and source in the same y coordinates
      else if (this.source.dot.y == this.target.dot.y) {
        this.setDirection('horizontal');
      }

      if ($(window).width() < 768) {
        this.setDirection('horizontal');
      }

      return this;
    },

    setRadius: function(radius) {
      this.radius = radius || Math.abs((this.target.dot.y - this.source.dot.y) / 2);
      return this;
    },

    setDirection: function(direction) {
      this.direction = direction || this.source.direction;
      return this;
    },

    setArc: function() {

      this.setRadius();

      // This gap will act as inner canvas padding for preventing bleeding
      this.gap = 20;
      this.lineX = this.source.line.width || this.line.width;

      switch (this.direction) {

        // Arc to the right
        case 'forward' :
          this.maxSpaceX = this.$el.innerWidth() - (this.source.$el.innerWidth() + this.source.dot.x);

          // No room to make curve, throw straight line
          if (this.maxSpaceX < 0) {
            this.setRadius(0);
          }

          // Radius too big, reduce them
          else if (this.radius > this.maxSpaceX) {
            this.setRadius(this.maxSpaceX - this.gap - this.lineX);
          }

          // Start curve X point, always use the source
          this.radiusX =  this.source.dot.x + this.source.$el.innerWidth();

          // Edge case ending curve is larger than starting x
          if (this.radiusX < this.target.dot.x) {
            this.radiusX = this.target.dot.x;
          }

          // End curve X point, take it to the end of the canvas
          this.dotX = (this.radiusX + this.radius) - this.lineX - this.gap;

          // Edge case, ending curve X point is bleeding
          if (this.dotX > this.$el.outerWidth()) {
            this.dotX = this.$el.outerWidth() - this.lineX;
          }

          // Edge case, starting curve X is bleeding
          if (this.radiusX > this.$el.outerWidth()) {
            this.radiusX = this.$el.outerWidth() - this.lineX;
          }

          // Edge case startingX is less than endingX, draw no curve
          if (this.radiusX > this.dotX) {
            this.radiusX = this.dotX;
            this.setRadius(0);
          }

          break;

        // Arc to left
        case 'reverse' :

          // Start Curve X point, always use destination
          this.maxSpaceX = this.target.dot.x;
          this.radiusX =  this.target.dot.x;

          // Edge case, source X point is before the target X point use it instead.
          if (this.radiusX > this.source.dot.x) {
            this.maxSpaceX = this.source.dot.x;
            this.radiusX = this.source.dot.x;
          }

          // Edge case no space to draw curve, force straight line
          if (this.maxSpaceX < 0) {
            this.setRadius(0);
          }

          else if (this.radius > this.maxSpaceX) {
            this.setRadius(this.maxSpaceX - this.gap - this.lineX);
          }

          // End curve X point, take to the start of canvas
          this.dotX = (this.radiusX - this.radius) + this.gap + this.lineX;

          // Edge Case, ending X point is less than starting point
          if (this.dotX < this.lineX) {
            this.dotX = this.lineX;
          }

          // Edge Case, starting X point is less than starting point
          if (this.radiusX < this.lineX) {
            this.radiusX = this.lineX;
          }

          // Edge Case starting X is larger than ending X, draw no curve
          if (this.dotX > this.radiusX) {
            this.dotX = this.radiusX;
            this.setRadius(0);
          }

          break;
      }

      // Edge Case startingX is the same with ending X, give no radius
      if (this.radiusX == this.dotX) {
        this.setRadius(0);
      }

      // Edge Case minus radius
      if (this.radius < 0) {
        this.setRadius(this.radius * -1);
      }

      this.arc = {
        one: {
          initial: {
            x: this.radiusX,
            y: this.source.dot.y
          },
          control: {
            x: this.dotX,
            y: this.source.dot.y
          },
          end: {
            x: this.dotX,
            y: this.source.dot.y + this.radius
          },
          radius: this.radius
        },
        two: {
          initial: {
            x: this.dotX,
            y: this.target.dot.y - this.radius
          },
          control: {
            x: this.dotX,
            y: this.target.dot.y
          },
          end: {
            x: this.radiusX,
            y: this.target.dot.y
          },
          radius: this.radius
        },
        connector : {
          one: {
            start: {
              x: this.source.dot.x,
              y: this.source.dot.y
            },
            end: {
              x: this.radiusX,
              y: this.source.dot.y
            }
          },
          two: {
            start: {
              x: this.dotX,
              y: this.source.dot.y + this.radius
            },
            end: {
              x: this.dotX,
              y: this.target.dot.y - this.radius
            }
          },
          three: {
            start: {
              x: this.radiusX,
              y: this.target.dot.y
            },
            end: {
              x: this.target.dot.x,
              y: this.target.dot.y
            }
          },
        }
      }

      return this;
    },

    clearCanvas: function() {
      this.ctx || this.setCanvas();
      this.ctx.clearRect(0, 0, this.$canvas.width(), this.$canvas.height());
      return this;
    },

    polarToCartesian: function(centerX, centerY, radius, angleInDegrees) {
      var angleInRadians = (angleInDegrees-90) * Math.PI / 180.0;

      return {
        x: centerX + (radius * Math.cos(angleInRadians)),
        y: centerY + (radius * Math.sin(angleInRadians))
      };
    },

    describeArc: function(x, y, radius, startAngle, endAngle){

      var start = this.polarToCartesian(x, y, radius, endAngle);
      var end = this.polarToCartesian(x, y, radius, startAngle);

      var arcSweep = endAngle - startAngle <= 180 ? "0" : "1";

      var d = [
        "M", start.x, start.y,
        "A", radius, radius, 0, arcSweep, 0, end.x, end.y
      ].join(" ");

      return d;
    },

    detectStroke: function(line) {

      switch (line.type) {
        case 'round' :
          this.strokeJoin = 'round';
          break;
        case 'square' :
          this.strokeJoin = 'bevel';
          break;
        case 'butt' :
          this.strokeJoin = 'miter';
          break;
      }

      switch (line.dash) {
        case 'dotted' :
          this.strokeDash = line.width / 4 + ', ' + line.width * 2;
          break;

        case 'line' :
          this.strokeDash = false;
          break;

        case 'dashed' :
          this.strokeDash = line.width + ', ' + line.width * 2;
          break;
      }

    },

    drawDot: function(dot) {

      if (!dot.animate) {
        this.timer = 1;
        dot.$el.addClass('no-animation');
      }
      else {
        dot.$el.addClass('with-animation');
      }

      this.time = dot.time;
      this.svg.push({
        path: this.describeArc(dot.x, dot.y + dot.radius, dot.radius, 0, 360),
        strokeWidth: dot.radius * 2,
        strokeColor: dot.color,
        drawSequential: true,
        delay: this.timer,
        duration: this.time,
        group: 'dots',
        animate: 'opacity',
        drawOnScroll: dot.animate,
        dot: dot
      });

      this.timer = this.time;

      return this;
    },

    drawCurve: function(arc, line) {

      if (!line.animate) {
        this.timer = 1;
      }

      this.detectStroke(line);
      this.time = line.time;
      this.svg.push({
        path:  [
          'M' +
          arc.initial.x,
          arc.initial.y,
          'Q' +
          arc.control.x,
          arc.control.y,
          arc.end.x,
          arc.end.y
        ].join(' '),
        strokeColor: line.color,
        strokeWidth: line.width,
        strokeJoin: this.strokeJoin,
        strokeDash: this.strokeDash,
        strokeCap: line.type,
        drawSequential: true,
        delay: this.timer,
        duration: this.time,
        group: 'lines',
        drawOnScroll: line.animate
      });

      this.timer = this.time;

      return this;
    },

    drawLine: function(start, end, line) {

      if (!line.animate) {
        this.timer = 1;
      }

      this.time = line.time;
      if (start.x == end.x && start.y == end.y) {
        return this;
      }

      this.detectStroke(line);

      this.svg.push({
        path: [
          'M',
          start.x,
          start.y,
          end.x,
          end.y
        ].join(' '),
        strokeColor: line.color,
        strokeWidth: line.width,
        strokeJoin: this.strokeJoin,
        strokeDash: this.strokeDash,
        strokeCap: line.type,
        drawSequential: true,
        delay: this.timer,
        duration: this.time,
        group: 'lines',
        drawOnScroll: line.animate
      });

      this.timer = this.time;

      return this;
    },

    drawConnector: function() {
      this
        .setDirection()
        .checkHorizontal();

      switch(this.direction) {

        // Use simple line for horizontal mode only for simplicity sake
        case 'horizontal' :

          // Draw simple line from source to target
          this.drawLine(this.source.dot, this.target.dot, this.source.line || this.line);

          break;

        default:
          this
            .setArc()

            // Fill in the gap
            .drawLine(this.arc.connector.one.start, this.arc.connector.one.end, this.source.line || this.line)

            // Draw the top half of the arc from the source to half of the target
            .drawCurve(this.arc.one, this.source.line || this.line)

            // Fill in the gap
            .drawLine(this.arc.connector.two.start, this.arc.connector.two.end, this.source.line || this.line)

            // Draw the bottom half of the arc from the target to half of the source
            .drawCurve(this.arc.two, this.source.line || this.line)

            // Fill in the gap
            .drawLine(this.arc.connector.three.start, this.arc.connector.three.end, this.source.line || this.line);

          break;
      }
      return this;
    },

    drawObject: function() {
      var that = this, mode = 'normal';

      if ($(window).width() < 768) {
        mode = 'mobile';
      }

      this.$children.each(function(delta, element) {

        var Target = new MemoryLinesDot($(this), that.$el);
        var Source = that.getDot(delta - 1);

        Target.process();

        if (mode == 'mobile') {
          Target.setDotMobile();
        }

        // Draw single dot, the next dot is drawn on next loop
        that
          .addDot(delta, Target);

        if (!Source) {
          that.drawDot(Target.dot);
        }

        // Draw connector when we got 2 dot points
        Source && that.setSource(Source).setTarget(Target).drawConnector().drawDot(Target.dot);
      });

      this.$el.data('svg-path', this.svg);

      var options = {};

      options[this.$canvas.attr('id')] = {
        overrideKey: this.$canvas.attr('id'),
        paths: this.svg,
        dimensions: {
          width: this.$el.width(),
          height: this.$el.height()
        }
      }

      this.$canvas.lazylinepainter({
        svgData: options,
        onStrokeComplete: function(path) {
          that.pathDrawComplete(path);
        },
        groups: [
          {
            id: 'lines'
          },
          {
            id: 'dots'
          }
        ]
      });

      this.$canvas.lazylinepainter('paint');

      return this;

    },

    pathDrawComplete: function(path) {
      path.dot && path.dot.$el && path.dot.$el.addClass('animated');
    }

  }


  /**
   * jQuery method for calling the object
   * @param options
   * @returns {*}
   */
  $.fn.memoryLineConnect = function(options) {

    return this.each(function() {

      if ($(this).children('.lazylinepainter').length) {
        $(this).children('.lazylinepainter').lazylinepainter('destroy').remove();
      }

      var MemoryDate = new Date();
      var MemoryID = 'memory-line-' + MemoryDate.getTime();
      var Canvas = $('<div id="' + MemoryID + '"></div>');
      Canvas.prependTo($(this));

      var MemoryLineObject = new MemoryLinesConnector($(this), Canvas, $(this).find('.memoryline-content'));
      MemoryLineObject.drawObject();

      $(this).data('memory-line-object', MemoryLineObject);

    });
  };

  var MemoryHelper = {
    wwidth: $(window).width(),
    timer: false
  }

  if ($('#page').length && $('#page').hasClass('animsition')) {
    $(window)
      .on('animsitionPageIn.memoryline', function() {

        $('.memoryline-connector').memoryLineConnect();

        $(window)
          .on('sortupdate.memoryline', function() {
            $('.memoryline-connector').memoryLineConnect();
          })
          .on('resize.memoryline', function() {
            if (MemoryHelper.wwidth != $(window).width()) {
              clearTimeout(MemoryHelper.timer);
              MemoryHelper.timer = setTimeout(function() {
                $('.memoryline-connector').memoryLineConnect();

                MemoryHelper.wwidth = $(window).width();
              }, 50);
            }
          });

      });
  }
  else {
    $(window)
      .on('load.memoryline sortupdate.memoryline', function () {
        $('.memoryline-connector').memoryLineConnect();
      })
      .on('resize.memoryline', function() {
        if (MemoryHelper.wwidth != $(window).width()) {
          clearTimeout(MemoryHelper.timer);
          MemoryHelper.timer = setTimeout(function() {
            $('.memoryline-connector').memoryLineConnect();

            MemoryHelper.wwidth = $(window).width();
          }, 50);
        }
      });
  }

})(jQuery)
