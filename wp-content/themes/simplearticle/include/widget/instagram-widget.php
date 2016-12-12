<?php
/**
 * Plugin Name: Goodlayers Instagram Widget
 * Plugin URI: http://goodlayers.com/
 * Description: A widget that show feeds from instagram.
 * Version: 1.0
 * Author: Goodlayers
 * Author URI: http://www.goodlayers.com
 *
 */

add_action( 'widgets_init', 'gdlr_instagram_widget' );
if( !function_exists('gdlr_instagram_widget') ){
	function gdlr_instagram_widget() {
		register_widget( 'Goodlayers_Instagram_Widget' );
	}
}

if( !class_exists('Goodlayers_Instagram_Widget') ){
	class Goodlayers_Instagram_Widget extends WP_Widget {

		// Initialize the widget
		function __construct(){
			parent::__construct(
				'gdlr-instagram-widget', 
				__('Goodlayers Instagram','gdlr_translate'), 
				array('description' => __('A widget that show instagram feeds.', 'gdlr_translate')));  
		}

		// Output of the widget
		function widget( $args, $instance ) {
			global $theme_option;
			
			$title = apply_filters( 'widget_title', $instance['title'] );
			$type = $instance['type'];
			$username = $instance['username'];
			$client_id = $instance['client_id'];
			$show_num = $instance['show_num'];
			$photo_size = $instance['photo_size'];

			// Opening of widget
			echo $args['before_widget'];
			
			// Open of title tag
			if( !empty($title) ){ 
				echo $args['before_title'] . $title . $args['after_title']; 
			}
			
			$instagram = $this->scrape_instagram($username, $client_id, $show_num);
			if( is_wp_error($instagram) ){
			   echo $instagram->get_error_message();
			}else if( empty($type) || $type == 'list' ){
				echo '<ul class="gdlr-instagram-widget">';
				foreach( $instagram as $data ){
					echo '<li><a href="' . $data['link'] . '" target="_blank" >';
					echo '<img src="' . $data[$photo_size]['url'] . '" width="' . $data[$photo_size]['width'] . '" height="' . $data[$photo_size]['height'] . '" alt="" />';
					echo '</a></li>';
				}
				echo '</ul>';
				
				echo '<div class="gdlr-instagram-list-link" >';
				echo '<a href="http://instagram.com/' . $username . '" target="_blank">';
				echo '<i class="icon-instagram"></i>';
				echo __('Instagram\'s account', 'gdlr_translate');
				echo '</a>';
				echo '</div>';
			}else{
				echo '<div class="gdlr-instagram-item gdlr-widget-style" >';
				echo '<div class="gdlr-instagram-item-head gdlr-nav-container" >';
				echo '<i class="icon-angle-left gdlr-flex-prev"></i>';
				echo '<a href="http://instagram.com/' . $username . '" target="_blank"><i class="icon-instagram"></i></a>';
				echo '<i class="icon-angle-right gdlr-flex-next"></i>';
				echo '</div>';

				echo '<div class="gdlr-instagram-item-wrapper" >';
				echo '<div class="flexslider" data-type="carousel" data-nav-container="gdlr-instagram-item-wrapper" >';
				echo '<ul class="slides" >';
				foreach( $instagram as $data ){
					echo '<li>';
					echo '<a href="' . $data['link'] . '" target="_blank" >';
					echo '<img src="' . $data[$photo_size]['url'] . '" width="' . $data[$photo_size]['width'] . '" height="' . $data[$photo_size]['height'] . '" alt="" />';
					echo '</a>';
					echo '<span class="gdlr-date"><i class="icon-calendar-empty"></i>' . date_i18n($theme_option['date-format'], $data['time']) . '</span>'; 
					echo '</li>';
				}
				echo '</ul>';			
				echo '</div>';
				echo '</div>'; // gdlr-twiiter-item-wrapper			
				echo '</div>'; // gdlr-twiiter-item		
			}

			// Closing of widget
			echo $args['after_widget'];	
		}

		// Widget Form
		function form( $instance ) {
			$title = isset($instance['title'])? $instance['title']: '';
			$type = isset($instance['type'])? $instance['type']: 'list';
			$username = isset($instance['username'])? $instance['username']: '';
			$client_id = isset($instance['client_id'])? $instance['client_id']: '';
			$show_num = isset($instance['show_num'])? $instance['show_num']: '6';
			$photo_size = isset($instance['photo_size'])? $instance['photo_size']: 'thumbnail';
			?>
			<!-- Text Input -->
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title :', 'gdlr_translate' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>

			<!-- Type -->
			<p>
				<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type :', 'gdlr_translate'); ?></label>		
				<select class="widefat" name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>">
				<option value="list" <?php if(empty($type) || $type=='list') echo ' selected '; ?>><?php _e('List', 'gdlr_translate') ?></option>
				<option value="carousel" <?php if(!empty($type) && $type=='carousel') echo ' selected '; ?>><?php _e('Carousel', 'gdlr_translate') ?></option>
				</select> 
			</p>			
			
			<!-- Username -->
			<p>
				<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e( 'Username :', 'gdlr_translate' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" />
			</p>		
			
			<!-- Client ID -->
			<p>
				<label for="<?php echo $this->get_field_id('client_id'); ?>"><?php _e( 'Client ID :', 'gdlr_translate' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('client_id'); ?>" name="<?php echo $this->get_field_name('client_id'); ?>" type="text" value="<?php echo $client_id; ?>" />
			</p>		
			
			<!-- Show Num --> 
			<p>
				<label for="<?php echo $this->get_field_id( 'show_num' ); ?>"><?php _e('Show Count :', 'gdlr_translate'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'show_num' ); ?>" name="<?php echo $this->get_field_name( 'show_num' ); ?>" type="text" value="<?php echo $show_num; ?>" />
			</p>
			
			<!-- Photo Size -->
			<p>
				<label for="<?php echo $this->get_field_id('photo_size'); ?>"><?php _e('Photo Size :', 'gdlr_translate'); ?></label>		
				<select class="widefat" name="<?php echo $this->get_field_name('photo_size'); ?>" id="<?php echo $this->get_field_id('photo_size'); ?>">
				<option value="thumbnail" <?php if(empty($photo_size) || $photo_size=='thumbnail') echo ' selected '; ?>><?php _e('Thumbnail', 'gdlr_translate') ?></option>
				<option value="large" <?php if(!empty($photo_size) && $photo_size=='large') echo ' selected '; ?>><?php _e('Large', 'gdlr_translate') ?></option>
				</select> 
			</p>
			<?php
		}
		
		// Update the widget
		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = (empty($new_instance['title']))? '': strip_tags($new_instance['title']);
			$instance['type'] = (empty($new_instance['type']))? '': strip_tags($new_instance['type']);
			$instance['username'] = (empty($new_instance['username']))? '': strip_tags($new_instance['username']);
			$instance['client_id'] = (empty($new_instance['client_id']))? '': strip_tags($new_instance['client_id']);
			$instance['show_num'] = (empty($new_instance['show_num']))? '': strip_tags($new_instance['show_num']);
			$instance['photo_size'] = (empty($new_instance['photo_size']))? '': strip_tags($new_instance['photo_size']);
			return $instance;
		}

		// based on https://gist.github.com/cosmocatalano/4544576
		function scrape_instagram($username, $client_id, $slice = 9) {

			//if (false === ($instagram = get_transient('instagram-photos-'.sanitize_title_with_dashes($username)))) {
				
				// get id section
				$remote_id = wp_remote_get('https://api.instagram.com/v1/users/search?q=' . trim($username) . '&client_id=' . trim($client_id));
				
				if(is_wp_error($remote_id)) 
					return new WP_Error('site_down', __('Unable to communicate with Instagram.', 'gdlr_translate'));

				if( 200 != wp_remote_retrieve_response_code($remote_id) ) 
					return new WP_Error('invalid_response', __('Instagram did not return a 200.', 'gdlr_translate'));				
				
				$user_data = json_decode($remote_id['body']);

				if( empty($user_data->data[0]->id) ){
					return new WP_Error('cannot_get_id', __('Could not get instagram access token.', 'gdlr_translate'));
				}

				// get image section
				$remote = wp_remote_get('https://api.instagram.com/v1/users/' . $user_data->data[0]->id . '/media/recent/?client_id=' . trim($client_id));
	
				if (is_wp_error($remote)) 
					return new WP_Error('site_down', __('Unable to communicate with Instagram.', 'gdlr_translate'));

				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) 
					return new WP_Error('invalid_response', __('Instagram did not return a 200.', 'gdlr_translate'));

				$user_content = json_decode($remote['body'], true);
				$images = $user_content['data'];

				$instagram = array();
				foreach ($images as $image) {
					if ($image['type'] == 'image') {

						$instagram[] = array(
							'description' 	=> $image['caption']['text'],
							'link' 			=> $image['link'],
							'time'			=> $image['created_time'],
							'comments' 		=> $image['comments']['count'],
							'likes' 		=> $image['likes']['count'],
							'thumbnail' 	=> $image['images']['thumbnail'],
							'large' 		=> $image['images']['standard_resolution']
						);
					}
				}

				$instagram = base64_encode( serialize( $instagram ) );
				set_transient('instagram-photos-'.sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS*2));
			// }

			$instagram = unserialize( base64_decode( $instagram ) );

			return array_slice($instagram, 0, $slice);
		}		
	}
}
?>