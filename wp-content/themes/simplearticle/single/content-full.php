<?php
/**
 * The default template for displaying standard post format
 */

	if( !is_single() ){ 
		global $gdlr_post_settings; 
		if($gdlr_post_settings['excerpt'] < 0) global $more; $more = 0;
	}else{
		global $gdlr_post_settings, $theme_option;
	}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="gdlr-standard-style">

		<div class="blog-date-wrapper gdlr-title-font" >
		<?php
			echo '<i class="icon-calendar-empty"></i>';
			echo '<div class="blog-date-day">' . get_the_time('j') . '</div>';
			echo '<div class="blog-date-month">' . get_the_time('M') . '</div>';
			echo '<div class="blog-date-year">' . get_the_time('Y') . '</div>';
			
			if( function_exists('zilla_likes') ){ zilla_likes(); }
		?>
		</div>	

		<div class="blog-content-wrapper" >
			<?php get_template_part('single/thumbnail', get_post_format()); ?>	
			
			<div class="blog-content-inner-wrapper">
				<header class="post-header">
					<?php if( is_single() ){ ?>
						<h1 class="gdlr-blog-title"><?php the_title(); ?></h1>
					<?php }else{ ?>
						<h3 class="gdlr-blog-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
					<?php } ?>	
					
					<?php 
						// print blog information
						echo gdlr_get_blog_info(array('tag', 'author', 'comment', 'category'), true, '<span class="gdlr-seperator">/</span>'); 
						
						echo '<div class="gdlr-blog-info gdlr-title-font gdlr-info gdlr-blog-full-date">';
						echo gdlr_get_blog_info(array('date')); 
						echo '</div>'
					?>			
					<div class="clear"></div>
				</header><!-- entry-header -->

				<?php 
					if( is_single() || $gdlr_post_settings['excerpt'] < 0 ){
						echo '<div class="gdlr-blog-content">';
						echo gdlr_content_filter($gdlr_post_settings['content'], true);
						wp_link_pages( array( 
							'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'gdlr_translate' ) . '</span>', 
							'after' => '</div>', 
							'link_before' => '<span>', 
							'link_after' => '</span>' )
						);
						if( !is_single() ){ gdlr_get_social_shares(); }
						echo '</div>';
					}else if( $gdlr_post_settings['excerpt'] != 0 ){
						echo '<div class="gdlr-blog-content">'; 
						echo get_the_excerpt();
						gdlr_get_social_shares();
						echo '</div>';
					}
				?>
			</div> 
		</div> <!-- blog content wrapper -->
		<div class="clear"></div>
	</div>
</article><!-- #post -->