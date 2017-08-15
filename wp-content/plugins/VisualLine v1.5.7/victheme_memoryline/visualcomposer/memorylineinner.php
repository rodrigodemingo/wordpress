<?php
/**
 * Class extending the Visualcomposer base class
 * for building the memorylineinner element
 *
 * how to use :

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
 *
 *   some content for the inner shortcodes allowed
 *
 * [/memorylineinner]
 *
 * This shortcode must be inside the timeline shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_MemoryLine_Visualcomposer_MemoryLineInner
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('MemoryLine Content', 'victheme_memoryline'),
      'description' => __('The content element for memoryline', 'victheme_memoryline'),
      'base' => 'memorylineinner',
      'icon' => 'icon-memorylineinner',
      'category' => __('VisualLine', 'victheme_memoryline'),
      'as_child' => array(
        'only' => 'memoryline',
      ),
      'is_container' => true,
      'js_view' => 'VTCoreContainer',
    );


    $options['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Title Color', 'victheme_memoryline'),
      'param_name' => 'titlecolor',
      'admin_label' => false,
    );

    $options['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Text Color', 'victheme_memoryline'),
      'param_name' => 'textcolor',
      'admin_label' => false,
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Title', 'victheme_memoryline'),
      'param_name' => 'title',
      'admin_label' => true,
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Extra Title CSS Class', 'victheme_memoryline'),
      'param_name' => 'titlecss',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Extra Content CSS Class', 'victheme_memoryline'),
      'param_name' => 'textcss',
      'admin_label' => false,
    );


    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Mark As New Row', 'victheme_memoryline'),
      'param_name' => 'newrow',
      'admin_label' => true,
      'value' => array(
        __('Not a new row', 'victheme_memoryline') => 'false',
        __('New Row', 'victheme_memoryline') => 'true',
      ),
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-4 vc_column-with-padding',
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Dot Direction', 'victheme_memoryline'),
      'param_name' => 'data___dot_direction',
      'admin_label' => true,
      'value' => array(
        __('Left', 'victheme_memoryline') => 'forward',
        __('Right', 'victheme_memoryline') => 'reverse',
      ),
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3 clearboth',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Dot Radius', 'victheme_memoryline'),
      'param_name' => 'data___dot_radius',
      'admin_label' => false,
      'value' => '',
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Dot Offset X', 'victheme_memoryline'),
      'param_name' => 'data___dot_offset_x',
      'admin_label' => false,
      'value' => '',
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Dot Offset Y', 'victheme_memoryline'),
      'param_name' => 'data___dot_offset_y',
      'admin_label' => false,
      'value' => '',
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Dots Time', 'victheme_timeline'),
      'param_name' => 'data___dot_time',
      'value' => '100',
      'admin_label' => false,
      'edit_field_class' => 'vc_col-xs-3',
      'group' => __('Points', 'victheme_memoryline'),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Line Time', 'victheme_timeline'),
      'param_name' => 'data___line_time',
      'value' => '600',
      'admin_label' => false,
      'edit_field_class' => 'vc_col-xs-3 clearboth',
      'group' => __('Points', 'victheme_memoryline'),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Line Width', 'victheme_memoryline'),
      'param_name' => 'data___line_width',
      'admin_label' => false,
      'value' => '',
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3 clearboth',
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Line Type', 'victheme_memoryline'),
      'param_name' => 'data___line_type',
      'admin_label' => false,
      'value' => array(
        __('Inherit', 'victheme_memoryline') => '',
        __('Round', 'victheme_memoryline') => 'round',
        __('Square', 'victheme_memoryline') => 'square',
        __('Butt', 'victheme_memoryline') => 'butt',
      ),
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Line Dash', 'victheme_memoryline'),
      'param_name' => 'data___line_dash',
      'admin_label' => false,
      'value' => array(
        __('Inherit', 'victheme_memoryline') => '',
        __('Line', 'victheme_memoryline') => 'line',
        __('Dashed', 'victheme_memoryline') => 'dashed',
        __('Dotted', 'victheme_memoryline') => 'dotted',
      ),
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Line color', 'victheme_memoryline'),
      'param_name' => 'data___line_color',
      'value' => '',
      'admin_label' => false,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3 clearboth',
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Dot color', 'victheme_memoryline'),
      'param_name' => 'data___dot_color',
      'value' => '',
      'admin_label' => false,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3',
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
          'param_name' => $name,
          'name' => $name,
          'heading' => ucfirst($key) . ' ' . ucfirst($size),
          'core_class' => 'VTCore_Bootstrap_Form_BsSelect',
          'edit_field_class' => 'vc_col-xs-3',
          'group' => __('Grid options', 'victheme_memoryline'),
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

        $name = 'title_element___grids___' . $key . '___' . $size;
        $options['params'][] = array(
          'type' => 'vtcore',
          'param_name' => $name,
          'name' => $name,
          'heading' => ucfirst($key) . ' ' . ucfirst($size),
          'core_class' => 'VTCore_Bootstrap_Form_BsSelect',
          'edit_field_class' => 'vc_col-xs-3',
          'group' => __('Title Grids', 'victheme_memoryline'),
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


        $name = 'text_element___grids___' . $key . '___' . $size;
        $options['params'][] = array(
          'type' => 'vtcore',
          'param_name' => $name,
          'name' => $name,
          'heading' => ucfirst($key) . ' ' . ucfirst($size),
          'core_class' => 'VTCore_Bootstrap_Form_BsSelect',
          'edit_field_class' => 'vc_col-xs-3',
          'group' => __('Element Grids', 'victheme_memoryline'),
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

    return $options;
  }
}


class WPBakeryShortCode_MemoryLineInner extends WPBakeryShortCodesContainer {}