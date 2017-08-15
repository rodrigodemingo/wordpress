<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $creta_Options;
get_header('shop');

$plugin_url = plugins_url();

?>

  <?php  if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
{      
?> 
<script type="text/javascript"><!--

    jQuery(function ($) {

        "use strict";


        jQuery.display = function (view) {

            view = jQuery.trim(view);

            if (view == 'list') {
                jQuery(".button-grid").removeClass("button-active");
                jQuery(".button-list").addClass("button-active");
                jQuery.getScript("<?php echo  esc_url(site_url()) ; ?>/wp-content/plugins/yith-woocommerce-quick-view/assets/js/frontend.js", function () {
                });
                jQuery('.category-products .products-grid').attr('class', 'products-list');


                jQuery('ul.products-list  > li.item').each(function (index, element) {

                    var htmls = '';
                    var element = jQuery(this);


                    element.attr('class', 'item');


                    htmls += '<div class="pimg">';

                    var image = element.find('.pimg').html();

                    if (image != undefined) {
                        htmls += image;
                    }

                    htmls += '</div>';

            

                    htmls += '<div class="product-shop">';
                    if (element.find('.item-title').length > 0)
                        htmls += '<h2 class="product-name item-title"> ' + element.find('.item-title').html() + '</h2>';

                     var ratings = element.find('.ratings').html();

                    htmls += '<div class="rating"><div class="ratings">' + ratings + '</div></div>';

                    var descriptions = element.find('.desc').html();
                    htmls += '<div class="desc std">' + descriptions + '</div>';

                      var price = element.find('.price-box').html();

                    if (price != null) {
                        htmls += '<div class="price-box">' + price + '</div>';
                    }

                    htmls += '<div class="actions"><div class="action actions-no">' + element.find('.actions-no').html() + '</div>';
                  
                    htmls += '</div>';
                    htmls += '</div>';


                    element.html(htmls);
                });


                jQuery.cookie('display', 'list');

            } else {
                 var wooloop=1;
                 var pgrid='';
                 jQuery(".button-list").removeClass("button-active");
                 jQuery(".button-grid").addClass("button-active");
                 jQuery.getScript("<?php echo esc_url(site_url()); ?>/wp-content/plugins/yith-woocommerce-quick-view/assets/js/frontend.js", function () {
                 });
                 jQuery('.category-products .products-list').attr('class', 'products-grid');
                 
                 jQuery('ul.products-grid > li.item').each(function (index, element) {
                    var html = '';

                    element = jQuery(this);
                      if(wooloop%3==1) 
                    {
                     pgrid='wide-first';   
                     }
                     else if(wooloop%3==0) 
                     {
                     pgrid='last'; 
                      }
                      else
                      {
                       pgrid=''; 

                      }

                    element.attr('class', 'item col-lg-4 col-md-4 col-sm-4 col-xs-6 '+pgrid);

                    html += '<div class="item-inner"><div class="images-container"><div class="product-hover"><div class="pimg">';
              

                    var image = element.find('.pimg').html();

                    if (image != undefined) {

                        html += image;
                    }
                    html +='</div></div><div class="actions-no hover-box">';
                     var actions = element.find('.actions-no').html();
                   
                     html +=actions;

                     html +='</div></div>';

                      html +='<div class="item-info"><div class="info-inner">';
                       if (element.find('.item-title').length > 0)
                       {
                        html += '<div class="item-title"> ' + element.find('.item-title').html() + '</div>';
                    }


                html +='<div class="item-content">';
                        var ratings = element.find('.ratings').html();

                    html += '<div class="rating"><div class="ratings">' + ratings + '</div></div>';

                        var price = element.find('.price-box').html();

                     if (price != null) {
                        html += '<div classs="item-price"><div class="price-box"> ' + price + '</div></div>';
                    }

                    var descriptions = element.find('.desc').html();
                    html += '<div class="desc std">' + descriptions + '</div>';
                 
                    html += '</div></div></div></div></div>';

                    element.html(html);
                      wooloop++;
                 });

                 jQuery.cookie('display', 'grid');
            }
        }

        jQuery('a.list-trigger').click(function () {
            jQuery.display('list');

        });
        jQuery('a.grid-trigger').click(function () {
            jQuery.display('grid');
        });

        var view = 'grid';
        view = jQuery.cookie('display') !== undefined ? jQuery.cookie('display') : view;

        if (view) {
            jQuery.display(view);

        } else {
            jQuery.display('grid');
        }
        return false;


    });
    //--></script>
<?php } else{ ?>
<script type="text/javascript"><!--

    jQuery(function ($) {

        "use strict";


        jQuery.display = function (view) {

            view = jQuery.trim(view);

            if (view == 'list') {
                jQuery(".button-grid").removeClass("button-active");
                jQuery(".button-list").addClass("button-active");
                jQuery.getScript("<?php echo  esc_url(site_url()) ; ?>/wp-content/plugins/yith-woocommerce-quick-view/assets/js/frontend.js", function () {
                });
                jQuery('.category-products .products-grid').attr('class', 'products-list');


                jQuery('ul.products-list  > li.item').each(function (index, element) {

                    var htmls = '';
                    var element = jQuery(this);


                    element.attr('class', 'item');


                    htmls += '<div class="pimg">';

                    var image = element.find('.pimg').html();

                    if (image != undefined) {
                        htmls += image;
                    }

                    htmls += '</div>';

            

                    htmls += '<div class="product-shop">';
                    if (element.find('.item-title').length > 0)
                        htmls += '<h2 class="product-name item-title"> ' + element.find('.item-title').html() + '</h2>';

                     var ratings = element.find('.ratings').html();

                    htmls += '<div class="rating"><div class="ratings">' + ratings + '</div></div>';

                    var descriptions = element.find('.desc').html();
                    htmls += '<div class="desc std">' + descriptions + '</div>';

                      var price = element.find('.price-box').html();

                    if (price != null) {
                        htmls += '<div class="price-box">' + price + '</div>';
                    }

                    htmls += '<div class="actions"><div class="action">' + element.find('.action').html() + '</div>';
                    htmls += '<ul class="add-to-links">';
                     var adtolinks = element.find('.add-to-links').html();
                    if (adtolinks != undefined) {

                        htmls += adtolinks;
                    }
                     htmls += '</ul>';
                    htmls += '</div>';
                    htmls += '</div>';


                    element.html(htmls);
                });


                jQuery.cookie('display', 'list');

            } else {
                 var wooloop=1;
                 var pgrid='';
                 jQuery(".button-list").removeClass("button-active");
                 jQuery(".button-grid").addClass("button-active");
                 jQuery.getScript("<?php echo esc_url(site_url()); ?>/wp-content/plugins/yith-woocommerce-quick-view/assets/js/frontend.js", function () {
                 });
                 jQuery('.category-products .products-list').attr('class', 'products-grid');
                 
                 jQuery('ul.products-grid > li.item').each(function (index, element) {
                    var html = '';

                    element = jQuery(this);
                      if(wooloop%3==1) 
                    {
                     pgrid='wide-first';   
                     }
                     else if(wooloop%3==0) 
                     {
                     pgrid='last'; 
                      }
                      else
                      {
                       pgrid=''; 

                      }

                    element.attr('class', 'item col-lg-4 col-md-4 col-sm-4 col-xs-6 '+pgrid);

                    html += '<div class="item-inner"><div class="item-img"><div class="item-img-info"><div class="pimg">';
              

                    var image = element.find('.pimg').html();

                    if (image != undefined) {

                        html += image;
                    }
                    html +='</div><div class="box-hover"><ul class="add-to-links">';
                    var adtolinks = element.find('.add-to-links').html();

                    if (adtolinks != undefined) {

                        html += adtolinks;
                    }
                    html +='</ul></div></div></div>';
                    
                    html +='<div class="item-info"><div class="info-inner">';
                       if (element.find('.item-title').length > 0)
                       {
                        html += '<div class="item-title"> ' + element.find('.item-title').html() + '</div>';
                    }


                html +='<div class="item-content">';
                        var ratings = element.find('.ratings').html();

                    html += '<div class="rating"><div class="ratings">' + ratings + '</div></div>';

                        var price = element.find('.price-box').html();

                     if (price != null) {
                        html += '<div classs="item-price"><div class="price-box"> ' + price + '</div></div>';
                    }

                    var descriptions = element.find('.desc').html();
                    html += '<div class="desc std">' + descriptions + '</div>';
                    html += '<div class="action">';
                     var actions = element.find('.action').html();
                   
                     html +=actions;
                   html += '</div>';
                    html += '</div></div></div></div>';

                    element.html(html);
                      wooloop++;
                 });

                 jQuery.cookie('display', 'grid');
            }
        }

        jQuery('a.list-trigger').click(function () {
            jQuery.display('list');

        });
        jQuery('a.grid-trigger').click(function () {
            jQuery.display('grid');
        });

        var view = 'grid';
        view = jQuery.cookie('display') !== undefined ? jQuery.cookie('display') : view;

        if (view) {
            jQuery.display(view);

        } else {
            jQuery.display('grid');
        }
        return false;


    });
    //--></script>

    <?php } ?>
