<?php
/*Define Constants */
define('MAGIKCRETA_CRETA_VERSION', '1.0');  
define('MAGIKCRETA_THEME_PATH', get_template_directory());
define('MAGIKCRETA_THEME_URI', get_template_directory_uri());
define('MAGIKCRETA_THEME_NAME', 'creta');

/* Include required tgm activation */
require_once ( get_template_directory(). '/includes/tgm_activation/install-required.php');
require_once ( get_template_directory(). '/includes/reduxActivate.php');
if (file_exists( get_template_directory(). '/includes/reduxConfig.php')) {
    require_once ( get_template_directory(). '/includes/reduxConfig.php');
}

/* Include theme variation functions */   
require_once(MAGIKCRETA_THEME_PATH . '/core/mgk_framework.php');


if (!isset($content_width)) {
    $content_width = 800;
}



class MagikCreta {
   
  /**
  * Constructor
  */
  function __construct() {
    // Register action/filter callbacks
  
    add_action('after_setup_theme', array($this, 'magikCreta_setup'));
    add_action( 'init', array($this, 'magikCreta_theme'));
    add_action('wp_enqueue_scripts', array($this,'magikCreta_custom_enqueue_google_font'));
    
    add_action('admin_enqueue_scripts', array($this,'magikCreta_admin_scripts_styles'));
    add_action('wp_enqueue_scripts', array($this,'magikCreta_scripts_styles'));
    add_action('wp_head', array($this,'magikCreta_apple_touch_icon'));
  
    add_action('widgets_init', array($this,'magikCreta_widgets_init'));
    add_action('wp_head', array($this,'magikCreta_front_init_js_var'),1);
    add_action('wp_head', array($this,'magikCreta_enqueue_custom_css'));
    
    add_action('add_meta_boxes', array($this,'magikCreta_reg_page_meta_box'));
    add_action('save_post',array($this, 'magikCreta_save_page_layout_meta_box_values')); 
    add_action('add_meta_boxes', array($this,'magikCreta_reg_post_meta_box'));
    add_action('save_post',array($this, 'magikCreta_save_post_layout_meta_box_values')); 
 
    }

    function magikCreta_theme() {

    global $creta_Options;

    }

