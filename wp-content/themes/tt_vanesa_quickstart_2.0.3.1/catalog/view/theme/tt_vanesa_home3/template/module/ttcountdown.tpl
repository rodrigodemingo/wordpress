<?php if($permission == true): ?>
<div class="container">
<div class="specialproductslider">
<div class="specialproductslider-title"><h3><?php echo $heading_title; ?></h3></div>
<div class="row">
<div class="product-layout countdown-products">
    <?php foreach ($products as $product) : ?>
    <div class="item-inner">
        <div class="product-thumb transition">
				<div class="image">
					<div class="image">
						<a href="<?php echo $product['href']; ?>">
							<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
							<img class="img2" src="<?php echo $product['rotator_image']; ?>" alt="<?php echo $product['name']; ?>" />
						</a>
					</div>
					<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
					<?php if (isset($product['rating'])) { ?>
					<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="" /></div>
					<?php } ?>
					<div class="price-box">
						<?php if ($product['orgprice']) { ?>
						<p class="price">
							<?php if (!$product['special']) { ?>
							<?php echo $product['orgprice']; ?>
							<?php } else { ?>
							<span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['orgprice']; ?></span>
							<?php } ?>
							<?php if ($product['tax']) { ?>
							<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
							<?php } ?>
						</p>
						<?php } ?>
					</div>
				</div>
                <!-- <p class="description"><?php echo $product['description']; ?></p> -->
                <?php if ($product['rating']) { ?>
                <div class="rating">
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <?php if ($product['rating'] < $i) { ?>
                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                    <?php } else { ?>
                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                    <?php } ?>
                    <?php } ?>
                </div>
                <?php } ?>
				<div class="right-time">
					<div class="actions">
						<div class="cart">
							<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span><span><i class="fa fa-shopping-cart"></i> Add to cart</span></span></button>
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
					<div class="box-timer">
						<?php if(strtotime($product['date_end'])) { ?>
						<div id="Countdown<?php echo $product['product_id']?>"></div>
						<?php } ?>
						<?php if(strtotime($product['date_end'])) { ?>
							<script type="text/javascript">
								$(function () {
									var austDay = new Date();
									austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
									$('#Countdown<?php echo $product['product_id'];?>').countdown({
										until: new Date(
											<?php echo date("Y",strtotime($product['date_end']))?>,
											<?php echo date("m",strtotime($product['date_end']))?> -1, 
											<?php echo date("d",strtotime($product['date_end']))?>,
											<?php echo date("H",strtotime($product['date_end']))?>,
											<?php echo date("i",strtotime($product['date_end']))?>, 
											<?php echo date("s",strtotime($product['date_end']))?>
											)
									});
								});
							</script>
						<?php } ?>
					</div>
				</div>
        </div>
    </div>
    

    <?php endforeach;  ?>
</div>
</div>
</div>
</div>
<script type="text/javascript">
	$('.countdown-products').owlCarousel({
			navigation:true,
			pagination: false,
			slideSpeed : 500,
			goToFirstSpeed : 1500,
			autoHeight : false,
			items :3,
			itemsDesktop : [1199,2], 
			itemsDesktopSmall : [900,2], 
			itemsTablet: [680,2], 
			itemsMobile : [480,1]
			
	});
</script>
<?php endif; ?>