<?php

 do_action('woocommerce_before_main_content'); 

/**
 * woocommerce_before_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */

?>

  <div class="main-container col2-left-layout bounceInUp animated"> 
    <!-- For version 1, 2, 3, 8 --> 
    <!-- For version 1, 2, 3 -->
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-sm-push-3">

    <?php  if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='default')
       {       
        ?>    
        <?php do_action('woocommerce_archive_description'); ?>
         <?php  } ?> 

      <div class="col-main">
      <?php if (have_posts()) : ?>

      <?php  if (isset($creta_Options['theme_layout']) && $creta_Options['theme_layout']=='version2')
        { ?>                                              
                    <div class="toolbar">
                    <?php
                    /**
                     * woocommerce_before_shop_loop hook
                     *
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action('woocommerce_before_shop_loop');
                    ?>
                   
                  </div>

                <?php }
                else { ?>
               <div class="page-heading"> 
                <?php if(apply_filters('woocommerce_show_page_title', true)) : ?>
                    <h2> <span class="page-heading-title">
                      <?php esc_html(woocommerce_page_title()); ?>
                    </span></h2>
                    <?php endif; ?>
                    <div class="toolbar">
                    <?php
                    /**
                     * woocommerce_before_shop_loop hook
                     *
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action('woocommerce_before_shop_loop');
                    ?>                   
                  </div>
                </div>

               <?php } ?>
               
                <div class="category-products">
                    <?php woocommerce_product_loop_start(); ?>
                    <?php woocommerce_product_subcategories(); ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php wc_get_template_part('content', 'product'); ?>
                    <?php endwhile; // end of the loop. ?>
                    <?php woocommerce_product_loop_end(); ?>
                    <?php
                    /**
                     * woocommerce_after_shop_loop hook
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                     ?>
                    <div class="after-loop">
                      <?php
                    do_action('woocommerce_after_shop_loop');
                    ?>
                    </div>            
                </div> 
        
              
                 <?php 
                elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) :         wc_get_template('loop/no-products-found.php');
                endif; ?>
             </div>      
            </div>
            <aside class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9">
            
                <?php
                /**
                 * woocommerce_sidebar hook
                 *
                 * @hooked woocommerce_get_sidebar - 10
                 */
                do_action('woocommerce_sidebar');
                ?>
               
            </aside>
        
        </div>
    </div>
</div>
<?php
/**
 * woocommerce_after_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>

<?php get_footer('shop'); ?>
