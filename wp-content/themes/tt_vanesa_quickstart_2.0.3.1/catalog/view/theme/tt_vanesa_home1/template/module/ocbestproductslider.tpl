<div class="container">
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
    <div class="item_product">
        <div class="product-thumb transition item-inner">
            <div class="image">
				<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive"/></a>
				<div class="actions">
					<div class="button-group">
						<div class="add-to-links">
							<div class="wishlist"><button type="button" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i><span><?php echo $button_wishlist; ?></span></button></div>
							<div class="compare"><button type="button" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-refresh"></i><span><?php echo $button_compare; ?></span></button></div>
						</div>
					 </div>
				</div>
			</div>
			<div class="name"><h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4></div>
			<?php if($config_slide['f_show_des']){ ?>
			<p><?php echo $product['description']; ?></p>
			<?php } ?>
			<?php if ($product['rating']) { ?>
			<div class="rating">
				<?php for ($i = 1; $i <= 5; $i++) { ?>
				<?php if ($product['rating'] < $i) { ?>
				<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
				<?php } else { ?>
				<span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i
							class="fa fa-star-o fa-stack-2x"></i></span>
				<?php } ?>
				<?php } ?>
			</div>
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
            <div class="cart">
				<?php if($config_slide['f_show_addtocart']) { ?>
				<button type="button" title="<?php echo $button_cart; ?>" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
				<?php } ?>
			</div>
        </div>
    </div>
    <?php if($count % $rows == 0 ) { echo '</div>'; } ?>
    <?php } ?>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $(".owl-demo-bestsellerproduct").owlCarousel({
	  autoPlay: <?php if($config_slide['f_ani_speed']) { echo $config_slide['f_ani_speed'] ;} else { echo 3000;} ?>, //Set AutoPlay to 3 seconds
      items : <?php if($config_slide['items']) { echo $config_slide['items'] ;} else { echo 3;} ?>,
	  slideSpeed : <?php if($config_slide['f_speed_slide']) { echo $config_slide['f_speed_slide'] ;} else { echo 200;} ?>,
	  navigation : <?php if($config_slide['f_show_nextback']) { echo 'true' ;} else { echo 'false';} ?>,
	  paginationNumbers : true,
	  pagination : <?php if($config_slide['f_show_ctr']) { echo 'true' ;} else { echo 'false';} ?>,
	  stopOnHover : false,

  });

});
</script>