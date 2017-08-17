<div class="new-products-container">
<div class="new-products-slider"><h2><?php echo $heading_title; ?></h2></div>
 <?php 
	$count = 0; 
	$row=1;
	$rows = $config_slide['f_rows']; 
	if(!$rows) {$rows=1;}
  ?>
	<div class="row">
		<div class="owl-demo-newproduct">
		  <?php foreach ($products as $product) { ?>
			<?php if($count++ % $rows == 0 ) { echo '<div class ="row_items">'; }  ?>
			<div class="item_product">
				<div class="product-thumb transition item-inner">
					<?php if ($product['special']) { ?>
						<span class="sale"> Sale </span>
					<?php } ?>
					<div class="image">
						<a href="<?php echo $product['href']; ?>">
							<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
							<img class="img2" src="<?php echo $product['rotator_image']; ?>" alt="<?php echo $product['name']; ?>" />
						</a>
					</div>
					<?php if($config_slide['f_show_price']){ ?>
						<?php if ($product['price']) { ?>
							<div class="price">
							  <?php if (!$product['special']) { ?>
							  <?php echo $product['price']; ?>
							  <?php } else { ?>
							  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
							  <?php } ?>
							  <?php if ($product['tax']) { ?>
							  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
							  <?php } ?>
							</div>
						<?php } ?>
					<?php } ?>
					<div class="actions">
						<div class="cart">
							<?php if($config_slide['f_show_addtocart']) { ?>
							<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span><span><i class="fa fa-shopping-cart"></i> Add to cart</span></span></button>
							<?php } ?>
						</div>
						<ul class="add-to-links">
							<li>
								<button type="button" class="wishlist" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i><span>wishlist</span></button>
							</li>
							<li>
								<button type="button" class="compare" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i><span>compare</span></button>
							</li>
						</ul>
					</div>
					<div class="name"><h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4></div>
					<?php if (isset($product['rating'])) { ?>
					<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="" /></div>
					<?php } ?>
				</div>
			</div>
			 <?php if($count % $rows == 0 ) { echo '</div>'; }  ?>
		  <?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() { 
  $(".owl-demo-newproduct").owlCarousel({
	  slideSpeed: <?php if($config_slide['f_ani_speed']) { echo $config_slide['f_ani_speed'] ;} else { echo 3000;} ?>,
      items : <?php if($config_slide['items']) { echo $config_slide['items'] ;} else { echo 3;} ?>,
	  autoPlay : false,
	  navigation : <?php if($config_slide['f_show_nextback']) { echo 'true' ;} else { echo 'false';} ?>,
	  paginationNumbers : true,
	  pagination : <?php if($config_slide['f_show_ctr']) { echo 'true' ;} else { echo 'false';} ?>,
	  stopOnHover : false,
	itemsDesktop : [1199,4], 
    itemsDesktopSmall : [900,3], // betweem 900px and 601px
    itemsTablet: [768,2], //2 items between 600 and 0
    itemsMobile : [480,1] // itemsMobile disabled - inherit from itemsTablet option
  });
 
});
</script>