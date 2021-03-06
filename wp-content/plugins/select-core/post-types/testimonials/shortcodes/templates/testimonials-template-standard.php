<div id="qodef-testimonials<?php echo esc_attr($current_id) ?>" class="qodef-testimonial-content">
	<div class="qodef-testimonial-content-inner">
        <?php if (has_post_thumbnail($current_id)) { ?>
            <div class="qodef-testimonial-image-holder">
                <?php esc_html(the_post_thumbnail($current_id)) ?>
            </div>
        <?php } ?>
		<div class="qodef-testimonial-text-holder">
			<div class="qodef-testimonial-text-inner">
                <div class="qodef-testimonial-info-holder">
                    <?php if ($show_author == "yes") { ?>
                        <div class = "qodef-testimonial-author">
                            <h3 class="qodef-testimonial-author-text">
                                <span><?php echo esc_attr($author)?></span><?php if($show_position == "yes" && $job !== ''){ ?><span class="qodef-testimonials-job">, <?php echo esc_attr($job)?></span><?php }?>
                            </h3>
                        </div>
                    <?php } ?>
                </div>
				<?php if($show_title == "yes"){ ?>
					<p class="qodef-testimonial-title">
						<?php echo esc_attr($title) ?>
					</p>
				<?php }?>
				<p class="qodef-testimonial-text"><?php echo trim($text) ?></p>
			</div>
        </div>
	</div>
</div>
