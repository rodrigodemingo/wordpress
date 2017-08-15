<?php

if(!function_exists('magikCreta_logo_image'))
{
function magikCreta_logo_image()
{ 
     global $creta_Options;
    $logoUrl = get_template_directory_uri() . '/images/logo.png';
                  
   if (isset($creta_Options['header_use_imagelogo']) && $creta_Options['header_use_imagelogo'] === 0) {           ?>
     <a title="<?php bloginfo('name'); ?>" href="<?php echo esc_url(get_home_url()); ?>">
               <?php bloginfo('name'); ?>
               </a>
               <?php
                  } else if (isset($creta_Options['header_logo']['url']) && !empty($creta_Options['header_logo']['url'])) { 
                      $logoUrl = $creta_Options['header_logo']['url'];
                      ?>
               <a title="<?php bloginfo('name'); ?>" href="<?php echo esc_url(get_home_url()); ?> "> <img
                  alt="<?php bloginfo('name'); ?>" src="<?php echo esc_url($logoUrl); ?>"
                  height="<?php echo !empty($creta_Options['header_logo_height']) ? esc_html($creta_Options['header_logo_height']) : ''; ?>"
                  width="<?php echo !empty($creta_Options['header_logo_width']) ? esc_html($creta_Options['header_logo_width']) : ''; ?>"> </a>
               <?php
                  } else { ?>
               <a title="<?php bloginfo('name'); ?>" href="<?php echo esc_url(get_home_url()); ?>"> 
               <img src="<?php echo esc_url($logoUrl) ;?>" alt="<?php bloginfo('name'); ?>"> </a>
               <?php } 

}
}

if(!function_exists('magikCreta_mobile_search'))
{
function magikCreta_mobile_search()
{ global $creta_Options;
  $MagikCreta = new MagikCreta();
    if (isset($creta_Options['header_remove_header_search']) && !$creta_Options['header_remove_header_search']) : 
        echo'<div class="mobile-search">';
         echo magikCreta_search_form();
         echo'<div class="search-autocomplete" id="search_autocomplete1" style="display: none;"></div></div>';
         endif;
}
}

if(!function_exists('magikCreta_search_form'))
{
 function magikCreta_search_form()
  {  
    global $creta_Options;
  $MagikCreta = new MagikCreta();
  ?>
  <?php if (isset($creta_Options['header_remove_header_search']) && !$creta_Options['header_remove_header_search']) : ?>
        <form name="myform" method="GET" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="text" maxlength="128" value="<?php echo get_search_query(); ?>" 
            name="s"  placeholder="<?php esc_attr_e('Search', 'creta'); ?>" 
            class="mgksearch search-bar-input" autocomplete="off">
             <?php if (class_exists('WooCommerce')) : ?>    
              <input type="hidden" value="product" name="post_type">
               <?php endif; ?>
              <button class="search-icon" title="<?php esc_attr_e('Search', 'creta'); ?>" type="submit"><span></span></button>
            
            </form>

 
            <?php  endif; ?>
  <?php
  }
}


if(!function_exists('magikCreta_currency_language'))
{
function magikCreta_currency_language()
{
  global $creta_Options;
   if((isset($creta_Options['enable_header_language']) && ($creta_Options['enable_header_language']!=0)) || (isset($creta_Options['enable_header_currency']) && ($creta_Options['enable_header_currency']!=0)))
        {?>
                           <div class="lang-curr">
                              <?php 
                                 if(isset($creta_Options['enable_header_language']) && ($creta_Options['enable_header_language']!=0))
                                     { ?>
                              <div class="form-language">
                                 <ul class="lang" role="menu">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/english.png" alt="<?php esc_attr_e('English', 'creta');?>">    </a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/francais.png" alt="<?php esc_attr_e('French', 'creta');?>"></a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/german.png" alt="<?php esc_attr_e('German', 'creta');?>">  </a></li>
                                 </ul>
                              </div>
                              <?php  } ?>
                              <!--form-language-->
                              <!-- END For version 1,2,3,4,6 -->
                              <!-- For version 1,2,3,4,6 -->
                              <?php if(isset($creta_Options['enable_header_currency']) && ($creta_Options['enable_header_currency']!=0))
                                 { ?>
                              <div class="form-currency">
                                 <ul class="currencies_list">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">
                                       <?php esc_attr_e('$', 'creta');?>
                                       </a>
                                    </li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">
                                       <?php esc_attr_e('&pound;', 'creta');?>
                                       </a>
                                    </li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">
                                       <?php esc_attr_e('&euro;', 'creta');?>
                                       </a>
                                    </li>
                                 </ul>
                              </div>
                              <?php  } ?> 
                              <!--form-currency-->
                              <!-- END For version 1,2,3,4,6 -->
                           </div>
                           <?php  }  
}
}

if(!function_exists('magikCreta_footer_text1'))
{
   function magikCreta_footer_text1()
  {
    global $creta_Options;
    if (isset($creta_Options['footer-text1']) && !empty($creta_Options['footer-text1'])) {
      echo htmlspecialchars_decode ($creta_Options['footer-text1']);
    }
    
  }
}


