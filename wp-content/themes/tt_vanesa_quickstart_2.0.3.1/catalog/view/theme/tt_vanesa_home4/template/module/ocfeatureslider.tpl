<?php 
	$count = 0; 
	$row=1;
	$rows = $config_slide['f_rows']; 
	if(!$rows) {$rows=1;}
?>
<div class="container">
<div class="featured-container">
<div class="featured-sldier-title"><h2><?php echo $heading_title; ?></h2></div>
<div class="row">
<div class="owl-demo-feature">
  <?php foreach ($products as $product) { ?>
  <?php if($count++ % $rows == 0 ) { echo '<div class="row_items">'; }  ?>
  <div class="item_product item">
    <div class="product-thumb transition item-inner">
		<?php if ($product['special']) { ?>
			<span class="sale"> Sale </span>
		<?php } ?>
		<?php if ($product['thumb']) { ?>
		<div class="image">
			<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a>
			<div class="button-group">
				<?php if($config_slide['f_show_addtocart']) { ?>
				<button type="button" class="add-to-cart" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i></button>
				<?php } ?>
				<button type="button" class="compare" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
				<button type="button" class="wishlist" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
			</div>
		</div>
		<?php } else { ?>
		<div class="image"><a href="<?php echo $product['href']; ?>"><img src="image/cache/no_image-100x100.png" alt="<?php echo $product['name']; ?>" /></a></div>
		<?php } ?>
		<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if($config_slide['f_show_price']){ ?>
        <?php if ($product['price']) { ?>
        <p class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>
          <?php if ($product['tax']) { ?>
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
          <?php } ?>
        </p> <?php } ?>
        <?php } ?>
    </div>
  </div>
  <?php if($count % $rows == 0 ) { echo '</div>'; }  ?>
  <?php } ?>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() { 
  $(".owl-demo-feature").owlCarousel({
	  slideSpeed: <?php if($config_slide['f_ani_speed']) { echo $config_slide['f_ani_speed'] ;} else { echo 3000;} ?>,
      items : <?php if($config_slide['items']) { echo $config_slide['items'] ;} else { echo 3;} ?>,
	  autoPlay : <?php if($config_slide['f_speed_slide']) { echo 'true' ;} else { echo 'false';} ?>,
	  navigation : <?php if($config_slide['f_show_nextback']) { echo 'true' ;} else { echo 'false';} ?>,
	  paginationNumbers : true,
	  pagination : <?php if($config_slide['f_show_ctr']) { echo 'true' ;} else { echo 'false';} ?>,
	  stopOnHover : false,
	itemsDesktop : [1199,3], 
    itemsDesktopSmall : [900,3], // betweem 900px and 601px
    itemsTablet: [768,2], //2 items between 600 and 0
    itemsMobile : [480,1] // itemsMobile disabled - inherit from itemsTablet option
  });
 
});
</script>