  /** * Theme setup */
  function magikCreta_setup() {   
    global $creta_Options;
     load_theme_textdomain('creta', get_template_directory() . '/languages');
     load_theme_textdomain('woocommerce', get_template_directory() . '/languages');

      // Add default posts and comments RSS feed links to head.
      add_theme_support('automatic-feed-links');
      add_theme_support('title-tag');
      add_theme_support('post-thumbnails');
      add_image_size('magikCreta-featured_preview', 55, 55, true);
      add_image_size('magikCreta-article-home-large',1140, 450, true);
      add_image_size('magikCreta-product-size-large',277, 366, true);      
          
         
    add_theme_support( 'html5', array(
      'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );
    
    add_theme_support( 'post-formats', array(
      'aside','video','audio'
    ) );
    
    // Setup the WordPress core custom background feature.
    $default_color = trim( 'ffffff', '#' );
    $default_text_color = trim( '333333', '#' );
    
    add_theme_support( 'custom-background', apply_filters( 'magikCreta_custom_background_args', array(
      'default-color'      => $default_color,
      'default-attachment' => 'fixed',
    ) ) );
    
    add_theme_support( 'custom-header', apply_filters( 'magikCreta_custom_header_args', array(
      'default-text-color'     => $default_text_color,
      'width'                  => 1170,
      'height'                 => 450,
      
    ) ) );

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, icons, and column width.
     */
    add_editor_style('css/editor-style.css' );
    
    /*
    * Edge WooCommerce Declaration: WooCommerce Support and settings
    */    
    
      if (class_exists('WooCommerce')) {
        add_theme_support('woocommerce');
        require_once(MAGIKCRETA_THEME_PATH. '/woo_function.php');
        // Disable WooCommerce Default CSS if set
        if (isset($creta_Options['woocommerce_disable_woo_css']) && !empty($creta_Options['woocommerce_disable_woo_css'])) {
          add_filter('woocommerce_enqueue_styles', '__return_false');
          wp_enqueue_style('woocommerce_enqueue_styles', get_template_directory_uri() . '/woocommerce.css');
        }
      }
 
    // Register navigation menus
    
    register_nav_menus(
      array(
      'toplinks' => esc_html__( 'Top menu', 'creta' ),
       'main_menu' => esc_html__( 'Main menu', 'creta' )
      ));
    
  }
    

function magikCreta_fonts_url() {
  global $creta_Options;
  $fonts_url = '';
  $fonts     = array();
  $subsets   = 'latin,latin-ext';
 
 if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
     {
       if ( 'off' !== _x( 'on', 'Herr: on or off', 'creta' ) ) {
       $fonts[]='Herr Von Muellerhoff';
    }
  
    if ( 'off' !== _x( 'on', 'Open Sans: on or off', 'creta' ) ) {
       $fonts[]='Open Sans:400,300,300italic,400italic,600,600italic,700,700italic,800';
    }
    
    if ( 'off' !== _x( 'on', 'Montserrat: on or off', 'creta' ) ) {
        $fonts[]='Montserrat:400,700';
    }
    
    if ( 'off' !== _x( 'on', 'Electrolize: on or off', 'creta' ) ) {
         $fonts[]='Electrolize';
    }  
     }
     else
     {

   if ( 'off' !== _x( 'on', 'Open Sans: on or off', 'creta' ) ) {
         $fonts[]='Open Sans:700,600,800,400';
        }
        if ( 'off' !== _x( 'on', 'Raleway: on or off', 'creta' ) ) {
         $fonts[]='Raleway:400,300,600,500,700,800';
        }
   }

    if ( $fonts ) {
    $fonts_url = add_query_arg( array(
      'family' => urlencode( implode( '|', $fonts ) ),
      'subset' => urlencode( $subsets ),
    ), 'https://fonts.googleapis.com/css' );
  }
    return $fonts_url;
}
/*
Enqueue scripts and styles.
*/
function magikCreta_custom_enqueue_google_font() {

  wp_enqueue_style( 'magikCreta-Fonts', $this->magikCreta_fonts_url() , array(), '1.0.0' );
}


  function magikCreta_admin_scripts_styles()
  {  
      wp_enqueue_script('adminjs', MAGIKCRETA_THEME_URI . '/js/admin_menu.js', array(), '', true);
      wp_enqueue_style('adminmenu', MAGIKCRETA_THEME_URI . '/css/admin_menu.css', array(), '');
  }

function magikCreta_scripts_styles()
{
    global $creta_Options;
    /*JavaScript for threaded Comments when needed*/
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }


     if (isset($creta_Options['theme_layout'])  && !empty($creta_Options['theme_layout']))
     {
      wp_enqueue_style('bootstrap.min', MAGIKCRETA_THEME_URI . '/skins/' . $creta_Options['theme_layout'] . '/bootstrap.min.css', array(), '');   
 
      }else
     {
     wp_enqueue_style('bootstrap.min', MAGIKCRETA_THEME_URI . '/skins/default/bootstrap.min.css', array(), '');   
    }

      
   if(isset($creta_Options['opt-animation']) && !empty($creta_Options['opt-animation']))
   {
    wp_enqueue_style('animate', MAGIKCRETA_THEME_URI . '/css/animate.css', array(), '');

   }
  wp_enqueue_style('font-awesome', MAGIKCRETA_THEME_URI . '/css/font-awesome.css', array(), '');
  wp_enqueue_style('simple-line-icons', MAGIKCRETA_THEME_URI . '/css/simple-line-icons.css', array(), '');
   
     

  wp_enqueue_style('owl.carousel', MAGIKCRETA_THEME_URI . '/css/owl.carousel.css', array(), '');

  wp_enqueue_style('owl.theme', MAGIKCRETA_THEME_URI . '/css/owl.theme.css', array(), '');
  
  wp_enqueue_style('flexslider', MAGIKCRETA_THEME_URI . '/css/flexslider.css', array(), '');

   wp_enqueue_style('jquery.bxslider', MAGIKCRETA_THEME_URI . '/css/jquery.bxslider.css', array(), '');
  
   wp_enqueue_style('search', MAGIKCRETA_THEME_URI . '/css/magikautosearch.css', array(), '');
     

  wp_enqueue_style('style', MAGIKCRETA_THEME_URI . '/style.css', array(), '');    
    if (isset($creta_Options['theme_layout']) && !empty($creta_Options['theme_layout']))
     {
    wp_enqueue_style( 'blog', MAGIKCRETA_THEME_URI . '/skins/' . $creta_Options['theme_layout'] . '/blogs.css', array(), '');
   wp_enqueue_style( 'revslider', MAGIKCRETA_THEME_URI . '/skins/' . $creta_Options['theme_layout'] . '/revslider.css', array(), '');
   wp_enqueue_style('layout', MAGIKCRETA_THEME_URI . '/skins/' . $creta_Options['theme_layout'] . '/style.css', array(), '');
   wp_enqueue_style( 'mgk_menu', MAGIKCRETA_THEME_URI . '/skins/' . $creta_Options['theme_layout'] . '/mgk_menu.css', array(), '');  
    wp_enqueue_style('jquery.mobile-menu', MAGIKCRETA_THEME_URI . '/skins/' . $creta_Options['theme_layout'] . '/jquery.mobile-menu.css', array(), '');
     }
     else
     {
   wp_enqueue_style( 'blog', MAGIKCRETA_THEME_URI . '/skins/default/blogs.css', array(), '');
   wp_enqueue_style( 'revslider', MAGIKCRETA_THEME_URI . '/skins/default/revslider.css', array(), '');
   wp_enqueue_style('layout', MAGIKCRETA_THEME_URI . '/skins/default/style.css', array(), '');
   wp_enqueue_style( 'mgk_menu', MAGIKCRETA_THEME_URI . '/skins/default/mgk_menu.css', array(), '');  
    wp_enqueue_style('jquery.mobile-menu', MAGIKCRETA_THEME_URI . '/skins/default/jquery.mobile-menu.css', array(), '');
     }
    
 //theme js

  
     wp_enqueue_script('bootstrap.min-js', MAGIKCRETA_THEME_URI . '/js/bootstrap.min.js', array('jquery'), '', true);      
   
     wp_enqueue_script('countdown',MAGIKCRETA_THEME_URI . '/js/countdown.js', array('jquery'), '', true);
    wp_enqueue_script('parallax',MAGIKCRETA_THEME_URI . '/js/parallax.js', array('jquery'), '', true);
   wp_enqueue_script('cart',MAGIKCRETA_THEME_URI . '/js/common.js', array('jquery'), '', true);
    

   
 if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
     {
        wp_enqueue_script('revolution', MAGIKCRETA_THEME_URI . '/js/revolution-slider.js', array('jquery'), '', true);
    wp_enqueue_script('revolution.extension.slideanims.min', MAGIKCRETA_THEME_URI . '/js/revolution.extension.slideanims.min.js', array('jquery'), '', true);
    wp_enqueue_script('revolution.extension.layeranimation.min', MAGIKCRETA_THEME_URI . '/js/revolution.extension.layeranimation.min.js', array('jquery'), '', true);
    wp_enqueue_script('revolution.extension.navigation.min', MAGIKCRETA_THEME_URI . '/js/revolution.extension.navigation.min.js', array('jquery'), '', true);
    wp_enqueue_script('revolution-exe', MAGIKCRETA_THEME_URI . '/js/revolution.extension.js', array('jquery'), '', true);

    
     }
     else{
    //creta theme default 1 JS
       wp_enqueue_script('revsliderjs', MAGIKCRETA_THEME_URI . '/js/revslider.js', array('jquery'), '', true);
    }
    
    wp_enqueue_script('jquery.bxslider.min', MAGIKCRETA_THEME_URI . '/js/jquery.bxslider.min.js', array('jquery'), '', true);
    wp_enqueue_script('jquery.flexslider', MAGIKCRETA_THEME_URI . '/js/jquery.flexslider.js', array('jquery'), '', true);
    wp_enqueue_script('jquery.mobile-menu-js', MAGIKCRETA_THEME_URI . '/js/jquery.mobile-menu.min.js', array('jquery'), '', true);
    wp_enqueue_script('owl.carousel.min',MAGIKCRETA_THEME_URI . '/js/owl.carousel.min.js', array('jquery'), '', true);
    if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
     {
        wp_enqueue_script('cloud-zoomv1-js', MAGIKCRETA_THEME_URI . '/js/cloud-zoomv1.js', array('jquery'), '', true);
     }
     else
     {      
       wp_enqueue_script('cloud-zoom-js', MAGIKCRETA_THEME_URI . '/js/cloud-zoom.js', array('jquery'), '', true);
  
     }

      wp_register_script('themejs', MAGIKCRETA_THEME_URI .'/js/mgk_menu.js', array('jquery'), '', true );
        wp_enqueue_script('themejs');

            wp_localize_script( 'themejs', 'js_creta_vars', array(
            'ajax_url' => esc_js(admin_url( 'admin-ajax.php' )),
            'container_width' => 1250,
            'grid_layout_width' => 20           
        ) );
           
}

 
  function magikCreta_apple_touch_icon()
  {
    printf(
      '<link rel="apple-touch-icon" href="%s" />',
      esc_url(MAGIKCRETA_THEME_URI). '/images/apple-touch-icon.png'
    );
    printf(
      '<link rel="apple-touch-icon" href="%s" />',
      esc_url(MAGIKCRETA_THEME_URI). '/images/apple-touch-icon57x57.png'
    );
    printf(
      '<link rel="apple-touch-icon" href="%s" />',
       esc_url(MAGIKCRETA_THEME_URI). '/images/apple-touch-icon72x72.png'
    );
    printf(
      '<link rel="apple-touch-icon" href="%s" />',
      esc_url(MAGIKCRETA_THEME_URI). '/images/apple-touch-icon114x114.png'
    );
    printf(
      '<link rel="apple-touch-icon" href="%s" />',
      esc_url(MAGIKCRETA_THEME_URI). '/images/apple-touch-icon144x144.png'
    );
  }
  //register sidebar widget
  function magikCreta_widgets_init()
  {
      register_sidebar(array(
      'name' => esc_html__('Blog Sidebar', 'creta'),
      'id' => 'sidebar-blog',
      'description' => esc_html__('Sidebar that appears on the right of Blog and Search page.', 'creta'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h3 class="block-title">',
      'after_title' => '</h3>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Shop Sidebar','creta'),
      'id' => 'sidebar-shop',
      'description' => esc_html__('Main sidebar that appears on the left.', 'creta'),
      'before_widget' => '<div id="%1$s" class="block %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<div class="block-title">',
      'after_title' => '</div>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Content Sidebar Left', 'creta'),
      'id' => 'sidebar-content-left',
      'description' => esc_html__('Additional sidebar that appears on the left.','creta'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<div class="block-title">',
      'after_title' => '</div>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Content Sidebar Right', 'creta'),
      'id' => 'sidebar-content-right',
      'description' => esc_html__('Additional sidebar that appears on the right.', 'creta'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<div class="block-title">',
      'after_title' => '</div>',
    ));
   
    register_sidebar(array(
      'name' => esc_html__('Footer Widget Area 1','creta'),
      'id' => 'footer-sidebar-1',
      'description' => esc_html__('Appears in the footer section of the site.','creta'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h4>',
      'after_title' => '</h4>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Footer Widget Area 2', 'creta'),
      'id' => 'footer-sidebar-2',
      'description' => esc_html__('Appears in the footer section of the site.', 'creta'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h4>',
      'after_title' => '</h4>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Footer Widget Area 3', 'creta'),
      'id' => 'footer-sidebar-3',
      'description' => esc_html__('Appears in the footer section of the site.','creta'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h4>',
      'after_title' => '</h4>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Footer Widget Area 4', 'creta'),
      'id' => 'footer-sidebar-4',
      'description' => esc_html__('Appears in the footer section of the site.', 'creta'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h4>',
      'after_title' => '</h4>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Footer Widget Area 5', 'creta'),
      'id' => 'footer-sidebar-5',
      'description' => esc_html__('Appears in the footer section of the site.', 'creta'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h4>',
      'after_title' => '</h4>',
    ));

  }



  function magikCreta_front_init_js_var()
  {
    global $yith_wcwl, $post;
    ?>
  <script type="text/javascript">
      var MGK_PRODUCT_PAGE = false;
      var THEMEURL = '<?php echo esc_url(MAGIKCRETA_THEME_URI) ?>';
      var IMAGEURL = '<?php echo esc_url(MAGIKCRETA_THEME_URI) ?>/images';
      var CSSURL = '<?php echo esc_url(MAGIKCRETA_THEME_URI) ?>/css';
      <?php if (isset($yith_wcwl) && is_object($yith_wcwl)) { ?>
      var MGK_ADD_TO_WISHLIST_SUCCESS_TEXT = '<?php printf(preg_replace_callback('/(\r|\n|\t)+/',  create_function('$match', 'return "";'),htmlspecialchars_decode('Product successfully added to wishlist. <a href="%s">Browse Wishlist</a>')), esc_url($yith_wcwl->get_wishlist_url())) ?>';

      var MGK_ADD_TO_WISHLIST_EXISTS_TEXT = '<?php printf(preg_replace_callback('/(\r|\n|\t)+/',  create_function('$match', 'return "";'),htmlspecialchars_decode('The product is already in the wishlist! <a href="%s">Browse Wishlist</a>')), esc_url($yith_wcwl->get_wishlist_url()) )?>';
      <?php } ?>
      <?php if(is_singular('product')){?>
      MGK_PRODUCT_PAGE = true;
      <?php }?>
    </script>
  <?php
  }

  function magikCreta_reg_page_meta_box() {
    $screens = array('page');

    foreach ($screens as $screen) {        
      add_meta_box(
          'magikCreta_page_layout_meta_box', esc_html__('Page Layout', 'creta'), 
          array($this, 'magikCreta_page_layout_meta_box_cb'), $screen, 'normal', 'core'
      );
    }
  }

  function magikCreta_page_layout_meta_box_cb($post) {

    $saved_page_layout = get_post_meta($post->ID, 'magikCreta_page_layout', true);
    
    $show_breadcrumb = get_post_meta($post->ID, 'magikCreta_show_breadcrumb', true);
    
   if(empty($saved_page_layout)) {
      $saved_page_layout = 3;
    }
    $page_layouts = array(
      1 => esc_url(MAGIKCRETA_THEME_URI).'/images/magik_col/category-layout-1.png',
      2 => esc_url(MAGIKCRETA_THEME_URI).'/images/magik_col/category-layout-2.png',
      3 => esc_url(MAGIKCRETA_THEME_URI).'/images/magik_col/category-layout-3.png',
      4 => esc_url(MAGIKCRETA_THEME_URI).'/images/magik_col/category-layout-4.png',
    );  
    ?>
  <style type="text/css">
        input.of-radio-img-radio{display: none;}
        .tile_img_wrap{
          display: block;                
        }
        .tile_img_wrap > span > img{
          float: left;
          margin:0 5px 10px 0;
        }
        .tile_img_wrap > span > img:hover{
          cursor: pointer;
        }            
        .tile_img_wrap img.of-radio-img-selected{
          border: 3px solid #CCCCCC;
        }
         #magikCreta_page_layout_meta_box h2 {
    margin-top: 20px;
    font-size: 1.5em;
    
     }
        #magikCreta_page_layout_meta_box .inside h2 {
    margin-top: 20px;
    font-size: 1.5em;
    margin-bottom: 15px;
    padding: 0 0 3px;
    clear: left;
}
        
      </style>
  <?php
    echo "<input type='hidden' name='magikCreta_page_layout_verifier' value='".wp_create_nonce('magikCreta_7a81jjde')."' />";    
    $output = '<div class="tile_img_wrap">';
      foreach ($page_layouts as $key => $img) {
        $checked = '';
        $selectedClass = '';
        if($saved_page_layout == $key){
          $checked = 'checked="checked"';
          $selectedClass = 'of-radio-img-selected';
        }
        $output .= '<span>';
        $output .= '<input type="radio" class="checkbox of-radio-img-radio" value="' . absint($key) . '" name="magikCreta_page_layout" ' . esc_html($checked). ' />';            
        $output .= '<img src="' . esc_url($img) . '" alt="" class="of-radio-img-img ' . esc_html($selectedClass) . '" />';
        $output .= '</span>';
            
      }    
    $output .= '</div>';
    echo htmlspecialchars_decode($output);
    ?>
  <script type="text/javascript">
      jQuery(function($){            
        $(document.body).on('click','.of-radio-img-img',function(){
          $(this).parents('.tile_img_wrap').find('.of-radio-img-img').removeClass('of-radio-img-selected');
          $(this).parent().find('.of-radio-img-radio').attr('checked','checked');
          $(this).addClass('of-radio-img-selected');
        });            
    });
      
      </script>

  <h2><?php esc_attr_e('Show breadcrumb', 'creta'); ?></h2>
  <p>
    <input type="radio" name="magikCreta_show_breadcrumb" value="1" <?php echo "checked='checked'"; ?> />
    <label><?php esc_attr_e('Yes','creta'); ?></label>
    &nbsp;
    <input type="radio" name="magikCreta_show_breadcrumb" value="0"  <?php if($show_breadcrumb === '0'){ echo "checked='checked'"; } ?>/>
    <label><?php esc_attr_e('No', 'creta'); ?></label>
  </p>
  <?php
  }

