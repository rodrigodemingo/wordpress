<?php 
	global $theme_option;

	echo '<div class="gdlr-navigation-wrapper">';

	// navigation
	if( has_nav_menu('main_menu') ){
		if( class_exists('gdlr_menu_walker') ){
			echo '<nav class="gdlr-navigation" id="gdlr-main-navigation" role="navigation">';
			wp_nav_menu( array(
				'theme_location'=>'main_menu', 
				'container'=> '', 
				'menu_class'=> 'sf-menu gdlr-main-menu',
				'walker'=> new gdlr_menu_walker() 
			) );
		}else{
			echo '<nav class="gdlr-navigation" role="navigation">';
			wp_nav_menu( array('theme_location'=>'main_menu') );
		}
		echo '</nav>'; // gdlr-navigation
	}
	
	if( empty($theme_option['enable-top-search']) || $theme_option['enable-top-search'] == 'enable' ){ ?>	
		<div class="top-search-button" id="top-search-button">
			<i class="icon-search"></i>
		</div>
	<?php }
	
	echo '<div class="clear"></div>';
	echo '</div>'; // gdlr-navigation-wrapper
?>