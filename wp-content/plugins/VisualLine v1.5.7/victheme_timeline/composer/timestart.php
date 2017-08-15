<?php
/**
 * Class extending the Shortcodes base class
 * for building the timestart element
 *
 * how to use :

 * [timestart]Some text to represent major events[/timestart]
 *
 * This shortcode must be inside the timeline shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Timeline_Composer_TimeStart
extends VTCore_Wordpress_Models_VC {


  // Column cannot be registered via VC yet.
  public function registerVC() {

    $options = array(
      'name' => __('Time line Start Marker', 'victheme_timeline'),
      'description' => __('Time line start marker element', 'victheme_timeline'),
      'base' => 'timestart',
      'icon' => 'icon-timestart',
      'category' => __('VisualLine', 'victheme_timeline'),
      'as_child' => array(
        'only' => 'timeline',
      ),
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS ID', 'victheme_timeline'),
      'param_name' => 'id',
      'admin_label' => false,
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS Class', 'victheme_timeline'),
      'param_name' => 'class',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textarea',
      'heading' => __('Content', 'victheme_timeline'),
      'param_name' => 'content',
      'value' => __('Start Text', 'victheme_timeline'),
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'css_editor',
      'heading' => __('Css', 'victheme_timeline'),
      'param_name' => 'css',
      'group' => __('Design options', 'victheme_timeline')
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __( 'CSS Animation', 'victheme_timeline'),
      'param_name' => 'css_animation',
      'admin_label' => false,
      'value' => array(
        __('No', 'victheme_timeline') => '',
        __('Top to bottom', 'victheme_timeline') => 'top-to-bottom',
        __('Bottom to top', 'victheme_timeline') => 'bottom-to-top',
        __('Left to right', 'victheme_timeline') => 'left-to-right',
        __('Right to left', 'victheme_timeline') => 'right-to-left',
        __('Appear from center', 'victheme_timeline') => "appear"
      ),
      'description' => __('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'victheme_timeline')
    );

    return $options;
  }
}


class WPBakeryShortCode_TimeStart extends WPBakeryShortCode {}