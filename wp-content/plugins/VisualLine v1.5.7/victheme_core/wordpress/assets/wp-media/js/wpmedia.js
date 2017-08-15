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

  /**
   * Function for opening the WordPress Native Media Uploader
   * 
   * @note This function has to be called from parent element (.form-wpmedia)
   */
  $.fn.VTCoreWPMediaUpload = function() {

    wp.media.frames.elementSource = $(this);
    
    file_frame = wp.media.frames.file_frame = wp.media({
      type: wp.media.frames.elementSource.attr('data-media-type'),
      library: {
        type: wp.media.frames.elementSource.attr('data-media-type'),
      },
      title: wp.media.frames.elementSource.attr('data-media-title'),
      button: {
        text: wp.media.frames.elementSource.attr('data-media-button'),
      },
      multiple: false //wp.media.frames.elementSource.attr('data-media-multiple'),
    });


    wp.Uploader.defaults.filters.mime_types[0].extensions = window.VT.pluploadDefaults;
    var types = wp.media.frames.elementSource.attr('data-media-type'), extensions = [];

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

    setTimeout(function() {
      file_frame.open();
    }, 10);
    
    /**
     * Binding on select event to the file frame select button
     */
    file_frame
    .off('select')
    .on('select', function() {
      if (typeof file_frame.state().get('selection').first() != 'undefined') {
        attachment = file_frame.state().get('selection').first().toJSON();  
        wp.media.frames.elementSource
          .find('[data-media-type="storage"]')
          .attr('data-media-url', attachment.url)
          .attr('data-media-filename', attachment.filename)
          .attr('data-media-filetype', wp.media.frames.elementSource.attr('data-media-type'))
          .val(attachment.id)
          .trigger('change');
      }
    });
    
    return this;
  } 
  
  
  
  /**
   * Function for toggling the uploader visibility state
   * 
   * @note This function has to be called from parent element (.form-wpmedia)
   */
  $.fn.VTCoreWPMediaToggleUploader = function() {
    
    var self = $(this),
        toggle = self.find('[data-media-type="storage"]').data('media-url');

    if (typeof toggle == 'undefined') {
      self.find('[data-media-type="add"]').removeClass('hidden');
      self.find('[data-media-type="remove"]').addClass('hidden');
    }
    else {
      self.find('[data-media-type="remove"]').removeClass('hidden');
      self.find('[data-media-type="add"]').addClass('hidden');
    }
    
    return this;
    
  };
  
  
  /**
   * Function for building the preview element
   *
   * @note This function has to be called from parent element (.form-wpmedia)
   */
  $.fn.VTCoreWPMediaPreview = function() {
    
    var self = $(this), mediaUrl = self.find('[data-media-type="storage"]').attr('data-media-url');

    switch (self.find('[data-media-type="storage"]').data('media-filetype')) {
      case 'image' :
        if (mediaUrl && mediaUrl != 'undefined') {
          self.find('[data-media-type="preview"]').removeClass('wpmedia-preview-empty').html(
            '<img src="' + mediaUrl + '" />'
          );
        }
        else {
          self.find('[data-media-type="preview"]').addClass('wpmedia-preview-empty').empty();
        }
        
      break;
      
      case 'video' :
        if (mediaUrl && mediaUrl != 'undefined') {
          var id = 'video-element-' + self.find('[data-media-type="storage"]').attr('id');

          // Video is expensive to build and can cause memory leaks
          // Only rebuild if source change
          if (self.find('[data-media-type="preview"]').find('#' + id).length == 0
            || self.find('[data-media-type="preview"]').find('#' + id).attr('src') != mediaUrl) {

            // Break memory leaks
            self.find('[data-media-type="preview"]').removeClass('wpmedia-preview-empty').find('video').each(function () {
              this.pause();
              delete(this);
              $(this).remove();
            });

            self.find('[data-media-type="preview"]').removeClass('wpmedia-preview-empty').html(
              '<video id="' + id + '" preload="metadata" controls src="' + mediaUrl + '" />'
            );

            // Build the poster image
            var video = document.getElementById(id);
            video.addEventListener("loadeddata", function () {

              var canvas = document.createElement('canvas');

              canvas.width = video.videoWidth;
              canvas.height = video.videoHeight;

              var ctx = canvas.getContext('2d');
              ctx.drawImage(video, 0, 0);

              var image = new Image();
              image.onload = function () {
                self.find('[data-media-type="preview"]').append(
                  // VTCore will pick this up in hook action
                  '<input type="hidden" name="vtcore-wp-media-video-poster[' + self.find('[data-media-type="storage"]').val() + ']" value="' + canvas.toDataURL('image/png') + '" />'
                );
              }
              image.src = canvas.toDataURL('image/png');

            });
          }
        }
        else {
          self.find('[data-media-type="preview"]').addClass('wpmedia-preview-empty').empty();
        }
      break;
      
      case 'audio' :
        if (mediaUrl && mediaUrl != 'undefined') {
          self.find('[data-media-type="preview"]').removeClass('wpmedia-preview-empty').html(
            '<audio preload="none" controls src="' + mediaUrl + '" />'
          );
        }
        else {
          self.find('[data-media-type="preview"]').addClass('wpmedia-preview-empty').empty();
        }
        
      break;

      default :
        self.find('[data-media-type="preview"]').removeClass('wpmedia-preview-empty').html(
          '<p class="text-left">' + self.find('[data-media-type="storage"]').attr('data-media-filename') + '</p>'
        );
        break;
    }
      
    if (self.find('[data-media-type="storage"]').val() == '') {
      self.find('[data-media-type="preview"]').addClass('wpmedia-preview-empty').html('');
    }
    
    
    return this;
    
  }
  
  
  
  /**
   * Function for reseting the media
   *
   * @note This function has to be called from parent element (.form-wpmedia)
   */  
  $.fn.VTCoreWPMediaReset = function() {

    $(this).find('[data-media-type="storage"]')
      .removeAttr('data-media-url')
      .removeData('media-url')
      .removeAttr('data-media-filename')
      .removeData('media-filename')
      .removeAttr('data-media-filetype')
      .removeData('media-filetype')
      .val('')
      .trigger('change');

    return this;
  }
  
  
	/**
	 * Binding remove event
	 */
	$(document)
	
	  .on('ready ajaxComplete', function() {

        // Auto booting using relaxed initialization by queuing the init method
        var objectQueue = $({});
        $('[data-media-type="storage"]').each(function() {
          var self = $(this);

          objectQueue.queue('wp-media', function(next) {
            setTimeout(function() {
              self.trigger('change');
              next();
            }, 100);
          });

        });

        // Process the queued item
        objectQueue.dequeue('wp-media');
	    
	  })
	  
	  .off('change', '[data-media-type="storage"]')
	  .on('change', '[data-media-type="storage"]', function() {
	     $(this)
	       .closest('.form-wpmedia')
	       .VTCoreWPMediaToggleUploader()
	       .VTCoreWPMediaPreview();    
	  })
	  
	  // Need to rebind the form change event to tablemanager add new row
	  // @bugfix This is a bugfix for the wpmedia element still use the 
	  // first row value on add new row.
	  .on('tablemanager-addrow', function(event, object) {
	    var target = $(object);
	    
	    // Reset the cloned object.
	    target.find('.form-wpmedia').VTCoreWPMediaReset();
	    
	    // Rebind the change event.
	    target.find('[data-media-type="storage"]')
        .on('change', function() {
          $(this).closest('.form-wpmedia')
                 .VTCoreWPMediaToggleUploader()
                 .VTCoreWPMediaPreview();    
          
        })
        .trigger('change');
	  })
	  
	  .off('click', '[data-media-type="remove"]')
	  .on('click', '[data-media-type="remove"]', function() {
	
	    $(this).closest('.form-wpmedia').VTCoreWPMediaReset();
	    
	  })
	  
	  .off('click', '[data-media-type="add"]')
	  .on('click', '[data-media-type="add"]', function() {
        $(this).closest('.form-wpmedia').VTCoreWPMediaUpload();
      });
});