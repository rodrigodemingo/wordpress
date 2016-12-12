<?php
/**
 * The template for displaying audio post format
 */
	global $gdlr_post_settings, $theme_option; 
	
	$post_format_data = ''; $gdlr_wp_audio = false;
	$content = trim(get_the_content('<span class="gdlr-button with-border excerpt-read-more">' . __('Read More', 'gdlr_translate') . '</span>'));		
	if(preg_match('#^https?://\S+#', $content, $match)){ 
		$gdlr_wp_audio = true;
		$post_format_data = do_shortcode('[audio src="' . $match[0] . '" ][/audio]');
		$gdlr_post_settings['content'] = substr($content, strlen($match[0]));					
	}else if(preg_match('#^\[audio\s.+\[/audio\]#', $content, $match)){ 
		$gdlr_wp_audio = true;
		$post_format_data = do_shortcode($match[0]);
		$gdlr_post_settings['content'] = substr($content, strlen($match[0]));
	}else if(preg_match('#^\[soundcloud\s.+\]#', $content, $match)){ 
		$post_format_data = do_shortcode($match[0]);
		$gdlr_post_settings['content'] = substr($content, strlen($match[0]));
	}else{
		$gdlr_wp_audio = true;
		$gdlr_post_settings['content'] = $content;
	}	

	if ( $gdlr_wp_audio &&  has_post_thumbnail() && ! post_password_required() ){ ?>
		<div class="gdlr-blog-thumbnail with-audio">
		<?php 
			if( is_single() ){
				echo gdlr_get_image(get_post_thumbnail_id(), $theme_option['post-thumbnail-size'], true);	
			}else{
				$temp_option = json_decode(get_post_meta(get_the_ID(), 'post-option', true), true);
				echo '<a href="' . get_permalink() . '"> ';
				echo gdlr_get_image(get_post_thumbnail_id(), $gdlr_post_settings['thumbnail-size']);
				echo '</a>';
				
				if( is_sticky() ){
					echo '<div class="gdlr-sticky-banner">';
					echo __('Sticky Post', 'gdlr_translate');
					echo '</div>';
				}
			}
		?>
		</div>
	<?php  } 	
	
	if ( !empty($post_format_data) ){
		echo '<div class="gdlr-blog-thumbnail gdlr-audio">' . $post_format_data . '</div>';
	} 
			
			
?>	
