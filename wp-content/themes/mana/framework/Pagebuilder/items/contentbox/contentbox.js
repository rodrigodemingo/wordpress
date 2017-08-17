

function get_blox_element_contentbox($content, $attrs){
	$tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-times action_remove"></a> \
				</div>';
	return '<div class="blox_item blox_contentbox" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> <i class="icon-mail-forward"></i> Content Box: <span class="blox_callout_title"></span>'+$tools+'</div> \
				<div class="blox_item_content">'+($content!=undefined ? $content : '')+'</div> \
			</div>';
}


function parse_shortcode_contentbox($content){
	$content = wp.shortcode.replace( 'blox_contentbox', $content, function(data){
		var attrs = '';
		jQuery.each(data.attrs.named, function(key, value){
			if( value!=undefined && value!='undefined' && value!='' ){
				if( key=='title' ){
					attrs += 'title="'+value+'" ';
				}
                if( key=='widget_title' ){
					attrs += 'widget_title="'+value+'" ';
				}
				if( key=='color' ){
					attrs += 'color="'+value+'" ';
				}
				if( key=='style' ){
					attrs += 'box_style="'+value+'" ';
				}
				if( key=='icon' ){
					attrs += 'icon="'+value+'" ';
				}
				if( key=='animation' ){
					attrs += 'animation="'+value+'" ';
				}
				if( key=='extra_class' ){
					attrs += 'extra_class="'+value+'" ';
				}
			}
		})
		return get_blox_element_contentbox(data.content, attrs);
	});
	return $content;
}


function revert_shortcode_contentbox($content){
	$content.find('.blox_contentbox').each(function(){
		attr = '';
		var temp_val = '';
        
		temp_val = jQuery(this).attr('title')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' title="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('color')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' color="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('box_style')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' style="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('icon')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' icon="'+temp_val+'"';
		}
		
		temp_val = jQuery(this).attr('widget_title')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' widget_title="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('animation')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' animation="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('extra_class')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' extra_class="'+temp_val+'"';
		}
		
		jQuery(this).replaceWith('[blox_contentbox'+attr+']'+jQuery(this).find('> .blox_item_content').html()+'[/blox_contentbox]');
	});
	
	return $content;
}


function add_event_blox_element_contentbox(){
	
	jQuery('.blox_contentbox').each(function(){
		var $this = jQuery(this);
		
		$this.find('.blox_item_actions .action_edit').unbind('click')
			.click(function(){

				var form_element = [
	        			{
	        				type: 'input',
	        				id: 'blox_el_option_wtitle',
	        				label: 'Element Title',
	        				value: $this.attr('title')
	        			},
	        			{
	        				type: 'input',
	        				id: 'blox_el_option_title',
	        				label: 'Box Title',
	        				value: $this.attr('title')
	        			},
	        			{
	        				type: 'editor',
	        				id: 'blox_option_editor',
	        				label: 'Content',
	        				value: $this.find('.blox_item_content').html()
	        			},
	        			{
	        				type: 'select',
	        				id: 'blox_el_option_style',
	        				label: 'Style',
	        				value: $this.attr('box_style'),
	        				options: [
	        					{ value: 'default', label: 'Default Style' },
	        					{ value: 'colored', label: 'Colored Style' }
	        				]
	        			},
	        			{
	        				type: 'colorpicker',
	        				id: 'blox_el_option_color',
	        				label: 'Background Color',
	        				value: $this.attr('color')
	        			},
	        			{
	        				type: 'icon',
	        				id: 'blox_el_option_icon',
	        				label: 'Icon',
	        				value: $this.attr('icon')
	        			}
	    			];

                show_blox_form('Edit Content Box', form_element, function($form){
                    $this.find('.blox_item_content').html(get_content_tinymce());
            		$this.attr('title', jQuery('#blox_el_option_title').val());
            		$this.attr('widget_title', jQuery('#blox_el_option_wtitle').val());
            		$this.attr('box_style', jQuery('#blox_el_option_style').val());
            		$this.attr('color', jQuery('#blox_el_option_color').val());            		
            		$this.attr('icon', jQuery('#blox_el_option_icon').val());
                },
                {
                    target: $this,
                    extra_field: true
                });
                
                // Folds
                jQuery('#blox_el_option_style').change(function(){
                    if( jQuery('#blox_el_option_style').val() == 'colored' ){
                        jQuery('.wp-picker-container').parent().show();
                    }
                    else{
                        jQuery('.wp-picker-container').parent().hide();
                    }
                });
                jQuery('#blox_el_option_style').change();
	            
            });
			
		
		$this.find('.blox_item_actions .action_clone').unbind('click')
			.click(function(){
				$this.after($this.clone());
				add_event_blox_element_contentbox();
			});
			
		$this.find('.blox_item_actions .action_remove').unbind('click')
			.click(function(){
				$this.remove();
			});
	});
	
}
