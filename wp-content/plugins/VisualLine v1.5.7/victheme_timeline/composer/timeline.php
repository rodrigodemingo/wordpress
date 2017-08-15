<?php
/**
 * Class extending the Shortcodes base class
 * for building the timeline element
 *
 * how to use :
 *
 * [timeline class="some class" id="someid" align="left|right|empty for center" ending_text="text for the end bubble"]
 * [timemajor]Some text to represent major events[/timemajor]
 * [timeevents
 *   datetime="YYYY-MM-DDTHH:MM"
 *   date="the date text"
 *   time="the time text"
 *   icon="fontawesome icon name"
 *   text="the event title"
 *   direction="left|right" // only applicable if the parent didn't specify align (centered)
 *   ending_text="text for the ending line bubble"
 * ]
 * Some content representing the event content
 * [/timeevents]
 * [/timeline]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Timeline_Composer_Timeline
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Advanced Timeline', 'victheme_timeline'),
      'description' => __('Timeline Elements', 'victheme_timeline'),
      'base' => 'timeline',
      'icon' => 'icon-timeline',
      'category' => __('VisualLine', 'victheme_timeline'),
      'as_parent' => array(
        'only' => 'timemajor,timeevents,timeend,timestart',
      ),
      'is_container' => true,
      'js_view' => 'VTCoreContainer',
      'params' => array()
    );


    $options['params'][] = array(
      'type' => 'dropdown',
      'admin_label' => true,
      'param_name' => 'layout',
      'heading' => __('Layout', 'victheme_timeline'),
      'description' => __('Define the major layout for the timeline element', 'victheme_timeline'),
      'value' => array(
        __('Vertical', 'victheme_timeline') => 'vertical',
        __('Horizontal', 'victheme_timeline') => 'horizontal',
      ),
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'admin_label' => true,
      'param_name' => 'align',
      'description' => __('Define the vertical layout default alignment', 'victheme_timeline'),
      'heading' => __('Alignment', 'victheme_timeline'),
      'value' => array(
        __('Center', 'victheme_timeline') => 'center',
        __('Left', 'victheme_timeline') => 'left',
        __('Right', 'victheme_timeline') => 'right',
      ),
      'dependency' => array(
        'element' => 'layout',
        'value' => array('vertical')
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


class WPBakeryShortCode_Timeline extends WPBakeryShortCodesContainer {}