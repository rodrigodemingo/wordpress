/**
 *
 * Triggering Script for triggering
 * custom vc_ready event when visualcomposer
 * is ready.
 *
 * @author jason.xie@victheme.com
 */
(function ($) {

  /**
   * VC Iframe Probably is ready at this time
   * using timer will cause the event to be
   * invoked AFTER the vc.build();
   * @see vc_page_editable.js
   */
  if (typeof window.vc_iframe != 'undefined') {


    /**
     * Helper function for acting like PHP strpos
     * @param haystack
     * @param needle
     * @param offset
     * @returns {boolean}
     */
    vc_iframe.strpos = function (haystack, needle, offset) {
      var i = (haystack + '').indexOf(needle, (offset || 0));
      return i === -1 ? false : i;
    }


    /**
     * Extract bootstrap grid classes
     * @param cssClass
     * @returns {string}
     */
    vc_iframe.extractBootstrapClasses = function (cssClass) {

      var arrayClass = [], that = this, classTarget = 'col-';

      if (cssClass.indexOf('vc_col-') !== -1) {
        classTarget = 'vc_col-';
      }

      $.each(cssClass.split(' '), function (key, value) {
        if (that.strpos(value, classTarget) !== false) {
          arrayClass.push(value);
        }
      });

      return arrayClass.join(' ');
    }



    /**
     * Hijack the original setSortable to piggy back
     * custom function and adding trigger so other
     * plugin can hijack into this function easily.
     *
     * @type {Function|vc_iframe.setSortable}
     */
    vc_iframe.setSortableExtended = function(app) {
      this.setSortable(app);
      this.setGridSortable();
      $(window).trigger('vc_sortable_callback', this);
    }


    /**
     * Custom sortable modification for grid system
     * This is based on bootstrap grid and all plugin
     * that wishes to use this method must add vtcore-grid-container
     * class and provide the data-connect-with in the sortable main wrapper.
     */
    vc_iframe.setGridSortable = function () {
      var that = this;

      $('.vtcore-grid-container.ui-sortable:not(.processed)')
        .each(function () {
          var dataConnect = $(this).data('connect-with') || '.vtcore-grid-container',
              self = $(this);

          if (!self.hasClass('processed')) {

            if (dataConnect != '.vc_element-container') {
              self.removeClass('vc_element-container');
            }

            self
              .addClass('processed')
              .sortable('option', 'connectWith', dataConnect)
              .off('sort.vtcore_grid sortupdate.vtcore_grid')
              .on('sort.vtcore_grid', function (event, ui) {
                var bsClass = that.extractBootstrapClasses(ui.item.attr('class'));

                if (bsClass.length || self.data('grid-override')) {
                  ui.placeholder
                    .attr('style', 'width:' + ui.item.width() + 'px !important')
                    .css('float', 'left')
                    .addClass(bsClass);
                }

                ui.placeholder
                  .height(ui.item.height());

              });

            // Integration with isotope
            if (self.hasClass('js-isotope')) {
              self
                .on('sortupdate.vtcore_grid', function (event, ui) {
                  var IsoElement = ui.item.closest('.js-isotope');

                  if (IsoElement.length) {
                    if (!IsoElement.eq(0).data('isotope')
                      && IsoElement.eq(0).data('isotope-options')) {
                      IsoElement.eq(0).isotope(IsoElement.eq(0).data('isotope-options'));
                    }

                    if (IsoElement.eq(0).data('isotope')) {
                      IsoElement.eq(0).isotope('reloadItems');
                      IsoElement.eq(0).isotope({sortBy: 'original-order'});
                    }
                  }
                  that.stopSorting();
                });
            }
          }
        });
    }


    /**
     * Load Google fonts by injecting new link
     * markup into head element
     *
     * fonts param must contain :
     * fonts.family = Valid google font family, this method will not check or sanitize
     * fonts.weight = the valid font weight as defined by the fonts.family
     * fonts.style = the valid font style as defined by the fonts.family
     *
     * @param fonts
     * @returns {boolean}
     */
    vc_iframe.loadGoogleFonts = function(fonts) {

      if (typeof fonts.family == 'undefined'
        || fonts.family == false
        || fonts.family == '') {

        return false;
      }

      var font = fonts.family;

      if (typeof fonts.weight != 'undefined'
        && fonts.weight != false
        && fonts.weight != '') {

        font += ':' + fonts.weight;
      }

      if (typeof fonts.style != 'undefined'
        && fonts.style != false
        && fonts.style != '') {

        font += fonts.style;
      }

      if (!this.fonts) {
        this.fonts = {};
      }


      if (typeof this.fonts[font] == 'undefined') {
        this.fonts[font] = fonts;
        $('<link media="all" type="text/css" href="http://fonts.googleapis.com/css?family=' + font + '&subset=latin,cyrillic-ext,cyrillic,greek-ext,greek,vietnamese,latin-ext" rel="stylesheet"/>')
          .prependTo('head');
      }

    };


    /**
     * Load Icon asset and place them in the frame document head.
     *
     * Valid icons params must have :
     * icons.family : the icon family
     * icons.css : the css file url to load the asset from
     *
     * @param icons
     */
    vc_iframe.loadIconAssets = function(icons) {

      if (typeof icons.family == 'undefined' || typeof icons.css == 'undefined') {
        return false;
      }

      // Storage to track and record all loaded icons for preventing double asset loading
      if (!this.icons) {
        this.icons = {};
      }

      if (typeof this.icons[icons.family] == 'undefined') {
        this.icons[icons.family] = icons;
        $('<link type="text/css" rel="stylesheet" href="' + icons.css + '" />').prependTo('head');
      }
    }


    /**
     * Trigger custom event marking the vc_frame is ready
     * and before the vc is build.
     */
    $(window).trigger('vc_frame_ready');

  }

})(window.jQuery);