<?php

	$cd = wp_upload_dir();
	$cdp = untrailingslashit( $cd['baseurl'] );
	$cdt = substr( $cd['subdir'], 1 );

	$su = preg_replace( '(^https?:)', '', untrailingslashit( get_option( 'siteurl' ) ) );

	$widgets = array(
		'sidebars_widgets'=> array ( 'wp_inactive_widgets'=> array ( 0=> 'text-18', 1=> 'text-19', 2=> 'text-20', 3=> 'nav_menu-10', 4=> 'nav_menu-11', 5=> 'nav_menu-12', 6=> 'text-15', 7=> 'text-16', 8=> 'prdctfltr-3', 9=> 'prdctfltr-4', ), 'sidebar-1'=> array (), 'sidebar-2'=> array (), 'sidebar-3'=> array ( 0=> 'woocommerce_top_rated_products-3', 1=> 'woocommerce_product_tag_cloud-2', 2=> 'woocommerce_product_search-2', 3=> 'woocommerce_recently_viewed_products-2', ), 'sidebar-4'=> array ( 0=> 'text-9', 1=> 'search-3', 2=> 'recent-posts-3', 3=> 'recent-comments-3', 4=> 'tag_cloud-2', ), 'shop-information-1'=> array ( 0=> 'text-10', ), 'shop-information-2'=> array ( 0=> 'text-11', ), 'shop-information-3'=> array ( 0=> 'text-12', ), 'shop-information-4'=> array ( 0=> 'text-13', ), 'shop-widgets-1'=> array ( 0=> 'woocommerce_products-2', ), 'shop-widgets-2'=> array ( 0=> 'woocommerce_top_rated_products-2', ), 'shop-widgets-3'=> array ( 0=> 'woocommerce_products-3', ), 'shop-widgets-4'=> array ( 0=> 'woocommerce_products-4', ), 'footer-1'=> array ( 0=> 'text-2', ), 'footer-2'=> array ( 0=> 'text-3', ), 'footer-3'=> array ( 0=> 'text-4', ), 'footer-4'=> array ( 0=> 'text-5', ), 'footer-5'=> array ( 0=> 'text-6', ), 'footer-6'=> array ( 0=> 'text-7', ), 'footer-7'=> array ( 0=> 'text-8', ), 'shopkit-cl-single-product-layout-3'=> array ( 0=> 'woocommerce_product_categories-2', 1=> 'woocommerce_top_rated_products-4', 2=> 'woocommerce_recent_reviews-2', 3=> 'woocommerce_recently_viewed_products-3', ), 'shopkit-cl-single-product-layout-4'=> array ( 0=> 'text-14', 1=> 'woocommerce_products-5', 2=> 'woocommerce_product_tag_cloud-4', 3=> 'woocommerce_product_search-3', ), 'shopkit-cl-woocommerce-layout-1'=> array ( 0=> 'text-17', 1=> 'prdctfltr-5', ), 'orphaned_widgets_1'=> array () ),'widget_categories'=> array ( '_multiwidget'=> 1,),'widget_text'=> array ( 2=> array ( 'title'=> 'ShopKit', 'text'=> '<ul><li><a href="#">Latest</a><li><a href="#">Trends</a><li><a href="#">Top Sales</a><li><a href="#">On Sale!</a></ul>', 'filter'=> false, ), 3=> array ( 'title'=> 'Categories', 'text'=> '<ul><li><a href="#">Women</a><li><a href="#">Men</a><li><a href="#">Featured</a><li><a href="#">Latest</a></ul>', 'filter'=> false, ), 4=> array ( 'title'=> 'Brands', 'text'=> '<ul><li><a href="#">Chic</a><li><a href="#">Lazara</a><li><a href="#">Roxed</a><li><a href="#">Womango</a></ul>', 'filter'=> false, ), 5=> array ( 'title'=> 'Tags', 'text'=> '<ul><li><a href="#">Crazy</a><li><a href="#">Denim</a><li><a href="#">Funky</a><li><a href="#">Short</a></ul>', 'filter'=> false, ), 6=> array ( 'title'=> 'Payments', 'text'=> '<p>Today, I\'m very happy about myself, because I realized my dreams. I learned how to understand what people want.</p><img src="' . $su . '/wp-content/themes/shopkit/demos/material/images/payments.png" style="width:auto;height:40px;" alt="" />', 'filter'=> false, ), 7=> array ( 'title'=> 'Shipping', 'text'=> '<p>Was trying to pass for hip or cool. It\'s the awkwardness that\'s nice.</p><img src="' . $su . '/wp-content/themes/shopkit/demos/material/images/shipping.png" style="width:auto;height:40px;" alt="" />', 'filter'=> false, ), 8=> array ( 'title'=> 'Our Partners', 'text'=> 'Women are more sure of themselves today.', 'filter'=> false, ), 9=> array ( 'title'=> 'Welcome to Shopkit!', 'text'=> 'All in one WooCommerce theme. Truly amazing functions and plugins that will make your Shop level up in seconds!<br/><a href="' . $su . '/shop/" class="button">Go to Shop!</a>', 'filter'=> false, ), 10=> array ( 'title'=> '', 'text'=> '<img src="' . $su . '/wp-content/themes/shopkit/demos/icons/basic_world.svg" width="36" height="36" style="vertical-align:middle;margin-right: 15px;" alt="" ><span style="display:inline-block;vertical-align:middle;">International shipping</span>', 'filter'=> false, ), 11=> array ( 'title'=> '', 'text'=> '<img src="' . $su . '/wp-content/themes/shopkit/demos/icons/ecommerce_cart.svg" width="36" height="36" style="vertical-align:middle;margin-right: 15px;" alt="" ><span style="display:inline-block;vertical-align:middle;">Standard delivery in<br/>5-10 working days</span>', 'filter'=> false, ), 12=> array ( 'title'=> '', 'text'=> '<img src="' . $su . '/wp-content/themes/shopkit/demos/icons/ecommerce_wallet.svg" width="36" height="36" style="vertical-align:middle;margin-right: 15px;" alt="" ><span style="display:inline-block;vertical-align:middle;">Secure payment</span>', 'filter'=> false, ), 13=> array ( 'title'=> '', 'text'=> '<img src="' . $su . '/wp-content/themes/shopkit/demos/icons/basic_cup.svg" width="36" height="36" style="vertical-align:middle;margin-right: 15px;" alt="" ><span style="display:inline-block;vertical-align:middle;">Worlds NO 1<br/>fashion destination</span>', 'filter'=> false, ), 14=> array ( 'title'=> 'Welcome to Shopkit!', 'text'=> 'All in one WooCommerce theme. Truly amazing functions and plugins that will make your Shop level up in seconds!<br/><a href="' . $su . '/shop/" class="button">Go to Shop!</a>', 'filter'=> false, ), 15=> array ( 'title'=> 'Welcome to ShopKit!', 'text'=> 'Use the product filter to quickly find products you\'re looking for', 'filter'=> false, ), 16=> array ( 'title'=> 'Product Filter', 'text'=> 'Use the product filter to quickly find products you\'re looking for', 'filter'=> false, ), 17=> array ( 'title'=> 'Welcome to ShopKit!', 'text'=> 'Use the product filter to quickly find products you\'re looking for', 'filter'=> false, ), 18=> array ( 'title'=> '', 'text'=> '<h2>ShopKit Collapsible Sections</h2>Any section can be collapsible. In the Creative Child Theme we\'ve implemented that as a great looking menu! We\'ve added the Widget Section and just made it collapsible with a custom trigger! It\'s all responsive too!', 'filter'=> false, ), 19=> array ( 'title'=> '', 'text'=> '<img src="' . $cdp . '/' . $cdt . '/showcase_icon_01.png" style="float:left;width:56px;margin-right:10px;" alt="" /><strong>ShopKit by <a href="https://mihajlovicnenad.com/">Mihajlovicnenad.com</a></strong><br/>All in one package!', 'filter'=> false, ), 20=> array ( 'title'=> '', 'text'=> '<img src="' . $cdp . '/' . $cdt . '/showcase_icon_05.png" style="float:left;width:56px;margin-right:10px;" alt="" /><strong>Great service, world wide!</strong><br/>Try it out today', 'filter'=> false, ), '_multiwidget'=> 1,),'widget_rss'=> array ( 1=> array (), '_multiwidget'=> 1,),'widget_search'=> array ( 3=> array ( 'title'=> 'Search Posts', ), '_multiwidget'=> 1,),'widget_recent-posts'=> array ( 3=> array ( 'title'=> '', 'number'=> 5, 'show_date'=> false, ), '_multiwidget'=> 1,),'widget_recent-comments'=> array ( 3=> array ( 'title'=> '', 'number'=> 5, ), '_multiwidget'=> 1,),'widget_archives'=> array ( '_multiwidget'=> 1,),'widget_meta'=> array ( '_multiwidget'=> 1,),'widget_pages'=> array ( '_multiwidget'=> 1,),'widget_calendar'=> array ( '_multiwidget'=> 1,),'widget_tag_cloud'=> array ( 2=> array ( 'title'=> '', 'taxonomy'=> 'post_tag', ), '_multiwidget'=> 1,),'widget_nav_menu'=> array ( 10=> array ( 'title'=> 'Demo Pages', 'nav_menu'=> 52, ), 11=> array ( 'title'=> 'System Pages', 'nav_menu'=> 53, ), 12=> array ( 'title'=> 'Theme Features', 'nav_menu'=> 54, ), '_multiwidget'=> 1,),'widget_woocommerce_widget_cart'=> array ( '_multiwidget'=> 1,),'widget_woocommerce_layered_nav_filters'=> array ( '_multiwidget'=> 1,),'widget_woocommerce_layered_nav'=> array ( '_multiwidget'=> 1,),'widget_woocommerce_price_filter'=> array ( '_multiwidget'=> 1,),'widget_woocommerce_product_categories'=> array ( 2=> array ( 'title'=> 'Select Category', 'orderby'=> 'name', 'dropdown'=> 1, 'count'=> 1, 'hierarchical'=> 1, 'show_children_only'=> 0, 'hide_empty'=> 0, ), '_multiwidget'=> 1,),'widget_woocommerce_product_search'=> array ( 2=> array ( 'title'=> 'Search Products', ), 3=> array ( 'title'=> 'Search Products', ), '_multiwidget'=> 1,),'widget_woocommerce_product_tag_cloud'=> array ( 2=> array ( 'title'=> 'Product Tags', ), 4=> array ( 'title'=> 'Product Tags', ), '_multiwidget'=> 1,),'widget_woocommerce_products'=> array ( 2=> array ( 'title'=> 'Newest Products', 'number'=> 4, 'show'=> '', 'orderby'=> 'date', 'order'=> 'desc', 'hide_free'=> 0, 'show_hidden'=> 0, ), 3=> array ( 'title'=> 'Best Sellers', 'number'=> 4, 'show'=> '', 'orderby'=> 'sales', 'order'=> 'desc', 'hide_free'=> 0, 'show_hidden'=> 0, ), 4=> array ( 'title'=> 'Top Picks', 'number'=> 4, 'show'=> '', 'orderby'=> 'rand', 'order'=> 'desc', 'hide_free'=> 0, 'show_hidden'=> 0, ), 5=> array ( 'title'=> 'Products', 'number'=> 5, 'show'=> '', 'orderby'=> 'date', 'order'=> 'desc', 'hide_free'=> 0, 'show_hidden'=> 0, ), '_multiwidget'=> 1,),'widget_woocommerce_rating_filter'=> array ( '_multiwidget'=> 1,),'widget_woocommerce_recent_reviews'=> array ( 2=> array ( 'title'=> 'Recent Reviews', 'number'=> 2, ), '_multiwidget'=> 1,),'widget_woocommerce_recently_viewed_products'=> array ( 2=> array ( 'title'=> 'Recently Viewed Products', 'number'=> 5, ), 3=> array ( 'title'=> 'Recently Viewed Products', 'number'=> 5, ), '_multiwidget'=> 1,),'widget_woocommerce_top_rated_products'=> array ( 2=> array ( 'title'=> 'Top Rated Products', 'number'=> 4, ), 3=> array ( 'title'=> 'Top Rated Products', 'number'=> 5, ), 4=> array ( 'title'=> 'Top Rated Products', 'number'=> 5, ), '_multiwidget'=> 1,),'widget_prdctfltr'=> array ( 3=> array ( 'preset'=> 'pf_default', 'template'=> 'default', 'disable_overrides'=> 'no', 'widget_action'=> '', ), 4=> array ( 'preset'=> 'pf_default', 'template'=> 'default', 'disable_overrides'=> 'no', 'widget_action'=> '', ), 5=> array ( 'preset'=> 'pf_default', 'template'=> 'default', 'disable_overrides'=> 'no', 'widget_action'=> '', ), '_multiwidget'=> 1,),'widget_woocommerce_product_search'=> array ( 2=> array ( 'title'=> 'Search Products', ), 3=> array ( 'title'=> 'Search Products', ), '_multiwidget'=> 1,),
	);

?>