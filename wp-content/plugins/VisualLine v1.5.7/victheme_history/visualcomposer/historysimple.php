<?php
/**
 * Class extending the Visualcomposer base class
 * for building the history simple element
 *
 * how to use :
 * contentargs="url decoded arrays of content"
 * gradientone="hex to serve as the gradient line one"
 * gradienttwo="hex to serve as the gradient line two"
 * linewidth="the line width"
 * linetype="the line type"
 * icon___icon="the icon name"
 * icon___color="the icon color"
 * icon___background="the icon background color"
 * label___background="the label background color"
 * label___color="the label font color"
 * image___style="the image style"
 * image___size="the image size"
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_History_Visualcomposer_HistorySimple
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('Simple History', 'victheme_history'),
      'description' => __('Simple History Element', 'victheme_history'),
      'base' => 'historysimple',
      'icon' => 'icon-history',
      'category' => __('VisualLine', 'victheme_history'),
      'params' => array()
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon___icon',
      'name' => 'icon___icon',
      'core_class' => 'VTCore_Fontawesome_Form_faIcon',
      'edit_field_class' => 'vc_col-xs-12',
      'core_context' => array(
        'text' => __('Icon', 'victheme_history'),
        'name' => 'icon___icon',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon_icon', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Line Width', 'victheme_history'),
      'param_name' => 'linewidth',
      'edit_field_class' => 'vc_col-xs-6',
      'admin_label' => true,
      'value' => '10',
      'description' => __('The connector line width in pixel', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __( 'Line Type', 'victheme_history'),
      'param_name' => 'linetype',
      'edit_field_class' => 'vc_col-xs-6',
      'admin_label' => true,
      'value' => array(
        __('Round', 'victheme_history') => 'round',
        __('Square', 'victheme_history') => 'square',
        __('Butt', 'victheme_history') => 'butt',
      ),
      'description' => __('The connector line type', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Image size', 'victheme_history'),
      'param_name' => 'image___size',
      'edit_field_class' => 'vc_col-xs-6',
      'description' => __('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'victheme_history'),
      'admin_label' => true,
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Image style', 'victheme_history'),
      'edit_field_class' => 'vc_col-xs-6',
      'param_name' => 'image___style',
      'value' => getVcShared('single image styles'),
    );


    $options['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Line Connector Color One', 'victheme_history'),
      'param_name' => 'gradientone',
      'edit_field_class' => 'vc_col-xs-4 vc_clearboth',
      'description' => __('Set the first color for the line connector gradient', 'victheme_history'),
    );

    $options['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Line Connector Color Two', 'victheme_history'),
      'param_name' => 'gradienttwo',
      'edit_field_class' => 'vc_col-xs-4',
      'description' => __('Set the second color for the line connector gradient', 'victheme_history'),
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Icon Color', 'victheme_history'),
      'param_name' => 'icon___color',
      'edit_field_class' => 'vc_col-xs-4',
      'admin_label' => true,
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Icon Background Color', 'victheme_history'),
      'param_name' => 'icon___background',
      'edit_field_class' => 'vc_col-xs-4',
      'admin_label' => true,
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Label Font Color', 'victheme_history'),
      'param_name' => 'label___fontcolor',
      'edit_field_class' => 'vc_col-xs-4',
      'admin_label' => true,
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'heading' => __('Label Background Color', 'victheme_history'),
      'param_name' => 'label___background',
      'edit_field_class' => 'vc_col-xs-4',
      'admin_label' => true,
    );

    $options['params']['group'] = array(
      'type' => 'param_group',
      'heading' => __('Items', 'victheme_history'),
      'param_name' => 'contentargs',
      'group' => __('Items', 'victheme_history'),
      'value' => urlencode(json_encode(array(
        array(
          'image_attachmentid' => '',
          'label_text' => '2013',
          'title' => __('Example Title', 'victheme_history'),
          'subtitle' => __('Example SubTitle', 'victheme_history'),
          'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
        ),
        array(
          'image_attachmentid' => '',
          'label_text' => '2014',
          'title' => __('Example Title', 'victheme_history'),
          'subtitle' => __('Example SubTitle', 'victheme_history'),
          'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
        ),
        array(
          'image_attachmentid' => '',
          'label_text' => '2015',
          'title' => __('Example Title', 'victheme_history'),
          'subtitle' => __('Example SubTitle', 'victheme_history'),
          'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
        ),
        array(
          'image_attachmentid' => '',
          'label_text' => '2016',
          'title' => __('Example Title', 'victheme_history'),
          'subtitle' => __('Example SubTitle', 'victheme_history'),
          'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
        ),
      ))),
      'params' => array(),
    );

    $options['params']['group']['params'][] = array(
      'type' => 'attach_image',
      'heading' => __('Image', 'victheme_history'),
      'param_name' => 'image_attachmentid',
      'value' => '',
      'description' => __('Select image from media library.', 'victheme_history'),
      'admin_label' => true,
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Label', 'victheme_history'),
      'param_name' => 'label_text',
      'admin_label' => true,
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Title', 'victheme_history'),
      'param_name' => 'title',
      'admin_label' => true,
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Subtitle', 'victheme_history'),
      'param_name' => 'subtitle',
      'admin_label' => true,
    );

    $options['params']['group']['params'][] = array(
      'type' => 'textarea',
      'heading' => __('Content', 'victheme_history'),
      'param_name' => 'content',
      'admin_label' => true,
    );

    return $options;
  }
}


class WPBakeryShortCode_HistorySimple extends WPBakeryShortCode {}