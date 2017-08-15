<?php
/**
 * Class extending the Visualcomposer base class
 * for building the snakelinesimple element
 *
 * how to use :

 * [snakelinesimple
 *   class="some class"
 *   id="someid"
 *   contentargs="url decoded arrays of content"
 * ]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SnakeLine_Visualcomposer_SnakeLineSimple
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Simple SnakeLine', 'victheme_snakeline'),
      'description' => __('Create a simple snake line', 'victheme_snakeline'),
      'base' => 'snakelinesimple',
      'icon' => 'icon-snakelinesimple',
      'category' => __('VisualLine', 'victheme_snakeline'),
    );

    $options['params'][] =  array(
      'type' => 'textfield',
      'heading' => __('Line Size', 'victheme_snakeline'),
      'param_name' => 'line___width',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Line Color', 'victheme_snakeline'),
      'param_name' => 'line___color',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Line Style', 'victheme_snakeline'),
      'param_name' => 'line___type',
      'edit_field_class' => 'vc_col-xs-4',
      'admin_label' => true,
      'value' => array(
        __('Solid', 'victheme_snakeline') => 'solid',
        __('Dotted', 'victheme_snakeline') => 'dotted',
        __('Dashed', 'victheme_snakeline') => 'dashed',
      ),
    );


    $options['params']['group'] = array(
      'type' => 'param_group',
      'heading' => __('Items', 'victheme_snakeline'),
      'param_name' => 'contentargs',
      'description' => __('Enter values for snake line.', 'victheme_snakeline'),
      'value' => urlencode(json_encode(array(
        array(
          'date___text' => __('2012', 'victheme_snakeline'),
          'date___color' => '#4F4F4F',
          'content___text' => __('This is an example text, insert your text here.', 'victheme_snakeline'),
          'content___color' => '#4F4F4F',
          'dot___text' => __('Text', 'victheme_snakeline'),
          'dot___color' => '#ffffff',
          'dot___link' => '',
          'dot___background' => '#1E477F',
        ),
        array(
          'date___text' => __('2012', 'victheme_snakeline'),
          'date___color' => '#4F4F4F',
          'content___text' => __('This is an example text, insert your text here.', 'victheme_snakeline'),
          'content___color' => '#4F4F4F',
          'dot___text' => __('Text', 'victheme_snakeline'),
          'dot___color' => '#ffffff',
          'dot___link' => '',
          'dot___background' => '#017BBE',
        ),
        array(
          'date___text' => __('2012', 'victheme_snakeline'),
          'date___color' => '#4F4F4F',
          'content___text' => __('This is an example text, insert your text here.', 'victheme_snakeline'),
          'content___color' => '#4F4F4F',
          'dot___text' => __('Text', 'victheme_snakeline'),
          'dot___color' => '#ffffff',
          'dot___link' => '',
          'dot___background' => '#019ADD',
        ),
        array(
          'date___text' => __('2012', 'victheme_snakeline'),
          'date___color' => '#4F4F4F',
          'content___text' => __('This is an example text, insert your text here.', 'victheme_snakeline'),
          'content___color' => '#4F4F4F',
          'dot___text' => __('Text', 'victheme_snakeline'),
          'dot___color' => '#ffffff',
          'dot___link' => '',
          'dot___background' => '#6BC2ED',
        ),
        array(
          'date___text' => __('2012', 'victheme_snakeline'),
          'date___color' => '#4F4F4F',
          'content___text' => __('This is an example text, insert your text here.', 'victheme_snakeline'),
          'content___color' => '#4F4F4F',
          'dot___text' => __('Text', 'victheme_snakeline'),
          'dot___color' => '#ffffff',
          'dot___link' => '',
          'dot___background' => '#A6A6A6',
        ),
      ))),
      'params' => array(),
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Date', 'victheme_snakeline'),
      'param_name' => 'date___text',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-12',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Bubble Text', 'victheme_snakeline'),
      'param_name' => 'dot___text',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Link To', 'victheme_snakeline'),
      'param_name' => 'dot___link',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textarea',
      'heading' => __('Content', 'victheme_snakeline'),
      'param_name' => 'content___text',
      'admin_label' => true,
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Date Color', 'victheme_snakeline'),
      'param_name' => 'date___color',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Content Color', 'victheme_snakeline'),
      'param_name' => 'content__color',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Dot Color', 'victheme_snakeline'),
      'param_name' => 'dot___color',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Dot Background', 'victheme_snakeline'),
      'param_name' => 'dot___background',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS ID', 'victheme_snakeline'),
      'param_name' => 'id',
      'admin_label' => true,
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS Class', 'victheme_snakeline'),
      'param_name' => 'class',
      'admin_label' => true,
    );


    $options['params'][] = array(
      'type' => 'css_editor',
      'heading' => __('Css', 'victheme_snakeline'),
      'param_name' => 'css',
      'group' => __('Design options', 'victheme_snakeline')
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __( 'CSS Animation', 'victheme_snakeline'),
      'param_name' => 'css_animation',
      'admin_label' => true,
      'value' => array(
         __('No', 'victheme_snakeline') => '',
         __('Top to bottom', 'victheme_snakeline') => 'top-to-bottom',
         __('Bottom to top', 'victheme_snakeline') => 'bottom-to-top',
         __('Left to right', 'victheme_snakeline') => 'left-to-right',
         __('Right to left', 'victheme_snakeline') => 'right-to-left',
         __('Appear from center', 'victheme_snakeline') => "appear"
      ),
      'description' => __('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'victheme_snakeline')
    );

    return $options;
  }
}


class WPBakeryShortCode_SnakeLineSimple extends WPBakeryShortCode {}