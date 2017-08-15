<?php
/**
 * Class extending the Visualcomposer base class
 * for building the memorylinesimple element
 *
 * how to use :

 * [memorylinesimple
 *   class="some class"
 *   id="someid"
 *   data___line_color="x"
 *   data___line_width="x"
 *   data___line_type="x"
 *   data___line_offset_x="x"
 *   data___line_offset_y="y"
 *   columns="1-5"
 *   contentargs="url decoded arrays of content"
 * ]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_MemoryLine_Visualcomposer_MemoryLineSimple
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Simple MemoryLine', 'victheme_memoryline'),
      'description' => __('Create a simple memory line', 'victheme_memoryline'),
      'base' => 'memorylinesimple',
      'icon' => 'icon-memorylinesimple',
      'category' => __('VisualLine', 'victheme_memoryline'),
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Animate', 'victheme_memoryline'),
      'param_name' => 'data___animation',
      'admin_label' => true,
      'value' => array(
        __('No', 'victheme_memoryline') => 'false',
        __('Yes', 'victheme_memoryline') => 'true',
      ),
      'edit_field_class' => 'vc_col-xs-6 vc_column-with-padding',
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Columns', 'victheme_memoryline'),
      'param_name' => 'columns',
      'admin_label' => true,
      'value' => array(
        __('Default', 'victheme_memoryline') => 3,
        __('One Column', 'victheme_memoryline') => 1,
        __('Two Column', 'victheme_memoryline') => 2,
        __('Three Column', 'victheme_memoryline') => 3,
        __('Four Column', 'victheme_memoryline') => 4,
        __('Five Column', 'victheme_memoryline') => 5,
      ),
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Drawing Dots Time', 'victheme_timeline'),
      'param_name' => 'data___dot_time',
      'value' => '100',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-6 vc_column-with-padding',
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
      'dependency' => array(
        'element' => 'data___animation',
        'value' => array('true')
      ),
    );


    $options['params']['group'] = array(
      'type' => 'param_group',
      'heading' => __('Lines', 'victheme_memoryline'),
      'param_name' => 'contentargs',
      'description' => __('Enter values for memory line.', 'victheme_memoryline'),
      'value' => urlencode(json_encode(array(
        array(
          'title' => __('2012', 'victheme_memoryline'),
          'content' => __('Starting this business', 'victheme_memoryline'),
          'textcolor' => '#ff6c00',
          'titlecolor' => '#c5c7cd',
        ),
        array(
          'title' => __('2013', 'victheme_memoryline'),
          'content' => __('Major Breakthrough', 'victheme_memoryline'),
          'textcolor' => '#ff6c00',
          'titlecolor' => '#c5c7cd',
        ),
        array(
          'title' => __('2014', 'victheme_memoryline'),
          'content' => __('New version launched', 'victheme_memoryline'),
          'textcolor' => '#ff6c00',
          'titlecolor' => '#c5c7cd',
        ),
      ))),
      'params' => array(),
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Title', 'victheme_memoryline'),
      'param_name' => 'title',
      'admin_label' => true,
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textarea',
      'heading' => __('Content', 'victheme_memoryline'),
      'param_name' => 'content',
      'admin_label' => true,
    );


    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Title Color', 'victheme_memoryline'),
      'param_name' => 'titlecolor',
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Text Color', 'victheme_memoryline'),
      'param_name' => 'textcolor',
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Dots Time', 'victheme_timeline'),
      'param_name' => 'data___dot_time',
      'value' => '100',
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Line Time', 'victheme_timeline'),
      'param_name' => 'data___line_time',
      'value' => '600',
      'edit_field_class' => 'vc_col-xs-3',
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Dot Offset X', 'victheme_memoryline'),
      'param_name' => 'data___dot_offset_x',
      'admin_label' => true,
      'value' => '',
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Dot Offset Y', 'victheme_memoryline'),
      'param_name' => 'data___dot_offset_y',
      'admin_label' => true,
      'value' => '',
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Dot Radius', 'victheme_memoryline'),
      'param_name' => 'data___dot_radius',
      'admin_label' => true,
      'value' => 8,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Line Width', 'victheme_memoryline'),
      'param_name' => 'data___line_width',
      'admin_label' => true,
      'value' => 10,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3 clearboth',
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Line Type', 'victheme_memoryline'),
      'param_name' => 'data___line_type',
      'admin_label' => true,
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
      'admin_label' => true,
      'value' => array(
        __('Inherit', 'victheme_memoryline') => '',
        __('Line', 'victheme_memoryline') => 'line',
        __('Dashed', 'victheme_memoryline') => 'dashed',
        __('Dotted', 'victheme_memoryline') => 'dotted',
      ),
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-3',
    );


    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Line color', 'victheme_memoryline'),
      'param_name' => 'data___line_color',
      'value' => '#f0f0f0',
      'admin_label' => true,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-12 clearboth',
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Dot color', 'victheme_memoryline'),
      'param_name' => 'data___dot_color',
      'value' => '#ff6c00',
      'admin_label' => true,
      'group' => __('Points', 'victheme_memoryline'),
      'edit_field_class' => 'vc_col-xs-12 clearboth',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS ID', 'victheme_memoryline'),
      'param_name' => 'id',
      'admin_label' => true,
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS Class', 'victheme_memoryline'),
      'param_name' => 'class',
      'admin_label' => true,
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
      'admin_label' => true,
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


class WPBakeryShortCode_MemoryLineSimple extends WPBakeryShortCode {}