<div class=" col-md-6">
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
					<div class="newproduct-left"><div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div></div>
					<div class="newproduct-right">
						<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
						<!-- <?php if (isset($product['rating'])) { ?>
					  <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="" /></div>
					  <?php } ?> -->
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
					</div>
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
  $(".owl-demo-newproduct").owlCarousel({
	  slideSpeed: <?php if($config_slide['f_ani_speed']) { echo $config_slide['f_ani_speed'] ;} else { echo 3000;} ?>,
      items : <?php if($config_slide['items']) { echo $config_slide['items'] ;} else { echo 3;} ?>,
	  autoPlay : false,
	  navigation : <?php if($config_slide['f_show_nextback']) { echo 'true' ;} else { echo 'false';} ?>,
	  paginationNumbers : true,
	  pagination : <?php if($config_slide['f_show_ctr']) { echo 'true' ;} else { echo 'false';} ?>,
	  stopOnHover : false,
	itemsDesktop : [1199,2], 
    itemsDesktopSmall : [900,2], // betweem 900px and 601px
    itemsTablet: [768,2], //2 items between 600 and 0
    itemsMobile : [480,2] // itemsMobile disabled - inherit from itemsTablet option
  });
 
});
</script>