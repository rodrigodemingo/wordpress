<?php
/**
 * Class extending the Visualcomposer base class
 * for building the centerline element
 *
 * how to use :
 *
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
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CenterLine_Visualcomposer_CenterLineImage
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('CenterLine Image', 'victheme_centerline'),
      'description' => __('Pointer source image', 'victheme_centerline'),
      'base' => 'centerlineimage',
      'icon' => 'icon-centerlineinner',
      'category' => __('VisualLine', 'victheme_centerline'),
      'as_child' => array(
        'only' => 'centerline',
      ),
      'is_container' => true,
      'js_view' => 'VTCoreContainer',
      'params' => array()
    );

    $options['params'][] = array(
      'type' => 'attach_image',
      'heading' => __('Image', 'victheme_centerline'),
      'param_name' => 'image_attachmentid',
      'value' => '',
      'description' => __('Select image from media library.', 'victheme_centerline'),
      'admin_label' => true,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Image size', 'victheme_centerline'),
      'param_name' => 'image_size',
      'description' => __('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme.
                          Alternatively enter image size in pixels: 200x100 (Width x Height).
                          Leave empty to use "thumbnail" size.', 'victheme_centerline'),
      'admin_label' => true,
      'value' => 'full',
    );


    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Image alignment', 'victheme_centerline'),
      'param_name' => 'image_position',
      'admin_label' => true,
      'value' => array(
        __('-- Select --', 'victheme_centerline') => false,
        __('Left', 'victheme_centerline') => 'left',
        __('Right', 'victheme_centerline') => 'right',
        __('Center', 'victheme_centerline') => 'center',
      ),
    );


    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Image style', 'victheme_centerline'),
      'param_name' => 'image_style',
      'value' => getVcShared('single image styles'),
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Border color', 'victheme_centerline'),
      'param_name' => 'border_color',
      'value' => getVcShared( 'colors' ),
      'std' => 'grey',
      'description' => __('Border color.', 'victheme_centerline'),
      'param_holder_class' => 'vc_colored-dropdown'
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


class WPBakeryShortCode_CenterLineImage extends WPBakeryShortCodesContainer {}