  function magikCreta_save_page_layout_meta_box_values($post_id){
    if (!isset($_POST['magikCreta_page_layout_verifier']) 
        || !wp_verify_nonce($_POST['magikCreta_page_layout_verifier'], 'magikCreta_7a81jjde') 
        || !isset($_POST['magikCreta_page_layout']) 
       
        )
      return $post_id;
    
    
    add_post_meta($post_id,'magikCreta_page_layout',sanitize_text_field( $_POST['magikCreta_page_layout']),true) or 
    update_post_meta($post_id,'magikCreta_page_layout',sanitize_text_field( $_POST['magikCreta_page_layout']));
    
    add_post_meta($post_id,'magikCreta_show_breadcrumb',sanitize_text_field( $_POST['magikCreta_show_breadcrumb']),true) or 
    update_post_meta($post_id,'magikCreta_show_breadcrumb',sanitize_text_field( $_POST['magikCreta_show_breadcrumb']));  
  }


  /*Register Post Meta Boxes for Blog Post Layouts*/

    function magikCreta_reg_post_meta_box() {
    $screens = array('post');

    foreach ($screens as $screen) {        
      add_meta_box(
          'magikCreta_post_layout_meta_box', esc_html__('Post Layout', 'creta'), 
          array($this, 'magikCreta_post_layout_meta_box_cb'), $screen, 'normal', 'core'
      );
    }
  }

