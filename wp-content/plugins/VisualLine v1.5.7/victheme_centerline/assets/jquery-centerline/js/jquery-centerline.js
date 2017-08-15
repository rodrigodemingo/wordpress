/**
 * Simple script for building canvas point
 * arc connector between 2 points
 * 
 * markup :
 * 
 * container must have position relative rule
 * and css class : point-connector
 * source point must have css class : startpoint
 * target point must have css class : endpoint
 * 
 * 
 * @todo : Break free from css classes and make this
 *         as fully working jQuery plugin
 *         
 * @author jason.xie@victheme.com
 */
(function($) {

  var CenterPoints = function(element, canvas, active) {
    this.$el = element;
    this.$active = active;
    this.$canvas = canvas;
    return this;
  }

  CenterPoints.prototype = {

    /** Not working yet! **/
    fitBoundaryX: function(value, offset) {
      if (value < offset) {
        return offset;
      }

      if (value > Points.wrappoint.width - offset) {
        return Points.wrappoint.width - offset;
      }

      return value;
    },

    /** Not working yet **/
    fitBoundaryY: function(value, offset) {
      if (value < offset) {
        return offset;
      }

      if (value > Points.wrappoint.height - offset) {
        return Points.wrappoint.height - offset;
      }

      return value;
    },

    /**
     * Building canvas element
     */
    setCanvas: function() {
      this.ctx = this.$canvas.get(0).getContext('2d');
      return this;
    },


    setCircles: function() {
      this.circles = {
        startradius: this.$active.data('circle-start') || this.$el.data('circle-start') || 3,
        endradius: this.$active.data('circle-end') ||  this.$el.data('circle-end') || 4,
        opaqueradius: this.$active.data('circle-opaque') || this.$el.data('circle-opaque') || 10,
        opacity: this.$active.data('circle-opacity') || this.$el.data('circle-opacity') || 0.6
      }

      return this;
    },

    setLine: function() {
      this.line = {
        color: this.$active.data('line-color') || this.$el.data('line-color') || '#158FBF',
        dot: this.$active.data('dot-color') || this.$el.data('dot-color') || '#158FBF',
        width: this.$active.data('line-width') || this.$el.data('line-width') || 1,
        type: this.$active.data('line-type') || this.$el.data('line-type') || 'round'
      }

      return this;
    },

    setPosition: function() {
      this.position = {
        start: this.$active.data('position-start') || 'center',
        end: this.$active.data('position-end') || 'top'
      }

      return this;
    },

    setControlPoint: function() {
      var offsetX = this.$active.data('offset-control-x') || 0,
          offsetY = this.$active.data('offset-control-y') || 100;

      this.control = {
        x: this.start.x + offsetX,
        y: this.start.y + offsetY
      }

      return this;
    },

    setStartPoint: function() {

      // Search for the centering element
      this.$center = this.$el.find('.centerline-image');

      var offsetX = this.$active.data('offset-start-x') || 0,
        offsetY = this.$active.data('offset-start-y') || 0,
        radius = (this.$active.data('circle-opaque') || this.circles.opaqueradius || 0) / 2;

      switch (this.position.start) {
        case 'top' :
          this.start = {
            x: this.$center.offset().left - this.$el.offset().left + this.$center.outerWidth(false) / 2 + offsetX + radius,
            y: this.$center.offset().top - this.$el.offset().top + offsetY + radius
          }
          break;

        case 'left':
          this.start = {
            x: this.$center.offset().left - this.$el.offset().left + offsetX + radius,
            y: this.$center.offset().top - this.$el.offset().top + this.$center.outerHeight(false) / 2 + offsetY + radius
          }

          break;

        case 'bottom' :
          this.start = {
            x: this.$center.offset().left - this.$el.offset().left + this.$center.outerWidth(false) / 2 + offsetX + radius,
            y: this.$center.offset().top - this.$el.offset().top + this.$center.outerHeight(false) + offsetY + radius
          }
          break;
        case 'right' :
          this.start = {
            x: this.$center.offset().left - this.$el.offset().left + this.$center.outerWidth(false) + offsetX + radius,
            y: this.$center.offset().top - this.$el.offset().top + this.$center.outerHeight(false) / 2 + offsetY + radius
          }

          break;
        case 'center' :
          this.start = {
            x: this.$center.offset().left - this.$el.offset().left + this.$center.outerWidth(false) / 2 + offsetX + radius,
            y: this.$center.offset().top - this.$el.offset().top + this.$center.outerHeight(false) / 2 + offsetY + radius
          }

          break;
      }

      return this;

    },

    setEndPoint: function() {

      var offsetX = this.$active.data('offset-end-x') || 0,
        offsetY = this.$active.data('offset-end-y') || 0,
        radius = (this.$active.data('circle-end') || this.circles.endradius || 0) / 2;

      switch (this.position.end) {
        case 'top' :
          this.end = {
            x: this.$active.offset().left - this.$canvas.offset().left + (this.$active.outerWidth(false) / 2) + offsetX + radius,
            y: this.$active.offset().top - this.$canvas.offset().top + offsetY + radius
          }

          break;

        case 'left' :
          this.end = {
            x: this.$active.offset().left - this.$el.offset().left + offsetX + radius,
            y: this.$active.offset().top - this.$el.offset().top + (this.$active.outerHeight(false) / 2) + offsetY + radius
          }
          break;

        case 'right' :
          this.end = {
            x: this.$active.offset().left - this.$el.offset().left  + this.$active.outerWidth(false) + offsetX + radius,
            y: this.$active.offset().top - this.$el.offset().top + (this.$active.outerHeight(false) / 2) + offsetY + radius
          }
          break;

        case 'bottom' :
          this.end = {
            x: this.$active.offset().left - this.$el.offset().left + (this.$active.outerWidth(false) / 2) + offsetX + radius,
            y: this.$active.offset().top - this.$el.offset().top + this.$active.outerHeight(false) + offsetY + radius
          }
          break;
      }

      return this;

    },

    drawLine: function(start, end, control, line) {

      this.ctx.beginPath();
      this.ctx.moveTo(start.x, start.y);
      this.ctx.quadraticCurveTo(control.x, control.y, end.x, end.y);
      this.ctx.lineWidth = line.width;
      this.ctx.lineCap = line.height;
      this.ctx.miterLimit = line.width;
      this.ctx.strokeStyle = line.color;
      this.ctx.stroke();

      return this;
    },

    drawCircle: function(position, radius, color, opacity) {

      this.ctx.beginPath();
      if (opacity != false) {
        this.ctx.globalAlpha = opacity;
      }

      this.ctx.arc(position.x, position.y, radius, 0, 2 * Math.PI, false);
      this.ctx.fillStyle = color;
      this.ctx.fill();

      if (opacity != false) {
        this.ctx.globalAlpha = 1;
      }

      return this;
    },

    clearCanvas: function() {
      this.ctx.clearRect(0, 0, this.$canvas.width(), this.$canvas.height());
      return this;
    },

    setObject: function() {
      this
        .setCanvas()
        .setCircles()
        .setLine()
        .setPosition();

      return this;
    },
    
    drawObject: function() {
      this
        .setStartPoint()
        .setEndPoint()
        .setControlPoint()
        .drawLine(this.start, this.end, this.control, this.line)
        .drawCircle(this.start, this.circles.opaqueradius, this.line.dot, this.circles.opacity)
        .drawCircle(this.start, this.circles.startradius, this.line.dot, false)
        .drawCircle(this.end, this.circles.endradius, this.line.dot, false);

      return this;
    }

  };


  /**
   * Initializing the center line connect
   * @returns {*}
   */
  $.fn.centerLineConnect = function() {

    return this.each(function() {

      var Container = $(this),
          Canvas = $('<canvas class="centerline-canvas" />');

      if (Container.find('.centerline-image').length == 0
          || Container.find('.centerline-content').length == 0) {
        return true;
      }

      Container.css('position', 'relative').prepend(Canvas);

      Canvas
        .attr('width', Container.width())
        .attr('height', Container.height())
        .css({
          position: 'absolute',
          zIndex: 1,
          left:  0,
          top: 0
        });


      Container.find('.centerline-content').css('z-index', 10).each(function(delta, element) {
        var Pointer = new CenterPoints(Container, Canvas, $(this), delta);

        Pointer.setObject().drawObject();

        // Store Pointer
        $(this).attr('data-pointer-object', true);
        $(this).data('pointer-object', Pointer);
      });
    }); 
  };

  var CenterLineHelper = {
    wwidth: $(window).width(),
    timer: false
  }


  if ($('#page').length && $('#page').hasClass('animsition')) {
    $(window)
      .on('animsitionPageIn.centerline', function() {

        $('.centerline-canvas').remove();
        $('.centerline-connector').centerLineConnect();

        $(window)
          .on('sortupdate.centerline', function() {
            $('.centerline-canvas').remove();
            $('.centerline-connector').centerLineConnect();
          })
          .on('resize.centerline', function() {
            if (CenterLineHelper.wwidth != $(window).width()) {
              clearTimeout(CenterLineHelper.timer);
              CenterLineHelper.timer = setTimeout(function() {
                $('.centerline-canvas').remove();
                $('.centerline-connector').centerLineConnect();

                CenterLineHelper.wwidth = $(window).width();
              }, 50);
            }
          });

      });
  }
  else {
    $(window)
      .on('load.centerline sortupdate.centerline', function () {
        $('.centerline-canvas').remove();
        $('.centerline-connector').centerLineConnect();
      })
      .on('resize.centerline', function() {
        if (CenterLineHelper.wwidth != $(window).width()) {
          clearTimeout(CenterLineHelper.timer);
          CenterLineHelper.timer = setTimeout(function() {
            $('.centerline-canvas').remove();
            $('.centerline-connector').centerLineConnect();

            CenterLineHelper.wwidth = $(window).width();
          }, 50);
        }
      });
  }

})(window.jQuery);