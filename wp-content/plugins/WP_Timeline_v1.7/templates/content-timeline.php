<?php
global $style, $post, $ajax_load, $ID, $animations, $posttype,$show_media, $taxonomy,$full_content;
$class = 'filter-'.$ID.'_'.get_the_ID();
if($animations!=''){
	$animations = ' scroll-effect';
}
if($ajax_load==1){ $class .=' de-active';}
$icon = get_post_meta( $post->ID, 'wpex_icon', true ) !='' ? get_post_meta( $post->ID, 'wpex_icon', true ) : 'fa-square no-icon';
$wpex_icon_img = get_post_meta( $post->ID, 'wpex_icon_img', true );
$we_eventcolor = get_post_meta( $post->ID, 'we_eventcolor', true );

$custom_link = wpex_custom_link();


?>
<li <?php post_class($class);?> <?php echo 'data-id="filter-'.$ID.'_'.get_the_ID().'"';?>>
    <div class="<?php echo esc_attr($animations);?>">
        <time class="wpex-timeline-time" datetime="<?php echo esc_attr(get_the_date( get_option( 'time_format' ) ).' '.get_the_date( get_option( 'date_format' ) ));?>">
            <?php if(has_post_thumbnail(get_the_ID())){?>
                <span class="info-img"><?php the_post_thumbnail('post-thumbnail');?></span>
            <?php }?>
            <span class="clearfix"></span>
            <?php 
            if($style!='icon'){wpex_tmfulldate();}?>
        </time>
        <div class="wpex-timeline-label">
            <?php 
            if($style=='icon'){
				wpex_tmbigdate($show_thumb=true);
			}?>
            <?php 
			if($style!='icon' && $show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
				echo '<div class="wpex-content-left">'.wptl_audio_video_iframe().'</div>';
			}
			?>
            <div class="timeline-details">
                <h2>
                    <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                        <?php the_title()?>
                    </a>
                </h2>
                <?php 
				$cat_html = wptl_show_cat($posttype, $taxonomy);
				if($cat_html!=''){?>
                <div class="wptl-more-meta">
                    <?php echo $cat_html;?>
                </div>
                <?php }?>
                <div class="wptl-excerpt">
                <?php 
				if($full_content=='1'){
					echo apply_filters('the_content', get_the_content());
				}else{
					echo get_the_excerpt();
				}?>
                </div>
                <div class="wptl-readmore">
                    <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                        <?php echo get_option('wpex_text_conread')!='' ? get_option('wpex_text_conread') : esc_html__('Continue reading','wp-timeline');?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="wpex-timeline-icon">
        <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>"><i class="fa <?php echo esc_attr($icon);?>"></i></a>
    </div>
    <?php if($we_eventcolor!=''|| $wpex_icon_img!=''){?>
	<style type="text/css">
		<?php if($wpex_icon_img!=''){?>
		.wpex-timeline-list li.post-<?php the_ID();?> .wpex-timeline-icon .fa.no-icon:before{ background:url(<?php echo esc_url(wp_get_attachment_thumb_url( $wpex_icon_img ));?>); background-repeat: no-repeat; background-size: 100% auto; background-position: center;}
		<?php }
		if($we_eventcolor!=''){?>
			.wpex li.post-<?php the_ID();?> .timeline-details .wptl-readmore > a:hover,
			.wpex-timeline-list li.post-<?php the_ID();?> .wpex-timeline-icon .fa{ background:<?php echo esc_attr($we_eventcolor);?>}
			.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label:before{border-right-color:<?php echo esc_attr($we_eventcolor);?>}
			.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label{ border-left-color:<?php echo esc_attr($we_eventcolor);?>;}
			.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-time span:last-child,
			.wpex-timeline-list.show-icon li.post-<?php the_ID();?> .wpex-timeline-icon .fa:not(.no-icon):before{color:<?php echo esc_attr($we_eventcolor);?>;}
			.wpex li.post-<?php the_ID();?> .timeline-details .wptl-readmore > a{ border-color:<?php echo esc_attr($we_eventcolor);?>;}
			<?php 
			$wpex_rtl_mode = get_option('wpex_rtl_mode');
			if($wpex_rtl_mode=='yes'){?>
				.left-tl:not(.show-icon) .wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label{border-right-color: <?php echo esc_html($we_eventcolor);?>;}
				.left-tl .wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label:before{border-left-color: <?php echo esc_html($we_eventcolor);?>;}
				<?php
			}
		
		}?>
    </style>
    <?php } ?>
</li>