<?php

function blox_parse_raw_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'title' => '',
		'animation' => '',
		'extra_class' => ''
	), $atts ) );

	$title = $title!='' && $title!='undefined' ? '<h3 class="element_title">' . $title . '</h3>' : '';

	$animate_class = get_blox_animate_class($animation);
	$content = fix_wpautop($content);
	
	$content = html_entity_decode($content);
	$content = str_replace('”','"',$content);
	$content = str_replace('″','"',$content);

	return "<div class='blox_element tt_raw_content $animate_class $extra_class'>".$title.do_shortcode($content)."</div>";
}
add_shortcode( 'blox_raw', 'blox_parse_raw_hook' );



?>