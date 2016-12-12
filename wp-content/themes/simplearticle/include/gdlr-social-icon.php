<?php
	/*	
	*	Goodlayers Framework File
	*	---------------------------------------------------------------------
	*	This file contains the function that helps you print the social section
	*	---------------------------------------------------------------------
	*/
	
	$gdlr_header_social_icon = array(
		'delicious'		=> __('Delicius','gdlr_translate'), 
		'deviantart'	=> __('Deviant Art','gdlr_translate'), 
		'digg'			=> __('Digg','gdlr_translate'),
		'email' 		=> __('Email','gdlr_translate'),				
		'facebook'		=> __('Facebook','gdlr_translate'), 
		'flickr'		=> __('Flickr','gdlr_translate'),
		'google-plus' 	=> __('Google Plus','gdlr_translate'),				
		'lastfm'       	=> __('Lastfm','gdlr_translate'),
		'linkedin' 		=> __('Linkedin','gdlr_translate'),
		'picasa' 		=> __('Picasa','gdlr_translate'),
		'pinterest' 	=> __('Pinterest','gdlr_translate'),
		'rss' 			=> __('Rss','gdlr_translate'),
		'skype'			=> __('Skype','gdlr_translate'),
		'stumble-upon' 	=> __('Stumble Upon','gdlr_translate'),
		'tumblr' 		=> __('Tumblr','gdlr_translate'),
		'twitter' 		=> __('Twitter','gdlr_translate'),
		'vimeo' 		=> __('Vimeo','gdlr_translate'),
		'youtube' 		=> __('Youtube','gdlr_translate'),
	);	
	
	// add_filter('gdlr_admin_option', 'gdlr_register_header_social_option');
	if( !function_exists('gdlr_register_header_social_option') ){
		function gdlr_register_header_social_option( $array ){		
			if( empty($array['overall-elements']['options']) ) return $array;
			
			global $gdlr_header_social_icon;
			$header_social = array( 									
				'title' => __('Header Social', 'gdlr_translate'),
				'options' => array(
					'header-social-type' => array(
						'title' => __('Header Social Icon Type', 'gdlr_translate'),
						'type' => 'combobox',	
						'options' => array(
							'light' => __('Light', 'gdlr_translate'),
							'dark' => __('Dark', 'gdlr_translate')
						),
						'default' => 'dark'
					),
				)
			);
				
			foreach( $gdlr_header_social_icon as $social_slug => $social_name ){
				$header_social['options'][$social_slug . '-header-social'] = array(
					'title' => $social_name . ' ' . __('Header Social', 'gdlr_translate'),
					'type' => 'text',				
				);
				
				if( $social_slug = 'email' ){
					$header_social['options'][$social_slug . '-header-social']['description'] =
						'Adding \'mailto:someone@example.com\' will allows users to click the icon to send an e-mail.';
				}
			}
			
			$array['overall-elements']['options']['header-social'] = $header_social;
			return $array;
		}
	}
	
	
	if( !function_exists('gdlr_print_header_social') ){
		function gdlr_print_header_social(){
			global $gdlr_header_social_icon, $theme_option;
			$type = empty($theme_option['header-social-type'])? 'dark': $theme_option['header-social-type'];
			
			foreach( $gdlr_header_social_icon as $social_slug => $social_name ){
				if( !empty($theme_option[$social_slug . '-header-social']) ){
?>
<div class="social-icon">
<a href="<?php echo $theme_option[$social_slug . '-header-social']; ?>" target="_blank" >
<img width="32" height="32" src="<?php echo GDLR_PATH . '/images/' . $type . '/social-icon/' . $social_slug . '.png'; ?>" alt="<?php echo $social_name; ?>" />
</a>
</div>
<?php				
				}
			}
			echo '<div class="clear"></div>';
		}
	}	
	
	add_filter('gdlr_admin_option', 'gdlr_register_social_shares_option');
	if( !function_exists('gdlr_register_social_shares_option') ){
		function gdlr_register_social_shares_option( $array ){	
			if( empty($array['overall-elements']['options']) ) return $array;
			
			$gdlr_social_shares = array(
				'digg'			=> __('Digg','gdlr_translate'),			
				'facebook'		=> __('Facebook','gdlr_translate'), 
				'google-plus' 	=> __('Google Plus','gdlr_translate'),	
				'linkedin' 		=> __('Linkedin','gdlr_translate'),
				'tumblr' 		=> __('Tumblr','gdlr_translate'),
				'pinterest' 	=> __('Pinterest','gdlr_translate'),
				'reddit' 		=> __('Reddit','gdlr_translate'),
				'stumble-upon' 	=> __('Stumble Upon','gdlr_translate'),
				'twitter' 		=> __('Twitter','gdlr_translate'),
			);	
			$header_social = array( 									
				'title' => __('Social Shares', 'gdlr_translate'),
				'options' => array(
					'enable-social-share'=> array(
						'title' => __('Enable Social Share' ,'gdlr_translate'),
						'type' => 'checkbox',
						'description' => 'Enable this option to show the social shares below each post'
					)
				)
			);
				
			foreach( $gdlr_social_shares as $social_slug => $social_name ){
				$header_social['options'][$social_slug . '-share'] = array(
					'title' => $social_name,
					'type' => 'checkbox'				
				);
			}
			
			$array['overall-elements']['options']['social-shares'] = $header_social;
			return $array;
		}
	}	

	if( !function_exists('gdlr_get_social_shares') ){
		function gdlr_get_social_shares(){	
			global $theme_option;

			$page_title = rawurlencode(get_the_title());
			$current_url = get_permalink();
			if( empty($current_url) ){
				$current_url = GDLR_HTTP . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			}

			if($theme_option['enable-social-share'] == 'enable'){ ?>
<div class="gdlr-social-share">
<?php if($theme_option['digg-share'] == 'enable'){ ?>
	<a href="http://digg.com/submit?url=<?php echo $current_url; ?>&#038;title=<?php echo $page_title; ?>" target="_blank">
		<img src="<?php echo GDLR_PATH; ?>/images/dark/social-share/digg.png" alt="digg-share" width="112" height="112" />
	</a>
<?php } ?>

<?php if($theme_option['facebook-share'] == 'enable'){ ?>
	<a href="http://www.facebook.com/share.php?u=<?php echo $current_url; ?>" target="_blank">
		<img src="<?php echo GDLR_PATH; ?>/images/dark/social-share/facebook.png" alt="facebook-share" width="112" height="112" />
	</a>
<?php } ?>

<?php if($theme_option['google-plus-share'] == 'enable'){ ?>
	<a href="https://plus.google.com/share?url=<?php echo $current_url; ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=500');return false;">
		<img src="<?php echo GDLR_PATH; ?>/images/dark/social-share/google-plus.png" alt="google-share" width="112" height="112" />
	</a>
<?php } ?>

<?php if($theme_option['linkedin-share'] == 'enable'){ ?>
	<a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=<?php echo $current_url; ?>&#038;title=<?php echo $page_title; ?>" target="_blank">
		<img src="<?php echo GDLR_PATH; ?>/images/dark/social-share/linkedin.png" alt="linked-share" width="112" height="112" />
	</a>
<?php } ?>

<?php if($theme_option['tumblr-share'] == 'enable'){ ?>
	<a href="http://www.tumblr.com/share/link?url=<?php echo rawurlencode($current_url); ?>&amp;name=<?php echo $page_title; ?>" target="_blank">
		<img src="<?php echo GDLR_PATH; ?>/images/dark/social-share/tumblr.png" alt="tumblr-share" width="112" height="112" />
	</a>
<?php } ?>

<?php 
	if($theme_option['pinterest-share'] == 'enable'){ 
		$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
		$thumbnail = wp_get_attachment_image_src( $thumbnail_id , 'large' ); 
?>
	<a href="http://pinterest.com/pin/create/button/?url=<?php echo $current_url; ?>&amp;media=<?php echo $thumbnail[0]; ?>" class="pin-it-button" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
		<img src="<?php echo GDLR_PATH; ?>/images/dark/social-share/pinterest.png" alt="pinterest-share" width="112" height="112" />
	</a>	
<?php } ?>

<?php if($theme_option['reddit-share'] == 'enable'){ ?>
	<a href="http://reddit.com/submit?url=<?php echo $current_url; ?>&#038;title=<?php echo $page_title; ?>" target="_blank">
		<img src="<?php echo GDLR_PATH; ?>/images/dark/social-share/reddit.png" alt="reddit-share" width="112" height="112" />
	</a>
<?php } ?>

<?php if($theme_option['stumble-upon-share'] == 'enable'){ ?>
	<a href="http://www.stumbleupon.com/submit?url=<?php echo $current_url; ?>&#038;title=<?php echo $page_title; ?>" target="_blank">
		<img src="<?php echo GDLR_PATH; ?>/images/dark/social-share/stumble-upon.png" alt="stumble-upon-share" width="112" height="112" />
	</a>
<?php } ?>

<?php if($theme_option['twitter-share'] == 'enable'){ ?>
	<a href="http://twitter.com/home?status=<?php echo str_replace('%26%23038%3B', '%26', $page_title) . '-' . $current_url; ?>" target="_blank">
		<img src="<?php echo GDLR_PATH; ?>/images/dark/social-share/twitter.png" alt="twitter-share" width="112" height="112" />
	</a>
<?php } ?>
<div class="clear"></div>
</div>
			<?php }
		}
	}	
	
	// add user field
	$author_social = array(
		'facebook'		=> __('Facebook Link', 'gdlr_translate'),
		'twitter'		=> __('Twitter Link', 'gdlr_translate'),
		'gdlremail'		=> __('Email Link', 'gdlr_translate'),
		'googleplus'	=> __('Google Plus Link', 'gdlr_translate'),
		'instagram'		=> __('Instagram Link', 'gdlr_translate'),
		'linkedin'		=> __('Linkedin Link', 'gdlr_translate'),
		'pinterest'		=> __('Pinterest Link', 'gdlr_translate'),
		'tumblr'		=> __('Tumblr Link', 'gdlr_translate'),
		'wordpress'		=> __('Wordpress Link', 'gdlr_translate'),
		'youtube'		=> __('Youtube Link', 'gdlr_translate')
	);
	
	if( !function_exists('gdlr_get_author_social') ){
		function gdlr_get_author_social($user_id) {
			global $author_social;
			
			$ret  = '<div class="gdlr-author-social-wrapper">';
			foreach( $author_social as $key => $value ){
				$link = get_user_meta($user_id, $key, true);
				if( !empty($link) ){
					$ret .= '<a href="' . $link . '" ><img src="' . GDLR_PATH . '/images/social-icon/' . $key . '.png" alt="' . $key . '"/></a>';
				}
			}
			$ret .= '<div class="clear"></div>';
			$ret .= '</div>';
			
			return $ret;
		}
	}
	
	add_filter('user_contactmethods', 'gdlr_modify_contact_methods');
	if( !function_exists('gdlr_modify_contact_methods') ){
		function gdlr_modify_contact_methods($profile_fields) {
			global $author_social;
			
			$profile_fields['authorimage'] = __('Author Image URL', 'gdlr_translate');
			foreach( $author_social as $key => $value ){
				$profile_fields[$key] = $value;
			}
			return $profile_fields;
		}
	}

	add_action( 'edit_user_profile_update', 'save_custom_profile_fields' );
	if( !function_exists('save_custom_profile_fields') ){
		function save_custom_profile_fields( $user_id ) {
			global $author_social;
			
			update_user_meta( $user_id, 'authorimage', $_POST['authorimage'], get_user_meta($user_id, 'authorimage', true) );
			foreach( $author_social as $key => $value ){
				update_user_meta( $user_id, $key, $_POST[$key], get_user_meta($user_id, $key, true) );
			}
		}	
	}
	
?>