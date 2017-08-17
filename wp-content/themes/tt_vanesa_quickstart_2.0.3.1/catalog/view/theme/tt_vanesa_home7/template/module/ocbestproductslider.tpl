
<div class="bestseller-sldier">
<div class="bestseller-sldier-title"><h3><?php echo $heading_title; ?></h3></div>
<div class="row">
<div class="owl-demo-bestsellerproduct">
    <?php
	$count = 0;
	$row=1;
	$rows = $config_slide['f_rows'];
	if(!$rows) {$rows=1;}
  ?>
    <?php foreach ($products as $product) { ?>
    <?php if($count++ % $rows == 0 ) { echo '<div class="row_items">'; } ?>
    <div class="item_product item">
        <div class="product-thumb transition item-inner">
            <div class="image">
				<a href="<?php echo $product['href']; ?>">
					<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive"/>
					<?php if(isset($product['rotator_image']) && $product['rotator_image'] != ""): ?>
						<img class="img2" src="<?php echo $product['rotator_image']; ?>" alt="<?php echo $product['name'] ?>" />
					<?php endif; ?>
				</a>
				<?php if ($product['special']) { ?>
				 <span class="sale"> Sale </span>
				<?php } else {if ($product['is_new']){?>
				 <div class="new"> New </div>
				<?php }} ?>
				<div class="price-rate">
					<?php if (isset($product['rating'])) { ?>
					  <div class="rating"><img src="catalog/view/theme/default/image/rating-<?php echo $product['rating']; ?>.png" alt="" /></div>
					  <?php } ?>
					<?php if($config_slide['f_show_price']){ ?>
					<?php if ($product['price']) { ?>
					<p class="price">
						<?php if (!$product['special']) { ?>
						<?php echo $product['price']; ?>
						<?php } else { ?>
						<span class="price-new"><?php echo $product['special']; ?></span> <span
								class="price-old"><?php echo $product['price']; ?></span>
						<?php } ?>
						<?php if ($product['tax']) { ?>
						<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
						<?php } ?>
					</p> <?php } ?>
					<?php } ?>
				</div>
				<div class="actions">
					<ul class="add-to-links">
						<li><button type="button" class="wishlist" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart-o"></i></button></li>
						<li><button type="button" class="compare" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-files-o"></i></button></li>
					</ul>
				</div>
			</div>
			<div class="name"><h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4></div>
			<?php if($config_slide['f_show_des']){ ?>
			<p><?php echo $product['description']; ?></p>
			<?php } ?>
            <div class="cart">
				<?php if($config_slide['f_show_addtocart']) { ?>
				<button type="button" class="add-to-cart" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> Add to cart</button>
				<?php } ?>
			</div>
        </div>
    </div>
    <?php if($count % $rows == 0 ) { echo '</div>'; } ?>
    <?php } ?>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $(".owl-demo-bestsellerproduct").owlCarousel({
	  autoPlay: false, //Set AutoPlay to 3 seconds
      items : <?php if($config_slide['items']) { echo $config_slide['items'] ;} else { echo 3;} ?>,
	  slideSpeed : <?php if($config_slide['f_speed_slide']) { echo $config_slide['f_speed_slide'] ;} else { echo 200;} ?>,
	  navigation : <?php if($config_slide['f_show_nextback']) { echo 'true' ;} else { echo 'false';} ?>,
	  paginationNumbers : true,
	  pagination : false,
	  stopOnHover : false,
	itemsDesktop : [1199,3], 
    itemsDesktopSmall : [900,2], // betweem 900px and 601px
    itemsTablet: [768,2], //2 items between 600 and 0
    itemsMobile : [480,1] // itemsMobile disabled - inherit from itemsTablet option
  });

});
</script>