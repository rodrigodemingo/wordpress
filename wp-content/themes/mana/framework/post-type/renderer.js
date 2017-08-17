
jQuery(function(){
	// init color picker
	jQuery('.tt_wpcolorpicker').wpColorPicker({
		palettes: [
					'#16a085', '#27ae60', '#2980b9', '#8e44ad', '#f39c12',
					'#f39c12','#d35400', '#c0392b', '#bdc3c7', '#7f8c8d'
				]
	});
	
	// init select field
	jQuery('.tt_wpselectbox').each(function(){
		var $this = jQuery(this);
		defval = $this.attr('default-value');
		if( $this.find('option[value="'+defval+'"]').length>0 ){
			$this.val(defval).change();
		}
		else{
			$this.find('option').eq(0).attr('selected', 'selected');
			$this.change();
		}
	});
	
	// init browse button
	jQuery('.pmeta_item_browse .pmeta_button_browse').each(function(){
		var $this = jQuery(this);
		if($this.parent().find('input').val()!=''){
			$this.parent().find('.browse_preview').find('a').unbind('click')
				.click(function(){
					$this.parent().find('.browse_preview').html('');
					$this.parent().find('input').val('');
					$this.parent().find('.browse_preview').hide();
					$this.parent().find('input').change();
				});
			$this.parent().find('.browse_preview').show();
		}
		
		jQuery(this).click(function(){
			var send_attachment_bkp = wp.media.editor.send.attachment;
			wp.media.editor.send.attachment = function(props, attachment){
				wp.media.editor.send.attachment = send_attachment_bkp;
				$this.parent().find('input').val(attachment.url);
				$this.parent().find('.browse_preview').html('<img src="'+attachment.url+'" />');
				$this.parent().find('.browse_preview').append('<a href="javascript:;">Remove</a>');
				$this.parent().find('.browse_preview').find('a').unbind('click')
					.click(function(){
						$this.parent().find('.browse_preview').html('');
						$this.parent().find('input').val('');
						$this.parent().find('.browse_preview').hide();
						$this.parent().find('input').change();
					});
				$this.parent().find('input').change();
				$this.parent().find('.browse_preview').show();
			}
			wp.media.editor.open();
			
	        return false;
		});
	});

	
	/* Gallery browse button
	==========================================*/
	jQuery('.pmeta_gallery .pmeta_button_browse').each(function(){
		var $this = jQuery(this);
		var $parent = $this.parent();
		var $input = $parent.find('.gallery_images');

		$this.click(function(){

    		blox_media( $input.val()!='' ? 'gallery-edit' : 'gallery-library', 'Add/Edit Gallery', $input.val(), function(selection){
				$counter = 0;
 				$input.val('');
 				$parent.find('.gallery_images_preview').html('');
 				
 				values = selection.map( function( attachment ){
 					element = attachment.toJSON();
 					$input.val($input.val()+($counter==0 ? '' : ',')+element.id);
 					$parent.find('.gallery_images_preview').append('<span style="background-image: url('+element.url+');"></span>');
 					$counter++;
 				});
			});
        	return false;
		});
	});


	/* Video browse button
	==========================================*/
	jQuery('.pmeta_video .pmeta_button_browse').each(function(){
		var $this = jQuery(this);
		var $parent = $this.parent();

		$this.click(function(){
			blox_media('blox_insert_video', 'Videos', '', function(selection){
				values = selection.map( function( attachment ){
							element = attachment.toJSON();
							$parent.find('input').val(element.url);
							$parent.find('input').change();
						});
			});
		});
	});
	
	
	jQuery('.pmeta_item_font .pmeta_button_font').each(function(){
		$this = jQuery(this);
		jQuery(this).click(function(){
			themeton_get_font( jQuery(this).parent().find('input') );
		});
	});


	// thumbnails click event
	jQuery('.page_option_field_thumbs').each(function(){
		var $this = jQuery(this);
		$this.find('label').click(function(){
			$this.find('label img').removeClass('active');
			jQuery(this).find('img').addClass('active');
		});
	});

	// blox switcher event
	jQuery('.blox_switcher').each(function(){
		var $this = jQuery(this);
		$this.click(function(){
			 $this.toggleClass("on");
			 if( $this.hasClass('on') ){
			 	$this.find('input').val('1').trigger('change');
			 }
			 else{
			 	$this.find('input').val('0').trigger('change');
			 }
		});
	});
	
});

/*
var browserInstanse = window.send_to_editor;
var newBrowser = function(html){
	imgurl = jQuery('img',html).attr('src');
	$this.parent().find('input').val(imgurl);
	tb_remove();
    window.send_to_editor = browserInstanse;
}
window.send_to_editor = newBrowser;
tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
*/
