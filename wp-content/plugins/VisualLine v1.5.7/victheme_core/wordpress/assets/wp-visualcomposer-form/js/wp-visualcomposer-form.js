/**
 * Javascript for initializing VTCore custom
 * form element when loaded inside the VC
 * form popup.
 *
 * @see VTCore_Wordpress_Factory_VC
 * @author jason.xie@victheme.com
 */
(function ($) {

  if ($('[data-query-editor]').length == 0
      && $('[data-iconset-editor]').length == 0
      && $('[data-icon-editor]').length == 0) {

    return;
  }

  var VTFormQuery = Backbone.View.extend({
    initialize: function () {
      this.$form = this.$el.find('[data-query-editor]');
      this.$storage = this.$el.find('[data-query-value]');
    },
    render: function () {
      // Updating value is done via PHP!
      return this;
    },
    save: function () {
      var value = _.escape(this.$form.serialize());
      this.$storage.val(value);
      return value;
    }
  });

  /**
   * Add new param to atts types list for vc
   */
  vc.atts.vt_query_form = {
    init: function(param, $field) {
      var $container = $field.find('[data-query-value]');
      $container.data('vtQueryForm',  new VTFormQuery({ el : $field }).render());
    },
    parse: function (param) {

      var $field = this.content().find('[data-query-value]'),
          vt_query_form = $field.data('vtQueryForm'),
          result = vt_query_form.save();

      return result;
    }
  };



  var VTFormIcon = Backbone.View.extend({
    initialize: function () {
      this.$form = this.$el.find('[data-iconset-editor]');
      this.$storage = this.$el.find('[data-iconset-value]');
    },
    render: function () {
      // Updating value is done via PHP!
      return this;
    },
    loadIcon: function() {

      // Only concern this on frontpage edit
      if (typeof vc.frame_window != 'undefined') {
        var picker = this.$form.find('.form-icons-iconpicker'),
          assets = picker.data('asset'),
          family = picker.data('family');

        // Load icon asset
        assets && $.each(assets, function(key, asset) {
          var icon = {
            family: family,
            css: asset.url || false
          }

          vc.frame_window.vc_iframe.loadIconAssets(icon);
        });
      }

      return this;
    },
    save: function () {
      var value = _.escape(this.$form.serialize());

      // Update storage value
      this.$storage.val(value);
      this.loadIcon();

      return value;
    }
  });


  /**
   * Add new param to atts types iconset for vc
   */
  vc.atts.vt_iconset_form = vc.atts.vt_icon_form = {
    init: function(param, $field) {
      var $container = $field.find('[data-iconset-value]');
      $container.data('vtIconForm',  new VTFormIcon({ el : $field }).render());

    },
    parse: function (param) {

      var $field = this.content().find('[data-iconset-value]'),
        vt_icon_form = $field.data('vtIconForm'),
        result = vt_icon_form.save();

      return result;
    }
  };


})(window.jQuery);