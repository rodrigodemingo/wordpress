<?php
/**
 * Class extending the Shortcodes base class
 * for building the timeline query element
 *
 * how to use :
 *
 * [timelinequery
 *   align="left|right|center"
 *   ending_text="ending text"
 *   layout="horizontal|vertical"
 *   start="starting text"
 *   align="top|bottom|left|right"
 *   icon___odd="fontawesome icon for odd rows"
 *   icon___even="fontawesome icon for even rows"
 *   timeselect="created|modified"
 *   queryargs="query parameter in json / url args"
 *   ordersort="latest|older"
 * ]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Timeline_Composer_TimelineQuery
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Query Timeline', 'victheme_timeline'),
      'description' => __('Timeline Elements from post query', 'victheme_timeline'),
      'base' => 'timelinequery',
      'icon' => 'icon-timelinequery',
      'category' => __('VisualLine', 'victheme_timeline'),
      'is_container' => false,
      'params' => array()
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-12',
      'param_name' => 'start',
      'heading' => __('Start Text', 'victheme_timeline'),
      'description' => __('Define the start bubble text', 'victheme_timeline'),
      'value' => '',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-12',
      'param_name' => 'end',
      'heading' => __('End Text', 'victheme_timeline'),
      'description' => __('Define the end bubble text', 'victheme_timeline'),
      'value' => '',
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon___odd',
      'name' => 'icon___odd',
      'heading' => __('Odd Event Icon', 'victheme_timeline'),
      'core_class' => 'VTCore_Fontawesome_Form_faIcon',
      'edit_field_class' => 'vc_col-xs-6',
      'core_context' => array(
        'name' => 'icon___odd',
        'value' => 'bell',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon___even',
      'name' => 'icon___even',
      'heading' => __('Even Event Icon', 'victheme_timeline'),
      'core_class' => 'VTCore_Fontawesome_Form_faIcon',
      'edit_field_class' => 'vc_col-xs-6',
      'core_context' => array(
        'name' => 'icon___even',
        'value' => 'bell',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-12 js-timeline-layout vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
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
        __('Alternate', 'victheme_timeline') => 'center',
        __('Left', 'victheme_timeline') => 'left',
        __('Right', 'victheme_timeline') => 'right',
        __('Top', 'victheme_timeline') => 'top',
        __('Bottom', 'victheme_timeline') => 'bottom',
      ),
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'admin_label' => true,
      'param_name' => 'timeselect',
      'description' => __('Select post created date or modified date as the time source', 'victheme_timeline'),
      'heading' => __('Source Time', 'victheme_timeline'),
      'value' => array(
        __('Post Created Date', 'victheme_timeline') => 'created',
        __('Post Modified Date', 'victheme_timeline') => 'modified',
      ),
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'admin_label' => true,
      'param_name' => 'ordersort',
      'description' => __('Sort the element position', 'victheme_timeline'),
      'heading' => __('Sort Direction', 'victheme_timeline'),
      'value' => array(
        __('Latest first', 'victheme_timeline') => 'latest',
        __('Oldest first', 'victheme_timeline') => 'older',
      ),
    );

    $options['params'][] = array(
      'type' => 'vt_query_form',
      'heading' => __('Query Parameter', 'victheme_timeline'),
      'param_name' => 'queryargs',
      'value' => '',
      'description' => __('Post query parameter settings for retrieving timeline items', 'victheme_timeline'),
      'group' => __('Query', 'victheme_timeline'),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS ID', 'victheme_timeline'),
      'param_name' => 'id',
      'admin_label' => true,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS Class', 'victheme_timeline'),
      'param_name' => 'class',
      'admin_label' => true,
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
      'admin_label' => true,
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


class WPBakeryShortCode_TimelineQuery extends WPBakeryShortCode {}