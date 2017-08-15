/*!
 Plugin:  jquery-parallax
 Version  1.1
 Author:  Víctor 'vxc' Ortega
 URL: 	 http://www.vxc.es/
 GitHub:  https://github.com/vxc-/jquery-parallax

 Customized version, don't update !
 2014, Licensed under the MIT and GPL licenses.
 */

(function ($) {

  var $window = $(window);
  var $windowHeight, $windowWidth;

  var Parallax = {

    //Object vars
    defaults: {},

    element: null,

    bgXunit: 'px',

    bgXvalue: 0,

    bgYunit: 'px',

    bgYvalue: 0,

    elementTop: 0,

    proxyTransition: function () {
    },

    __init: function (element, options) {

      var $this = this;

      $this.element = $(element);

      $this.$id = $this.element.attr('class');

      //Set options
      $this.setConfig(options);

      $this.render();
    },

    setConfig: function (options) {

      var $this = this;

      $this.defaults = $.extend({}, $.fn.parallax.DEFAULTS, options);

      $this.dispatchTransitionType();

      $this.parseBGPosition();

      var transition = $this.defaults.transitionType;

      //Tuning speed for % positioned images TODO: Rework all this
      if ((transition == 'vertical' && $this.bgYunit == '%' ) || (transition == 'horizontal' && $this.bgXunit == '%' )) {
        $this.defaults.speed = $this.defaults.speed / 4;
      }

    },

    dispatchTransitionType: function () {

      var $this = this;

      switch ($this.defaults.transitionType) {
        case 'vertical':
          $this.proxyTransition = $.proxy($this.renderVertical, $this);
          break;
        case 'horizontal':
          $this.proxyTransition = $.proxy($this.renderHorizontal, $this);
          break;
        case 'diagonal':
          $this.proxyTransition = $.proxy($this.renderDiagonal, $this);
          break;
      }

    },

    getHeight: function () {

      var element = this.element;
      var defaults = this.defaults;

      if (defaults.outerHeight) {
        return element.outerHeight(true);
      }
      else {
        return element.height();
      }

    },

    parseBGSize: function () {

      var IEtranslations = {
        top: {x: '50%', y: '0px'},
        bottom: {x: '50%', y: '100%'}
      };

      var $this = this;

      var pattern = new RegExp(/[-+]?\d*\.?\d*/);

      var BGPosArr = $this.element.css('background-size').split(" ");

      //IExplorer possible clase
      if (BGPosArr.length == 1) {
        //Matching key in translation object
        if (BGPosArr[0] in IEtranslations) {
          var matchKey = BGPosArr[0];
          var match = IEtranslations[matchKey];
          BGPosArr[0] = match.x;
          BGPosArr[1] = match.y;
          //If it doesn't match is always 50%
        }
        else {
          BGPosArr[1] = '50%';
        }
      }

      $this.bgXunit = BGPosArr[0].replace(pattern, '');
      $this.bgYunit = BGPosArr[1].replace(pattern, '');

      $this.bgXvalue = parseFloat(BGPosArr[0].replace($this.bgXunit, ''));
      $this.bgYvalue = parseFloat(BGPosArr[1].replace($this.bgYunit, ''));


      if ($this.bgXvalue == 0) {
        $this.bgXunit = 'px';
      }

      if ($this.bgYvalue == 0) {
        $this.bgYunit = 'px';
      }

    },
    parseBGPosition: function () {

      var IEtranslations = {
        top: {x: '50%', y: '0px'},
        bottom: {x: '50%', y: '100%'}
      };

      var $this = this;

      var pattern = new RegExp(/[-+]?\d*\.?\d*/);

      var BGPosArr = $this.element.css('background-position').split(" ");

      //IExplorer possible clase
      if (BGPosArr.length == 1) {
        //Matching key in translation object
        if (BGPosArr[0] in IEtranslations) {
          var matchKey = BGPosArr[0];
          var match = IEtranslations[matchKey];
          BGPosArr[0] = match.x;
          BGPosArr[1] = match.y;
          //If it doesn't match is always 50%
        }
        else {
          BGPosArr[1] = '50%';
        }
      }

      $this.bgXunit = BGPosArr[0].replace(pattern, '');
      $this.bgYunit = BGPosArr[1].replace(pattern, '');

      $this.bgXvalue = parseFloat(BGPosArr[0].replace($this.bgXunit, ''));
      $this.bgYvalue = parseFloat(BGPosArr[1].replace($this.bgYunit, ''));


      if ($this.bgXvalue == 0) {
        $this.bgXunit = 'px';
      }

      if ($this.bgYvalue == 0) {
        $this.bgYunit = 'px';
      }

    },
    imageSize: function(w, h) {
      this.img = {
        width: w,
        height: h
      }
      return this;
    },

    getViewport: function() {
      var newWindow = $(window);
      if (!this.$window || this.$window.width() != newWindow.width()) {
        this.$window = newWindow;

        this.viewport = {
          width: this.$window.width(),
          height: this.$window.height(),
          top: 0,
          bottom: this.$window.height() - this.element.height(),
          left: 0,
          right: this.$window.width() - this.element.width()
        }
      }

      if (this.img) {
        this.viewport.bottom = this.$window.height() - this.img.height;
        this.viewport.right = this.$window.width() - this.img.width;
      }
    },

    inViewport: function(orientation) {

      this.getViewport();

      this.bounding = this.element[0].getBoundingClientRect();
      this.offset = 0;
      switch (orientation) {
        case 'vertical' :

          if (this.viewport.top > this.bounding.top) {
            return 'up';
          }

          if (this.bounding.bottom > this.viewport.height) {
            return 'down';
          }
          break;

        case 'horizontal' :
          if ((this.viewport.left > this.bounding.top) || (this.bounding.left > this.viewport.right)) {
            return false;
          }
          break;
      }

      return 'inside';

    },

    renderVertical: function (currentPos) {

      var $this = this,
        yPos = ($this.bgYvalue + Math.round((currentPos - $this.elementTop) * $this.defaults.speed)),
        minPos = 0,
        maxPos = 100,
        inViewPort = this.inViewport('vertical');

      if ($this.bgYunit == 'px') {
        if (inViewPort === 'inside') {
          maxPos = Math.abs(parseFloat($this.element.data('img-height')) - parseFloat($this.element.data('frame-height')));
          minPos = -Math.abs(parseFloat($this.element.data('img-height')) - parseFloat($this.element.data('frame-height')));
        }
      }

      switch (inViewPort) {
        case 'inside' :
          if (yPos < minPos) {
            yPos = minPos;
          }

          if (yPos > maxPos) {
            yPos = maxPos;
          }
          break;

        case 'up' :
          yPos = Math.abs(this.bounding.top  * $this.defaults.speed);
          break;

        case 'down' :
          var zero = this.viewport.height - this.element.data('frame-height');
          yPos = - Math.abs(yPos + zero * this.defaults.speed);
          break;

      }

      $this.element.css('background-position',
        $this.bgXvalue + $this.bgXunit + ' ' + yPos + $this.bgYunit);
    },

    renderHorizontal: function (currentPos) {

      var $this = this,
        xPos = ($this.bgXvalue + Math.round((currentPos - $this.elementTop) * $this.defaults.speed)),
        minPos = 0,
        maxPos = 100;

      if (!this.inViewport('horizontal')) {
        if (xPos < minPos) {
          xPos = minPos;
        }

        if (xPos > maxPos) {
          xPos = maxPos;
        }
      }


      $this.element.css('background-position',
        xPos + $this.bgXunit + ' ' + $this.bgYvalue + $this.bgYunit);
    },

    renderDiagonal: function (currentPos) {

      var $this = this;

      var movCalc = Math.round((currentPos - $this.elementTop) * $this.defaults.speed);

      this.element.css('background-position',
        (($this.bgXvalue + movCalc ) + $this.bgXunit) + " " + (($this.bgYvalue + movCalc ) + $this.bgYunit));

    },

    render: function () {

      var $this = this;
      var currentPos = $window.scrollTop();
      $this.elementTop = $this.element.offset().top;
      var elementHeight = $this.getHeight();

      //Return if we are not within viewport
      if ($this.elementTop + elementHeight < currentPos || $this.elementTop > currentPos + $windowHeight) {
        return;
      }

      $this.proxyTransition(currentPos);

    }

  };

  //Global Scope Listener
  $windowHeight = $window.height();

  //Constructor definition
  if (typeof Object.create !== "function") {
    Object.create = function (obj) {
      function Fun() {
      };
      Fun.prototype = obj;
      return new Fun();
    };
  }

  $.fn.parallax = function (options) {
    return this.each(function () {
      var parallax = $(this).data('Parallax') || Object.create(Parallax);
      parallax.__init(this, options);
      $(this).data('Parallax', parallax);
    });

  };


  $.fn.parallax.DEFAULTS = {
    speed: 0.5,
    outerHeight: true,
    transitionType: 'vertical'
  };

  var ParallaxObjects = {
    init: function() {

      $('.parallax-vertical:not(.parallax)').parallax({
        speed: 0.8,
        transitionType: 'vertical'
      }).addClass('parallax');

      $('.parallax-horizontal:not(.parallax)').parallax({
        speed: 0.8,
        transitionType: 'horizontal'
      }).addClass('parallax');

      $('.parallax-diagonal:not(.parallax)').parallax({
        speed: 0.8,
        transitionType: 'diagonal'
      }).addClass('parallax');

      this.$el = $('.parallax');

      if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
        this.mobile = true;
      }

      return this;
    },
    checkImage: function() {

      this.img = new Image();
      this.img.src = this.$current.css('background-image').replace(/"/g, "").replace(/url\(|\)$/ig, "");
      this.img;
      this.img.ratio = this.img.width / this.img.height;

      return this;
    },
    stretchImage: function() {

      if (!this.mobile) {
        this.$current.css('background-size', '');
        this.checkImage();

        this.frame = {
          width: this.$current.outerWidth(),
          height: this.$current.outerHeight()
        }

        this.newsize = {
          width: this.frame.width,
          height: this.frame.width / this.img.ratio
        };

        // Image is shorter than the viewport
        if (this.newsize.height < this.frame.height) {
          this.newsize.height = this.frame.height;
          this.newsize.width = this.newsize.height * this.img.ratio;
        }

        this.$current
          .css('background-size', this.newsize.width + 'px ' + this.newsize.height + 'px')
          .data('max-scroll-width', this.newsize.width - this.frame.width)
          .data('max-scroll-height', this.newsize.height - this.frame.height)
          .data('frame-width', this.frame.width)
          .data('frame-height', this.frame.height)
          .data('img-width', this.newsize.width)
          .data('img-height', this.newsize.height);
      }

      if (this.mobile) {
        this.$current.css('background-size', 'cover').css('background-position', '0 0');
      }
      return this;
    },
    resizeImage: function() {
      var that = this;
      this.$el.each(function(key, val) {
        that.$current = $(this);
        that.stretchImage();
      });
      return this;
    },
    reposition: function() {
      // Don't scroll on mobile devices, it just wont work!
      if (this.mobile) {
        return this;
      }
      var that = this;
      this.$el.each(function(key, val) {
        if (that.newsize) {
          $(this).data('Parallax').imageSize(that.newsize.width, that.newsize.height);
        }
        $(this).data('Parallax').render(that.newsize);
      });
      return this;
    }
  }

  ParallaxObjects.init();
  ResizeTimer = false;


  $(window)

    .off('scroll.parallax')
    .on('scroll.parallax', function() {

      // VC needs to be refreshed this way!
      window.vc_iframe && ParallaxObjects && ParallaxObjects.init();

      ParallaxObjects && ParallaxObjects.reposition();
    })

    .off('resize.parallax')
    .on('resize.parallax', function() {
      if ($windowWidth != $(this).width() || $windowHeight != $(this).height()) {
        ParallaxObjects && ParallaxObjects.resizeImage().reposition();
        $windowHeight = $(this).height();
        $windowWidth = $(this).width();
      }
    })
    .on('pageready.parallax', function() {
      ParallaxObjects && ParallaxObjects.init().resizeImage().reposition();
    })
    .on('load.parallax', function() {
      ParallaxObjects && ParallaxObjects.init().resizeImage().reposition();
    });

  $(document)
    .on('ajaxComplete.parallax', function () {
      ParallaxObjects && ParallaxObjects.init().resizeImage();
    });

})(window.jQuery);
