<?php

function shopkit_flat_general_settings( $custom_settings ) {

$custom_settings['settings']['logo_image']['std'] = preg_replace( '(^https?:)', '', esc_url( untrailingslashit( get_template_directory_uri() ) ) . '/demos/creative/images/logo.png' );
$custom_settings['settings']['logo_image_link']['std'] = '';
$custom_settings['settings']['site_title_font']['std'] = array (
  'font-color' => '',
  'font-family' => '',
  'font-size' => '20px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '20px',
  'text-decoration' => '',
  'text-transform' => 'none',
);
$custom_settings['settings']['site_description_font']['std'] = array (
  'font-color' => '',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '400',
  'letter-spacing' => '0em',
  'line-height' => '20px',
  'text-decoration' => '',
  'text-transform' => 'none',
);
$custom_settings['settings']['favorites_icon']['std'] = '';
$custom_settings['settings']['favorites_ipad57']['std'] = '';
$custom_settings['settings']['favorites_ipad72']['std'] = '';
$custom_settings['settings']['favorites_ipad114']['std'] = '';
$custom_settings['settings']['favorites_ipad144']['std'] = '';
$custom_settings['settings']['seo_publisher']['std'] = '';
$custom_settings['settings']['fb_publisher']['std'] = '';
$custom_settings['settings']['header_elements']['std'] = array (
  2 => 
  array (
    'title' => 'Search',
    'select_element' => 'content-text-html',
    'fullwidth' => 'off',
  ),
  0 => 
  array (
    'title' => 'Header',
    'select_element' => 'elements-bar',
    'fullwidth' => 'off',
  ),
  1 => 
  array (
    'title' => 'Breadcrumbs',
    'select_element' => 'elements-bar',
    'fullwidth' => 'off',
  ),
);
$custom_settings['settings']['footer_elements']['std'] = array (
  2 => 
  array (
    'title' => 'Shop Information',
    'select_element' => 'widget-section',
    'fullwidth' => 'off',
  ),
  3 => 
  array (
    'title' => 'Shop Widgets',
    'select_element' => 'widget-section',
    'fullwidth' => 'off',
  ),
  0 => 
  array (
    'title' => 'Footer',
    'select_element' => 'widget-section',
    'fullwidth' => 'off',
  ),
);
$custom_settings['settings']['content_padding']['std'] = '40px 0 60px';
$custom_settings['settings']['content_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => 'inc-lato',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '400',
  'letter-spacing' => '',
  'line-height' => '26px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['content_link']['std'] = '#107fc9';
$custom_settings['settings']['content_link_hover']['std'] = '#333333';
$custom_settings['settings']['content_separator']['std'] = '#aaaaaa';
$custom_settings['settings']['content_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['content_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['content_button_style']['std'] = 'filled';
$custom_settings['settings']['content_background']['std'] = '';
$custom_settings['settings']['content_boxshadow']['std'] = '';
$custom_settings['settings']['content_h1_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['content_h2_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '32px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['content_h3_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['content_h4_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '18px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['content_h5_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '17px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['content_h6_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '16px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['_wrapper_background']['std'] = '';
$custom_settings['settings']['_wrapper_boxshadow']['std'] = '';
$custom_settings['settings']['_header_background']['std'] = '';
$custom_settings['settings']['_header_boxshadow']['std'] = '';
$custom_settings['settings']['_footer_background']['std'] = '';
$custom_settings['settings']['_footer_boxshadow']['std'] = '';
$custom_settings['settings']['page_title']['std'] = 'content';
$custom_settings['settings']['page_comments']['std'] = 'on';
$custom_settings['settings']['blog_style']['std'] = 'full';
$custom_settings['settings']['post_comments']['std'] = 'on';
$custom_settings['settings']['404_image']['std'] = '';
$custom_settings['settings']['wrapper_padding']['std'] = '';
$custom_settings['settings']['wrapper_mode']['std'] = 'shopkit-central';
$custom_settings['settings']['wrapper_width']['std'] = '4096';
$custom_settings['settings']['inner_wrapper_width']['std'] = '1500';
$custom_settings['settings']['columns_margin']['std'] = '50';
$custom_settings['settings']['rows_margin']['std'] = '50';
$custom_settings['settings']['custom_css']['std'] = '#header_section .shopkit-section-left .shopkit-layout-element-separator {margin-left:19px;margin-right:2px;}
#header_section .shopkit-section-right {text-transform:uppercase;}';
$custom_settings['settings']['responsive_tablet_mode']['std'] = '1120';
$custom_settings['settings']['responsive_tablet_css']['std'] = '';
$custom_settings['settings']['responsive_mobile_mode']['std'] = '840';
$custom_settings['settings']['responsive_mobile_css']['std'] = '';
$custom_settings['settings']['sidebar_heading']['std'] = 'h4';
$custom_settings['settings']['left_sidebar_1']['std'] = 'off';
$custom_settings['settings']['left_sidebar_width_1']['std'] = '200';
$custom_settings['settings']['left_sidebar_2']['std'] = 'off';
$custom_settings['settings']['left_sidebar_width_2']['std'] = '200';
$custom_settings['settings']['right_sidebar_1']['std'] = 'on';
$custom_settings['settings']['right_sidebar_width_1']['std'] = '290';
$custom_settings['settings']['right_sidebar_1_visibility']['std'] = array (
  0 => 'shopkit-responsive-low',
);
$custom_settings['settings']['right_sidebar_2']['std'] = 'on';
$custom_settings['settings']['right_sidebar_width_2']['std'] = '290';
$custom_settings['settings']['right_sidebar_2_visibility']['std'] = array (
  0 => 'shopkit-responsive-low',
  1 => 'shopkit-responsive-medium',
);
$custom_settings['settings']['sidebars']['std'] = array (
  0 => 
  array (
    'title' => 'Single Product Layout',
    'display_condition' => 'is_product||is_cart||is_checkout||is_account_page',
    'left_sidebar_1' => 'off',
    'left_sidebar_width_1' => '200',
    'left_sidebar_2' => 'off',
    'left_sidebar_width_2' => '200',
    'right_sidebar_1' => 'on',
    'right_sidebar_width_1' => '290',
    'right_sidebar_1_visibility' => 
    array (
      0 => 'shopkit-responsive-low',
    ),
    'right_sidebar_2' => 'on',
    'right_sidebar_width_2' => '290',
    'right_sidebar_2_visibility' => 
    array (
      0 => 'shopkit-responsive-low',
      1 => 'shopkit-responsive-medium',
    ),
  ),
  1 => 
  array (
    'title' => 'WooCommerce Layout',
    'display_condition' => 'is_woocommerce',
    'left_sidebar_1' => 'on',
    'left_sidebar_width_1' => '300',
    'left_sidebar_2' => 'off',
    'left_sidebar_width_2' => '200',
    'right_sidebar_1' => 'off',
    'right_sidebar_width_1' => '200',
    'right_sidebar_2' => 'off',
    'right_sidebar_width_2' => '200',
  ),
);
$custom_settings['settings']['wc_columns']['std'] = '4';
$custom_settings['settings']['wc_category_columns']['std'] = '4';
$custom_settings['settings']['wc_per_page']['std'] = '8';
$custom_settings['settings']['wc_orderby']['std'] = 'shopkit-orderby-bc';
$custom_settings['settings']['wc_product_style']['std'] = 'none';
$custom_settings['settings']['wc_image_effect']['std'] = 'zoom';
$custom_settings['settings']['wc_shop_title']['std'] = 'off';
$custom_settings['settings']['wc_shop_rating']['std'] = 'off';
$custom_settings['settings']['wc_shop_price']['std'] = 'off';
$custom_settings['settings']['wc_shop_desc']['std'] = 'on';
$custom_settings['settings']['wc_shop_add_to_cart']['std'] = 'off';
$custom_settings['settings']['wc_image_position']['std'] = 'imageleft';
$custom_settings['settings']['wc_thumbnails_columns']['std'] = '4';
$custom_settings['settings']['wc_single_image_size']['std'] = '3';
$custom_settings['settings']['wc_upsell_columns']['std'] = '4';
$custom_settings['settings']['wc_related_columns']['std'] = '4';
$custom_settings['settings']['wc_product_sidebars']['std'] = 'off';
$custom_settings['settings']['wc_single_rating']['std'] = 'off';
$custom_settings['settings']['wc_single_price']['std'] = 'off';
$custom_settings['settings']['wc_single_desc']['std'] = 'off';
$custom_settings['settings']['wc_single_add_to_cart']['std'] = 'off';
$custom_settings['settings']['wc_single_meta']['std'] = 'off';
$custom_settings['settings']['wc_single_upsells']['std'] = 'off';
$custom_settings['settings']['wc_product_tabs']['std'] = 'off';
$custom_settings['settings']['wc_single_related']['std'] = 'off';
	return $custom_settings;

}
add_filter( 'shopkit_flat_general_settings_args', 'shopkit_flat_general_settings' );


function shopkit_flat_section_search_settings( $custom_settings ) {
$custom_settings['settings']['search_content']['std'] = '<h2>Search Products! <span style="color: #107fc9;">Easy Product Searches</span>, Bigger Conversions!</h2>
<p>WooCommerce Product Filter is all in one filter for every shop! It’s a must have for any WordPress and WooCommerce Online Store owner. This plugin extends your store by adding advanced filters that both you and your customers will love. Take your business to a higher level with this brilliant plugin. <strong>Exclusively included in ShopKit theme!</strong></p>
[prdctfltr_sc_products preset="directory-filter-preset" show_products="no" ajax="yes" action="' . esc_url( home_url() ) . '/shop/" bot_margin="0"]';
$custom_settings['settings']['search_padding']['std'] = '50px 0 50px';
$custom_settings['settings']['search_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['search_link']['std'] = '#107fc9';
$custom_settings['settings']['search_link_hover']['std'] = '#333333';
$custom_settings['settings']['search_separator']['std'] = '#aaaaaa';
$custom_settings['settings']['search_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['search_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['search_button_style']['std'] = 'filled';
$custom_settings['settings']['search_background']['std'] = array (
  'background-color' => '#f4f4f4',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);
$custom_settings['settings']['search_boxshadow']['std'] = '';
$custom_settings['settings']['search_h1_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['search_h2_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '32px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['search_h3_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['search_h4_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '18px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['search_h5_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '17px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['search_h6_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '16px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['search_type']['std'] = 'always-collapsed-with-trigger';
$custom_settings['settings']['search_type_height']['std'] = 'shopkit-height-30';
$custom_settings['settings']['search_condition']['std'] = '';
	return $custom_settings;

}
add_filter( 'shopkit_flat_section_search_args', 'shopkit_flat_section_search_settings' );


function shopkit_flat_section_header_settings( $custom_settings ) {
$custom_settings['settings']['header_elements_align']['std'] = 'shopkit-sections-leftright';
$custom_settings['settings']['header_elements_on_left']['std'] = array (
  0 => 
  array (
    'title' => 'Logo',
    'select_element' => 'logo',
    'text' => '',
    'social_network' => 'facebook',
    'icon' => 'line-icon',
    'woo_cart_icon' => 'line-icon',
    'image' => '',
    'image_hover' => '',
    'url' => '',
    'menu' => 'none',
    'menu_style' => 'shopkit-menu-nomargin',
    'menu_effect' => 'none',
    'menu_font' => '',
    'menu_font_hover' => '',
    'menu_background_active' => '',
    'menu_submenu_font' => '',
    'menu_submenu_font_hover' => '',
    'menu_submenu_background' => '',
    'menu_submenu_background_active' => '',
    'height' => 'shopkit-height-42',
    'class' => '',
  ),
  1 => 
  array (
    'title' => 'Site Title',
    'select_element' => 'site-title',
    'text' => '',
    'social_network' => 'facebook',
    'icon' => 'line-icon',
    'woo_cart_icon' => 'line-icon',
    'image' => '',
    'image_hover' => '',
    'url' => '',
    'menu' => 'none',
    'menu_style' => 'shopkit-menu-nomargin',
    'menu_effect' => 'none',
    'menu_font' => '',
    'menu_font_hover' => '',
    'menu_background_active' => '',
    'menu_submenu_font' => '',
    'menu_submenu_font_hover' => '',
    'menu_submenu_background' => '',
    'menu_submenu_background_active' => '',
    'height' => 'shopkit-height-30',
    'class' => '',
  ),
  4 => 
  array (
    'title' => 'Separator',
    'select_element' => 'separator',
    'text' => '',
    'social_network' => 'facebook',
    'icon' => 'line-icon',
    'woo_cart_icon' => 'line-icon',
    'image' => '',
    'image_hover' => '',
    'url' => '',
    'menu' => 'none',
    'menu_style' => 'shopkit-menu-nomargin',
    'menu_effect' => 'none',
    'menu_font' => '',
    'menu_font_hover' => '',
    'menu_background_active' => '',
    'menu_submenu_font' => '',
    'menu_submenu_font_hover' => '',
    'menu_submenu_background' => '',
    'menu_submenu_background_active' => '',
    'height' => 'shopkit-height-24',
    'class' => '',
  ),
  6 => 
  array (
    'title' => 'Search Trigger',
    'select_element' => 'image-link',
    'text' => '',
    'social_network' => 'facebook',
    'icon' => 'line-icon',
    'woo_cart_icon' => 'line-icon',
    'image' => preg_replace( '(^https?:)', '', esc_url( untrailingslashit( get_template_directory_uri() ) ) ) . '/demos/flat/images/products.svg',
    'image_hover' => preg_replace( '(^https?:)', '', esc_url( untrailingslashit( get_template_directory_uri() ) ) ) . '/demos/flat/images/products-hover.svg',
    'url' => '#',
    'menu' => 'none',
    'menu_style' => 'shopkit-menu-nomargin',
    'menu_effect' => 'none',
    'menu_font' => '',
    'menu_font_hover' => '',
    'menu_background_active' => '',
    'menu_submenu_font' => '',
    'menu_submenu_font_hover' => '',
    'menu_submenu_background' => '',
    'menu_submenu_background_active' => '',
    'height' => 'shopkit-height-48',
    'class' => 'shopkit-search-trigger',
  ),
  5 => 
  array (
    'title' => 'Menu',
    'select_element' => 'menu',
    'text' => '',
    'social_network' => 'facebook',
    'icon' => 'button',
    'woo_cart_icon' => 'line-icon',
    'image' => '',
    'image_hover' => '',
    'url' => '',
    'menu' => 'all-pages',
    'menu_style' => 'shopkit-menu-nomargin',
    'menu_effect' => 'sweep-to-right',
    'menu_font' => 
    array (
      'font-color' => '#222222',
      'font-family' => '',
      'font-size' => '',
      'font-style' => '',
      'font-variant' => '',
      'font-weight' => '800',
      'letter-spacing' => '0.01em',
      'line-height' => '',
      'text-decoration' => '',
      'text-transform' => 'uppercase',
    ),
    'menu_font_hover' => '#ffffff',
    'menu_background_active' => '#107fc9',
    'menu_submenu_font' => 
    array (
      'font-color' => '#222222',
      'font-family' => '',
      'font-size' => '',
      'font-style' => '',
      'font-variant' => '',
      'font-weight' => '',
      'letter-spacing' => '',
      'line-height' => '40px',
      'text-decoration' => '',
      'text-transform' => 'none',
    ),
    'menu_submenu_font_hover' => '#ffffff',
    'menu_submenu_background' => '#f4f4f4',
    'menu_submenu_background_active' => '#107fc9',
    'height' => 'shopkit-height-30',
    'class' => '',
  ),
);
$custom_settings['settings']['header_elements_on_right']['std'] = array (
  3 => 
  array (
    'title' => 'Login',
    'select_element' => 'login-registration',
    'text' => '',
    'social_network' => 'facebook',
    'icon' => 'text',
    'woo_cart_icon' => 'line-icon',
    'image' => '',
    'image_hover' => '',
    'url' => '',
    'menu' => 'none',
    'menu_style' => 'shopkit-menu-nomargin',
    'menu_effect' => 'none',
    'menu_font' => '',
    'menu_font_hover' => '',
    'menu_background_active' => '',
    'menu_submenu_font' => '',
    'menu_submenu_font_hover' => '',
    'menu_submenu_background' => '',
    'menu_submenu_background_active' => '',
    'height' => 'shopkit-height-30',
    'class' => '',
  ),
  4 => 
  array (
    'title' => 'Separator',
    'select_element' => 'separator',
    'text' => '',
    'social_network' => 'facebook',
    'icon' => 'line-icon',
    'woo_cart_icon' => 'line-icon',
    'image' => '',
    'image_hover' => '',
    'url' => '',
    'menu' => 'none',
    'menu_style' => 'shopkit-menu-nomargin',
    'menu_effect' => 'none',
    'menu_font' => '',
    'menu_font_hover' => '',
    'menu_background_active' => '',
    'menu_submenu_font' => '',
    'menu_submenu_font_hover' => '',
    'menu_submenu_background' => '',
    'menu_submenu_background_active' => '',
    'height' => 'shopkit-height-24',
    'class' => '',
  ),
  2 => 
  array (
    'title' => 'Cart',
    'select_element' => 'woo-cart',
    'text' => '',
    'social_network' => 'facebook',
    'icon' => 'line-icon',
    'woo_cart_icon' => 'text',
    'image' => '',
    'image_hover' => '',
    'url' => '',
    'menu' => 'none',
    'menu_style' => 'shopkit-menu-nomargin',
    'menu_effect' => 'none',
    'menu_font' => '',
    'menu_font_hover' => '',
    'menu_background_active' => '',
    'menu_submenu_font' => '',
    'menu_submenu_font_hover' => '',
    'menu_submenu_background' => '',
    'menu_submenu_background_active' => '',
    'height' => 'shopkit-height-30',
    'class' => '',
  ),
);
$custom_settings['settings']['header_outer_elements_align']['std'] = 'middle';
$custom_settings['settings']['header_inner_elements_align']['std'] = 'middle';
$custom_settings['settings']['header_padding']['std'] = '20px 0';
$custom_settings['settings']['header_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['header_link']['std'] = '#107fc9';
$custom_settings['settings']['header_link_hover']['std'] = '#333333';
$custom_settings['settings']['header_separator']['std'] = '#aaaaaa';
$custom_settings['settings']['header_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['header_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['header_button_style']['std'] = 'filled';
$custom_settings['settings']['header_background']['std'] = '';
$custom_settings['settings']['header_boxshadow']['std'] = '';
$custom_settings['settings']['header_h1_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['header_h2_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '32px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['header_h3_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['header_h4_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '18px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['header_h5_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '17px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['header_h6_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '16px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['header_type']['std'] = 'normal';
$custom_settings['settings']['header_type_height']['std'] = 'shopkit-height-30';
$custom_settings['settings']['header_condition']['std'] = '';
	return $custom_settings;

}
add_filter( 'shopkit_flat_section_header_args', 'shopkit_flat_section_header_settings' );


function shopkit_flat_section_breadcrumbs_settings( $custom_settings ) {
$custom_settings['settings']['breadcrumbs_elements_align']['std'] = 'shopkit-sections-leftright';
$custom_settings['settings']['breadcrumbs_elements_on_left']['std'] = array (
  0 => 
  array (
    'title' => 'Breadcrumbs',
    'select_element' => 'breadcrumbs',
    'text' => '',
    'social_network' => 'facebook',
    'icon' => 'line-icon',
    'woo_cart_icon' => 'line-icon',
    'image' => '',
    'image_hover' => '',
    'url' => '',
    'menu' => 'none',
    'menu_style' => 'shopkit-menu-nomargin',
    'menu_effect' => 'none',
    'menu_font' => '',
    'menu_font_hover' => '',
    'menu_background_active' => '',
    'menu_submenu_font' => '',
    'menu_submenu_font_hover' => '',
    'menu_submenu_background' => '',
    'menu_submenu_background_active' => '',
    'height' => 'shopkit-height-30',
    'class' => '',
  ),
);
$custom_settings['settings']['breadcrumbs_outer_elements_align']['std'] = 'middle';
$custom_settings['settings']['breadcrumbs_inner_elements_align']['std'] = 'middle';
$custom_settings['settings']['breadcrumbs_padding']['std'] = '5px 0';
$custom_settings['settings']['breadcrumbs_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['breadcrumbs_link']['std'] = '#107fc9';
$custom_settings['settings']['breadcrumbs_link_hover']['std'] = '#333333';
$custom_settings['settings']['breadcrumbs_separator']['std'] = '#aaaaaa';
$custom_settings['settings']['breadcrumbs_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['breadcrumbs_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['breadcrumbs_button_style']['std'] = 'filled';
$custom_settings['settings']['breadcrumbs_background']['std'] = array (
  'background-color' => '#f4f4f4',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);
$custom_settings['settings']['breadcrumbs_boxshadow']['std'] = '';
$custom_settings['settings']['breadcrumbs_h1_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['breadcrumbs_h2_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '32px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['breadcrumbs_h3_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['breadcrumbs_h4_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '18px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['breadcrumbs_h5_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '17px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['breadcrumbs_h6_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '16px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['breadcrumbs_type']['std'] = 'normal';
$custom_settings['settings']['breadcrumbs_type_height']['std'] = 'shopkit-height-30';
$custom_settings['settings']['breadcrumbs_condition']['std'] = '!is_front_page';
	return $custom_settings;

}
add_filter( 'shopkit_flat_section_breadcrumbs_args', 'shopkit_flat_section_breadcrumbs_settings' );


function shopkit_flat_section_shop_information_settings( $custom_settings ) {
$custom_settings['settings']['shop_information_sidebar_heading']['std'] = 'h3';
$custom_settings['settings']['shop_information_rows']['std'] = array (
  0 => 
  array (
    'title' => 'Shop Information Row',
    'select_element' => 'widget-4-columns-4',
  ),
);
$custom_settings['settings']['shop_information_padding']['std'] = '20px 0 0';
$custom_settings['settings']['shop_information_font']['std'] = array (
  'font-color' => '#bbbbbb',
  'font-family' => '',
  'font-size' => '12px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '18px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_information_link']['std'] = '#107fc9';
$custom_settings['settings']['shop_information_link_hover']['std'] = '#333333';
$custom_settings['settings']['shop_information_separator']['std'] = '#aaaaaa';
$custom_settings['settings']['shop_information_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_information_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_information_button_style']['std'] = 'filled';
$custom_settings['settings']['shop_information_background']['std'] = '';
$custom_settings['settings']['shop_information_boxshadow']['std'] = '';
$custom_settings['settings']['shop_information_h1_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_information_h2_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '32px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_information_h3_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_information_h4_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '16px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '20px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_information_h5_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '20px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_information_h6_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '12px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '20px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_information_margin_override']['std'] = 'off';
$custom_settings['settings']['shop_information_columns_margin']['std'] = '30';
$custom_settings['settings']['shop_information_rows_margin']['std'] = '60';
$custom_settings['settings']['shop_information_type']['std'] = 'normal';
$custom_settings['settings']['shop_information_type_height']['std'] = 'shopkit-height-30';
$custom_settings['settings']['shop_information_condition']['std'] = 'is_woocommerce';
	return $custom_settings;

}
add_filter( 'shopkit_flat_section_shop_information_args', 'shopkit_flat_section_shop_information_settings' );


function shopkit_flat_section_shop_widgets_settings( $custom_settings ) {
$custom_settings['settings']['shop_widgets_sidebar_heading']['std'] = 'h4';
$custom_settings['settings']['shop_widgets_rows']['std'] = array (
  0 => 
  array (
    'title' => 'Product Widgets',
    'select_element' => 'widget-4-columns-4',
    'element_visibility' => 
    array (
      0 => 'shopkit-responsive-low',
    ),
  ),
);
$custom_settings['settings']['shop_widgets_padding']['std'] = '60px 0 0';
$custom_settings['settings']['shop_widgets_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_widgets_link']['std'] = '#222222';
$custom_settings['settings']['shop_widgets_link_hover']['std'] = '#107fc9';
$custom_settings['settings']['shop_widgets_separator']['std'] = '#bbbbbb';
$custom_settings['settings']['shop_widgets_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_widgets_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_widgets_button_style']['std'] = 'filled';
$custom_settings['settings']['shop_widgets_background']['std'] = array (
  'background-color' => '#fafafa',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);
$custom_settings['settings']['shop_widgets_boxshadow']['std'] = '';
$custom_settings['settings']['shop_widgets_h1_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '42px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_widgets_h2_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '30px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_widgets_h3_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_widgets_h4_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => 'uppercase',
);
$custom_settings['settings']['shop_widgets_h5_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '13px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_widgets_h6_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '12px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['shop_widgets_margin_override']['std'] = 'off';
$custom_settings['settings']['shop_widgets_columns_margin']['std'] = '30';
$custom_settings['settings']['shop_widgets_rows_margin']['std'] = '60';
$custom_settings['settings']['shop_widgets_type']['std'] = 'normal';
$custom_settings['settings']['shop_widgets_type_height']['std'] = 'shopkit-height-30';
$custom_settings['settings']['shop_widgets_condition']['std'] = 'is_woocommerce';
	return $custom_settings;

}
add_filter( 'shopkit_flat_section_shop_widgets_args', 'shopkit_flat_section_shop_widgets_settings' );


function shopkit_flat_section_footer_settings( $custom_settings ) {
$custom_settings['settings']['footer_sidebar_heading']['std'] = 'h4';
$custom_settings['settings']['footer_rows']['std'] = array (
  1 => 
  array (
    'title' => 'Footer #1',
    'select_element' => 'widget-4-columns-4',
  ),
  0 => 
  array (
    'title' => 'Footer #2',
    'select_element' => 'widget-7-columns-3',
  ),
);
$custom_settings['settings']['footer_padding']['std'] = '60px 0 10px';
$custom_settings['settings']['footer_font']['std'] = array (
  'font-color' => '#222222',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['footer_link']['std'] = '#107fc9';
$custom_settings['settings']['footer_link_hover']['std'] = '#333333';
$custom_settings['settings']['footer_separator']['std'] = '#eeeeee';
$custom_settings['settings']['footer_button_font']['std'] = array (
  'font-color' => '#222222',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['footer_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['footer_button_style']['std'] = 'filled';
$custom_settings['settings']['footer_background']['std'] = array (
  'background-color' => '#ffffff',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);
$custom_settings['settings']['footer_boxshadow']['std'] = array (
  'inset' => 'inset',
  'offset-x' => '0',
  'offset-y' => '1px',
  'blur-radius' => '0',
  'spread-radius' => '0',
  'color' => '#aaaaaa',
);
$custom_settings['settings']['footer_h1_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '42px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['footer_h2_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '11px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['footer_h3_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['footer_h4_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => 'uppercase',
);
$custom_settings['settings']['footer_h5_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '13px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['footer_h6_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '12px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => 'inherit',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);
$custom_settings['settings']['footer_margin_override']['std'] = 'off';
$custom_settings['settings']['footer_columns_margin']['std'] = '30';
$custom_settings['settings']['footer_rows_margin']['std'] = '60';
$custom_settings['settings']['footer_type']['std'] = 'normal';
$custom_settings['settings']['footer_type_height']['std'] = 'shopkit-height-30';
$custom_settings['settings']['footer_condition']['std'] = '';

return $custom_settings;

}
add_filter( 'shopkit_flat_section_footer_args', 'shopkit_flat_section_footer_settings' );

function shopkit_flat_activate() {

	if ( ( $thememod = get_theme_mod( 'shopkit_demo_installed' ) ) === false && get_option( 'shopkit_demo_installed', false ) ) {

		$widgets = array ( 'wp_inactive_widgets'=> array ( 0=> 'text-18', 1=> 'text-19', 2=> 'text-20', 3=> 'nav_menu-10', 4=> 'nav_menu-11', 5=> 'nav_menu-12', 6=> 'text-15', 7=> 'text-16', 8=> 'prdctfltr-3', 9=> 'prdctfltr-4', ), 'sidebar-1'=> array (), 'sidebar-2'=> array (), 'sidebar-3'=> array ( 0=> 'woocommerce_top_rated_products-3', 1=> 'woocommerce_product_tag_cloud-2', 2=> 'woocommerce_product_search-2', 3=> 'woocommerce_recently_viewed_products-2', ), 'sidebar-4'=> array ( 0=> 'text-9', 1=> 'search-3', 2=> 'recent-posts-3', 3=> 'recent-comments-3', 4=> 'tag_cloud-2', ), 'shop-information-1'=> array ( 0=> 'text-10', ), 'shop-information-2'=> array ( 0=> 'text-11', ), 'shop-information-3'=> array ( 0=> 'text-12', ), 'shop-information-4'=> array ( 0=> 'text-13', ), 'shop-widgets-1'=> array ( 0=> 'woocommerce_products-2', ), 'shop-widgets-2'=> array ( 0=> 'woocommerce_top_rated_products-2', ), 'shop-widgets-3'=> array ( 0=> 'woocommerce_products-3', ), 'shop-widgets-4'=> array ( 0=> 'woocommerce_products-4', ), 'footer-1'=> array ( 0=> 'text-2', ), 'footer-2'=> array ( 0=> 'text-3', ), 'footer-3'=> array ( 0=> 'text-4', ), 'footer-4'=> array ( 0=> 'text-5', ), 'footer-5'=> array ( 0=> 'text-6', ), 'footer-6'=> array ( 0=> 'text-7', ), 'footer-7'=> array ( 0=> 'text-8', ), 'shopkit-cl-single-product-layout-3'=> array ( 0=> 'woocommerce_product_categories-2', 1=> 'woocommerce_top_rated_products-4', 2=> 'woocommerce_recent_reviews-2', 3=> 'woocommerce_recently_viewed_products-3', ), 'shopkit-cl-single-product-layout-4'=> array ( 0=> 'text-14', 1=> 'woocommerce_products-5', 2=> 'woocommerce_product_tag_cloud-4', 3=> 'woocommerce_product_search-3', ), 'shopkit-cl-woocommerce-layout-1'=> array ( 0=> 'text-17', 1=> 'prdctfltr-5', ), 'orphaned_widgets_1'=> array () );

		update_option( 'sidebars_widgets', $widgets );
		set_theme_mod( 'shopkit_demo_installed', time() );

	}

}
add_action( 'after_switch_theme', 'shopkit_flat_activate' );

?>