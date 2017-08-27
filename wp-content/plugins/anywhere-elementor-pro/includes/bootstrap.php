<?php

namespace Aepro;

use Elementor;
use Elementor\Controls_Manager;

class Aepro{

    private static $_instance = null;

    public $_hook_positions = array();

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function init(){

        add_post_type_support( 'ae_global_templates', 'elementor' );
        add_filter( 'widget_text', 'do_shortcode' );
    }

    /**
     * Plugin constructor.
     */
    private function __construct() {

        $this->load_hook_positions();

        $this->_includes();

        add_action( 'init', [ $this, 'init' ] );
        add_action( 'plugins_loaded', [ $this, '_plugins_loaded' ] );
        add_action( 'elementor/init',[ $this, 'elementor_loaded']);

        // for frontend scripts & styles
        add_action( 'wp_enqueue_scripts', [ $this, '_enqueue_scripts' ]);

        // elementor editor scripts & styles
        add_action('elementor/editor/wp_head', [$this, '_editor_enqueue_scripts']);


        // for admin scripts & styles
        add_action( 'admin_enqueue_scripts', [ $this, '_admin_enqueue_scripts' ]);


        add_action( 'elementor/widgets/widgets_registered', [$this, 'elementor_widget_registered']);


        add_filter( 'manage_ae_global_templates_posts_columns', [$this,'set_custom_edit_ae_global_templates_posts_columns'] );
        add_action( 'manage_ae_global_templates_posts_custom_column' , [$this, 'add_ae_global_templates_columns'], 10, 2 );
        add_filter( 'ae_pro_filter_hook_positions', [$this, 'theme_hooks']);


        // woo template hook
        add_filter( 'wc_get_template_part', [$this, 'load_wc_layout'],10,3 );

        // woo scripts setup
        add_action( 'template_redirect', [$this, 'ae_woo_setup'] );

        add_action( 'after_setup_theme', [$this, 'editor_woo_scripts'] );

        // TODO:: Do this only if product page is using AE Template
        add_filter( 'woocommerce_enqueue_styles', [$this, 'load_wc_styles'], 99, 1 );


        add_action('woocommerce_init', [ $this, 'woo_init']);

    }

