<?php
/**
 * Class extending the Visualcomposer base class
 * for building the centerlineinner element
 *
 * how to use :

 * [centerlineinner
 *   id="x"
 *   class="class_one class_two"
 *   mobile="X" tablet="X" small="X" large="X"
 *   mobile_offset="X" tablet_offset="X" small_offset="X" large_offset="X"
 *   mobile_push="X" tablet_push="X" small_push="X" large_push="X"
 *   mobile_pull="X" tablet_pull="X" small_pull="X" large_pull="X"
 *   data___circle_start="3"
 *   data___circle_end="4"
 *   data___circle_opaque="10"
 *   data___circle_opacity="0.6"
 *   data___line_color= "#158FBF"
 *   data___line_width="1"
 *   data___line_type= "round"
 *   data___dot_color= "#158FBF"
 *   data___position_start= "center"
 *   data___position_end= "top"
 *   data___offset_control_x="0"
 *   data___offset_control_y="100"
 *   data___offset_start_x="0"
 *   data___offset_start_y="0"
 *   data___offset_end_x="0"
 *   data___offset_end_y="0"
 * ]
 *
 *   some content for the inner shortcodes allowed
 *
 * [/centerlineinner]
 *
 * This shortcode must be inside the timeline shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CenterLine_Visualcomposer_CenterLineInner
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('CenterLine Content', 'victheme_centerline'),
      'description' => __('The content element for centerline', 'victheme_centerline'),
      'base' => 'centerlineinner',
      'icon' => 'icon-centerlineinner',
      'category' => __('VisualLine', 'victheme_centerline'),
      'as_child' => array(
        'only' => 'centerline',
      ),
      'is_container' => true,
      'js_view' => 'VTCoreContainer',
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS ID', 'victheme_centerline'),
      'param_name' => 'id',
      'admin_label' => true,
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS Class', 'victheme_centerline'),
      'param_name' => 'class',
      'admin_label' => true,
    );


    $keys = array('columns', 'offset', 'push', 'pull');
    $sizes = array('mobile', 'tablet', 'small', 'large');

    foreach ($keys as $key) {
      foreach ($sizes as $size) {

        $name =  $key .'_' . $size;

        $value = 0;
        if ($key == 'columns') {
          $value = 12;
        }

        $options['params'][] = array(
          'type' => 'vtcore',
          'heading' => ucfirst($key) . ' ' . ucfirst($size),
          'param_name' => $name,
          'name' => $name,
          'core_class' => 'VTCore_Bootstrap_Form_BsSelect',
          'edit_field_class' => 'vc_col-xs-3',
          'group' => __('Grid options', 'victheme_centerline'),
          'core_context' => array(
            'name' => $name,
            'value' => $value,
            'input_elements' => array(
              'attributes' => array(
                'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon', 'vtcore_field')
              ),
            ),
            'options' => range(0, 12, 1),
          ),
        );
      }
    }

    // Don't know wtf is going on with VC 4.7, data___position_start always missing!
    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Position Start', 'victheme_centerline'),
      'param_name' => 'data___position_start',
      'admin_label' => true,
      'value' => array(
        __('Center', 'victheme_centerline') => 'center',
        __('Left', 'victheme_centerline') => 'left',
        __('Right', 'victheme_centerline') => 'right',
        __('Top', 'victheme_centerline') => 'top',
        __('Bottom', 'victheme_centerline') => 'bottom',
      ),
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Position End', 'victheme_centerline'),
      'param_name' => 'data___position_end',
      'admin_label' => true,
      'value' => array(
        __('Top', 'victheme_centerline') => 'top',
        __('Left', 'victheme_centerline') => 'left',
        __('Right', 'victheme_centerline') => 'right',
        __('Bottom', 'victheme_centerline') => 'bottom',
      ),
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Offset Start X', 'victheme_centerline'),
      'param_name' => 'data___offset_start_x',
      'admin_label' => true,
      'value' => 0,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3 clearboth',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Offset Start Y', 'victheme_centerline'),
      'param_name' => 'data___offset_start_y',
      'admin_label' => true,
      'value' => 0,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Offset End X', 'victheme_centerline'),
      'param_name' => 'data___offset_end_x',
      'admin_label' => true,
      'value' => 0,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Offset End Y', 'victheme_centerline'),
      'param_name' => 'data___offset_end_y',
      'admin_label' => true,
      'value' => 0,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Offset Control X', 'victheme_centerline'),
      'param_name' => 'data___offset_control_x',
      'admin_label' => true,
      'value' => 0,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Offset Control Y', 'victheme_centerline'),
      'param_name' => 'data___offset_control_y',
      'admin_label' => true,
      'value' => 100,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Circle Start Point Radius', 'victheme_centerline'),
      'param_name' => 'data___circle_start',
      'admin_label' => true,
      'value' => 3,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3 clearboth',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Circle End Point Radius', 'victheme_centerline'),
      'param_name' => 'data___circle_end',
      'admin_label' => true,
      'value' => 3,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Circle Start Opaque Radius', 'victheme_centerline'),
      'param_name' => 'data___circle_opaque',
      'admin_label' => true,
      'value' => 10,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Circle Opaque Opacity', 'victheme_centerline'),
      'param_name' => 'data___circle_opacity',
      'admin_label' => true,
      'value' => 0.6,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Line Width', 'victheme_centerline'),
      'param_name' => 'data___line_width',
      'admin_label' => true,
      'value' => 1,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3 clearboth',
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Line Type', 'victheme_centerline'),
      'param_name' => 'data___line_type',
      'admin_label' => true,
      'value' => array(
        __('Round', 'victheme_centerline') => 'round',
        __('Square', 'victheme_centerline') => 'square',
        __('Butt', 'victheme_centerline') => 'butt',
      ),
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Line color', 'victheme_centerline'),
      'param_name' => 'data___line_color',
      'value' => '#158FBF',
      'admin_label' => true,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-12 clearboth',
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Dot color', 'victheme_centerline'),
      'param_name' => 'data___dot_color',
      'value' => '#158FBF',
      'admin_label' => true,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-12',
    );



    $options['params'][] = array(
      'type' => 'css_editor',
      'heading' => __('Css', 'victheme_centerline'),
      'param_name' => 'css',
      'group' => __('Design options', 'victheme_centerline')
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __( 'CSS Animation', 'victheme_centerline'),
      'param_name' => 'css_animation',
      'admin_label' => true,
      'value' => array(
         __('No', 'victheme_centerline') => '',
         __('Top to bottom', 'victheme_centerline') => 'top-to-bottom',
         __('Bottom to top', 'victheme_centerline') => 'bottom-to-top',
         __('Left to right', 'victheme_centerline') => 'left-to-right',
         __('Right to left', 'victheme_centerline') => 'right-to-left',
         __('Appear from center', 'victheme_centerline') => "appear"
      ),
      'description' => __('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'victheme_centerline')
    );

    return $options;
  }
}


class WPBakeryShortCode_CenterLineInner extends WPBakeryShortCodesContainer {}