  function magikCreta_post_layout_meta_box_cb($post) {

    $saved_post_layout = get_post_meta($post->ID, 'magikCreta_post_layout', true);         
    if(empty($saved_post_layout))
    {
      $saved_post_layout = 2;
    }
    
    $post_layouts = array(
      1 => esc_url(MAGIKCRETA_THEME_URI).'/images/magik_col/category-layout-1.png',
      2 => esc_url(MAGIKCRETA_THEME_URI).'/images/magik_col/category-layout-2.png',
      3 => esc_url(MAGIKCRETA_THEME_URI).'/images/magik_col/category-layout-3.png',
      
    );  
    ?>
  <style type="text/css">
        input.of-radio-img-radio{display: none;}
        .tile_img_wrap{
          display: block;                
        }
        .tile_img_wrap > span > img{
          float: left;
          margin:0 5px 10px 0;
        }
        .tile_img_wrap > span > img:hover{
          cursor: pointer;
        }            
        .tile_img_wrap img.of-radio-img-selected{
          border: 3px solid #CCCCCC;
        }
        .postbox-container .inside .tile_img_wrap
        {
          height:70px;
        }
        
      </style>
  <?php
    echo "<input type='hidden' name='magikCreta_post_layout_verifier' value='".wp_create_nonce('magikCreta_7a81jjde1')."' />";    
    $output = '<div class="tile_img_wrap">';
      foreach ($post_layouts as $key => $img) {
        $checked = '';
        $selectedClass = '';
        if($saved_post_layout == $key){
          $checked = 'checked="checked"';
          $selectedClass = 'of-radio-img-selected';
        }
        $output .= '<span>';
        $output .= '<input type="radio" class="checkbox of-radio-img-radio" value="' . absint($key) . '" name="magikCreta_post_layout" ' . esc_html($checked). ' />';            
        $output .= '<img src="' . esc_url($img) . '" alt="" class="of-radio-img-img ' . esc_html($selectedClass) . '" />';
        $output .= '</span>';
            
      }    
    $output .= '</div>';
    echo htmlspecialchars_decode($output);
    ?>
  <script type="text/javascript">
      jQuery(function($){            
        $(document.body).on('click','.of-radio-img-img',function(){
          $(this).parents('.tile_img_wrap').find('.of-radio-img-img').removeClass('of-radio-img-selected');
          $(this).parent().find('.of-radio-img-radio').attr('checked','checked');
          $(this).addClass('of-radio-img-selected');
        });            
    });
      
      </script>

  
  <?php
  }

