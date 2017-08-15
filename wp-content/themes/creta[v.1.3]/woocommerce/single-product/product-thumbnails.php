<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.3
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post, $product, $woocommerce , $creta_Options;

$attachment_ids = $product->get_gallery_attachment_ids();

if ($attachment_ids) {
    $loop = 0;
    $columns = apply_filters('woocommerce_product_thumbnails_columns', 3);
    ?>

    <?php if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
    {?>

          <div class="flexslider flexslider-thumb">
           
            <ul class="previews-list slides">
                <?php

                      if( $loop==0)
                 {
                  $classes = array('cloud-zoom-gallery');


                    if ($loop == 0 || $loop % $columns == 0)
                        $classes[] = 'first';

                    if (($loop + 1) % $columns == 0)
                        $classes[] = 'last';

                    $classes = array('cloud-zoom-gallery');
                    $attachment_count = count( $product->get_gallery_attachment_ids() );
                    $attachment_id=get_post_thumbnail_id();
                    $props      = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
                    $image_title = $props['title'];
                    $image_link = $props['url'];
 
                     $image= wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props );
                                   
                    $image_class = esc_attr(implode(' ', $classes));
                 
                  $rel="useZoom: 'zoom1', smallImage: '".$image_link."'";     

                  echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<li><a href="%s" class="%s" rel="%s">%s</a></li>', $image_link, $image_class, $rel, $image), $attachment_id, $post->ID,$image_class);
                   $loop++;
                    
                 }

                foreach ($attachment_ids as $attachment_id) {

                     $classes = array('cloud-zoom-gallery');

                   if ($loop == 0 || $loop % $columns == 0)
                        $classes[] = 'first';


                    if (($loop + 1) % $columns == 0)
                        $classes[] = 'last';

                    $image_class = implode( ' ', $classes );
                    $props       = wc_get_product_attachment_props( $attachment_id, $post );          

                     $image_link = $props['url'];

                    if ( ! $image_link )
                      continue;                  

                    $image_title  = $props['title'];
                    $image_caption  = $props['caption'];

                   $image= wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props );
                    
                    $rel="useZoom: 'zoom1', smallImage: '".$image_link."'";    


                    echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<li><a href="%s" class="%s" rel="%s">%s</a></li>', $image_link, $image_class, $rel, $image), $attachment_id, $post->ID,$image_class);

                    $loop++;
                }

                ?>
            </ul>
        
        </div>


        <?php } else { ?>
          
                    
        <div class="more-views">
          <div class="slider-items-products">
           <div  id="gallery_01" class="product-flexslider hidden-buttons product-img-thumb">
          <div class="slider-items slider-width-col4 block-content">
                <?php
                   if( $loop==0)
                 {
                  $classes = array('cloud-zoom-gallery');


                    if ($loop == 0 || $loop % $columns == 0)
                        $classes[] = 'first';

                    if (($loop + 1) % $columns == 0)
                        $classes[] = 'last';

                    $classes = array('cloud-zoom-gallery');
                    $attachment_count = count( $product->get_gallery_attachment_ids() );
                    $attachment_id=get_post_thumbnail_id();
                    $props      = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
                    $image_title = $props['title'];
                    $image_link = $props['url'];
 
                      $image= wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props );
                                   
                    $image_class = esc_attr(implode(' ', $classes));
                 
                    $rel="useZoom: 'zoom1', smallImage: '".$image_link."'";    

                echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<div class="more-views-items"><a id="product-zoom" href="%s" class="%s" title="%s" rel="%s"  data-image="%s" data-zoom-image="%s" >%s</a></div>', esc_html($image_link), $image_class, esc_html($image_title), $rel,esc_html($image_link),esc_html($image_link), $image), $attachment_id, $post->ID, $image_class);
                   $loop++;
                    
                 }
                 

                foreach ($attachment_ids as $attachment_id) {

                    $classes = array('cloud-zoom-gallery');

                    if ($loop == 0 || $loop % $columns == 0)
                        $classes[] = 'first';

                    if (($loop + 1) % $columns == 0)
                        $classes[] = 'last';

                    $image_class = implode( ' ', $classes );
                    $props       = wc_get_product_attachment_props( $attachment_id, $post );          

                     $image_link = $props['url'];

                    if ( ! $image_link )
                      continue;                  

                    $image_title  = $props['title'];
                    $image_caption  = $props['caption'];

                   $image= wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props );

                    $rel="useZoom: 'zoom1', smallImage: '".$image_link."'";
                    echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<div class="more-views-items"><a id="product-zoom" href="%s" class="%s" title="%s" rel="%s" data-image="%s" data-zoom-image="%s">%s</a></div>', esc_url($image_link), esc_attr($image_class), esc_html($image_title), $rel,esc_url($image_link),esc_url($image_link),$image), $attachment_id, $post->ID, esc_attr($image_class));
                    ?>
                   

          
                    <?php
                    $loop++;
                }

                ?>
            </div>
             </div>
            </div>
             </div>

    <?php  }
}?>

 

