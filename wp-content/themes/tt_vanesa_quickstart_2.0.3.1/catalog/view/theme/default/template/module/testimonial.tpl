<div class="col-sm-6 col-md-6 col-xs-12">
		<div class="testimonial-container">
				<div class="block-title">
						<strong>
								<span>
										<?php echo $heading_title; ?>
								</span>
						</strong>
				</div>
				<div class="block-content">
						<div id="slides">
								<?php $limit=$limits; $i=0; ?>
								<?php foreach ($testimonials as $testimonial) { ?>
										<?php if ($testimonial['content']) { ?>
												<div class="testimonial-content">
														<div class="testimonial-images pull-left">
																<?php   if($testimonial['image'] != null) { ?>
																<img src="<?php echo $testimonial['image'];?>" alt="plazathemes.com">
																<?php } ?>
														</div>
														<div class="testimonial-box media-body">
																<span class="testimonial-author"><?php echo $testimonial['customer_name']; ?></span>
																<em>-</em>
																<span class="testimonial-date">December 14, 2014</span>
																<a href="<?php echo $more; ?>"><?php echo substr($testimonial['content'],0,100)."..."; ?></a>
																<!--<div class="testimonial-submit"><a href="<?php echo $submit_testimonial; ?>"><span>Submit Testimonial...</span></a></div> -->
														</div>
														
												</div><!--testimonial-content-->
										<?php $i++; } ?>
								<?php if($i==$limit){break;} } ?>
								
						</div>
				</div><!--block-content-->
		</div><!--testimonial-container-->
</div>
<script type="text/javascript">
    $("#slides").owlCarousel({
        autoPlay : false,
		items : 1,
		itemsDesktop : [1199,1],
		itemsDesktopSmall : [980,1],
		itemsTablet: [768,1],
		itemsMobile : [479,1],
		slideSpeed : 3000,
		paginationSpeed : 3000,
		rewindSpeed : 3000,
		navigation : false,
		stopOnHover : true,
		pagination : true,
		scrollPerPage:true,
    });
</script>