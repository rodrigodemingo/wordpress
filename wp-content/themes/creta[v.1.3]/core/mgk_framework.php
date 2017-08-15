<?php 
// call theme skins function

require_once(MAGIKCRETA_THEME_PATH . '/includes/layout.php');
require_once(MAGIKCRETA_THEME_PATH . '/core/resize.php');
require_once(MAGIKCRETA_THEME_PATH . '/includes/mgk_menu.php');
require_once(MAGIKCRETA_THEME_PATH . '/includes/widget.php');
require_once(MAGIKCRETA_THEME_PATH . '/includes/mgk_widget.php');
require_once(MAGIKCRETA_THEME_PATH .'/core/social_share.php');


add_action('init','magikCreta_theme_layouts');
 /* Include theme variation functions */  
if(!function_exists('magikCreta_theme_layouts'))
{
function magikCreta_theme_layouts()
{
 global $creta_Options;   
 if (isset($creta_Options['theme_layout']) && !empty($creta_Options['theme_layout'])) {
require_once ( get_template_directory(). '/skins/' . $creta_Options['theme_layout'] . '/functions.php');   
} else {
require_once ( get_template_directory(). '/skins/default/functions.php');   
}
 }


}


 /* Include theme variation header */   
if(!function_exists('magikCreta_theme_header'))
{
function magikCreta_theme_header()
{
 global $creta_Options;  
  if (isset($creta_Options['theme_layout']) && !empty($creta_Options['theme_layout'])) {
load_template(get_template_directory() . '/skins/' . $creta_Options['theme_layout'] . '/header.php', true);
} else {
load_template(get_template_directory() . '/skins/default/header.php', true);
}

 }

}

/* Include theme variation homepage */ 

if(!function_exists('magikCreta_theme_homepage'))
{
 function magikCreta_theme_homepage()
 {  
 global $creta_Options;  
 
 if (isset($creta_Options['theme_layout']) && !empty($creta_Options['theme_layout'])) {
load_template(get_template_directory() . '/skins/' . $creta_Options['theme_layout'] . '/homepage.php', true);
} else {
load_template(get_template_directory() . '/skins/default/homepage.php', true);
}
 }
}

 /* Include theme variation footer */ 

if(!function_exists('magikCreta_theme_footer'))
{
function magikCreta_theme_footer()
{
     
 global $creta_Options;   
  if (isset($creta_Options['theme_layout']) && !empty($creta_Options['theme_layout'])) {
load_template(get_template_directory() . '/skins/' . $creta_Options['theme_layout'] . '/footer.php', true);
} else {
load_template(get_template_directory() . '/skins/default/footer.php', true);
} 
}
}

 /* Include theme  backtotop */

if(!function_exists('magikCreta_backtotop'))
{
function magikCreta_backtotop()
{
    
 global $creta_Options;   
 if (isset($creta_Options['back_to_top']) && !empty($creta_Options['back_to_top'])) {
    ?>
   <script type="text/javascript">
    jQuery(document).ready(function($){ 
        jQuery().UItoTop();
    });
    </script>
<?php
}
 }
}

if(!function_exists('magikCreta_layout_breadcrumb'))
{
function magikCreta_layout_breadcrumb() {
$MagikCreta = new MagikCreta();
 global $creta_Options; 

 if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
  {
  ?>
<div class="page-heading">   
  <div class="container">
     <div class="breadcrumbs">
      <?php $MagikCreta->magikCreta_breadcrumbs(); ?>
      </div>
        
      <div class="page-title">
       <h1 class="entry-title">
       <?php $MagikCreta->magikCreta_page_title(); ?>
       </h1>
       </div>
    </div>     
</div>
     
<?php 
}
else
{ 
?>


 <div class="breadcrumbs">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
          <?php $MagikCreta->magikCreta_breadcrumbs(); ?>
          </div>
          <!--col-xs-12--> 
        </div>
        <!--row--> 
      </div>
      <!--container--> 
    </div>
<?php

}

}
}


if(!function_exists('magikCreta_singlepage_breadcrumb'))
{
function magikCreta_singlepage_breadcrumb() {
 $MagikCreta = new MagikCreta();
 global $creta_Options; 

 if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
{
?>
<div class="page-heading">   
  <div class="container">
      <div class="breadcrumbs">
      <?php $MagikCreta->magikCreta_breadcrumbs(); ?>
      </div>
  </div>
</div>
     
<?php }
else{ ?>
 <div class="breadcrumbs">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
          <?php $MagikCreta->magikCreta_breadcrumbs(); ?>
          </div>
          <!--col-xs-12--> 
        </div>
        <!--row--> 
      </div>
      <!--container--> 
    </div>


<?php

}

}
}

