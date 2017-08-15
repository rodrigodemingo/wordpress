/**
 * Generic javascript for processing json returned
 * by VTCore Elements. This class must be used in
 * conjunction with VTCore_Ajax API Rules.
 * 
 * Element that will invoke the ajax calls must have
 * .btn-ajax class and place all the data to be 
 * passed into PHP via HTML data-* attributes.
 * 
 * required data :
 * 
 *    ajax-mode : post | data | both | trigger | value
 *                post    - this mode will retrieve the parent element (must be a form) post data, serialized
 *                          serialized it and convert into an url parameters
 *                data    - this mode will just retrieve the element html5 data-* attributes, serialized it and
 *                          convert it into url parameters
 *                both    - this mode will retrieve both parent element post and element data attributes,
 *                          merged them, serialized it and convert to url parameters.
 *                trigger - this mode will retrieve the data-ajax-trigger on selected target
 *                value   - this mode will retrieve the value of the selected target using jQuery .val() method.
 *
 *    ajax-target : CSS selector - recommended to use id such as '#someid', this is the target parent
 *                  used to determine the target point for fetching post or modifying the content
 *
 *    ajax-loading-text : string - this string will be shown in the button or input submit element when
 *                                 an ajax event is processing
 *
 *    ajax-object : valid PHP object name - this object will be invoked when an ajax request is made, it must
 *                                          be a valid php object that also been registered via autoloader
 *                                          the script will not attempt to look for the class file, it will
 *                                          just initializes the class.
 *
 *    ajax-action : the nonce key - by default it will use 'vtcore-ajax-framework' unless you have change
 *                                  the default nonce key, no need to change this.
 *
 *    ajax-value : the custom value that you can pass from ajax to processor, this is usefull to mark a button
 *                 like the triggering element name
 *
 *    ajax-queue : array and optional - you can use queueing system to queue the ajax process and pass the value
 *                 name to act as triggering marker one by one in the array. The array will be converted into
 *                 a json object via VTCore_Html base data-* processor.
 *                 
 *    ajax-group : group of button that will be disabled during ajax queue process
 *
 *    ajax-retry : number of times to requeue the current queue if it failed (default is 0)
 *                 
 *                 
 *  @author jason.xie@victheme.com
 */


