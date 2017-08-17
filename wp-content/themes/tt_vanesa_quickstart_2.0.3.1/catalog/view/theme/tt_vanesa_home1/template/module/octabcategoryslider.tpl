
<?php $tab_effect = 'wiggle'; ?>
<script type="text/javascript">

$(document).ready(function() {
	$(".<?php echo $cateogry_alias;?> .tab_content_category").hide();
	$(".<?php echo $cateogry_alias;?> .tab_content_category:first").show(); 
	var id_rel = $(".<?php echo $cateogry_alias;?> .tab_content_category:first").attr('id');
	$('.<?php echo $cateogry_alias;?> .tabs-category li').each(function() {
		if($(this).attr('rel') == id_rel) {
			$(this).addClass('active');
		}
	});

	$(".<?php echo $cateogry_alias;?> ul.tabs-category li").click(function() {
		$(".<?php echo $cateogry_alias;?> ul.tabs-category li").removeClass("active");
		$(this).addClass("active");
		$(".<?php echo $cateogry_alias;?> .tab_content_category").hide();
		$(".<?php echo $cateogry_alias;?> .tab_content_category").removeClass("animate1 <?php echo $tab_effect;?>");
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab) .addClass("animate1 <?php echo $tab_effect;?>");
		$("#"+activeTab).fadeIn(); 
	});
});

</script>
<?php 
	$row=1;
	$row = $config_slide['f_rows']; 
	if(!$row) {$row=1;}
?>
<div class="product-tabs-category-container-slider <?php echo $cateogry_alias;?>">
	<ul class="tabs-category"> 
	<?php $count=0; ?>
	<?php foreach($category_products as $cate_id => $products ){ ?>
		<li rel="tab_cate<?php echo $cate_id; ?>"  >
				<?php echo $array_cates[$cate_id]; ?>
		</li>
			<?php $count= $count+1; ?>
	<?php } ?>	
	</ul>
		<div class="tab_container_category row"> 
		<?php foreach($category_products as $cate_id => $products ){ ?>
			<div id="tab_cate<?php echo $cate_id; ?>" class="tab_content_category">
				
				<ul class="productTabContent owl-demo-tabcate">
				<?php $i=0; ?>
				<?php foreach ($products as $product){ ?>
							<?php if($i++ % $row ==0){  echo  "<li class='row_item'><ul>"; } ?>
							 <li class="tab-item item">
								<?php if ($product['thumb']) { ?>
								<div class="image">
								
									<a href="<?php echo $product['href']; ?>">
										<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
										<?php if(isset($product['rotator_image']) && $product['rotator_image'] != ""): ?>
											<img class="img2" src="<?php echo $product['rotator_image']; ?>" alt="<?php echo $product['name'] ?>" />
										<?php endif; ?>
									</a>
									<?php if ($product['special']) { ?>
									 <span class="sale"> Sale </span>
									<?php } else {if ($product['is_new']){?>
									 <div class="new"> New </div>
									<?php }} ?>
									<?php if ($product['price']) { ?>
									<div class="price">
									  <?php if (!$product['special']) { ?>
									  <?php echo $product['price']; ?>
									  <?php } else { ?>
									  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
									  <?php } ?>
									</div>
									<?php } ?>
								</div>
								<?php } ?>
								<div class="actions">
									<div class="cart">
										<?php if($config_slide['tab_cate_show_addtocart']) { ?>
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
								<?php if($config_slide['tab_cate_show_des']) { ?>
								<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
								<?php } ?>
								<?php if (isset($product['rating'])) { ?>
								<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="" /></div>
								<?php } ?>
								<?php if ($product['rating']) { ?>
								<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
								<?php } ?>
						  </li>
						  	<?php if($i % $row ==0){  echo  "</ul></li>"; } ?>
				<?php } ?>
				</ul>
			</div>

		<?php } ?>
	
	 </div> <!-- .tab_container_category -->

</div>


<script type="text/javascript">
$(document).ready(function() { 
  $(".<?php echo $cateogry_alias;?> .owl-demo-tabcate").owlCarousel({
      autoPlay: false, //Set AutoPlay to 3 seconds
      items : <?php if($config_slide['items']) { echo $config_slide['items'] ;} else { echo 3;} ?>,
	  slideSpeed : <?php if($config_slide['tab_cate_speed_slide']) { echo $config_slide['tab_cate_speed_slide'] ;} else { echo 200;} ?>,
	  navigation : <?php if($config_slide['tab_cate_show_nextback']) { echo 'true' ;} else { echo 'false';} ?>,
	  paginationNumbers : true,
	  pagination : false,
	  stopOnHover : false,
	itemsDesktop : [1199,3], 
    itemsDesktopSmall : [900,3], // betweem 900px and 601px
    itemsTablet: [768,2], //2 items between 600 and 0
    itemsMobile : [480,1] // itemsMobile disabled - inherit from itemsTablet option
  });
 
});
</script>




