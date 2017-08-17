<?php $tab_effect = 'wiggle'; ?>
<?php 
	$count = 0; 
	$row=1;
	$row = $config_slide['f_rows']; 
	if(!$row) {$row=1;}
?>
<script type="text/javascript">

$(document).ready(function() {

	$(".tab_content").hide();
	$(".tab_content:first").show(); 

	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content").hide();
		$(".tab_content").removeClass("animate1 <?php echo $tab_effect;?>");
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab) .addClass("animate1 <?php echo $tab_effect;?>");
		$("#"+activeTab).fadeIn(); 
	});
});

</script>
<div class="product-tabs-container-slider">
	<ul class="tabs"> 
	<?php $count=0; ?>
	<?php foreach($productTabslider as $productTab ){ ?>
		<li rel="tab_<?php echo $productTab['id']; ?>"  >
			<?php echo $productTab['name']; ?>
		</li>
			<?php $count= $count+1; ?>
	<?php } ?>	
	</ul>
		<div class="tab_container"> 
		<?php foreach($productTabslider as $productTab){ ?>
			<div id="tab_<?php echo $productTab['id']; ?>" class="tab_content">
				<ul class="owl-demo-tabproduct">
				<?php $i=0; ?>
				<?php foreach ($productTab['productInfo'] as $product){ ?>
						<?php if($i++ % $row ==0){  echo  "<li class='row_item'><ul>"; } ?>
							 <li class="item">
								<?php if ($product['thumb']) { ?>
								<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
								<?php } ?>
								<?php if($config_slide['f_show_des']) { ?>
								
								<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
								<?php } ?>
								<?php if($config_slide['f_show_price']) { ?>
								<?php if ($product['price']) { ?>
								<div class="price">
								  <?php if (!$product['special']) { ?>
								  <?php echo $product['price']; ?>
								  <?php } else { ?>
								  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
								  <?php } ?>
								</div>
								<?php } ?>
								<?php } ?>
								
								<?php if ($product['rating']) { ?>
								<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
								<?php } ?>
								 <div class="button-group">
									<?php if($config_slide['f_show_addtocart']) { ?>
									<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
									<?php } ?>
									<button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
									<button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
								  </div>
						  </li>
						 <?php if($i % $row ==0){  echo  "</ul></li>"; } ?>
				<?php } ?>
				</ul>
			</div>

		<?php } ?>
	
	 </div> <!-- .tab_container -->

</div>

<script type="text/javascript">
$(document).ready(function() { 
  $(".owl-demo-tabproduct").owlCarousel({
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



