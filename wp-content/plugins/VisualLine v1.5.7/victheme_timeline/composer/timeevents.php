<?php
/**
 * Class extending the Shortcodes base class
 * for building the timeevents element
 *
 * how to use :

 * [timeevents
 *   datetime="YYYY-MM-DDTHH:MM"
 *   day="eg. Monday"
 *   month="eg. January"
 *   year="eg. 2014"
 *   date="eg. 12"
 *   icon="fontawesome icon name"
 *   text="the event title"
 *   direction="left|right"
 *   image="wordpress image id"
 *   size="valid image size"
 *   style="valid image style"
 * ]
 * Some content representing the event content
 * [/timeevents]
 *
 * This shortcode must be inside the timeline shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Timeline_Composer_TimeEvents
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Time Line Events', 'victheme_timeline'),
      'description' => __('Time line events elements', 'victheme_timeline'),
      'base' => 'timeevents',
      'icon' => 'icon-timeevents',
      'category' => __('VisualLine', 'victheme_timeline'),
      'as_child' => array(
        'only' => 'timeline',
      ),
      'is_container' => true,
      'js_view' => 'VTCoreContainer',
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon',
      'name' => 'icon',
      'heading' => __('Icon', 'victheme_timeline'),
      'core_class' => 'VTCore_Fontawesome_Form_faIcon',
      'edit_field_class' => 'vc_col-xs-6',
      'core_context' => array(
        'name' => 'icon',
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
      'param_name' => 'direction',
      'name' => 'direction',
      'heading' => __('Direction', 'victheme_timeline'),
      'core_class' => 'VTCore_Bootstrap_Form_BsSelect',
      'edit_field_class' => 'vc_col-xs-6',
      'core_context' => array(
        'name' => 'direction',
        'description' => __('Right and left only applicable in vertical mode while top and bottom only applicable in horizontal mode.', 'victheme_timeline'),
        'options' => array(
          'left' => __('Left', 'victheme_timeline'),
          'right' => __('Right', 'victheme_timeline'),
          'top' => __('Top', 'victheme_timeline'),
          'bottom' => __('Bottom', 'victheme_timeline'),
        ),
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'direction', 'vtcore_field')
          ),
        ),
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
      'type' => 'textfield',
      'heading' => __('Date Time', 'victheme_timeline'),
      'param_name' => 'datetime',
      'value' => '',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Day', 'victheme_timeline'),
      'param_name' => 'day',
      'value' => '',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Month', 'victheme_timeline'),
      'param_name' => 'month',
      'value' => '',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Year', 'victheme_timeline'),
      'param_name' => 'year',
      'value' => '',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Date', 'victheme_timeline'),
      'param_name' => 'date',
      'value' => '',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Heading Text', 'victheme_timeline'),
      'param_name' => 'text',
      'value' => '',
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


class WPBakeryShortCode_TimeEvents extends WPBakeryShortCodesContainer {}