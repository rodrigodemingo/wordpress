/**
 * jQuery Icon Picker plugin
 * Creating icon picker smartly, can be used with various
 * kind of icon library.
 * 
 * Markup required :
 * 
 * <div data-element="i|span|or else" 
 *      data-base="fa|glyphicon| or else"
 *      data-prefix="fa-|glyphicon-|or else"
 *      class="form-icons-iconpicker">
 * <select class="form-icon-picker">
 *  <options value="icon name without prefix">Icon nice name</options>
 * </select>
 * </div>
 * 
 * - Support ajax fetched content via generic ajaxComplete generic event
 * - Autoloaded for all select element with class form-icon-picker
 * - Caveats : the navigator icon still depends on fontawesome.
 * - Support old vtcore table manager js, this will be removed later!.
 *
 * @author jason.xie@victheme.com
 * @todo clean up the functions and remove dependencies on classes. instead use data-x to autoload.
 * @todo remove dependencies to fontawesome and use image instead.
 * @todo add options variable.
 */
jQuery(document).ready(function($) {

  /**
   * Main function for building the simple icon picker
   */
  $.fn.iconPickerNG = function() {
    
    return this.each(function() {
      
      // Build Icon selector
      var Selector = $(this),
          parent = Selector.parent(),
          IconMarkup = [],
          i = 0,
          x = 0,
          limit = parent.data('limit') || 25,
          tag = parent.data('element') || 'i',
          base = parent.data('base') || '',
          prefix = parent.data('prefix') || '',
          iconValue = Selector.val();
      
      IconMarkup[i++] = '<div class="iconpicker-main-wrapper">' +
                        '<div class="iconpicker-previewer"><div class="iconpicker-icon-preview">' +
                        '<' + tag + ' class="' + base + ' ' + prefix + '0"/></div><i class="fa fa-caret-down"/></div>' +
                        '<div class="iconpicker-popover iconpicker-wrapper">' + 
                        '<div class="iconpicker-topnavbar"><i class="iconpicker-prev fa fa-arrow-left"/><i class="iconpicker-next fa fa-arrow-right"/></div>' +
                        '<div class="iconpicker-content">';
      
      Selector.children().each(function() {
        x++;
        
        if (x == 1) {
          IconMarkup[i++] = '<div class="iconpicker-pager">';
        }

        IconMarkup[i++] = '<' + tag + ' class="iconpicker-icons ' + base + ' ' + prefix + $(this).val() + '" data-icon="' + $(this).val() + '"/>';
        
        if (x == limit) {
          IconMarkup[i++] = '</div>';
          x = 0;
        }
      });
      
      IconMarkup[i++] = '</div></div></div>';
      
      IconMarkup = IconMarkup.join('');
        
      $(IconMarkup).insertAfter(Selector);
      
      Selector.hide().addClass('iconpicker-processed').parent().find('.iconpicker-icon-preview > ' + tag).attr('class', base + ' ' + prefix + iconValue);
      Selector.parent().find('.iconpicker-content .' + iconValue).addClass('active-icon');
      
    });
  };
  
  
  // Bind all the events to document
  $(document)
    
    // Click on any element to close selector
    .on('click', 'html', function() {
      $('.iconpicker-previewer').next().hide();
    })
    
    // Open the icon picker
    .off('click', '.iconpicker-previewer')
    .on('click', '.iconpicker-previewer', function(e) {
      e.stopPropagation();
      
      var target = $(this).next();
      $('.iconpicker-wrapper').not(target).hide();
      target.toggle('slow');
    })
    
    // Next page
    .off('click', '.iconpicker-next')
    .on('click', '.iconpicker-next', function(e) {
      
      e.stopPropagation();
      
      var self = $(this),
          visible = self.parent().next().find('.iconpicker-pager:visible');
      
      if (visible.next().length != 0) {
        visible.hide().next().fadeIn();
      }
      else {
        e.preventDefault();
      }
    })
    
    // Previous page
    .off('click', '.iconpicker-prev')
    .on('click', '.iconpicker-prev', function(e) {
      
      e.stopPropagation();
      
      var self = $(this),
          visible = self.parent().next().find('.iconpicker-pager:visible');
      
      if (visible.prev().length != 0) {
        visible.hide().prev().fadeIn();
      }
      else {
        e.preventDefault();
      }
    })
    
    // Acts on user selecting icon
    .off('click', '.iconpicker-pager > .iconpicker-icons')
    .on('click', '.iconpicker-pager > .iconpicker-icons', function(e) {
      
      e.stopPropagation();
      
      var self = $(this),
          parent = self.closest('.form-icons-iconpicker');
      
      // Update active class
      parent.find('.active-icon').removeClass('active-icon');
      self.addClass('active-icon');
      
      // Update Select element
      parent.find('.form-icon-picker').val(self.data('icon')).trigger('change');
      
      // Update previewer
      parent
        .find('.iconpicker-icon-preview')
        .find(parent.data('element'))
        .attr('class', parent.data('base') + ' ' + parent.data('prefix') + self.data('icon'));      
    })
 

    // Clean on table manager add new row event
    .on('tablemanager-addrow', function(events, clone) {

      var parent = $(clone).find('.form-icons-iconpicker');
      
      parent
        .find('.iconpicker-icon-preview')
        .find(parent.data('element'))
        .removeAttr('class');
      
    }) 

    // Acts on if form is fetched via ajax
    .on('ajaxComplete', function() {
      $('.form-icon-picker:not(.iconpicker-processed)').iconPickerNG();
    })
    
    // WP post page need ready events
    .on('ready', function() {
      $('.form-icon-picker:not(.iconpicker-processed)').iconPickerNG();
    });
  
  
  // Auto invoke and build the selector
  $('.form-icon-picker:not(.iconpicker-processed)').iconPickerNG();
  
});