  function magikCreta_save_post_layout_meta_box_values($post_id){
    if (!isset($_POST['magikCreta_post_layout_verifier']) 
        || !wp_verify_nonce($_POST['magikCreta_post_layout_verifier'], 'magikCreta_7a81jjde1') 
        || !isset($_POST['magikCreta_post_layout']) 
       
        )
      return $post_id;
    
    
    add_post_meta($post_id,'magikCreta_post_layout',sanitize_text_field($_POST['magikCreta_post_layout']),true) or 
    update_post_meta($post_id,'magikCreta_post_layout',sanitize_text_field($_POST['magikCreta_post_layout']));
    
    
  }

  //custom functions 



// page title code
function magikCreta_page_title() {

    global  $post, $wp_query, $author,$creta_Options;

    $home = esc_html__('Home', 'creta');

  
    if ( ( ! is_home() && ! is_front_page() && ! (is_post_type_archive()) ) || is_paged() ) {

        if ( is_home() ) {
           echo htmlspecialchars_decode(single_post_title('', false));

        } else if ( is_category() ) {

            echo esc_html(single_cat_title( '', false ));

        } elseif ( is_tax() ) {

            $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            echo htmlspecialchars_decode(esc_html( $current_term->name ));

        }  elseif ( is_day() ) {

            printf( esc_html__( 'Daily Archives: %s', 'creta' ), get_the_date() );

        } elseif ( is_month() ) {

            printf( esc_html__( 'Monthly Archives: %s', 'creta' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'creta' ) ) );

        } elseif ( is_year() ) {

            printf( esc_html__( 'Yearly Archives: %s', 'creta' ), get_the_date( _x( 'Y', 'yearly archives date format', 'creta' ) ) );

        }   else if ( is_post_type_archive() ) {
            sprintf( esc_html__( 'Archives: %s', 'creta' ), post_type_archive_title( '', false ) );
        } elseif ( is_single() && ! is_attachment() ) {
        
                echo esc_html(get_the_title());

            

        } elseif ( is_404() ) {

            echo esc_html__( 'Error 404', 'creta' );

        } elseif ( is_attachment() ) {

            echo esc_html(get_the_title());

        } elseif ( is_page() && !$post->post_parent ) {

            echo esc_html(get_the_title());

        } elseif ( is_page() && $post->post_parent ) {

            echo esc_html(get_the_title());

        } elseif ( is_search() ) {

            echo htmlspecialchars_decode(esc_html__( 'Search results for &ldquo;', 'creta' ) . get_search_query() . '&rdquo;');

        } elseif ( is_tag() ) {

            echo htmlspecialchars_decode(esc_html__( 'Posts tagged &ldquo;', 'creta' ) . single_tag_title('', false) . '&rdquo;');

        } elseif ( is_author() ) {

            $userdata = get_userdata($author);
            echo htmlspecialchars_decode(esc_html__( 'Author:', 'creta' ) . ' ' . $userdata->display_name);

        } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' ) {

            $post_type = get_post_type_object( get_post_type() );

            if ( $post_type ) {
                echo htmlspecialchars_decode($post_type->labels->singular_name);
            }

        }

        if ( get_query_var( 'paged' ) ) {
            echo htmlspecialchars_decode( ' (' . esc_html__( 'Page', 'creta' ) . ' ' . get_query_var( 'paged' ) . ')');
        }
    } else {
        if ( is_home() && !is_front_page() ) {
            if ( ! empty( $home ) ) {               
                  echo htmlspecialchars_decode(single_post_title('', false));
            }
        }
    }
}

