<?php if($permission == true): ?>
<div class="countdown-title"><h3><?php echo $heading_title; ?></h3></div>
<div class="product-layout countdown-products">
    <?php foreach ($products as $product) : ?>
    <div class="item-inner">
        <div class="product-thumb transition">
			<div class="box-item">
				<div class="product-image">
					<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
					<div class="image1"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
				</div>
			</div>
                <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                <p class="description"><?php echo $product['description']; ?></p>
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
				<div class="actions">
					<div class="button-group">
					<div class="add-to-links">
						<div class="cart">
							<button class="fa fa-shopping-cart" data-toggle="tooltip" title="<?php echo $button_cart; ?>" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_cart; ?></span></button>
						</div>
						<div class="wishlist"><button class="fa fa-heart" data-toggle="tooltip" type="button" title="<?php echo $button_wishlist; ?>"  onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_wishlist; ?></span></button></div>
						<div class="compare"><button class="fa fa-retweet" data-toggle="tooltip" type="button" title="<?php echo $button_compare; ?>"  onclick="compare.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_compare; ?></span></button></div>
					</div>
					</div>
				</div>
        </div>
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
    

    <?php endforeach;  ?>
</div>
<script type="text/javascript">
	$('.countdown-products').owlCarousel({
			navigation:false,
			pagination: true,
			slideSpeed : 500,
			goToFirstSpeed : 1500,
			autoHeight : false,
			items :1,
			itemsDesktop : [1199,1], 
			itemsDesktopSmall : [900,1], 
			itemsTablet: [680,1], 
			itemsMobile : [480,1]
			
	});
</script>
<?php endif; ?>


