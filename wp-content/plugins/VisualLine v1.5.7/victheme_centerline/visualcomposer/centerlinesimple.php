<?php
/**
 * Class extending the Visualcomposer base class
 * for building the centerlinesimple element
 *
 * how to use :
 *
 * how to use :
 *
 * [centerlinesimple
 *   image___image_attachmentid=""
 *   image___image_size=""
 *   image___image_style=""
 *   image___border_color=""
 *
 *   left___enabled="true|false"
 *   left___data___circle_start="3"
 *   left___data___circle_end="4"
 *   left___data___circle_opaque="10"
 *   left___data___circle_opacity="0.6"
 *   left___data___line_color= "#158FBF"
 *   left___data___line_width="1"
 *   left___data___dot_color= "#158FBF"
 *   left___text=""
 *   left___content=""
 *   left___textcolor=""
 *   left___contentcolor=""
 *
 *   center___enabled="true|false"
 *   center___data___circle_start="3"
 *   center___data___circle_end="4"
 *   center___data___circle_opaque="10"
 *   center___data___circle_opacity="0.6"
 *   center___data___line_color= "#158FBF"
 *   center___data___line_width="1"
 *   center___data___dot_color= "#158FBF"
 *   center___text=""
 *   center___content=""
 *   center___textcolor=""
 *   center___contentcolor=""
 *
 *   right___enabled="true|false"
 *   right___data___circle_start="3"
 *   right___data___circle_end="4"
 *   right___data___circle_opaque="10"
 *   right___data___circle_opacity="0.6"
 *   right___data___line_color= "#158FBF"
 *   right___data___line_width="1"
 *   right___data___dot_color= "#158FBF"
 *   right___text=""
 *   right___content=""
 *   right___textcolor=""
 *   right___contentcolor=""
 * ]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CenterLine_Visualcomposer_CenterLineSimple
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Simple CenterLine', 'victheme_centerline'),
      'description' => __('Simple centerline element', 'victheme_centerline'),
      'base' => 'centerlinesimple',
      'icon' => 'icon-centerlinesimple',
      'category' => __('VisualLine', 'victheme_centerline'),
      'is_container' => false,
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
      'type' => 'attach_image',
      'heading' => __('Image', 'victheme_centerline'),
      'param_name' => 'image___image_attachmentid',
      'value' => '',
      'description' => __('Select image from media library.', 'victheme_centerline'),
      'group' => __('Image', 'victheme_centerline'),
      'admin_label' => true,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Image size', 'victheme_centerline'),
      'param_name' => 'image___image_size',
      'description' => __('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme.
                          Alternatively enter image size in pixels: 200x100 (Width x Height).
                          Leave empty to use "thumbnail" size.', 'victheme_centerline'),
      'admin_label' => true,
      'group' => __('Image', 'victheme_centerline'),
      'value' => 'full',
    );


    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Image style', 'victheme_centerline'),
      'param_name' => 'image___image_style',
      'group' => __('Image', 'victheme_centerline'),
      'value' => getVcShared('single image styles'),
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Border color', 'victheme_centerline'),
      'param_name' => 'image___border_color',
      'value' => getVcShared( 'colors' ),
      'std' => 'grey',
      'group' => __('Image', 'victheme_centerline'),
      'description' => __('Border color.', 'victheme_centerline'),
      'param_holder_class' => 'vc_colored-dropdown'
    );

    $positions = array(
      'left' => __('Left', 'victheme_centerline'),
      'center' => __('Center', 'victheme_centerline'),
      'right' => __('Right', 'victheme_centerline'),
    );

    foreach ($positions as $key => $text) {
      $options['params'][] = array(
        'type' => 'dropdown',
        'heading' => __('Enabled', 'victheme_centerline'),
        'param_name' => $key . '___enabled',
        'admin_label' => true,
        'value' => array(
          __('Disabled', 'victheme_centerline') => 'false',
          __('Enabled', 'victheme_centerline') => 'true',
        ),
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-3',
      );

      $options['params'][] = array(
        'type' => 'textfield',
        'heading' => __('Text', 'victheme_centerline'),
        'param_name' => $key . '___text',
        'admin_label' => true,
        'group' => $text,
      );

      $options['params'][] = array(
        'type' => 'textarea',
        'heading' => __('Content', 'victheme_centerline'),
        'param_name' => $key . '___content',
        'admin_label' => true,
        'group' => $text,
      );

      $options['params'][] = array(
        'type' => 'textfield',
        'heading' => __('Circle Start Point Radius', 'victheme_centerline'),
        'param_name' => $key . '___data___circle_start',
        'admin_label' => true,
        'value' => 3,
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-3',
      );

      $options['params'][] = array(
        'type' => 'textfield',
        'heading' => __('Circle End Point Radius', 'victheme_centerline'),
        'param_name' => $key . '___data___circle_end',
        'admin_label' => true,
        'value' => 3,
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-3',
      );

      $options['params'][] = array(
        'type' => 'textfield',
        'heading' => __('Circle Start Opaque Radius', 'victheme_centerline'),
        'param_name' => $key . '___data___circle_opaque',
        'admin_label' => true,
        'value' => 10,
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-3',
      );

      $options['params'][] = array(
        'type' => 'textfield',
        'heading' => __('Circle Opaque Opacity', 'victheme_centerline'),
        'param_name' => $key . '___data___circle_opacity',
        'admin_label' => true,
        'value' => 0.6,
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-3',
      );


      $options['params'][] = array(
        'type' => 'textfield',
        'heading' => __('Line Width', 'victheme_centerline'),
        'param_name' => $key . '___data___line_width',
        'admin_label' => true,
        'value' => 1,
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-3',
      );

      $options['params'][] = array(
        'type' => 'textfield',
        'heading' => __('Margin', 'victheme_centerline'),
        'param_name' => $key . '___styles___margin',
        'admin_label' => true,
        'value' => '',
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-3',
      );


      $options['params'][] = array(
        'type' => 'colorpicker',
        'heading' => __('Line color', 'victheme_centerline'),
        'param_name' => $key . '___data___line_color',
        'value' => '#158FBF',
        'admin_label' => true,
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-12',
      );

      $options['params'][] = array(
        'type' => 'colorpicker',
        'heading' => __('Dot color', 'victheme_centerline'),
        'param_name' => $key . '___data___dot_color',
        'value' => '#158FBF',
        'admin_label' => true,
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-12',
      );

      $options['params'][] = array(
        'type' => 'colorpicker',
        'heading' => __('Text color', 'victheme_centerline'),
        'param_name' => $key . '___textcolor',
        'value' => '',
        'admin_label' => true,
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-12',
      );

      $options['params'][] = array(
        'type' => 'colorpicker',
        'heading' => __('Content text color', 'victheme_centerline'),
        'param_name' => $key . '___contentcolor',
        'value' => '',
        'admin_label' => true,
        'group' => $text,
        'edit_field_class' => 'vc_col-xs-12',
      );
    }

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


class WPBakeryShortCode_CenterLineSimple extends WPBakeryShortCode {}