// page breadcrumbs code
function magikCreta_breadcrumbs() {
    global $post, $creta_Options,$wp_query, $author;

    $delimiter = '<span> &frasl; </span>';
    $before = '<li>';
    $after = '</li>';
    $home = esc_html__('Home', 'creta');
    $linkbefore='<strong>';
    $linkafter='</strong>';

  
  // breadcrumb code
   
    if ( ( ! is_home() && ! is_front_page() && ! (is_post_type_archive()) ) || is_paged() ) {
        echo '<ul>';

        if ( ! empty( $home ) ) {
            echo htmlspecialchars_decode($before . '<a class="home" href="' . esc_url(home_url() ) . '">' . $home . '</a>' . $delimiter . $after);
        }

        if ( is_home() ) {

            echo htmlspecialchars_decode($before .$linkbefore. single_post_title('', false) .$linkafter. $after);

         }      
         else if ( is_category() ) {

            if ( get_option( 'show_on_front' ) == 'page' ) {
                echo htmlspecialchars_decode($before . '<a href="' . esc_url(get_permalink( get_option('page_for_posts' ) )) . '">' . esc_html(get_the_title( get_option('page_for_posts', true) )) . '</a>' . $delimiter . $after);
            }

            $cat_obj = $wp_query->get_queried_object();
            if ($cat_obj) {
                $this_category = get_category( $cat_obj->term_id );
                if ( 0 != $this_category->parent ) {
                    $parent_category = get_category( $this_category->parent );
                    if ( ( $parents = get_category_parents( $parent_category, TRUE, $delimiter . $after . $before ) ) && ! is_wp_error( $parents ) ) {
                        echo htmlspecialchars_decode($before . substr( $parents, 0, strlen($parents) - strlen($delimiter . $after . $before) ) . $delimiter . $after);
                    }
                }
                echo htmlspecialchars_decode($before .$linkbefore. single_cat_title( '', false ) .$linkafter. $after);
            }

        } 
        elseif ( is_tax()) {      
                    
            $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            $ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

            foreach ( $ancestors as $ancestor ) {
                $ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

                echo htmlspecialchars_decode($before . '<a href="' . esc_url(get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) )) . '">' . esc_html( $ancestor->name ) . '</a>' . $delimiter . $after);
            }

            echo htmlspecialchars_decode($before .$linkbefore. esc_html( $current_term->name ) .$linkafter. $after);

        } 
       
        elseif ( is_day() ) {

            echo htmlspecialchars_decode($before . '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a>' . $delimiter . $after);
            echo htmlspecialchars_decode($before . '<a href="' . esc_url(get_month_link(get_the_time('Y'),get_the_time('m'))) . '">' . esc_html(get_the_time('F')) . '</a>' . $delimiter . $after);
            echo htmlspecialchars_decode($before .$linkbefore. get_the_time('d') .$linkafter. $after);

        } elseif ( is_month() ) {

            echo htmlspecialchars_decode($before . '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a>' . $delimiter . $after);
            echo htmlspecialchars_decode($before .$linkbefore. get_the_time('F') .$linkafter. $after);

        } elseif ( is_year() ) {

            echo htmlspecialchars_decode($before .$linkbefore. get_the_time('Y') .$linkafter. $after);

        } elseif ( is_single() && ! is_attachment() ) {

         
            if ( 'post' != get_post_type() ) {
                $post_type = get_post_type_object( get_post_type() );
                $slug = $post_type->rewrite;
                echo htmlspecialchars_decode($before . '<a href="' . esc_url(get_post_type_archive_link( get_post_type() )) . '">' . esc_html($post_type->labels->singular_name) . '</a>' . $delimiter . $after);
                echo htmlspecialchars_decode($before .$linkbefore. get_the_title() .$linkafter. $after);

            } else {

                if ( 'post' == get_post_type() && get_option( 'show_on_front' ) == 'page' ) {
                    echo htmlspecialchars_decode($before . '<a href="' . esc_url(get_permalink( get_option('page_for_posts' ) )) . '">' . esc_html(get_the_title( get_option('page_for_posts', true) )) . '</a>' . $delimiter . $after);
                }

                $cat = current( get_the_category() );
              if ( ( $parents = get_category_parents( $cat, TRUE, $delimiter . $after . $before ) ) && ! is_wp_error( $parents ) ) {
                $getitle=get_the_title();
                  if(empty($getitle))
                  {
                    $newdelimiter ='';
                  }
                  else
                  {
                     $newdelimiter=$delimiter;
                  }
                    echo htmlspecialchars_decode($before . substr( $parents, 0, strlen($parents) - strlen($delimiter . $after . $before) ) . $newdelimiter . $after);
                }
                echo htmlspecialchars_decode($before .$linkbefore. get_the_title() .$linkafter. $after);

            }

        } elseif ( is_404() ) {

            echo htmlspecialchars_decode($before .$linkbefore. esc_html__( 'Error 404', 'creta' ) .$linkafter. $after);

        } elseif ( is_attachment() ) {

            $parent = get_post( $post->post_parent );
            $cat = get_the_category( $parent->ID );
            $cat = $cat[0];
            if ( ( $parents = get_category_parents( $cat, TRUE, $delimiter . $after . $before ) ) && ! is_wp_error( $parents ) ) {
                echo htmlspecialchars_decode($before . substr( $parents, 0, strlen($parents) - strlen($delimiter . $after . $before) ) . $delimiter . $after);
            }
            echo htmlspecialchars_decode($before . '<a href="' . esc_url(get_permalink( $parent )) . '">' . esc_html($parent->post_title) . '</a>' . $delimiter . $after);
            echo htmlspecialchars_decode($before .$linkbefore. get_the_title() .$linkafter. $after);

        } elseif ( is_page() && !$post->post_parent ) {

            echo htmlspecialchars_decode($before .$linkbefore. get_the_title() .$linkafter. $after);

        } elseif ( is_page() && $post->post_parent ) {

            $parent_id  = $post->post_parent;
            $breadcrumbs = array();

            while ( $parent_id ) {
                $page = get_post( $parent_id );
                $breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title( $page->ID )) . '</a>';
                $parent_id  = $page->post_parent;
            }

            $breadcrumbs = array_reverse( $breadcrumbs );

            foreach ( $breadcrumbs as $crumb ) {
                echo htmlspecialchars_decode($before . $crumb . $delimiter . $after);
            }

            echo htmlspecialchars_decode($before .$linkbefore. get_the_title() .$linkafter. $after);

        } elseif ( is_search() ) {

            echo htmlspecialchars_decode($before .$linkbefore. esc_html__( 'Search results for &ldquo;', 'creta' ) . get_search_query() . '&rdquo;' .$linkafter. $after);

        } elseif ( is_tag() ) {

            if ( 'post' == get_post_type() && get_option( 'show_on_front' ) == 'page' ) {
                echo htmlspecialchars_decode($before . '<a href="' . esc_url(get_permalink( get_option('page_for_posts' ) )) . '">' . esc_html(get_the_title( get_option('page_for_posts', true) )) . '</a>' . $delimiter . $after);
            }

            echo htmlspecialchars_decode($before .$linkbefore. esc_html__( 'Posts tagged &ldquo;', 'creta' ) . single_tag_title('', false) . '&rdquo;' .$linkafter. $after);

        } elseif ( is_author() ) {

            $userdata = get_userdata($author);
            echo htmlspecialchars_decode($before .$linkbefore. esc_html__( 'Author:', 'creta' ) . ' ' . $userdata->display_name .$linkafter. $after);

        } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' ) {

            $post_type = get_post_type_object( get_post_type() );

            if ( $post_type ) {
                echo htmlspecialchars_decode($before .$linkbefore. $post_type->labels->singular_name .$linkafter. $after);
            }

        }

        if ( get_query_var( 'paged' ) ) {
            echo htmlspecialchars_decode($before .$linkbefore. '&nbsp;(' . esc_html__( 'Page', 'creta' ) . ' ' . get_query_var( 'paged' ) . ')' .$linkafter. $after);
        }

        echo '</ul>';
    } else { 
        if ( is_home() && !is_front_page() ) {
            echo '<ul class="breadcrumb">';

            if ( ! empty( $home ) ) {
                echo htmlspecialchars_decode($before . '<a class="home" href="' . esc_url(home_url()) . '">' . $home . '</a>' . $delimiter . $after);

               
                echo htmlspecialchars_decode($before .$linkbefore. single_post_title('', false) .$linkafter. $after);
            }

            echo '</ul>';
        }
    }
}
  
  
  // magik mini cart
  function magikCreta_mini_cart()
{
    global $woocommerce,$creta_Options;

    ?>

<div class="mini-cart">
   
    <?php  if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
     {?>
     <div class="basket"> <a href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>">
        <span> <?php echo esc_html($woocommerce->cart->cart_contents_count); ?> </span></a> </div>
     
     <?php } else{ ?>
           <div data-hover="dropdown"  class="basket dropdown-toggle">
      <a href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>"> 
        <span class="cart_count"><?php echo esc_html($woocommerce->cart->cart_contents_count); ?> </span>
        <span class="price"><?php  esc_attr_e('My Cart','creta'); ?> /
          <?php echo htmlspecialchars_decode(WC()->cart->get_cart_subtotal()); ?></span> </a>
           </div>
     <?php } ?>
      
 
            <div class="top-cart-content">
               <?php  if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
     {?>
                <div class="block-subtitle">
                <div class="top-subtotal"><?php echo esc_html($woocommerce->cart->cart_contents_count); ?>  <?php  esc_attr_e('items','creta'); ?> , <span class="price"><?php echo htmlspecialchars_decode(WC()->cart->get_cart_subtotal()); ?></span> </div>
                 </div>
                <!--top-subtotal--> 
                <?php } ?>
             
                   
         <?php if (sizeof(WC()->cart->get_cart()) > 0) : $i = 0; ?>
         <ul class="mini-products-list" id="cart-sidebar" >
            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
            <?php
               $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
               $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
               
               if ($_product && $_product->exists() && $cart_item['quantity'] > 0
                   && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)
               ) :
               
                   $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key);
                   $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(array(80, 160)), $cart_item, $cart_item_key);
                   $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                   $cnt = sizeof(WC()->cart->get_cart());
                   $rowstatus = $cnt % 2 ? 'odd' : 'even';
                   ?>
            <li class="item<?php if ($cnt - 1 == $i) { ?>last<?php } ?>">
              <div class="item-inner">
               <a class="product-image"
                  href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>"  title="<?php echo htmlspecialchars_decode($product_name); ?>"> <?php echo str_replace(array('http:', 'https:'), '', htmlspecialchars_decode($thumbnail)); ?> </a>
             

                  <div class="product-details">
                       <div class="access">
                        <a class="btn-edit" title="<?php esc_attr_e('Edit item','creta') ;?>"
                        href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>"><i
                        class="icon-pencil"></i><span
                        class="hidden"><?php esc_attr_e('Edit item','creta') ;?></span></a>
                     <a href="<?php echo esc_url(WC()->cart->get_remove_url($cart_item_key)); ?>"
                        title="<?php esc_attr_e('Remove This Item','creta') ;?>" onClick="" 
                        class="btn-remove1"><?php esc_attr_e('Remove','creta') ;?></a> 

                         </div>
                      <strong><?php echo esc_html($cart_item['quantity']); ?>
                  </strong> x <span class="price"><?php echo htmlspecialchars_decode($product_price); ?></span>
                     <p class="product-name"><a href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>"
                        title="<?php echo htmlspecialchars_decode($product_name); ?>"><?php echo htmlspecialchars_decode($product_name); ?></a> </p>
                  </div>
                  <?php echo htmlspecialchars_decode(WC()->cart->get_item_data($cart_item)); ?>
                     </div>
              
            </li>
            <?php endif; ?>
            <?php $i++; endforeach; ?>
         </ul> 
         <!--actions-->
                    
         <div class="actions">
                      <button class="btn-checkout" title="<?php esc_attr_e('Checkout','creta') ;?>" type="button" 
                      onClick="window.location.assign('<?php echo esc_js(WC()->cart->get_checkout_url()); ?>')">
                      <span><?php esc_attr_e('Checkout','creta') ;?></span> </button>

                       <?php  if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='default')
                       {?>
                      <a class="view-cart" type="button"
                     onClick="window.location.assign('<?php echo esc_js(WC()->cart->get_cart_url()); ?>')">
                     <span><?php esc_attr_e('View Cart','creta') ;?></span> </a>
                     <?php } ?>
          
         </div>   
         
         <?php else:?>
         <p class="a-center noitem">
            <?php esc_attr_e('Sorry, nothing in cart.', 'creta');?>
         </p>
         <?php endif; ?>
      
   </div>
 </div>

