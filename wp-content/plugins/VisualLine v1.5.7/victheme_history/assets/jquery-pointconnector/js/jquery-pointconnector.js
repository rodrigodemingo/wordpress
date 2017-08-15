/**
 * Simple script for building canvas point
 * arc connector between 2 points
 * 
 * markup :
 * 
 * container must have position relative rule
 * and css class : point-connector
 * source point must have css class : Points.$start
 * target point must have css class : Points.$end
 *
 * Improved to use multiple canvas for avoiding
 * canvas maximum size limit in browser
 *
 * @author jason.xie@victheme.com
 */
(function($) {

  $.fn.pointConnect = function() {

    return this.each(function() {

      var self = $(this),
          totalCanvas = Math.ceil(self.innerHeight() / 8000),
          Points = {
            $el: $(this),
            $items: $(this).find('.history-content'),
            point: {}
        };
      
      self.css('position', 'relative');
      
      Points.$items.each(function(key, element) {

        var mainCanvas = $('<canvas class="pointer-canvas" />'),
            line = $(this).data('linewidth') || Points.$el.data('linewidth') || 10;

        Points.$start = Points.$items.eq(key).find('.startpoint');
        Points.$end = Points.$items.eq(key + 1).find('.endpoint');

        // Skip if no valid Points.$end found.
        if (Points.$end.length == 0 || Points.$start.length == 0) {
          return true;
        }

        mainCanvas
          .attr('width', self.innerWidth())
          .attr('height', (Points.$end.offset().top - Points.$start.offset().top) + line * 10)
          .css({
            zIndex: 1,
            position: 'absolute',
            left:  0,
            top: Points.$start.offset().top - self.offset().top
          })
          .prependTo(self);

        Points.ctx = mainCanvas.get(0).getContext('2d');

        Points.$end.css({
          display: 'inline-block',
          height: '20px',
          width: '20px',
          margin: '0 30px'
        });

        $(this).css({
          zIndex: 2,
          position: 'relative'
        });

        Points.point[key] = {
          start: {
            x: Points.$start.offset().left - mainCanvas.offset().left,
            y: Points.$start.offset().top - mainCanvas.offset().top
          },
          end: {
            x: Points.$end.offset().left - mainCanvas.offset().left,
            y: Points.$end.offset().top - mainCanvas.offset().top
          },
          control: {
            x: 0,
            y: 0
          },
          curve: {
            x: $(this).data('curve-x') || Points.$el.data('curvex') || 0,
            y: $(this).data('curve-y') || Points.$el.data('curvey') || 100
          },
          offset: {
            start: {
              x: $(this).data('offset-start-x') || Points.$el.data('startx') || Points.$start.width() / 2,
              y: $(this).data('offset-start-y') || Points.$el.data('starty') || Points.$start.height() / 2
            },
            end: {
              x: $(this).data('offset-end-x') || Points.$el.data('endx') || Points.$end.width() / 2,
              y: $(this).data('offset-end-y') || Points.$el.data('endy') || Points.$end.height() / 2
            }
          },
          gradient: {
            one : $(this).data('gradientone') || Points.$el.data('gradientone') || '#ff6c00',
            two : $(this).data('gradienttwo') || Points.$el.data('gradienttwo') || '#1c2232'
          },
          line: {
            width: line,
            type: $(this).data('linetype') || Points.$el.data('linetype') || 'round'
          }
        };

        Points.point[key].start.x += Points.point[key].offset.start.x;
        Points.point[key].start.y += Points.point[key].offset.start.y;

        Points.point[key].end.x += Points.point[key].offset.end.x;
        Points.point[key].end.y += Points.point[key].offset.end.y;

        Points.point[key].control.x = Points.point[key].start.x + Points.point[key].curve.x;
        Points.point[key].control.y = Points.point[key].start.y + Points.point[key].curve.y;

        Points.ctx.beginPath();

        Points.ctx.moveTo(
          Points.point[key].start.x,
          Points.point[key].start.y
        );

        Points.ctx.quadraticCurveTo(
          Points.point[key].control.x,
          Points.point[key].control.y,
          Points.point[key].end.x,
          Points.point[key].end.y
        );

        Points.ctx.lineWidth = Points.point[key].line.width;

        // Dashed mode
        Points.ctx.lineCap = Points.point[key].line.type;
        Points.ctx.miterLimit = Points.point[key].width;

        if (typeof Points.ctx.setLineDash !== 'undefined' ) {
          Points.ctx.setLineDash([10,20]);
        }

        else if (typeof Points.ctx.mozDash !== 'undefined' ) {
          Points.ctx.mozDash = [10,20];
        }

        // Gradient
        Points.grd = Points.ctx.createLinearGradient(0, Points.point[key].start.x, mainCanvas.width(), Points.point[key].end.x);
        Points.grd.addColorStop(0, Points.point[key].gradient.one);
        Points.grd.addColorStop(0.2, Points.point[key].gradient.one);
        Points.grd.addColorStop(0.8, Points.point[key].gradient.two);
        Points.grd.addColorStop(1, Points.point[key].gradient.two);

        // line color
        Points.ctx.strokeStyle = Points.grd;
        Points.ctx.stroke();

        delete mainCanvas;
        mainCanvas = null;
      });

      // Destroy Points
      Points = null

      // Destroy references
      delete Points;
      
    }); 
  };

  var HistoryConnector = {
    wwidth: $(window).width(),
    timer: false
  }

  if ($('#page').length && $('#page').hasClass('animsition')) {
    $(window)
      .on('animsitionPageIn', function() {

        $('.pointer-canvas').remove();
        $('.point-connector').pointConnect();

        $(window)
          .on('sortupdate.pointer', function() {
            $('.pointer-canvas').remove();
            $('.point-connector').pointConnect();
          })
          .on('resize.pointer', function() {
            if (HistoryConnector.wwidth != $(window).width()) {
              clearTimeout(HistoryConnector.timer);
              HistoryConnector.timer = setTimeout(function() {
                $('.pointer-canvas').remove();
                $('.point-connector').pointConnect();

                HistoryConnector.wwidth = $(window).width();
              }, 50);
            }
          });

      });
  }
  else {
    $(window)
      .on('load.pointer sortupdate.pointer', function () {
        $('.pointer-canvas').remove();
        $('.point-connector').pointConnect();
      })
      .on('resize.pointer', function() {
        if (HistoryConnector.wwidth != $(window).width()) {
          clearTimeout(HistoryConnector.timer);
          HistoryConnector.timer = setTimeout(function() {
            $('.pointer-canvas').remove();
            $('.point-connector').pointConnect();

            HistoryConnector.wwidth = $(window).width();
          }, 50);
        }
      });
  }
  
  
})(jQuery);