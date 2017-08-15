/**
 * Simple script for creating table that can add rows
 * or remove rows quickly using javascript.
 * 
 * 
 * @requires Requires jQuery UI sortable to be loaded first
 * @triggers tablemanager-addrow 
 *           invoked when table manager is adding new row to the table
 *           
 *           tablemaanger-removerow
 *           invoked when table manager is removing row from table
 */
jQuery(document).ready(function($) {
  
    
  /**
   * Reorder and change the form element id
   */
  $.fn.VTCoreTableManagerReorder = function(Filter) {
    return this.children('tbody').children('tr').each(function() {
      
      if ($.isNumeric(Filter) == false) {
        Filter = 1;
      }
          
      var Index = $(this).index(),
          replacement = '[' + Index + ']';
      
      $(this).find('input, select, textarea').each(function() {
        
        // Crude fix to generate unique id without doing
        // fancy stuff such as ajax fetching, This is done this
        // way because the correct ID is generated via VTCore Html
        // elements which is expensive to build via ajax.
        if (typeof $(this).attr('id') != 'undefined') {
          $(this).attr('id', $(this).attr('id') + '-' + Index);
          $(this).parent().find('label').attr('for', $(this).attr('id') + '-' + Index);
        }
        
        if (typeof $(this).attr('name') != 'undefined') {
          var i = 0;  
          $(this).attr('name', $(this).attr('name').replace(/\[\d+\]/g,
              function(m) { return (Filter == (++i) ? replacement : m); }));
        }  
      });
    });
  }
  
  
  
  
  
  /**
   * Helper function for clearing form element values
   */
  $.fn.VTCoreTableManagerClearForm = function() {   

    return this
            .find('input:not([type="hidden"], [type="checkbox"], [type="radio"])').val('').attr('value', '').prop('value', '').trigger('change').end()
            .find('textarea').val('').empty().trigger('change').end()
            .find(':checkbox, :radio' ).removeAttr( 'checked', false ).trigger('change').end()
            .find('select > option').removeAttr('selected').trigger('change').end();
  }



  
  
  /**
   * Binding events to document
   */
  $(document)
    
    // Add new row events
    .off('click', '[data-tablemanager-type="addrow"]')
    .on('click', '[data-tablemanager-type="addrow"]', function() {
      var table = $(this).parent().find('table'),
          clone = table.find('tbody > tr').eq(0).clone(true, true),
          i = 0;
      
      clone.VTCoreTableManagerClearForm().appendTo(table.find('tbody'));      
      table.VTCoreTableManagerReorder(table.data('filter'));
      
      // Trigger global events for other plugin to pickup and do
      // their own cleaning process.
      $(document).trigger('tablemanager-addrow', clone);
    })
    
    
    
    // Remove row events
    .off('click', '[data-tablemanager-type="removerow"]')
    .on('click', '[data-tablemanager-type="removerow"]', function() {
      
      if ($(this).closest('tbody').find('tr').length == 1) {      
        $(this).closest('tbody').find('tr').VTCoreTableManagerClearForm();
        $(document).trigger('tablemanager-addrow');
      }
      else {
        var table = $(this).closest('table'), row = $(this).closest('tr');

        $(document).trigger('tablemanager-before-removerow', row);

        row.remove();
        table.VTCoreTableManagerReorder(table.data('filter'));
      }

      $(document).trigger('tablemanager-removerow');
      
    })
    
    
    
    
    // Ajax complete events
    .on('ajaxComplete', function() {
      // Bind sortable function
      $('.table-manager:not(table-processed)')
        .find('tbody')
        .sortable({
          handler: 'clone',
          items: '> tr',
          axis: 'y',
          update: function(event, ui) {
            var Item = $(ui.item);
            if (Item.is('tr')) {
              Item.closest('table').VTCoreTableManagerReorder(Item.closest('table').data('filter'));
            }
          },
          cursor: 'move',
          placeholder: 'tablemanager-placeholder-helper',
      })
      .addClass('table-processed');

    });

 
  
    
    
  /**
   * Build sortable function
   */
  $('.table-manager')
    .find('tbody')
    .sortable({
      handler: 'clone',
      items: '> tr',
      axis: 'y',
      /**
       * This is broken as of Wordpress 4.2.2 !
      start: function(event, ui) {
        var yOffset = 21,
        xOffset = 150;
  
        // Force ui helper to use mouse position
        $(document).mousemove(function(e) {
          $(ui.helper).offset({top: e.pageY - yOffset , left: e.pageX - xOffset});
        });

      },
     **/
      update: function(event, ui) {
        var Item = $(ui.item);
        if (Item.is('tr')) {
          Item.closest('table').VTCoreTableManagerReorder(Item.closest('table').data('filter'));
        }
      },
      cursor: 'move',
      placeholder: 'tablemanager-placeholder-helper',
  })
  .addClass('table-processed');

  
 
});