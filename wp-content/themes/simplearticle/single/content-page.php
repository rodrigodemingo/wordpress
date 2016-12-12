<?php 
	global $gdlr_post_option;
	
	
	while ( have_posts() ){ the_post();
		$content = gdlr_content_filter(get_the_content(), true); 
		if(!empty($content)){
			?>
			<div class="main-content-container container gdlr-item-start-content">
				<div class="gdlr-item gdlr-main-content <?php 
					if( empty($gdlr_post_option['show-content']) || $gdlr_post_option['show-content'] == 'enable' ){
						echo 'gdlr-with-background';
					}
				?>">
					<?php echo $content; ?>
				</div>
			</div>
			<?php
		}
	} 
?>