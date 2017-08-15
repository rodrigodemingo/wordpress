<?php
/*
* Plugin Name: WooCommerce Single Product Page Builder
* Plugin URI: http://sitesao.com/
* Description: Woocommerce single product page builder for Visual Composer plugin and Cornerstone plugin
* Version: 3.0.7
* Author: SiteSao Team
* Author URI: http://sitesao.com/
* License: License GNU General Public License version 2 or later;
* Copyright 2013  SiteSao
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!defined('DHVC_WOO_PAGE'))
	define('DHVC_WOO_PAGE','dhvc-woocommerce-page');

if(!defined('DHVC_WOO_PAGE_VERSION'))
	define('DHVC_WOO_PAGE_VERSION','3.0.7');

if(!defined('DHVC_WOO_PAGE_URL'))
	define('DHVC_WOO_PAGE_URL',untrailingslashit( plugins_url( '/', __FILE__ ) ));

if(!defined('DHVC_WOO_PAGE_DIR'))
	define('DHVC_WOO_PAGE_DIR',untrailingslashit( plugin_dir_path( __FILE__ ) ));


if(!class_exists('DHVC_Woo_Page')):

global $dhvc_single_product_template_id,$dhvc_single_product_template;

class DHVC_Woo_Page{
	
	protected $_shortcode_class;
	protected static $_instance = null;
	
	public function __construct(){
		add_action('init',array(&$this,'init'));
		
		if(!function_exists('is_plugin_active'))
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) && is_plugin_active('cornerstone/cornerstone.php')) {
			require_once DHVC_WOO_PAGE_DIR.'/includes/cornerstone.php';
		}
	}
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function get_shortcode_class(){
		return $this->_shortcode_class;
	}
	
	public function init(){
		load_plugin_textdomain( DHVC_WOO_PAGE, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		wp_register_style('dhvc-woo-page-chosen', DHVC_WOO_PAGE_URL.'/assets/css/chosen.min.css');
		
		if(!defined('WOOCOMMERCE_VERSION')){
			add_action('admin_notices', array(&$this,'woocommerce_notice'));
			return;
		}
		
		require_once DHVC_WOO_PAGE_DIR.'/includes/functions.php';
		require_once DHVC_WOO_PAGE_DIR.'/includes/shortcode.php';
		$this->_shortcode_class = new DHVC_Woo_Page_Shortcode();
		$this->_shortcode_class->add_shortcodes();
		
		if(defined('WPB_VC_VERSION') || class_exists('Cornerstone_Plugin',false)){
			
			if ( defined( 'WPB_VC_VERSION' ) ) {
					
				require_once DHVC_WOO_PAGE_DIR.'/includes/visual-composer.php';
					
				$params_script = DHVC_WOO_PAGE_URL.'/assets/js/params.js';
				vc_add_shortcode_param ( 'dhvc_woo_product_page_field_categories', 'dhvc_woo_product_page_setting_field_categories',$params_script);
				vc_add_shortcode_param ( 'dhvc_woo_product_page_field_products_ajax', 'dhvc_woo_product_page_setting_field_products_ajax',$params_script);
			}
		}else{
			add_action('admin_notices', array(&$this,'notice'));
			return;
		}
		
		
		if(is_admin()):
			require_once DHVC_WOO_PAGE_DIR.'/includes/admin.php';
		else:
			add_action( 'template_redirect', array( &$this, 'get_register_single_product_template' ) );
			add_action( 'template_redirect', array( &$this, 'register_assets' ) );
			add_action(	'wp_enqueue_scripts', array(&$this, 'frontend_assets'));
			add_filter(	'wc_get_template_part', array(&$this,'wc_get_template_part'),50,3);
			add_action( 'admin_bar_menu', array(
				&$this,
				'adminBarEditLink',
			), 1000 );
			if(apply_filters('dhvc_woocommerce_page_use_custom_single_product_template',false))
				add_filter( 'template_include', array( &$this, 'template_loader' ),50 );
		endif;

	}
	
	public function register_assets(){
		wp_register_style('dhvc-woocommerce-page-awesome', DHVC_WOO_PAGE_URL.'/assets/fonts/awesome/css/font-awesome.min.css',array(),'4.0.3');
		wp_register_style('dhvc-woocommerce-page', DHVC_WOO_PAGE_URL.'/assets/css/style.css',array(),DHVC_WOO_PAGE_VERSION);
	}
	
	public function frontend_assets(){
		wp_enqueue_style('js_composer_front');
		wp_enqueue_style('js_composer_custom_css');
		wp_enqueue_style('dhvc-woocommerce-page-awesome');
		wp_enqueue_style('dhvc-woocommerce-page');
	}
	
	protected function has_wc_single_product_shortcode(){
		global $shortcode_tags;	
		foreach ($this->_shortcode_class->get_shortcodes() as $shortcode=>$fnc)
			if(array_key_exists( $shortcode, $shortcode_tags ))
				return true;
		
		return false;
	}
	
	public function get_register_single_product_template(){
		global $post,$dhvc_single_product_template_id;
		
		if(empty($post))
			return;
		
		$product_template_id = apply_filters('dhvc_woocommerce_page_default_template_id', 0);
		
		if($dhvc_woo_page_product = get_post_meta($post->ID,'dhvc_woo_page_product',true)):
			$product_template_id = $dhvc_woo_page_product;
		else:
			$terms = wp_get_post_terms( $post->ID, 'product_cat' );
			foreach ( $terms as $term ):
				if($dhvc_woo_page_cat_product = get_woocommerce_term_meta($term->term_id,'dhvc_woo_page_cat_product',true)):
					$product_template_id = $dhvc_woo_page_cat_product;
				endif;
			endforeach;
		endif;
		
		$product_template_id = apply_filters('dhvc_woocommerce_page_template_id', $product_template_id);
		
		if(!empty($product_template_id)){
			$dhvc_single_product_template_id = $product_template_id;
		}
		
		
		do_action('dhvc_woocommerce_page_register_single',$product_template_id);
		
		return $product_template_id;
	}
	
	public function template_loader( $template ) {
		global $dhvc_single_product_template_id;
		if ( is_singular('product')) {
			$find = array();
			if(empty($dhvc_single_product_template_id))
				$dhvc_single_product_template_id = $this->get_register_single_product_template();
			$file 	= 'single-product.php';
			$find[] = 'dhvc-woocommerce-page/'.$file;
			if($dhvc_single_product_template = get_post($dhvc_single_product_template_id)){
				$template       = locate_template( $find );
				$status_options = get_option( 'woocommerce_status_options', array() );
				if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) )
					$template = $this->get_plugin_dir() . '/templates/' . $file;
					
				return $template;
			}
		}
		return $template;
	}
	
	public function wc_get_template_part($template, $slug, $name){
		global $post,$dhvc_single_product_template,$dhvc_single_product_template_id;
		if(empty($dhvc_single_product_template_id))
			$dhvc_single_product_template_id = $this->get_register_single_product_template();
		if($slug === 'content' && $name === apply_filters('dhvc_woocommerce_page_single_product_temp_name', 'single-product')){
			do_action('dhvc_woocommerce_page_before_override');
			
			$file 	= 'content-single-product.php';
			$find[] = 'dhvc-woocommerce-page/' . $file;
			if(!empty($dhvc_single_product_template_id)){
				if($wpb_custom_css = get_post_meta( $dhvc_single_product_template_id, '_wpb_post_custom_css', true )){
					echo '<style type="text/css">'.$wpb_custom_css.'</style>';
				}
				if($wpb_shortcodes_custom_css = get_post_meta( $dhvc_single_product_template_id, '_wpb_shortcodes_custom_css', true )){
					echo '<style type="text/css">'.$wpb_shortcodes_custom_css.'</style>';
				}
				$dhvc_single_product_template = get_post($dhvc_single_product_template_id);
				if(class_exists('Ultimate_VC_Addons')){
					$backup_post = $post;
					$post  = $dhvc_single_product_template;
					$Ultimate_VC_Addons = new Ultimate_VC_Addons;
					$Ultimate_VC_Addons->aio_front_scripts();
					$post = $backup_post;
				}
				if($dhvc_single_product_template){
					$template       = locate_template( $find );
					if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) )
						$template = $this->get_plugin_dir() . '/templates/' . $file;
						
					return $template;
				}
			}
			do_action('dhvc_woocommerce_page_after_override');
		}
		return $template;
	}
	
	public function notice(){
		$plugin = get_plugin_data(__FILE__);
		echo '<div class="updated">
			    <p>' . sprintf(__('<strong>%s</strong> requires <strong><a href="codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=Sitesao" target="_blank">Visual Composer</a></strong> plugin or <a href="http://codecanyon.net/item/cornerstone-the-wordpress-page-builder/15518868?ref=Sitesao" target="_blank">Cornerstone</a> plugin to be installed and activated on your site.', DHVC_WOO_PAGE), $plugin['Name']) . '</p>
			  </div>';
	}
	
	public function woocommerce_notice(){
		$plugin = get_plugin_data(__FILE__);
		echo '
			  <div class="updated">
			    <p>' . sprintf(__('<strong>%s</strong> requires <strong><a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a></strong> plugin to be installed and activated on your site.', DHVC_WOO_PAGE), $plugin['Name']) . '</p>
			  </div>';
	}
	
	public function adminBarEditLink($wp_admin_bar){
		global $dhvc_single_product_template_id;
		if ( ! is_object( $wp_admin_bar ) ) {
			global $wp_admin_bar;
		}
		if ( is_singular('product') ) {
			if ( !empty($dhvc_single_product_template_id) ) {
				$wp_admin_bar->add_menu( array(
					'id' => 'dhvc_woo_product_page-admin-bar-link',
					'title' => __( 'Edit Custom Product Template', DHVC_WOO_PAGE ),
					'href' => get_edit_post_link($dhvc_single_product_template_id),
					'meta' => array( 'target' => '_blank' ),
				) );
			}
		}
	}
	
	public function get_plugin_url(){
		return DHVC_WOO_PAGE_URL;
	}
	
	public function get_plugin_dir(){
		return DHVC_WOO_PAGE_DIR;
	}
	
}

new DHVC_Woo_Page();

endif;