<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see       https://docs.woocommerce.com/document/template-structure/
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
global $post, $woocommerce, $product,$creta_Options;


?>

            <div class="images product-image">
              
                <?php if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
                 {
                    ?>
                     <div class="large-image">
                  <?php if ($product->is_on_sale()) : ?>
                <div class="sale-label sale-top-left">
                    <?php esc_attr_e('Sale', 'creta'); ?>
                </div>
            <?php endif; ?>
                    <?php
                    if (has_post_thumbnail()) {

                    $attachment_count = count( $product->get_gallery_attachment_ids() );
                    $attachment_id=get_post_thumbnail_id();
                    $props      = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
                    $image_title = $props['title'];
                    $image_link = $props['url'];
 
                    $image     = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                        'title'  => $props['title'],
                       'alt'    => $props['alt'],
                        ) );

                      

                        echo apply_filters('woocommerce_single_product_image_html', sprintf('<a href="%s" itemprop="image" class="woocommerce-main-image cloud-zoom" title="%s"  id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20">%s</a>', esc_url($image_link), esc_html($image_title), $image), $post->ID);

                    } else {

                       echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

                    }
                    ?>
                    
                </div>      


        <?php } 
            else{?>

                 <?php if ($product->is_on_sale()) : ?>
                   <div class="sale-label sale-top-left">
                    <?php esc_attr_e('Sale', 'creta'); ?>
                   </div>
                  <?php endif; ?>
                    <div class="product-full">


                    <?php
                    if (has_post_thumbnail()) {

                      $attachment_count = count( $product->get_gallery_attachment_ids() );
                    $attachment_id=get_post_thumbnail_id();
                    $props      = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
                    $image_title = $props['title'];
                    $image_link = $props['url'];
 
                    $image     = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                        'title'  => $props['title'],
                       'alt'    => $props['alt'],
                        ) );
                      ?>
                      

                      <?php
                      
                       echo apply_filters('woocommerce_single_product_image_html', sprintf('<a href="%s" itemprop="image" class="woocommerce-main-image zoom cloud-zoom"><img src="%s" alt="%s"  id="product-zoom" data-zoom-image="%s" /></a>', esc_url($image_link), esc_url($image_link) ,esc_html($image_title), esc_url($image_link) , __('Placeholder', 'woocommerce')), $post->ID);
                      ?>
                    
                      <?php
 
                    } else {

                       echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

                    }
                    ?>
                    </div>

           <?php }?>                    
           
           <?php do_action('woocommerce_product_thumbnails'); ?>
                    </div>