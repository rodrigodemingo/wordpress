/**
 * jQuery script for form element media type
 * 
 * @note Don't change the ready function header, it won't work
 * in wordpress admin form
 */
jQuery(document).ready(function($) {


  if (!window.VT) {
    window.VT = {};
  }

  if (!window.VT.pluploadDefaults) {
    window.VT.pluploadDefaults = wp.Uploader.defaults.filters.mime_types[0].extensions;
  }

  VT.MultipleUploader = function(element) {

    var that = this;

    this.$el = element;

    this.template = '<tr>' + this.$el.find('[data-wp-multiple-uploader="template"]').html().replace(/(\r\n|\n|\r)/gm, "") + '</tr>';
    this.$el.find('[data-wp-multiple-uploader="template"]').remove();
    this.defaultExtensions = window.VT.pluploadDefaults;
    this.table = this.$el.find('tbody');
    this.frame = wp.media({
      type: this.$el.attr('data-media-type'),
      library: {
        type: this.$el.attr('data-media-type'),
      },
      title: this.$el.attr('data-media-title'),
      button: {
        text: this.$el.attr('data-media-button'),
      },
      multiple: true
    });

    this.frame
      .off('select')
      .on('select', function() {
        if (typeof that.frame.state().get('selection').first() != 'undefined') {
          that.attachment = that.frame.state().get('selection').toJSON();
          that.add();
          that.revertExtensions();
        }
      });

    this.sortable();
  }

  VT.MultipleUploader.prototype = {
    sortable: function() {
      this
        .table
        .sortable({
          handler: 'clone',
          items: '> tr',
          axis: 'y',
          cursor: 'move',
          placeholder: 'wp-multiple-uploader-placeholder-helper',
        });
    },
    setExtensions: function() {
      var types = this.$el.attr('data-media-type'), extensions = [];

      if (types.indexOf('image') > - 1) {
        extensions.push('jpg,png,gif,tiff,jpeg,bmp');
      }

      if (types.indexOf('video') > - 1) {
        extensions.push('webm,flv,vob,ogv,ogg,avi,mov,wmv,rmvb,mp4,mpeg,mpg,m4v,m2v,flv,3gp');
      }

      if (types.indexOf('audio') > - 1) {
        extensions.push('mp3,wma,aac,ogg,flac,alac,aiff,wav');
      }

      if (types.indexOf('filtered#') > - 1 && wp.media.frames.elementSource.attr('data-media-filter')) {
        extensions.push(wp.media.frames.elementSource.attr('data-media-filter'));
      }

      if (extensions.length != 0) {
        wp.Uploader.defaults.filters.mime_types[0].extensions = extensions.join(',');
      }

      return this;
    },
    revertExtensions: function() {
      wp.Uploader.defaults.filters.mime_types[0].extensions = this.defaultExtensions;
      return this;
    },
    open: function() {
      this.setExtensions();
      this.frame.open();
      return this;
    },
    add: function() {
      if (!this.attachment) {
        return this;
      }

      var that = this;

      $.each(this.attachment, function(key, attachment) {

        var row = $(that.template);

        row
          .removeAttr('data-wp-multiple-uploader');

        row
          .find('[data-media-type="storage"]')
          .attr('data-media-url', attachment.url)
          .attr('data-media-filename', attachment.filename)
          .attr('data-media-filetype', attachment.type)
          .attr('name', that.$el.attr('data-media-name'))
          .attr('value', attachment.id)
          .removeAttr('id');


        that
          .table
          .append(row);

        row
          .find('[data-media-type="storage"]').trigger('change');

        row.find('.wp-multiplemedia-type').text(attachment.type);
        row.find('.wp-multiplemedia-filename').text(attachment.filename);
        row.find('.wp-multiplemedia-url').text(attachment.url);

        delete(row);

      });

      this.attachment = false;
    },
    remove: function($button) {
      $button.closest('tr').remove();
    },
  }

  
  
  /**
   * Binding remove event
   */
  $(document)

    .on('ready.wp-multiple-uploader ajaxComplete.wp-multiple-uploader', function() {

      // Auto booting using relaxed initialization by queuing the init method
      var objectQueue = $({});
      $('.form-wpmultiplemedia:not(.initialized)').each(function() {
        var self = $(this);
        objectQueue.queue('wp-multiplemedia', function(next) {
          setTimeout(function() {
            self.data('multiple-uploader', new VT.MultipleUploader(self)).addClass('initialized');
            next();
          }, 100);
        });

      });

      // Process the queued item
      objectQueue.dequeue('wp-multiplemedia');

    })

    .off('click.wp-multiple-uploader', '[data-wp-multiple-uploader="remove"]')
    .on('click.wp-multiple-uploader', '[data-wp-multiple-uploader="remove"]', function() {
      $(this).closest('.form-wpmultiplemedia').data('multiple-uploader').remove($(this));
    })

    .off('click.wp-multiple-uploader', '[data-wp-multiple-uploader="add"]')
    .on('click.wp-multiple-uploader', '[data-wp-multiple-uploader="add"]', function() {
      $(this).closest('.form-wpmultiplemedia').data('multiple-uploader').open();
    });
});