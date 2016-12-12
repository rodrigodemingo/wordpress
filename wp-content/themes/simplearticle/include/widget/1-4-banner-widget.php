<?php
/**
 * Plugin Name: 1/2 Goodlayers Banner Widget
 * Plugin URI: http://goodlayers.com/
 * Description: Half size banner widget
 * Version: 1.0
 * Author: Goodlayers
 * Author URI: http://www.goodlayers.com
 *
 */

add_action( 'widgets_init', 'goodlayers_1_4_banner_init' );
function goodlayers_1_4_banner_init(){
	register_widget('Goodlayers_1_4_Banner_widget');      
}

class Goodlayers_1_4_Banner_widget extends WP_Widget{ 

	// Initialize the widget
    function Goodlayers_1_4_Banner_widget() {
        parent::__construct(
			'goodlayers-1-4-banner-widget', __('1/4 Banner Widget (Goodlayers)','gdl_back_office'), 
			array('description' => __('Half size with 2 rows banner widget', 'gdl_back_office')));  
    }  
	
	// Output of the widget
	function widget($args, $instance) {  
		global $wpdb;
	
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$image = $instance['image'];
		$link = $instance['link'];
		$image2 = $instance['image2'];
		$link2 = $instance['link2'];
		$image3 = $instance['image3'];
		$link3 = $instance['link3'];
		$image4 = $instance['image4'];
		$link4 = $instance['link4'];

		// Opening of widget
		echo $args['before_widget'];
		
		// Open of title tag
		if( !empty($title) ){ 
			echo $args['before_title'] . $title . $args['after_title']; 
		}
		
		echo '<div class="banner-widget1-4-wrapper">';
		
		if( !empty($image) ){
			echo '<div class="banner-widget1-4" >';
			echo '<div class="left" >';
			echo '<a href="' . $link . '" target="_blank">';
			echo '<img src="' . $image . '" alt="banner" />';
			echo '</a>';
			echo '</div>';
			echo '</div>';
		}
		
		if( !empty($image2) ){
			echo '<div class="banner-widget1-4" >';
			echo '<div class="right" >';
			echo '<a href="' . $link2 . '" target="_blank">';
			echo '<img src="' . $image2 . '" alt="banner"/>';
			echo '</a>';	
			echo '</div>';
			echo '</div>';
		}
		
		echo '<div class="clear"></div>';
		
		if( !empty($image3) ){
			echo '<div class="banner-widget1-4" >';
			echo '<div class="left" >';
			echo '<a href="' . $link3 . '" target="_blank">';
			echo '<img src="' . $image3 . '" alt="banner" />';
			echo '</a>';
			echo '</div>';
			echo '</div>';
		}
		
		if( !empty($image4) ){
			echo '<div class="banner-widget1-4" >';
			echo '<div class="right" >';
			echo '<a href="' . $link4 . '" target="_blank">';
			echo '<img src="' . $image4 . '" alt="banner"/>';
			echo '</a>';	
			echo '</div>';
			echo '</div>';	
		}
		
		echo '<div class="clear"></div>';
		echo '</div>'; // 1-4 Banner Widget Wrapper
		
		// Closing of widget
		echo $args['after_widget'];
    }  	
	
	// Widget Form
	function form($instance) {  
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$image = esc_attr( $instance[ 'image' ] );
			$link = esc_attr( $instance[ 'link' ] );
			$image2 = esc_attr( $instance[ 'image2' ] );
			$link2 = esc_attr( $instance[ 'link2' ] );
			$image3 = esc_attr( $instance[ 'image3' ] );
			$link3 = esc_attr( $instance[ 'link3' ] );
			$image4 = esc_attr( $instance[ 'image4' ] );
			$link4 = esc_attr( $instance[ 'link4' ] );
		} else {
			$title = '';
			$image = '';
			$link = '';
			$image2 = '';
			$link2 = '';
			$image3 = '';
			$link3 = '';
			$image4 = '';
			$link4 = '';
		}
		?>
		
		<!-- Title --> 
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<!-- Image --> 
		<p>
			<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e( 'Banner Image URL :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo $image; ?>" />
		</p>		
		
		<!-- Link --> 
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e( 'Banner Link :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
		</p>		
		
		<!-- Image2 --> 
		<p>
			<label for="<?php echo $this->get_field_id('image2'); ?>"><?php _e( 'Banner Image URL 2 :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('image2'); ?>" name="<?php echo $this->get_field_name('image2'); ?>" type="text" value="<?php echo $image2; ?>" />
		</p>		
		
		<!-- Link2 --> 
		<p>
			<label for="<?php echo $this->get_field_id('link2'); ?>"><?php _e( 'Banner Link 2 :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('link2'); ?>" name="<?php echo $this->get_field_name('link2'); ?>" type="text" value="<?php echo $link2; ?>" />
		</p>		
		
		<!-- Image3 --> 
		<p>
			<label for="<?php echo $this->get_field_id('image3'); ?>"><?php _e( 'Banner Image URL 3 :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('image3'); ?>" name="<?php echo $this->get_field_name('image3'); ?>" type="text" value="<?php echo $image3; ?>" />
		</p>		
		
		<!-- Link3 --> 
		<p>
			<label for="<?php echo $this->get_field_id('link3'); ?>"><?php _e( 'Banner Link 3 :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('link3'); ?>" name="<?php echo $this->get_field_name('link3'); ?>" type="text" value="<?php echo $link3; ?>" />
		</p>		
		
		<!-- Image4 --> 
		<p>
			<label for="<?php echo $this->get_field_id('image4'); ?>"><?php _e( 'Banner Image URL 4 :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('image4'); ?>" name="<?php echo $this->get_field_name('image4'); ?>" type="text" value="<?php echo $image4; ?>" />
		</p>		
		
		<!-- Link4 --> 
		<p>
			<label for="<?php echo $this->get_field_id('link4'); ?>"><?php _e( 'Banner Link 4 :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('link4'); ?>" name="<?php echo $this->get_field_name('link4'); ?>" type="text" value="<?php echo $link4; ?>" />
		</p>		

		<?php
    }  
	
	// Update the widget
	function update($new_instance, $old_instance){  
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['image'] = strip_tags($new_instance['image']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['image2'] = strip_tags($new_instance['image2']);
		$instance['link2'] = strip_tags($new_instance['link2']);
		$instance['image3'] = strip_tags($new_instance['image3']);
		$instance['link3'] = strip_tags($new_instance['link3']);
		$instance['image4'] = strip_tags($new_instance['image4']);
		$instance['link4'] = strip_tags($new_instance['link4']);
		
		return $instance;
    }
	
}  

?>