if(!function_exists('magikCreta_home_page_banner'))
{
function magikCreta_home_page_banner()
{
    global $creta_Options;
    if(isset($creta_Options['enable_home_gallery']) && $creta_Options['enable_home_gallery']  && isset($creta_Options['home-page-slider']) && !empty($creta_Options['home-page-slider'])) {  
        ?>
   <div class="rev_slider_wrapper"> 
    <!-- START REVOLUTION SLIDER 5.0 auto mode -->
    <div id="rev_slider" class="rev_slider"  data-version="5.0">
      <ul>

              <?php foreach($creta_Options['home-page-slider'] as $slide) :?>
            <li data-transition="fade">  <img src="<?php echo esc_url($slide['image']); ?>"  alt="<?php echo esc_html($slide['title']);?>" /> 
              <?php echo htmlspecialchars_decode($slide['description']); ?>
               <a class="s-link" href="<?php echo !empty($slide['url']) ? esc_url($slide['url']) : '#' ?>"></a>
               </li>
              <?php endforeach; ?>
            </ul>
             <div class="tp-bannertimer"></div>
      </div>

  

<!-- end Slider --> 
<script type="text/javascript">
           var $=jQuery.noConflict();
          var revapi;
  jQuery(document).ready(function() {   
    revapi = jQuery("#rev_slider").revolution({
      sliderType:"standard",
      sliderLayout:"fullscreen",
      fullScreenOffset:"0px",
      delay:9000,
      navigation: {
        arrows:{enable:true}        
      },      
      gridwidth:1200,
      gridheight:720    
    });   
  }); /*ready*/
</script>
</div>
<?php 
    }
}
}

if(!function_exists('magikCreta_header_service'))
{
function magikCreta_header_service()
{
    global $creta_Options;

if (isset($creta_Options['header_show_info_banner']) && !empty($creta_Options['header_show_info_banner'])) :
                  ?>
    <div class="home-block">
      <div class="container">
        <div class="row">
       <ul>
   
                     <?php if (!empty($creta_Options['header_shipping_banner'])) : ?>
                      <li>
                      <div class="feature-box">
                        
                        <div class="content"><?php echo htmlspecialchars_decode($creta_Options['header_shipping_banner']); ?></div>
                      </div>
                       </li>
                      <?php endif; ?>
                 
                  
                       <?php if (!empty($creta_Options['header_customer_support_banner'])) : ?>
                       <li>|</li>
                     <li>
                      <div class="feature-box">
                        <div class="content"><?php echo htmlspecialchars_decode($creta_Options['header_customer_support_banner']); ?></div>
                      </div>
                      </li>
                       <?php endif; ?>
                    
                    <?php if (!empty($creta_Options['header_moneyback_banner'])) : ?>
                     <li>|</li>
                      <li>
                      <div class="feature-box">
                        <div class="content"><?php echo htmlspecialchars_decode($creta_Options['header_moneyback_banner']); ?></div>
                      </div>
                      </li>
                      <?php endif; ?>

                     <?php if (!empty($creta_Options['header_returnservice_banner'])) : ?>
                      <li>|</li>
                      <li class="last">
                    <div class="feature-box">
                      <div class="content"><?php echo htmlspecialchars_decode($creta_Options['header_returnservice_banner']); ?></div>
                    </div>
                      </li>
                    <?php endif; ?>
                
                     
               </ul>
            </div>
        </div>
      </div>

    <?php
   
     endif;
}
}

if(!function_exists('magikCreta_footer_middle'))
{
function magikCreta_footer_middle()
{
  global $creta_Options;
 if (isset($creta_Options['enable_footer_middle']) && !empty($creta_Options['enable_footer_middle'])) {?>
    <div class="newsletter-row">
      <div class="container">
        <div class="row">
          <!-- Footer Newsletter -->
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
           <?php  if (isset($creta_Options['enable_mailchimp_form']) && !empty($creta_Options['enable_mailchimp_form'])) {?> 
          <!-- Footer Newsletter -->
          <?php 
            if( function_exists( 'mc4wp_show_form' ) ) {
                 ?> 
        
            <div class="newsletter-wrap">
               <?php
                 mc4wp_show_form();
                ?>
           
            <!--newsletter-wrap-->
          </div>
          <?php  }
        }  ?>
           </div>
         <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
            <!-- Footer Payment Link -->
            <?php if (isset($creta_Options['enable_footer_middle']) && !empty($creta_Options['footer_middle']))
             {?>
     
             <?php echo htmlspecialchars_decode($creta_Options['footer_middle']);?>

               
   <?php   }  ?>
        </div>

        </div>
      </div>
      <!--footer-column-last-->
    </div>
    <?php  }  

}
}

