<?php
/**
 * Class extending the Shortcodes base class
 * for building the timeline simple element
 *
 * how to use :
 *
 * [timelinesimple
 *   align="left|right|centered"
 *   ending_text="ending text"
 *   layout="horizontal|vertical"
 *   contentargs="url encoded json format"
 * ]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Timeline_Composer_TimelineSimple
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Simple Timeline', 'victheme_timeline'),
      'description' => __('Simple Timeline Elements', 'victheme_timeline'),
      'base' => 'timelinesimple',
      'icon' => 'icon-timelinesimple',
      'category' => __('VisualLine', 'victheme_timeline'),
      'is_container' => false,
      'params' => array()
    );


    $options['params'][] = array(
      'type' => 'dropdown',
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
      'admin_label' => true,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS Class', 'victheme_timeline'),
      'param_name' => 'class',
      'admin_label' => true,
    );

    $options['params']['group'] = array(
      'type' => 'param_group',
      'heading' => __('Timeline Items', 'victheme_timeline'),
      'group' => __('Events', 'victheme_timeline'),
      'param_name' => 'contentargs',
      'description' => __('Enter timeline entry.', 'victheme_timeline'),
      'value' => urlencode(json_encode(array(
        array(
          'timetype' => 'major',
          'content' => __('Start', 'victheme_timeline'),
        ),
        array(
          'timetype' => 'events',
          'direction' => 'left',
          'icon' => 'angle-left',
          'image' => '',
          'size' => 'large',
          'style' => '',
          'text' => __('Example Heading', 'victheme_timeline'),
          'content' => __('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium', 'victheme_timeline'),
          'day' => __('Monday', 'victheme_timeline'),
          'date' => __('12', 'victheme_timeline'),
          'month' => __('January', 'victheme_timeline'),
          'year' => __('2014', 'victheme_timeline'),
        ),
        array(
          'timetype' => 'events',
          'direction' => 'right',
          'icon' => 'angle-right',
          'image' => '',
          'size' => 'large',
          'style' => '',
          'text' => __('Example Heading', 'victheme_timeline'),
          'content' => __('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium', 'victheme_timeline'),
          'day' => __('Tuesday', 'victheme_timeline'),
          'date' => __('13', 'victheme_timeline'),
          'month' => __('January', 'victheme_timeline'),
          'year' => __('2015', 'victheme_timeline'),
        ),
        array(
          'timetype' => 'events',
          'direction' => 'left',
          'icon' => 'angle-left',
          'image' => '',
          'size' => 'large',
          'style' => '',
          'text' => __('Example Heading', 'victheme_timeline'),
          'content' => __('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium', 'victheme_timeline'),
          'day' => __('Wednesday', 'victheme_timeline'),
          'date' => __('13', 'victheme_timeline'),
          'month' => __('February', 'victheme_timeline'),
          'year' => __('2015', 'victheme_timeline'),
        ),
        array(
          'timetype' => 'ending',
          'content' => __('Ends', 'victheme_timeline'),
        ),
      ))),
      'params' => array(),
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'dropdown',
      'heading' => __('Event Type', 'victheme_timeline'),
      'param_name' => 'timetype',
      'admin_label' => true,
      'value' => array(
        __('Normal Events', 'victheme_timeline') => 'events',
        __('Major Events', 'victheme_timeline') => 'major',
        __('Ending', 'victheme_timeline') => 'ending',
      ),
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'attach_image',
      'heading' => __('Image', 'victheme_timeline'),
      'param_name' => 'image',
      'value' => '',
      'description' => __('Select image from media library.', 'victheme_timeline'),
      'admin_label' => true,
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Image size', 'victheme_timeline'),
      'param_name' => 'size',
      'edit_field_class' => 'vc_col-xs-6',
      'description' => __('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'victheme_timeline'),
      'admin_label' => true,
    );

    $options['params']['group']['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Image style', 'victheme_timeline'),
      'edit_field_class' => 'vc_col-xs-6',
      'param_name' => 'style',
      'value' => getVcShared('single image styles'),
    );


    $options['params']['group']['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon',
      'name' => 'icon',
      'heading' => __('Icon', 'victheme_timeline'),
      'core_class' => 'VTCore_Fontawesome_Form_faIcon',
      'edit_field_class' => 'vc_col-xs-3',
      'core_context' => array(
        'name' => 'contentargs_icon',
        'value' => 'bell',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params']['group']['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Direction', 'victheme_timeline'),
      'param_name' => 'direction',
      'value' => array(
        __('Left', 'victheme_timeline') => 'left',
        __('Right', 'victheme_timeline') => 'right',
        __('Top', 'victheme_timeline') => 'top',
        __('Bottom', 'victheme_timeline') => 'bottom',
      ),
      'dependency' => array(
        'element' => 'contentargs_timetype',
        'value' => array('major')
      ),
      'edit_field_class' => 'vc_col-xs-3',
    );


    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Day', 'victheme_timeline'),
      'param_name' => 'day',
      'value' => '',
      'dependency' => array(
        'element' => 'contentargs_timetype',
        'value' => array('events')
      ),
      'edit_field_class' => 'vc_col-xs-3 clearboth vc_xs-clear vc_sm-clear',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Date', 'victheme_timeline'),
      'param_name' => 'date',
      'value' => '',
      'dependency' => array(
        'element' => 'contentargs_timetype',
        'value' => array('events')
      ),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Month', 'victheme_timeline'),
      'param_name' => 'month',
      'value' => '',
      'dependency' => array(
        'element' => 'contentargs_timetype',
        'value' => array('events')
      ),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Year', 'victheme_timeline'),
      'param_name' => 'year',
      'value' => '',
      'dependency' => array(
        'element' => 'contentargs_timetype',
        'value' => array('events')
      ),
      'edit_field_class' => 'vc_col-xs-3',
    );


    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Text', 'victheme_timeline'),
      'param_name' => 'text',
      'dependency' => array(
        'element' => 'contentargs_timetype',
        'value' => array('events')
      ),
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textarea',
      'heading' => __('Content', 'victheme_timeline'),
      'param_name' => 'content',
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


class WPBakeryShortCode_TimelineSimple extends WPBakeryShortCode {}