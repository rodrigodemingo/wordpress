<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7 ltie8 ltie9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8 ltie9" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="initial-scale = 1.0" />
	<title><?php bloginfo('name'); ?>  <?php wp_title(); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php 
		global $theme_option, $gdlr_post_option;
		if( !empty($gdlr_post_option) ){ $gdlr_post_option = json_decode($gdlr_post_option, true); }
		
		wp_head(); 
	?>
</head>

<body <?php body_class(); ?>>
<?php
	$body_wrapper = '';
	$body_wrapper .= ($theme_option['enable-float-menu'] != 'disable')? ' float-menu': '';
	$body_wrapper .= ($theme_option['body-background-type'] == 'pattern')? ' gdlr-pattern-background': '';
	$body_wrapper .= ($theme_option['body-background-type'] == 'image')? ' gdlr-image-background': '';
?>
<div class="body-wrapper <?php echo $body_wrapper; ?>" data-home="<?php echo home_url(); ?>" >
	<?php 
		if( $theme_option['body-background-type'] == 'image' ){
			if( !empty($theme_option['body-background-image']) && 
				is_numeric($theme_option['body-background-image']) ){
				
				$alt_text = get_post_meta($theme_option['body-background-image'] , '_wp_attachment_image_alt', true);	
				$image_src = wp_get_attachment_image_src($theme_option['body-background-image'], 'full');
				echo '<img class="gdlr-full-boxed-background" src="' . $image_src[0] . '" alt="' . $alt_text . '" />';
			}else if( !empty($theme_option['body-background-image']) ){
				echo '<img class="gdlr-full-boxed-background" src="' . $theme_option['body-background-image'] . '" />';
			}
		}	
	
		// page style
		if( empty($gdlr_post_option) || empty($gdlr_post_option['page-style']) ||
			  $gdlr_post_option['page-style'] == 'normal' || 
			  $gdlr_post_option['page-style'] == 'no-footer'){ 
	?>
	<header class="gdlr-header-wrapper">
		<!-- top navigation -->
		<?php if( false && (empty($theme_option['enable-top-bar']) || $theme_option['enable-top-bar'] == 'enable') ){ ?>
		<div class="top-navigation-wrapper">
			<div class="top-navigation-container container">
				<div class="top-navigation-left">
					<div class="top-social-wrapper">
						<?php gdlr_print_header_social(); ?>
					</div>
				</div>
				<div class="top-navigation-right">
					<div class="top-navigation-right-text">
						<?php 
							if( !empty($theme_option['top-bar-right-text']) ) 
								echo gdlr_text_filter($theme_option['top-bar-right-text']); 
						?>
					</div>
				</div>
				<div class="clear"></div>
				<div class="top-navigation-divider"></div>
			</div>
		</div>
		<?php } ?>
		
		<!-- logo -->
		<div class="gdlr-logo-container container">
			<div class="gdlr-logo-wrapper">
				<div class="gdlr-logo">
					<a href="<?php echo home_url(); ?>" >
						<?php 
							if(empty($theme_option['logo-id'])){ 
								echo gdlr_get_image(GDLR_PATH . '/images/logo.png');
							}else{
								echo gdlr_get_image($theme_option['logo-id']);
							}
						?>						
					</a>
					<?php
						// mobile navigation
						if( class_exists('gdlr_dlmenu_walker') && has_nav_menu('main_menu') &&
							( empty($theme_option['enable-responsive-mode']) || $theme_option['enable-responsive-mode'] == 'enable' ) ){
							echo '<div class="gdlr-responsive-navigation dl-menuwrapper" id="gdlr-responsive-navigation" >';
							echo '<button class="dl-trigger">Open Menu</button>';
							wp_nav_menu( array(
								'theme_location'=>'main_menu', 
								'container'=> '', 
								'menu_class'=> 'dl-menu gdlr-main-mobile-menu',
								'walker'=> new gdlr_dlmenu_walker() 
							) );						
							echo '</div>';
						}						
					?>						
				</div>
			</div>
		</div> <!-- gdlr-logo-container -->
		<div class="clear"></div>
	</header>
	
	<!-- navigation -->
	<div class="gdlr-navigation-outer-wrapper" id="gdlr-navigation-outer-wrapper" >
		<div class="gdlr-navigation-container container">
			<div class="gdlr-navigation-gimmick" id="gdlr-navigation-gimmick"></div>
			<?php get_template_part( 'header', 'nav' ); ?>
			<div class="clear"></div>
		</div>	
	</div>	
	<div id="gdlr-navigation-substitute" ></div>
	
	<!-- top search -->
	<?php if( empty($theme_option['enable-top-search']) || $theme_option['enable-top-search'] == 'enable' ){ ?>
	<div class="gdlr-nav-search-form" id="gdlr-nav-search-form">
		<div class="gdlr-nav-search-container container"> 
		<form method="get" action="<?php  echo home_url(); ?>">
			<i class="icon-search"></i>
			<input type="submit" id="searchsubmit2" class="style-2" value="">
			<div class="search-text" id="search-text2">
				<input type="text" value="" name="s" id="s2" autocomplete="off" data-default="<?php _e("Type keywords..." , "gdlr_translate"); ?>" >
			</div>
			<div class="clear"></div>
		</form>
		</div>
	</div>	
	<?php } ?>	
	<?php get_template_part( 'header', 'title' );
	
	} // page style ?>
	<div class="content-wrapper">