<?php
}
 

 
  //social links
  function magikCreta_social_media_links()
  {
    global $creta_Options;
    if(isset($creta_Options
  ['enable_social_link_footer']) && !empty($creta_Options['enable_social_link_footer']))
    {?>
 <div class="social">
<?php  if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='default')
     {?>
  <h4><?php esc_attr_e('Follow Us', 'creta'); ?></h4>
  <?php } ?>
  <ul>
  <?php
    if (isset($creta_Options
  ['social_facebook']) && !empty($creta_Options['social_facebook'])) {
      echo "<li class=\"fb pull-left\"><a target=\"_blank\" href='".  esc_url($creta_Options['social_facebook']) ."'></a></li>";
    }

    if (isset($creta_Options['social_twitter']) && !empty($creta_Options['social_twitter'])) {
      echo "<li class=\"tw pull-left\"><a target=\"_blank\" href='".  esc_url($creta_Options['social_twitter']) ."'></a></li>";
    }

    if (isset($creta_Options['social_googlep']) && !empty($creta_Options['social_googlep'])) {
      echo "<li class=\"googleplus pull-left\"><a target=\"_blank\" href='".  esc_url($creta_Options['social_googlep'])."'></a></li>";
    }

    if (isset($creta_Options['social_rss']) && !empty($creta_Options['social_rss'])) {
      echo "<li class=\"rss pull-left\"><a target=\"_blank\" href='".  esc_url($creta_Options['social_rss'])."'></a></li>";
    }

    if (isset($creta_Options['social_pinterest']) && !empty($creta_Options['social_pinterest'])) {
      echo "<li class=\"pintrest pull-left\"><a target=\"_blank\" href='".  esc_url($creta_Options['social_pinterest'])."'></a></li>";
    }

    if (isset($creta_Options['social_linkedin']) && !empty($creta_Options['social_linkedin'])) {
      echo "<li class=\"linkedin pull-left\"><a target=\"_blank\" href='".  esc_url($creta_Options['social_linkedin'])."'></a></li>";
    }

    if (isset($creta_Options['social_youtube']) && !empty($creta_Options['social_youtube'])) {
      echo "<li class=\"youtube pull-left\"><a target=\"_blank\" href='".  esc_url($creta_Options['social_youtube'])."'></a></li>";
    }
    ?>
 </ul>
 </div>

 <?php }
  }


  // bottom cpyright text 
  function magikCreta_footer_text()
  {
    global $creta_Options;
    if (isset($creta_Options['bottom-footer-text']) && !empty($creta_Options['bottom-footer-text'])) {
      echo htmlspecialchars_decode ($creta_Options['bottom-footer-text']);
    }
  }



  function magikCreta_getPostViews($postID)
  {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '0');
      return "0  View";
    }
    return $count . '  Views';
  }

  function magikCreta_setPostViews($postID)
  {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
      $count = 0;
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '0');
    } else {
      $count++;
      update_post_meta($postID, $count_key, $count);
    }
  }


  function magikCreta_is_blog() {
    global  $post;
    $posttype = get_post_type($post );
    return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
  }
  //add to cart function
