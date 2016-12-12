<?php
/**
 * The template for displaying video post format
 */
	global $gdlr_post_settings; 
	
	$post_format_data = '';
	$content = trim(get_the_content('<span class="gdlr-button with-border excerpt-read-more">' . __('Read More', 'gdlr_translate') . '</span>'));	
	if(preg_match('#\[gallery[^\]]+]#', $content, $match)){ 
		if( is_single() || $gdlr_post_settings['blog-style'] == 'blog-full' ){
			$post_format_data = do_shortcode($match[0]);
		}else{
			preg_match('#\[gallery.+ids\s?=\s?\"([^\"]+).+]#', $match[0], $match2);
			$post_format_data = gdlr_get_flex_slider(explode(',', $match2[1]), array('size'=>$gdlr_post_settings['thumbnail-size']));
		}
		$gdlr_post_settings['content'] = substr($content, strlen($match[0]));
	}else{
		$gdlr_post_settings['content'] = $content;
	}

	if ( !empty($post_format_data) ){
		echo '<div class="gdlr-blog-thumbnail gdlr-gallery">' . $post_format_data . '</div>';
	} 
?>	
			