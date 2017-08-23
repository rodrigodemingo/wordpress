<?php

// Porto FAQs
add_shortcode('porto_faqs', 'porto_shortcode_faqs');
add_action('vc_after_init', 'porto_load_faqs_shortcode');

function porto_shortcode_faqs($atts, $content = null) {
    ob_start();
    if ($template = porto_shortcode_template('porto_faqs'))
        include $template;
    return ob_get_clean();
}

function porto_load_faqs_shortcode() {
    $animation_type = porto_vc_animation_type();
    $animation_duration = porto_vc_animation_duration();
    $animation_delay = porto_vc_animation_delay();
    $custom_class = porto_vc_custom_class();

    vc_map( array(
        'name' => "Porto " . __('FAQs', 'porto-shortcodes'),
        'base' => 'porto_faqs',
        'category' => __('Porto', 'porto-shortcodes'),
        'icon' => 'porto_vc_faqs',
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'porto-shortcodes'),
                "param_name" => "title",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "heading" => __("Category IDs", 'porto-shortcodes'),
                "description" => __("comma separated list of category ids", 'porto-shortcodes'),
                "param_name" => "cats",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "heading" => __("FAQ IDs", 'porto-shortcodes'),
                "description" => __("comma separated list of faq ids", 'porto-shortcodes'),
                "param_name" => "post_in"
            ),
            array(
                "type" => "textfield",
                "heading" => __("FAQs Count", 'porto-shortcodes'),
                "param_name" => "number",
                "value" => '8'
            ),
            array(
                'type' => 'checkbox',
                'heading' => __("Show Archive Link", 'porto-shortcodes'),
                'param_name' => 'view_more',
                'value' => array( __( 'Yes', 'js_composer' ) => 'yes' )
            ),
            array(
                'type' => 'textfield',
                'heading' => __("Extra class name for Archive Link", 'porto-shortcodes'),
                'param_name' => 'view_more_class',
                'dependency' => array('element' => 'view_more', 'not_empty' => true),
            ),
            array(
                'type' => 'checkbox',
                'heading' => __("Show Filter", 'porto-shortcodes'),
                'param_name' => 'filter',
                'value' => array( __( 'Yes', 'js_composer' ) => 'yes' )
            ),
            array(
                'type' => 'checkbox',
                'heading' => __("Show Pagination", 'porto-shortcodes'),
                'param_name' => 'pagination',
                'value' => array( __( 'Yes', 'js_composer' ) => 'yes' )
            ),
            $custom_class,
            $animation_type,
            $animation_duration,
            $animation_delay
        )
    ) );

    if (!class_exists('WPBakeryShortCode_Porto_Faqs')) {
        class WPBakeryShortCode_Porto_Faqs extends WPBakeryShortCode {
        }
    }
}