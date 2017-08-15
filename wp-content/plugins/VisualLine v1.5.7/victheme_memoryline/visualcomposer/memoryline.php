<?php
/**
 * Class extending the Visualcomposer base class
 * for building the memoryline element
 *
 * how to use :
 *
 * [memoryline
 *   class="some class"
 *   id="someid"
 *   data___line_color="x"
 *   data___line_width="x"
 *   data___line_type="x"
 *   data___line_offset_x="x"
 *   data___line_offset_y="y"
 * ]
 *
 * [memorylineinner
 *   id="x"
 *   class="class_one class_two"
 *   titlecolor="the title color"
 *   titlecss="extra css class for the title element"
 *   textcolor="the text color"
 *   textcss="extra css class for the text element"
 *   title="the title text"
 *   mobile="X" tablet="X" small="X" large="X"
 *   mobile_offset="X" tablet_offset="X" small_offset="X" large_offset="X"
 *   mobile_push="X" tablet_push="X" small_push="X" large_push="X"
 *   mobile_pull="X" tablet_pull="X" small_pull="X" large_pull="X"
 *   data___dot_direction="x"
 *   data___dot_radius="x"
 *   data___dot_color="x"
 *   data___dot_offset_x="x"
 *   data___dot_offset_y="x"
 *   data___line_color="x"
 *   data___line_width="x"
 *   data___line_type="x"
 *   newrow="true|false"
 * ]
 *   some content for the inner shortcodes allowed
 *
 * [/memorylineinner]
 *
 * [/memoryline]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_MemoryLine_Visualcomposer_MemoryLine
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Advanced MemoryLine', 'victheme_memoryline'),
      'description' => __('Element Wrapper', 'victheme_memoryline'),
      'base' => 'memoryline',
      'icon' => 'icon-memoryline',
      'category' => __('VisualLine', 'victheme_memoryline'),
      'as_parent' => array(
        'only' => 'memorylineinner',
      ),
      'is_container' => true,
      'js_view' => 'VTCoreContainer',
      'params' => array()
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS ID', 'victheme_memoryline'),
      'param_name' => 'id',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS Class', 'victheme_memoryline'),
      'param_name' => 'class',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Animate', 'victheme_memoryline'),
      'param_name' => 'data___animation',
      'admin_label' => true,
      'group' => __('Points', 'victheme_memoryline'),
      'value' => array(
        __('No', 'victheme_memoryline') => 'false',
        __('Yes', 'victheme_memoryline') => 'true',
      ),
      'edit_field_class' => 'vc_col-xs-12 vc_column-with-padding',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Drawing Dots Time', 'victheme_timeline'),
      'param_name' => 'data___dot_time',
      'value' => '100',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-6 vc_column-with-padding',
      'group' => __('Points', 'victheme_memoryline'),
      'dependency' => array(
        'element' => 'data___animation',
        'value' => array('true')
      ),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Drawing Line Time', 'victheme_timeline'),
      'param_name' => 'data___line_time',
      'value' => '600',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-6 vc_column-with-padding',
      'group' => __('Points', 'victheme_memoryline'),
      'dependency' => array(
        'element' => 'data___animation',
        'value' => array('true')
      ),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Line Offset X', 'victheme_memoryline'),
      'param_name' => 'data___line_offset_x',
      'admin_label' => false,
      'value' => 0,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Line Offset Y', 'victheme_memoryline'),
      'param_name' => 'data___line_offset_y',
      'admin_label' => false,
      'value' => 2,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Line Width', 'victheme_memoryline'),
      'param_name' => 'data___line_width',
      'admin_label' => false,
      'value' => 10,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-6 clearboth',
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Line Type', 'victheme_memoryline'),
      'param_name' => 'data___line_type',
      'admin_label' => false,
      'value' => array(
        __('Round', 'victheme_memoryline') => 'round',
        __('Square', 'victheme_memoryline') => 'square',
        __('Butt', 'victheme_memoryline') => 'butt',
      ),
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Line Dash', 'victheme_memoryline'),
      'param_name' => 'data___line_dash',
      'admin_label' => false,
      'value' => array(
        __('Line', 'victheme_memoryline') => 'line',
        __('Dashed', 'victheme_memoryline') => 'dashed',
        __('Dotted', 'victheme_memoryline') => 'dotted',
      ),
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Dot Radius', 'victheme_memoryline'),
      'param_name' => 'data___dot_radius',
      'admin_label' => false,
      'value' => 8,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Line color', 'victheme_memoryline'),
      'param_name' => 'data___line_color',
      'value' => '#f0f0f0',
      'admin_label' => false,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3 clearboth',
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Dot color', 'victheme_memoryline'),
      'param_name' => 'data___dot_color',
      'value' => '#ff6c00',
      'admin_label' => false,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3 clearboth',
    );


    $options['params'][] = array(
      'type' => 'css_editor',
      'heading' => __('Css', 'victheme_memoryline'),
      'param_name' => 'css',
      'group' => __('Design options', 'victheme_memoryline')
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __( 'CSS Animation', 'victheme_memoryline'),
      'param_name' => 'css_animation',
      'admin_label' => false,
      'value' => array(
        __('No', 'victheme_memoryline') => '',
        __('Top to bottom', 'victheme_memoryline') => 'top-to-bottom',
        __('Bottom to top', 'victheme_memoryline') => 'bottom-to-top',
        __('Left to right', 'victheme_memoryline') => 'left-to-right',
        __('Right to left', 'victheme_memoryline') => 'right-to-left',
        __('Appear from center', 'victheme_memoryline') => "appear"
      ),
      'description' => __('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'victheme_memoryline')
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
          'heading' => ucfirst($key) . ' ' . ucfirst($size),
          'param_name' => $name,
          'name' => $name,
          'group' => __('Grids', 'victheme_history'),
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

    return $options;
  }
}


class WPBakeryShortCode_MemoryLine extends WPBakeryShortCodesContainer {}