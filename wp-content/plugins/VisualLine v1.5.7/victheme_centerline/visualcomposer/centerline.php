<?php
/**
 * Class extending the Visualcomposer base class
 * for building the centerline element
 *
 * how to use :
 *
 * [centerline
 *   class="some class"
 *   id="someid"
 *   grids___columns___mobile="X"
 *   grids___columns___tablet="X"
 *   grids___columns___small="X"
 *   grids___columns___large="X"
 *   grids___offset___mobile="X"
 *   grids___offset___tablet="X"
 *   grids___offset___small="X"
 *   grids___offset___large="X"
 *   grids___push___mobile="X"
 *   grids___push___tablet="X"
 *   grids___push___small="X"
 *   grids___push___large="X"
 *   grids___pull___mobile="X"
 *   grids___pull___tablet="X"
 *   grids___pull___small="X"
 *   grids___pull___large="X"
 *   data___circle_start="x"
 *   data___circle_end="X"
 *   data___circle_opaque="X"
 *   data___circle_opacity="X"
 *   data___line_color="X"
 *   data___line_width="X"
 *   data___line_type="X"
 *   data___dot_color="X"
 * ]

 * [centerlineimage
 *   class="some class"
 *   id="someid"
 *   image_attachmentid="the wp attachment id to serve as the center image"
 *   image_size="the size for center image"
 *   image_position="the position of the image"
 *   image_style="the style for the image"
 *   border_color="the border color for the image"
 *   grids___columns___mobile="X"
 *   grids___columns___tablet="X"
 *   grids___columns___small="X"
 *   grids___columns___large="X"
 *   grids___offset___mobile="X"
 *   grids___offset___tablet="X"
 *   grids___offset___small="X"
 *   grids___offset___large="X"
 *   grids___push___mobile="X"
 *   grids___push___tablet="X"
 *   grids___push___small="X"
 *   grids___push___large="X"
 *   grids___pull___mobile="X"
 *   grids___pull___tablet="X"
 *   grids___pull___small="X"
 *   grids___pull___large="X"
 * ]
 *
 * [/centerlineimage]
 *
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
 * [/centerline]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CenterLine_Visualcomposer_CenterLine
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Advanced CenterLine', 'victheme_centerline'),
      'description' => __('Element Wrapper', 'victheme_centerline'),
      'base' => 'centerline',
      'icon' => 'icon-centerline',
      'category' => __('VisualLine', 'victheme_centerline'),
      'as_parent' => array(
        'only' => 'centerlineinner, centerlineimage',
      ),
      'is_container' => true,
      'js_view' => 'VTCoreContainer',
      'params' => array()
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

    $options['params'][] = array(
      'type' => 'css_editor',
      'heading' => __('Css', 'victheme_centerline'),
      'param_name' => 'css',
      'group' => __('Design options', 'victheme_centerline')
    );


    $keys = array('columns', 'offset', 'push', 'pull');
    $sizes = array('mobile', 'tablet', 'small', 'large');

    foreach ($keys as $key) {
      foreach ($sizes as $size) {

        $name = 'grids___' . $key . '___' . $size;

        $value = 0;
        if ($key == 'columns') {
          $value = 12;
        }

        $options['params'][] = array(
          'type' => 'vtcore',
          'param_name' => $name,
          'name' => $name,
          'heading' => ucfirst($key) . ' ' . ucfirst($size),
          'group' => __('Grids', 'victheme_centerline'),
          'core_class' => 'VTCore_Bootstrap_Form_BsSelect',
          'edit_field_class' => 'vc_col-xs-3',
          'core_context' => array(
            'name' => $name,
            'value' => $value,
            'input_elements' => array(
              'attributes' => array(
                'class' => array(
                  'wpb_vc_param_value',
                  'wpb-dropdown',
                  'icon',
                  'vtcore_field'
                )
              ),
            ),
            'options' => range(0, 12, 1),
          ),
        );
      }
    }

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Circle Start Point Radius', 'victheme_centerline'),
      'param_name' => 'data___circle_start',
      'admin_label' => true,
      'value' => 3,
      'group' => __('Points', 'victheme_centerline'),
      'edit_field_class' => 'vc_col-xs-3',
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


class WPBakeryShortCode_CenterLine extends WPBakeryShortCodesContainer {}