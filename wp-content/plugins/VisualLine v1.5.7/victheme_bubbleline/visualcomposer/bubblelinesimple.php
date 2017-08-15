<?php
/**
 * Class extending the Visualcomposer base class
 * for building the bubblelinesimple element
 *
 * how to use :

 * [bubblelinesimple
 *   class="some class"
 *   id="someid"
 *   contentargs="url decoded arrays of content"
 * ]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_BubbleLine_Visualcomposer_BubbleLineSimple
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Simple BubbleLine', 'victheme_bubbleline'),
      'description' => __('Create a simple bubble line', 'victheme_bubbleline'),
      'base' => 'bubblelinesimple',
      'icon' => 'icon-bubblelinesimple',
      'category' => __('VisualLine', 'victheme_bubbleline'),
    );

    $options['params']['group'] = array(
      'type' => 'param_group',
      'heading' => __('Items', 'victheme_bubbleline'),
      'param_name' => 'contentargs',
      'description' => __('Enter values for bubble line.', 'victheme_bubbleline'),
      'value' => urlencode(json_encode(array(
        array(
          'bubble___date' => __('2012', 'victheme_bubbleline'),
          'bubble___text' => __('Starting this business', 'victheme_bubbleline'),
          'bubble___color' => '#019ADD',
          'bubble___size' => 'small',
          'bubble___text_color' => '#ffffff',
          'bubble___style' => 'bubble',
          'text___color' => '#019ADD',
          'dot___color' => '',
          'dot___border_color' => '#3EA7C7',
          'line___color' => '#dddddd',
          'line___width' => 4,
          'line___type' => 'dotted',
          'link' => '',
        ),
        array(
          'bubble___date' => __('2013', 'victheme_bubbleline'),
          'bubble___text' => __('Expanding this business', 'victheme_bubbleline'),
          'bubble___color' => '#019ADD',
          'bubble___size' => 'normal',
          'bubble___text_color' => '#ffffff',
          'bubble___style' => 'bubble',
          'text___color' => '#019ADD',
          'dot___color' => '',
          'dot___border_color' => '#3EA7C7',
          'line___color' => '#dddddd',
          'line___width' => 4,
          'line___type' => 'dotted',
          'link' => '',
        ),
        array(
          'bubble___date' => __('2014', 'victheme_bubbleline'),
          'bubble___text' => __('Take off with this business', 'victheme_bubbleline'),
          'bubble___color' => '#019ADD',
          'bubble___size' => 'large',
          'bubble___text_color' => '#ffffff',
          'bubble___style' => 'bubble',
          'text___color' => '#019ADD',
          'dot___color' => '',
          'dot___border_color' => '#3EA7C7',
          'line___color' => '#dddddd',
          'line___width' => 4,
          'line___type' => 'dotted',
          'link' => '',
        ),
      ))),
      'params' => array(),
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Date', 'victheme_bubbleline'),
      'param_name' => 'bubble___date',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Link To', 'victheme_bubbleline'),
      'param_name' => 'link',
      'admin_label' => true,
      'edit_field_class' => 'vc_col-xs-6',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textarea',
      'heading' => __('Content', 'victheme_bubbleline'),
      'param_name' => 'bubble___text',
      'admin_label' => true,
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Background', 'victheme_bubbleline'),
      'param_name' => 'bubble___color',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Text Color', 'victheme_bubbleline'),
      'param_name' => 'bubble___text_color',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Date Color', 'victheme_bubbleline'),
      'param_name' => 'text___color',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Dot Color', 'victheme_bubbleline'),
      'param_name' => 'dot___color',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Dot Border Color', 'victheme_bubbleline'),
      'param_name' => 'dot___border_color',
      'edit_field_class' => 'vc_col-xs-4',
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Line Color', 'victheme_bubbleline'),
      'param_name' => 'line___color',
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Bubble Size', 'victheme_bubbleline'),
      'param_name' => 'bubble___size',
      'edit_field_class' => 'vc_col-xs-3',
      'admin_label' => true,
      'value' => array(
        __('Normal', 'victheme_bubbleline') => 'normal',
        __('Small', 'victheme_bubbleline') => 'small',
        __('Large', 'victheme_bubbleline') => 'large',
      ),
    );

    $options['params']['group']['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Bubble Style', 'victheme_bubbleline'),
      'param_name' => 'bubble___style',
      'edit_field_class' => 'vc_col-xs-3',
      'admin_label' => true,
      'value' => array(
        __('Point', 'victheme_bubbleline') => 'point',
        __('Circle', 'victheme_bubbleline') => 'circle',
        __('Thin', 'victheme_bubbleline') => 'thin',
      ),
    );

    $options['params']['group']['params'][] =  array(
      'type' => 'textfield',
      'heading' => __('Line Size', 'victheme_bubbleline'),
      'param_name' => 'line___width',
      'edit_field_class' => 'vc_col-xs-3',
    );

    $options['params']['group']['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Line Style', 'victheme_bubbleline'),
      'param_name' => 'line___type',
      'edit_field_class' => 'vc_col-xs-3',
      'admin_label' => true,
      'value' => array(
        __('Solid', 'victheme_bubbleline') => 'solid',
        __('Dotted', 'victheme_bubbleline') => 'dotted',
        __('Dashed', 'victheme_bubbleline') => 'dashed',
      ),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS ID', 'victheme_bubbleline'),
      'param_name' => 'id',
      'admin_label' => true,
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS Class', 'victheme_bubbleline'),
      'param_name' => 'class',
      'admin_label' => true,
    );


    $options['params'][] = array(
      'type' => 'css_editor',
      'heading' => __('Css', 'victheme_bubbleline'),
      'param_name' => 'css',
      'group' => __('Design options', 'victheme_bubbleline')
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __( 'CSS Animation', 'victheme_bubbleline'),
      'param_name' => 'css_animation',
      'admin_label' => true,
      'value' => array(
         __('No', 'victheme_bubbleline') => '',
         __('Top to bottom', 'victheme_bubbleline') => 'top-to-bottom',
         __('Bottom to top', 'victheme_bubbleline') => 'bottom-to-top',
         __('Left to right', 'victheme_bubbleline') => 'left-to-right',
         __('Right to left', 'victheme_bubbleline') => 'right-to-left',
         __('Appear from center', 'victheme_bubbleline') => "appear"
      ),
      'description' => __('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'victheme_bubbleline')
    );

    return $options;
  }
}


class WPBakeryShortCode_BubbleLineSimple extends WPBakeryShortCode {}