if(!function_exists('magikCreta_simple_product_link'))
{
function magikCreta_simple_product_link()
{
  global $product,$class;
  $product_type = $product->product_type;
  $product_id=$product->id;
  if($product->price=='')
  { ?>
<a class="button btn-cart" title='<?php echo esc_html($product->add_to_cart_text()); ?>'
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")' >
    <span><?php echo esc_html($product->add_to_cart_text()); ?> </span>
    </a>
<?php  }
  else{
  ?>
<a class="single_add_to_cart_button add_to_cart_button  product_type_simple ajax_add_to_cart button btn-cart" title='<?php echo esc_html($product->add_to_cart_text()); ?>' data-quantity="1" data-product_id="<?php echo esc_attr($product->id); ?>"
      href='<?php echo esc_url($product->add_to_cart_url()); ?>'>
    <span><?php echo esc_html($product->add_to_cart_text()); ?> </span>
    </a>
<?php
}
}
}

if(!function_exists('magikCreta_allowedtags'))
{
function magikCreta_allowedtags() {
    // Add custom tags to this string
        return '<script>,<style>,<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<img>,<video>,<audio>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<b>,<blockquote>,<strong>,<figcaption>'; 
    }

}

if ( ! function_exists( 'magikCreta_wp_trim_excerpt' ) ) : 

    function magikCreta_wp_trim_excerpt($wpse_excerpt) {
    $raw_excerpt = $wpse_excerpt;
        if ( '' == $wpse_excerpt ) {

            $wpse_excerpt = get_the_content('');
            $wpse_excerpt = strip_shortcodes( $wpse_excerpt );
            $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
            $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
            $wpse_excerpt = strip_tags($wpse_excerpt, magikCreta_allowedtags()); /*IF you need to allow just certain tags. Delete if all tags are allowed */

            //Set the excerpt word count and only break after sentence is complete.
                $excerpt_word_count = 75;
                $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
                $tokens = array();
                $excerptOutput = '';
                $count = 0;

                // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);

                foreach ($tokens[0] as $token) { 

                    if ($count >= $excerpt_length && preg_match('/[\,\;\?\.\!]\s*$/uS', $token)) { 
                    // Limit reached, continue until , ; ? . or ! occur at the end
                        $excerptOutput .= trim($token);
                        break;
                    }

                    // Add words to complete sentence
                    $count++;

                    // Append what's left of the token
                    $excerptOutput .= $token;
                }

            $wpse_excerpt = trim(force_balance_tags($excerptOutput));

                $excerpt_end = ' '; 
                $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end); 

                $wpse_excerpt .= $excerpt_more; /*Add read more in new paragraph */

            return $wpse_excerpt;   

        }
        return apply_filters('magikCreta_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt);
    }

endif; 

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'magikCreta_wp_trim_excerpt');


if(!function_exists('magikCreta_disable_srcset'))
{
function magikCreta_disable_srcset( $sources ) {
return false;
}
}
add_filter( 'wp_calculate_image_srcset', 'magikCreta_disable_srcset' );


if(!function_exists('magikCreta_body_classes'))
{
function magikCreta_body_classes( $classes ) 
{
  // Adds a class to body.
global $creta_Options; 
 if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
{
if ((is_front_page() && is_home()) || is_front_page())
{
  $classes[]='cms-index-index cms-creta-home cms-home-page';
}
else
{
  $classes[]='cms-home-page';
}
}
else
{
    $classes[] = 'cms-index-index cms-home-page';
}

  return $classes;
}
}

add_filter( 'body_class', 'magikCreta_body_classes');

if(!function_exists('magikCreta_post_classes'))
{
function magikCreta_post_classes( $classes ) 
{
  // add custom post classes.
if(class_exists('WooCommerce') && is_woocommerce())
{ 
$classes[]='notblog';
if(is_product_category())
{
 $classes[]='notblog'; 
} 
}
else if(is_category() || is_archive() || is_search() || is_tag() || is_home())
{
$classes[] = 'blog-post container-paper';
}
else
{
$classes[]='notblog';
} 

  return $classes;
}
}
add_filter( 'post_class', 'magikCreta_post_classes');
?>