(function($) {
  
  var requests = [];
  
  /**
   * Fix for serialized array ignoring
   * disabled element
   */
  var proxy = $.fn.serializeArray;
  $.fn.serializeArray = function(){
      var inputs = this.find(':disabled');
      inputs.prop('disabled', false);
      var serialized = proxy.apply( this, arguments );
      inputs.prop('disabled', true);
      return serialized;
  };
  
  /**
   * Ajax queue manager
   */
  var ajaxManager = {
     addReq:  function(opt) {
       requests.push(opt);
     },
     removeReq:  function(opt) {
       if ( $.inArray(opt, requests) > -1 ) {
         requests.splice($.inArray(opt, requests), 1);
       }
     },
     run: function(callback) {

       var self = this;

       // Got queue
       if ( requests.length ) {

         $.ajax(requests[0])

           // Move to next queue
           .done(function(msg) {
             requests.shift();
             self.run.call(self, callback);
           })

           // Attempt to retry if configured to do so
           .fail(function( jqXHR, textStatus ) {

             requests[0].retry--;
             if (requests[0].retry <= 0) {
               requests.shift();
             }
             self.run.call(self, callback);
           });

       } 

       // Finished queue
       else {
         self.tid = setTimeout(function() {
            
           self.run.call(self, callback);
            
            if (callback && typeof callback == 'function') {
              callback();
            }
            
            self.stop();
            
         }, 1000);
         
       }
     },
     stop:  function() {
         requests = [];
         clearTimeout(this.tid);
     }
   };
 
  
  
	/**
	 * Function for translating the VTCore_Ajax Server side api into 
	 * javascript sets of commands.
	 */
	$.fn.VTCoreProcessAjaxResponse = function(response) {
    var data = response.split('<---JSON-STARTS---->'),
		response = [];  
    
    if (data[0] != ' ') {
    	response.error = '<div clas="alert alert-danger">' + data[0] + '</div>';
    }
    
    response.content = $.parseJSON(data[1]);
    
    return response;	
	};
	
	
	
	
	/**
	 * Processing the returned ajax data
	 * 
	 * User can define this variables in the json data returned :
	 * content 				 = array of contents
	 * 		action			 = array All the actions that will be processed
	 * 			mode			 = string error|replace|append|prepend|delete	
	 * 			target		 = string the target css id or class to perform the action mode
	 * 
	 */
	$.fn.VTCoreProcessAjaxReturn = function(response, status) {
	  
	  if (typeof response.content == 'undefined' || response.content == null) {
	    return false;
	  }
	  
      if (typeof response.content.errortarget != 'undefined'
              && typeof response.error != 'undefined') {
        $(response.content.errortarget).prepend(response.error);
      }
		
      $.each(response.content.action, function(key, data) {

        switch (data.mode) {
          case 'error' :
            $(data.target).append(data.content);
            $(document).trigger('wpajax:error', $(data.target), data);
          break;

          case 'replace' :
            $(data.target).replaceWith(data.content);
            $(document).trigger('wpajax:replace', $(data.target), data);
          break;

          case 'html' :
            $(data.target).html(data.content);
            $(document).trigger('wpajax:html', $(data.target), data);
          break;

          case 'append' :
            $(data.target).append(data.content);
            $(document).trigger('wpajax:append', $(data.target), data);
          break;

          case 'prepend' :
            $(data.target).prepend(data.content);
            $(document).trigger('wpajax:prepend', $(data.target), data);
          break;

          case 'delete' :
            $(data.target).remove();
            $(document).trigger('wpajax:error', $(data.target), data);
          break;

          case 'empty' :
            $(data.target).empty();
            $(document).trigger('wpajax:empty', $(data.target), data);
          break;

          case 'text' :
            $(data.target).html(data.content);
            $(document).trigger('wpajax:text', $(data.target), data);
          break;

          case 'callback' :
            (new Function(data.content))();
            $(document).trigger('wpajax:callback', data);
          break;

          case 'data' :
            if (data.merge) {
              data.content = $.extend($(data.target).data(data.key), data.content);
            }
            $(data.target).data(data.key, data.content);
            $(document).trigger('wpajax:data', $(data.target), data);
          break;

          case 'addClass' :
            $(data.target).addClass(data.content);
            $(document).trigger('wpajax:addclass', $(data.target), data);
          break;

          case 'removeClass' :
            $(data.target).removeClass(data.content);
            $(document).trigger('wpajax:removeclass', $(data.target), data);
          break;

          case 'openlock' :
            $(data.target).data('ajax-stop', false);
            break;

          case 'stylesheet' :
            $.each(data.content, function(key, value) {
              value.id
              && value.src
              && !$(data.target).find('#' + value.id).length
              && $(data.target).append('<link type="text/css" rel="stylesheet" id="' + value.id + '" href="' + value.src + '" />');
            });
            $(document).trigger('wpajax:stylesheet', data);
            break;
        }
      });
	}
	
	
	$.fn.VTCoreInvokeAjax = function(e) {
	  
    // Prevents submission or link default event
    e.preventDefault();
    
    // Allow other plugin to stop the ajax via
    // data-ajax-stop="true"
    if ($(this).data('ajax-stop') == true) {
      return false;
    }

    // All the data parameter must be attached as HTML5 data
    // so it can be passed on to the PHP server side script.
    var ajaxMode = $(this).data('ajax-mode'),
        btn = $(this),
        text = (btn.is('input')) ? btn.val() : btn.html(),
        target = $(btn.data('ajax-target')),
        replacement = btn.data('ajax-loading-text'),
        queue = btn.data('ajax-queue'),
        retry = btn.data('ajax-retry') || 0,
        marker = btn.data('ajax-marker'),
        ajaxData = {
          data   : '',
          nonce  : btn.data('nonce') || '',
          action : btn.data('ajax-action') || 'vtcore_ajax_framework',            
          object : btn.data('ajax-object'),
          value  : btn.data('ajax-value'),
          target : btn.data('ajax-target'),
          elval  : btn.val()
        };

      $.extend(marker, {target: btn.data('ajax-target')});
        
    // Processing if element is a select element
    if (btn.is('select')) {
      
      // Break ajax if user set the selected options to not do ajax
      if (btn.find('option[value="' + btn.val() + '"]').data('ajax-stop') == true) {
        return false;
      }
      
      btn.addClass('disabled').attr('disabled', true);
    }
    
    // Disabling button to prevent double posting
    if (btn.is('button')) {
      btn.html(btn.data('ajax-loading-text')).addClass('disabled').attr('disabled', true);
      ajaxData.nonce = btn.data('nonce');
    }
    
    if (btn.is('input')) {
      btn.val(btn.data('ajax-loading-text')).addClass('disabled').attr('disabled', true);
      ajaxData.nonce = btn.closest('form').find('[name="_nonce"]').val();
      if (!ajaxData.nonce &&  btn.data('nonce')) {
        ajaxData.nonce = btn.data('nonce');
      }
    }
    
    if (btn.is('a')) {
      btn.html(btn.data('ajax-loading-text')).addClass('disabled').attr('disabled', true);
      ajaxData.nonce = btn.data('nonce');
    }
    
    if (btn.data('ajax-group')) {
      $('[data-ajax-group="' + btn.data('ajax-group') + '"]').addClass('disabled').attr('disabled', true);
    }
    
    btn.addClass('ajax-processing');
    
    
    // Retrieve data
    if (typeof target != 'undefined' && typeof ajaxMode != 'undefined') {
      switch (ajaxMode) {
        case 'data' :
          ajaxData.data = $.param(target.data(), true);
          break;
          
        case 'post' :
          ajaxData.data = $.param(target.serializeArray(), true);
          break;
          
        case 'both' :
          ajaxData.data = $.param($.extend(target.serialize(), target.data()), true);
          break;
          
        case 'trigger' :
          ajaxData.data = btn.data('ajax-trigger');
          break;
          
        case 'value' :
          ajaxData.data = target.val();
          break;
        
        case 'selfData' :
          ajaxData.data = $.param(btn.data(), true);
          break;
      }
    }

    // Queueing ajax request
    for (var i=0; i < queue.length; i++) {
      
      // @bugfix value never changes bug
      var data = $.extend({}, ajaxData);
      data.queue = queue[i];

      // @bugfix at front no ajax url defined
      if (typeof wpajax != 'undefined'
          && typeof wpajax.ajaxurl != 'undefined') {
        window.ajaxurl = wpajax.ajaxurl;
      }

      // Invoke AJAX request
      ajaxManager.addReq({
        cache : false,
        type : 'POST',
        url : window.ajaxurl,
        data : data,
        marker : marker,
        retry : retry,
        async : false,
        dataFilter : function(response) {
          
          // Processing the json data
          // PHP must return the data as the VTCore_Ajax API requires.
          return $(this).VTCoreProcessAjaxResponse(response);
        },
        success : function(response, status) {
          
          // Assigning the processed content to the appropriate location
          // PHP must return the data as the VTCore_Ajax API requires.
          $(this).VTCoreProcessAjaxReturn(response, status);
        }
      });   
    };
    
    // Processing queued requests
    ajaxManager.run(function() {               
      // Enabling the button again
      if (btn.is('button')) {
        btn.html(text).removeClass('disabled').removeAttr('disabled');
      }
      
      if (btn.is('input')) {
        btn.val(text).removeClass('disabled').removeAttr('disabled');
      }
      
      if (btn.is('a')) {
        btn.html(text).removeClass('disabled').removeAttr('disabled');
      }
      
      if (btn.data('ajax-group')) {
        $('[data-ajax-group="' + btn.data('ajax-group') + '"]').removeClass('disabled').removeAttr('disabled');
      }
      
      if (btn.is('select')) {
        btn.removeClass('disabled').removeAttr('disabled');
      }
      
    });
	}


	/**
	 * Bind the button click event.
     *
     * Defer the trigger so other plugin can break infinite looping
     * with ajax-stop.
	 */
	$(document)

      .on('click.btn-ajax', '.btn-ajax', function(e) {
        $(this).VTCoreInvokeAjax(e);
      })

      .on('change.btn-ajax', '.btn-ajax-change', function(e) {
        $(this).VTCoreInvokeAjax(e);
      })

      .on('doajax', '.btn-ajax-content', function(e) {
        $(this).VTCoreInvokeAjax(e);
      })

      .on('doajax_defer', '.btn-ajax-content', function(e) {
        var self = $(this);
        setTimeout(function() {
          self.VTCoreInvokeAjax(e);
        }, 1);
      })
      ;

})(jQuery);