if(!function_exists('magikCreta_related_upsell_template'))
{
function magikCreta_related_upsell_template()
{
  $MagikCreta = new MagikCreta();
 global $product, $woocommerce_loop, $yith_wcwl,$post;


$imageUrl = woocommerce_placeholder_img_src();
if (has_post_thumbnail())
    $imageUrl =  wp_get_attachment_image_src(get_post_thumbnail_id(),'magikCreta-product-size-large');  
?>
<!-- Item -->
<div class="item">
                      <div class="item-inner">
                        <div class="images-container">
                          <div class="product-hover"> 
                            <a href="<?php the_permalink(); ?>" title="<?php echo htmlspecialchars_decode($post->post_title); ?>" 
                             class="product-image">
                              <figure class="img-responsive">
                              <img alt="<?php echo htmlspecialchars_decode($post->post_title); ?>" src="<?php echo esc_url($imageUrl[0]); ?>">
                              </figure></a> 
                               <?php if ($product->is_on_sale()) : ?>
                               <div class="new-label new-top-right">
                              <?php esc_attr_e('Sale', 'creta'); ?>
                              </div>
                              <?php endif; ?>
                           </div>

                          <div class="actions-no hover-box"> <a class="detail_links" href="<?php the_permalink(); ?>"></a>
                            <div class="actions">
                               <ul class="add-to-links pull-left-none">

                                <li class="pull-left-none">
                                    <?php
                               if (isset($yith_wcwl) && is_object($yith_wcwl)) {
                            $classes = get_option('yith_wcwl_use_button') == 'yes' ? 'class="link-wishlist"' : 'class="link-wishlist"';
                            ?>

                            <a href="<?php echo esc_url($yith_wcwl->get_addtowishlist_url()) ?>"  data-product-id="<?php echo esc_html($product->id); ?>"
                              data-product-type="<?php echo esc_html($product->product_type); ?>" <?php echo htmlspecialchars_decode($classes); ?>
                                ><i class="fa fa-heart-o icons"></i></a> 
                             <?php
                               }
                               ?>
                                  
                                </li>

                                <li class="pull-left-none">
                                   <?php if (class_exists('YITH_Woocompare_Frontend')) {
                               $mgk_yith_cmp = new YITH_Woocompare_Frontend; ?>      
                              <a href="<?php echo esc_url($mgk_yith_cmp->add_product_url($product->id)); ?>" class="compare link-compare add_to_compare" data-product_id="<?php echo esc_html($product->id); ?>"
                                ><i class="fa fa-signal icons"></i></a>
                              <?php
                              }
                             ?> 

                                </li>
                                <li class="link-view pull-left-none">
                                   <?php if (class_exists('YITH_WCQV_Frontend')) { ?>
                                     <div class="product-detail-bnt">
                                      <a class="yith-wcqv-button button detail-bnt" href="<?php echo esc_url($mgk_yith_cmp->add_product_url($product->id)); ?>" 
                                        data-product_id="<?php echo esc_html($product->id); ?>">
                                        <span><?php esc_attr_e('Quick View', 'creta'); ?></span></a>
                                     </div>

                                     <?php } ?>

                                </li>
                                
                              </ul>

                            </div>
                            <div class="actions-cart">
                              <?php $MagikCreta->magikCreta_woocommerce_product_add_to_cart_text() ;?>
                            </div>
                          </div>
                        </div>
                        <div class="item-info">
                          <div class="info-inner">
                            <div class="item-title">
                                <a href="<?php the_permalink(); ?>"
                                               title="<?php echo htmlspecialchars_decode($post->post_title); ?>"> <?php echo htmlspecialchars_decode($post->post_title); ?> </a> </div>
       
                            </div>
                            <div class="item-content">
                              <div class="rating">
                                <div class="ratings">
                                  <div class="rating-box">
                                     <?php $average = $product->get_average_rating(); ?>
                                       <div class="rating"  style="width:<?php echo esc_html(($average / 5) * 100); ?>%"></div>
                                  </div>
                                  
                                </div>
                              </div>
                              <div class="item-price">
                                <div class="price-box">
                                  <?php echo htmlspecialchars_decode($product->get_price_html()); ?>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>
                    


<?php
}
}

if(!function_exists('magikCreta_footer_brand_logo'))
{
function magikCreta_footer_brand_logo()
  {
    global $creta_Options;
    if (isset($creta_Options['enable_brand_logo']) && $creta_Options['enable_brand_logo'] && !empty($creta_Options['all-company-logos'])) : ?>
    
    <div class="brand-logo wow bounceInUp animated animated">
    <div class="container">
      <div class="row">
      <div class="slider-items-products">
        <div id="brand-logo-slider" class="product-flexslider hidden-buttons">
          <div class="slider-items slider-width-col6"> 
            
            <!-- Item -->
            
                   <?php foreach ($creta_Options['all-company-logos'] as $_logo) : ?>
                  <div class="item">
                    <a href="<?php echo esc_url($_logo['url']); ?>">
                     <img
                        src="<?php echo esc_url($_logo['image']); ?>" 
                        alt="<?php echo esc_attr($_logo['title']); ?>"> </a>
                  </div>
                  <?php endforeach; ?>
                
      </div>
    </div>
  </div>
</div>
  </div>
  </div>

  <?php endif;
  }
}

