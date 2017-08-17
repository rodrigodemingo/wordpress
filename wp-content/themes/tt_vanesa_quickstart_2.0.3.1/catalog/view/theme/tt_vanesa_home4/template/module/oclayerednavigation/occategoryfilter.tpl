<?php if ($products) { ?>
<p><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></p>
<div class="product-filter">
    <div class="col-md-4">
        <div class="btn-group hidden-xs">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
        </div>
    </div>
    <div class="col-md-2 text-right">
        <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
    </div>
    <div class="col-md-3 text-right">
        <select id="input-sort" class="form-control" onchange="oclayerednavigationajax.filter(this.value)">
            <?php foreach ($sorts as $sorts) { ?>
            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-1 text-right">
        <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
    </div>
    <div class="col-md-2 text-right">
        <select id="input-limit" class="form-control" onchange="oclayerednavigationajax.filter(this.value)">
            <?php foreach ($limits as $limits) { ?>
            <?php if ($limits['value'] == $limit) { ?>
            <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
            <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>
<br />
<div class="row">
    <?php foreach ($products as $product) { ?>
        <div class="product-layout product-list col-xs-12">
		<div class="product-container item">
			<div class="item-inner">
				  <div class="left-block">
					<div class="image">
						<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
						<?php if ($product['special']) { ?>
						 <span class="sale"> Sale </span>
						<?php } else {if ($product['is_new']){?>
						 <div class="new"> New </div>
						<?php }} ?>
						<div class="button-group button-group1 actions">
							<div class="cart"><button type="button" class="add-to-cart" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i></button></div>
							<ul class="add-to-links">
								<li><button type="button" class="wishlist" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button></li>
								<li><button type="button" class="compare" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button></li>
							</ul>
						</div>
					</div>
				  </div>
					<div class="right-block">
						<div class="caption">
							<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
							<?php if ($product['price']) { ?>
							<?php } ?>
							<div class="price-box">
								<p class="price">
								  <?php if (!$product['special']) { ?>
								  <?php echo $product['price']; ?>
								  <?php } else { ?>
								  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
								  <?php } ?>
								  <?php if ($product['tax']) { ?>
								  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
								  <?php } ?>
								</p>
							</div>
							<p class="description"><?php echo $product['description']; ?></p>
							<div class="button-group2 actions">
								<div class="cart"><button type="button" class="add-to-cart" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i></button></div>
								<ul class="add-to-links">
									<li><button type="button" class="wishlist" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button></li>
									<li><button type="button" class="compare" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button></li>
								</ul>
							</div>
						</div>
					</div>
			</div>
		</div>
		</div>
        <?php } ?>
</div>
<div class="row product-filter">
    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
</div>
<?php } ?>
<?php if (!$categories && !$products) { ?>
<p><?php echo $text_empty; ?></p>
<div class="buttons">
    <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
</div>
<?php } ?>

<script type="text/javascript">
    // Product List
    $('#list-view').click(function() {
        $('#content .product-layout > .clearfix').remove();

        $('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');

        localStorage.setItem('display', 'list');
    });

    // Product Grid
    $('#grid-view').click(function() {
        $('#content .product-layout > .clearfix').remove();

        // What a shame bootstrap does not take into account dynamically loaded columns
        cols = $('#column-right, #column-left').length;

        if (cols == 2) {
            $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
        } else if (cols == 1) {
            $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
        } else {
            $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
        }

        localStorage.setItem('display', 'grid');
    });
</script>

