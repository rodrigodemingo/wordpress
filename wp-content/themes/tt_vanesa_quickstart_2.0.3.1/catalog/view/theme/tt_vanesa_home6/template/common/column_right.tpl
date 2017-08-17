<?php if ($modules) { ?>
<div id="column-right" class="col-sm-3 hidden-xs">
	<!-- Related Product -->
	<!-- <?php if ($related_products) { ?>
    <div class="only_product_page">
        <div class="title-module oc-title"><h2>Related products</h2></div>
          <div class="view-related">
            <?php foreach ($related_products as $product) { ?>
            <div class="related-items">
              <div class="product-thumb transition item-inner">
                <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
                
                <h2 class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h2>
                        <?php if ($product['rating']) { ?>
								    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <?php if ($product['rating'] == $i) {
                                                $class_r= "rating".$i;
                                                echo "<div class=\"".$class_r."\">rating</div>";
                                            }}  ?> 
                                    </div>
						<?php } ?>
                        <?php if ($product['price']) { ?>
					        <div class="price-box">
						        <?php if (!$product['special']) { ?>
						            <?php echo $product['price']; ?>
						        <?php } else { ?>
						            <p class="old-price"><span class="price"><?php echo $product['price']; ?></span></p> <p class="special-price"><span class="price"><?php echo $product['special']; ?></span></p>
						        <?php } ?>
					        </div>
				        <?php } ?>
              </div>
            </div>
            <?php } ?>
          </div>
      </div>
    <?php } ?> -->
	
	<!-- Modules -->
	<?php foreach ($modules as $module) { ?>
	<?php echo $module; ?>
	<?php } ?>

	<!-- Tags -->
	<?php if ($tags) { ?>
	<div class="block-tag">
		<div class="tag-title"><h2>Popular Tags</h2></div>
		  <p class="view-tag">
			<?php for ($i = 0; $i < count($tags); $i++) { ?>
			<?php if ($i < (count($tags) - 1)) { ?>
			<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
			<?php } else { ?>
			<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
			<?php } ?>
			<?php } ?>
		  </p>
	</div>
	<?php } ?>
</div>
<?php } ?>