function magikCreta_woocommerce_product_add_to_cart_text() {
    global $product;
    $product_type = $product->product_type;
    $product_id=$product->id;
    if($product->is_in_stock())
    {
    switch ( $product_type ) {
    case 'external':
    ?>
    <a class="button btn-cart" title='<?php echo esc_html($product->add_to_cart_text()); ?>'
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")'>
    <span> <?php echo esc_html($product->add_to_cart_text()); ?></span>
    </a>
    <?php
       break;
       case 'grouped':
        ?>
    <a class="button btn-cart" title='<?php echo esc_html($product->add_to_cart_text()); ?>'
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")' >
    <span><?php echo esc_html($product->add_to_cart_text()); ?> </span>
    </a>
    <?php
       break;
       case 'simple':
        ?>
    <?php magikCreta_simple_product_link();?>
    <?php
       break;
       case 'variable':
        ?>
    <a class="button btn-cart"  title='<?php esc_attr_e("Select options",'creta'); ?>'
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")'>
    <span>
    <?php echo esc_html($product->add_to_cart_text()); ?>
    </span> 
    </a>
    <?php
       break;
       default:
        ?>
    <a class="button btn-cart" title='<?php esc_attr_e("Read more",'creta'); ?>'
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")'>
    <span><?php esc_attr_e('Read more', 'creta'); ?></span> 
    </a>
    <?php
       break;
       
       }
       }
       else
       {
       ?>
    <a type='button' class="button btn-cart" title='<?php esc_attr_e('Out of stock', 'creta'); ?> '
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")'
       class='button btn-cart'>
    <span> <?php esc_attr_e('Out of stock', 'creta'); ?> </span>
    </a>
    <?php
    }
}
 
 // comment display 
  function magikCreta_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>

  <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
    <div class="comment-body">
      <div class="img-thumbnail">
        <?php echo get_avatar($comment, 80); ?>
      </div>
      <div class="comment-block">
        <div class="comment-arrow"></div>
        <span class="comment-by">
          <strong><?php echo get_comment_author_link() ?></strong>
          <span class="pt-right">
            <span> <?php edit_comment_link('<i class="fa fa-pencil"></i> ' . esc_html__('Edit', 'creta'),'  ','') ?></span>
            <span> <?php comment_reply_link(array_merge( $args, array('reply_text' => '<i class="fa fa-reply"></i> ' . esc_html__('Reply', 'creta'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
          </span>
        </span>
        <div>
          <?php if ($comment->comment_approved == '0') : ?>
            <em><?php echo esc_html__('Your comment is awaiting moderation.', 'creta') ?></em>
            <br />
          <?php endif; ?>
          <?php comment_text() ?>
        </div>
        <span class="date pt-right"><?php printf(esc_html__('%1$s at %2$s', 'creta'), get_comment_date(),  get_comment_time()) ?></span>
      </div>
    </div>
  </li>
  <?php }

  //css manage by admin
  function magikCreta_enqueue_custom_css() {
    global $creta_Options;

    ?>
    <style rel="stylesheet" property="stylesheet" type="text/css">
      <?php if(isset($creta_Options['opt-color-rgba']) &&  !empty($creta_Options['opt-color-rgba'])) {
      ?>
      .mgk-main-menu {
        background-color: <?php echo esc_html($creta_Options['opt-color-rgba'])." !important";
      ?>
      }
      <?php
      }
      ?>
       
      
      <?php if(isset($creta_Options['footer_color_scheme']) && $creta_Options['footer_color_scheme']) {
      if(isset($creta_Options['footer_copyright_background_color']) && !empty($creta_Options['footer_copyright_background_color'])) {
       ?>
      .footer-bottom {
        background-color: <?php echo esc_html($creta_Options['footer_copyright_background_color'])." !important";
       ?>
      }

      <?php
       }
       ?>
      <?php if(isset($creta_Options['footer_copyright_font_color']) && !empty($creta_Options['footer_copyright_font_color'])) {
       ?>
      .coppyright {
        color: <?php echo esc_html($creta_Options['footer_copyright_font_color'])." !important";
      ?>
      }

      <?php
       }
       ?>
      <?php
       }
       ?>
         <?php 
         if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2') {
        if(isset($creta_Options['header_breadcrumb']) && !empty($creta_Options['header_breadcrumb']['url'])) {
       ?>
       .page-heading,.tax-product_cat .page-heading
       {
         background-image:url("<?php echo esc_url($creta_Options['header_breadcrumb']['url']);?>");
       }
        <?php
      }
       }
       ?>
    </style>
    <?php
  }
}

// Instantiate theme
$MagikCreta = new MagikCreta();

?>