    public function woo_init(){
        \WC_Frontend_Scripts::load_scripts();
        wp_enqueue_script( 'wc-single-product' );
        wp_enqueue_script( 'wc-product-gallery-zoom' );
        wp_enqueue_script( 'flexslider' );
        wp_enqueue_script( 'photoswipe-ui-default' );
        wp_enqueue_style('photoswipe-default-skin');
        add_action( 'wp_footer', 'woocommerce_photoswipe' );


        if(isset($_REQUEST['ae_global_templates'])){

            add_theme_support( 'wc-product-gallery-zoom' );
            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );
        }
    }

    public function load_wc_styles($styles){
        return $styles;
    }

    function _editor_enqueue_scripts(){

        wp_enqueue_script('aepro-editor-js',AE_PRO_URL.'includes/assets/js/editor.js',array('jquery') );
        wp_localize_script('aepro-editor-js','aepro',array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));

        wp_enqueue_style('vegas-css',AE_PRO_URL.'includes/assets/lib/vegas/vegas.min.css' );
        wp_enqueue_script('vegas',AE_PRO_URL.'includes/assets/lib/vegas/vegas.min.js',array('jquery'),'1.0', true);
        wp_enqueue_script('ae-elementor-editor-js',AE_PRO_URL.'includes/assets/js/common.js', array('jquery'), '1.0');
        $localize_data = array(
            'plugin_url' => plugins_url('anywhere-elementor-pro')
        );
        wp_localize_script( 'ae-elementor-editor-js', 'aepro_editor', $localize_data );


        wp_enqueue_script('ae-swiper',AE_PRO_URL.'includes/assets/lib/swiper/js/swiper.js',array('jquery'),'1.0',true);
        wp_enqueue_style('ae-swiper',AE_PRO_URL.'includes/assets/lib/swiper/css/swiper.css');
    }


    public function theme_hooks($hook_positions){
        if(class_exists('Aepro\Ae_Theme')){
            $theme_obj = new Ae_Theme();
            $hook_positions = $theme_obj->theme_hooks($hook_positions);
        }
        return $hook_positions;
    }




   public function set_custom_edit_ae_global_templates_posts_columns($columns) {
        //unset( $columns['author'] );
        $columns['ae_shortcode_column'] = __( 'Shortcode', 'ae_pro' );
        $columns['ae_global_template_column'] = __( 'Is Global', 'ae_pro' );
        $columns['ae_render_mode_column'] = __( 'Render Mode', 'ae_pro' );
        return $columns;
    }
    public function add_ae_global_templates_columns( $column, $post_id ) {

        switch ( $column ) {

            case 'ae_shortcode_column' :
                echo '<input type=\'text\' class=\'widefat\' value=\'[INSERT_ELEMENTOR id="'.$post_id.'"]\' readonly="">';
                break;

            case 'ae_global_template_column' :
                $is_global = get_post_meta( $post_id , 'ae_apply_global' , true );
                if(!empty($is_global)){
                    echo '<span class="dashicons dashicons-star-filled" style="color:#ffd71c;"></span>';
                }
                break;

            case 'ae_render_mode_column' :
                $helper = new Helper();
                $render_mode = get_post_meta( $post_id , 'ae_render_mode' , true );
                if(!empty($render_mode)){
                    $render_modes = $helper->get_ae_render_mode_hook();

                    if(isset($render_modes[$render_mode])){
                        echo $render_modes[$render_mode];
                    }else{
                        echo '<span style="color:#ff6033">' .$render_mode.'</span>';
                    }

                }
                break;
        }
    }

    public function _plugins_loaded(){

        require_once AE_PRO_PATH.'includes/admin/butterbean/butterbean.php';

        require_once AE_PRO_PATH.'includes/controls/control-manager.php';
    }

    private function _includes(){
        global $ae_template;

        if(file_exists(AE_PRO_PATH.'includes/themes/'.$ae_template.'/Ae_Theme.php')){
            require_once AE_PRO_PATH.'includes/themes/'.$ae_template.'/Ae_Theme.php';
        }else{
            do_action('ae_external_theme_support');
        }


        // controls on existing elements

        require_once AE_PRO_PATH.'includes/controls/featured-bg.php';

        // Todo :: load only one frontend
        require_once AE_PRO_PATH.'includes/frontend.php';

        require_once AE_PRO_PATH.'includes/post_helper.php';
        require_once AE_PRO_PATH.'includes/rules.php';

        require_once AE_PRO_PATH.'includes/helper.php';
        require_once AE_PRO_PATH.'includes/post-type.php';
        require_once AE_PRO_PATH.'includes/admin/metaboxes.php';
		require_once AE_PRO_PATH.'includes/elements/bg-slider.php';

        if(is_admin()){
            require_once AE_PRO_PATH.'includes/license/admin.php';
        }


        if($this->licence_activated()){
            require_once AE_PRO_PATH.'includes/license/wp-updates-plugin.php';
            new AE_Updater( 'http://wp-updates.com/api/2/plugin',plugin_basename(AE_PRO_PATH.'anywhere-elementor-pro.php') );
        }


    }

    public function licence_activated(){
        return true;
    }

    public function _enqueue_scripts(){
        wp_enqueue_style('ae-pro-css',AE_PRO_URL.'includes/assets/css/ae-pro.css');
        wp_enqueue_script('ae-pro-js',AE_PRO_URL.'includes/assets/js/ae-pro.js', array('jquery'),'1.0', true);
        wp_enqueue_script('aepro-editor-js',AE_PRO_URL.'includes/assets/js/common.js', array('jquery'), '1.0');
		wp_enqueue_style('vegas-css',AE_PRO_URL.'includes/assets/lib/vegas/vegas.css' );
        wp_enqueue_script('vegas',AE_PRO_URL.'includes/assets/lib/vegas/vegas.js',array('jquery'),'1.0', true);
        $helper = new Helper();
        $post_css = $helper->ae_get_post_css();
        wp_add_inline_style('ae-pro-css',$post_css);
        wp_add_inline_style('ae-pro-css',$post_css);


        wp_enqueue_script( 'wc-single-product' );
        wp_enqueue_style( 'woocommerce-general' );

        wp_localize_script('ae-pro-js','aepro',array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
		$localize_data = array(
            'plugin_url' => plugins_url('anywhere-elementor-pro')
        );
        wp_localize_script( 'aepro-editor-js', 'aepro_editor', $localize_data );

        wp_register_script('ae-swiper',AE_PRO_URL.'includes/assets/lib/swiper/js/swiper.js',array('jquery'),'1.0',true);
        wp_enqueue_style('ae-swiper',AE_PRO_URL.'includes/assets/lib/swiper/css/swiper.css');


    }

    public function _admin_enqueue_scripts(){
        wp_enqueue_script('ae-admin-js',AE_PRO_URL.'includes/admin/admin-scripts.js', array(), '1.0');
    }

    public function load_hook_positions(){
        $hook_positions = array(
            '' => esc_html__('None','ae-pro'),
            'custom' => esc_html__('Custom','ae_pro'),
        );
        $this->_hook_positions = $hook_positions;

    }

    public function get_hook_positions(){
        return $this->_hook_positions;
    }

    public function elementor_loaded(){
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'ae-template-elements',
            [
                'title'  => 'AE Template Elements',
                'icon' => 'fa fa-plug'
            ],
            1
        );


    }

    public function load_wc_layout($template,$slug,$name){

        global $product, $ae_template;
        $helper = new Helper();
        $ae_wc_template = '';

        if($slug == 'content' && $name == 'single-product'){
            $ae_wc_template = $helper->get_ae_active_post_template($product->get_id(),'product');
                if($ae_wc_template != '' && is_numeric($ae_wc_template)){
                    $ae_wc_path =  AE_PRO_PATH.'includes/wc/ae-wc-single.php';
                    return $ae_wc_path;
                }
        }


        if($slug == 'content' && $name == 'product'){
            $ae_wc_template = $helper->get_woo_archive_template();

            if($ae_wc_template != '' && is_numeric($ae_wc_template)){
                if($helper->is_full_override($ae_wc_template)){
                    $ae_theme = new Ae_Theme();
                    $ae_theme->_override = 'full';

                    $ae_theme->_use_canvas = $helper->is_canvas_enabled($ae_wc_template);
                    $ae_wc_path = $ae_theme->load_archive_template($template);
                }else{
                    $ae_wc_path =  AE_PRO_PATH.'includes/wc/ae-wc-archive.php';
                }

                return $ae_wc_path;
            }
        }



        return $template;
    }

    public function elementor_widget_registered()
    {
        require_once AE_PRO_PATH . 'includes/elements/post-title.php';
        require_once AE_PRO_PATH . 'includes/elements/post-navigation.php';
        require_once AE_PRO_PATH . 'includes/elements/post-thumbnail.php';
        require_once AE_PRO_PATH . 'includes/elements/post-content.php';
        require_once AE_PRO_PATH . 'includes/elements/post-readmore.php';
        require_once AE_PRO_PATH . 'includes/elements/post-meta.php';
		//require_once AE_PRO_PATH . 'includes/elements/avatar.php';
		//require_once AE_PRO_PATH . 'includes/elements/author-bio.php';
        require_once AE_PRO_PATH . 'includes/elements/post-custom-taxonomy.php';
        require_once AE_PRO_PATH . 'includes/elements/post-custom-field.php';
		require_once AE_PRO_PATH . 'includes/elements/post-blocks.php';
		require_once AE_PRO_PATH . 'includes/elements/author.php';
		require_once AE_PRO_PATH . 'includes/elements/post-comments.php';

        // Todo:: Load only when acfpro is active
        require_once AE_PRO_PATH . 'includes/elements/Skins/acf-gallery/skin-base.php';
       // require_once AE_PRO_PATH . 'includes/elements/Skins/acf-gallery/skin-carousel.php';
       // require_once AE_PRO_PATH . 'includes/elements/Skins/acf-gallery/skin-slider.php';
        require_once AE_PRO_PATH . 'includes/elements/Skins/acf-gallery/grid-view.php';
        require_once AE_PRO_PATH . 'includes/elements/acf-gallery.php';


        if (class_exists('WooCommerce')) {
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-title.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-price.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-sku.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-content.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-readmore.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-add-to-cart.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-stock-status.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-rating.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-category.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-tags.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-product-image-gallery.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-tabs.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-notices.php';

            require_once AE_PRO_PATH . 'includes/elements/Skins/woo-products/skin-base.php';
         // require_once AE_PRO_PATH . 'includes/elements/Skins/woo-products/skin-carousel.php';
            require_once AE_PRO_PATH . 'includes/elements/Skins/woo-products/skin-grid.php';
         // require_once AE_PRO_PATH . 'includes/elements/Skins/woo-products/skin-slider.php';
            require_once AE_PRO_PATH . 'includes/elements/woo-elements/woo-products.php';
        }
    }


    function ae_woo_setup() {
        global $post;
        global $product;

        if(!class_exists('woocommerce')){
            return false;
        }

        if(is_product()){
            $helper = new Helper();
            $ae_product_template = $helper->get_ae_active_post_template($post->ID,'product');

            if($ae_product_template){
                add_theme_support( 'wc-product-gallery-zoom' );
                add_theme_support( 'wc-product-gallery-lightbox' );
                add_theme_support( 'wc-product-gallery-slider' );
            }
        }
    }

    function editor_woo_scripts(){

        if(is_singular('ae_global_templates')){
            add_theme_support( 'wc-product-gallery-zoom' );
            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );
        }
    }

}

Aepro::instance();