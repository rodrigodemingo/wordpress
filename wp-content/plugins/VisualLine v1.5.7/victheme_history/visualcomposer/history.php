<?php
/**
 * Class extending the Visualcomposer base class
 * for building the history element
 *
 * how to use :
 *
 * [history
 *   class="some class"
 *   id="someid"
 *   conenctor="true|false"]
 *
 * [historyinner
 *   id="x"
 *   class="class_one class_two"
 *   direction="left|right|center"
 *   image_attachmentid="wp attachment id or image url"
 *   image_size="the image size using numeric widthxheight or wp image size"
 *   image_position="the position for the image"
 *   border_color="the border color as vc border color"
 *   image_style="extra css class to style the image"
 *   icon_icon="fontawesome icon class"
 *   icon_size="the icon size utilizing fontawesome icon sizing"
 *   icon_rotate="rotate value for the icon"
 *   icon_flip="flip the icon or not"
 *   icon_spin="spin the icon"
 *   icon_border="the border value for the icon wrapper"
 *   icon_shape="the custom shape for the icon"
 *   icon_position="the position for the icon"
 *   icon_inner_padding="the padding for the icon"
 *   icon_font="the fontsize for the icon overriding the fontawesome icon size rule"
 *   icon_width="the width for the icon wrapper"
 *   icon_height="the height for the icon wrapper"
 *   icon_color="the color for the icon"
 *   icon_background="the background color for the wrapper element"
 *   icon_border_color="the border color for the icon"
 *   label_type="the type for the label according to bootstrap label types"
 *   label_fontcolor="the font color for the label element"
 *   label_text="the text for the label"
 *   label_background="the label background color"
 *   title="some title"
 *   title_class="extra css class for title"
 *   subtitle="some subtitle"
 *   subtitle_class="extra css class for subtitle"
 *   data_curve_x="numeric representing pixel value for quadratic curve control point x relative to starting point x"
 *   data_curve_y="numeric representing pixel value for quadratic curve control point y relative to starting point y"
 *   data_offset_start_x="numeric representing pixel value for offsetting the start x"
 *   data_offset_start_y="numeric representing pixel value for offsetting the start y"
 *   data_offset_end_x="numeric representing pixel value for offsetting the end x"
 *   data_offset_end_y="numeric representing pixel value for offsetting the end y"
 *   data_gradientone="hex value for gradient value one"
 *   data_gradienttwo="hex value for gradient value two"
 *   data_linewidth="numeric representing the width of the conneting line"
 *   data_linetype="butt|round|square"
 *
 *   // Grids with dotted notation
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
 *   left_grids___columns___mobile="X"
 *   left_grids___columns___tablet="X"
 *   left_grids___columns___small="X"
 *   left_grids___columns___large="X"
 *   left_grids___offset___mobile="X"
 *   left_grids___offset___tablet="X"
 *   left_grids___offset___small="X"
 *   left_grids___offset___large="X"
 *   left_grids___push___mobile="X"
 *   left_grids___push___tablet="X"
 *   left_grids___push___small="X"
 *   left_grids___push___large="X"
 *   left_grids___pull___mobile="X"
 *   left_grids___pull___tablet="X"
 *   left_grids___pull___small="X"
 *   left_grids___pull___large="X"
 *   right_grids___columns___mobile="X"
 *   right_grids___columns___tablet="X"
 *   right_grids___columns___small="X"
 *   right_grids___columns___large="X"
 *   right_grids___offset___mobile="X"
 *   right_grids___offset___tablet="X"
 *   right_grids___offset___small="X"
 *   right_grids___offset___large="X"
 *   right_grids___push___mobile="X"
 *   right_grids___push___tablet="X"
 *   right_grids___push___small="X"
 *   right_grids___push___large="X"
 *   right_grids___pull___mobile="X"
 *   right_grids___pull___tablet="X"
 *   right_grids___pull___small="X"
 *   right_grids___pull___large="X"
 * ]
 *
 *   some content for the inner shortcodes allowed
 *
 * [/historyinner]
 *
 * [history]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_History_Visualcomposer_History
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('History', 'victheme_history'),
      'description' => __('Element Wrapper', 'victheme_history'),
      'base' => 'history',
      'icon' => 'icon-history',
      'category' => __('VisualLine', 'victheme_history'),
      'as_parent' => array(
        'only' => 'historyinner',
      ),
      'is_container' => true,
      'js_view' => 'VTCoreContainer',
      'params' => array()
    );


    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __( 'Point Connector', 'victheme_history'),
      'param_name' => 'connector',
      'admin_label' => true,
      'value' => array(
        __('Disable', 'victheme_history') => false,
        __('Enable', 'victheme_history') => true,
      ),
      'description' => __('Enable point connector created by canvas element', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS ID', 'victheme_history'),
      'param_name' => 'id',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('CSS Class', 'victheme_history'),
      'param_name' => 'class',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'css_editor',
      'heading' => __('Css', 'victheme_history'),
      'param_name' => 'css',
      'group' => __('Design options', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __( 'CSS Animation', 'victheme_history'),
      'param_name' => 'css_animation',
      'admin_label' => false,
      'value' => array(
        __('No', 'victheme_history') => '',
        __('Top to bottom', 'victheme_history') => 'top-to-bottom',
        __('Bottom to top', 'victheme_history') => 'bottom-to-top',
        __('Left to right', 'victheme_history') => 'left-to-right',
        __('Right to left', 'victheme_history') => 'right-to-left',
        __('Appear from center', 'victheme_history') => "appear"
      ),
      'description' => __('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'victheme_history')
    );


    // Points connector default config
    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Quadratic Curve X', 'victheme_history'),
      'param_name' => 'curvex',
      'edit_field_class' => 'vc_col-xs-6',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '0',
      'description' => __('The connector line quadratic curve point x coordinates related to starting point', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Quadratic Curve Y', 'victheme_history'),
      'param_name' => 'curvey',
      'edit_field_class' => 'vc_col-xs-6',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '100',
      'description' => __('The connector line quadratic curve point y coordinates related to starting point', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Offset Start X', 'victheme_history'),
      'param_name' => 'startx',
      'edit_field_class' => 'vc_col-xs-3 vc_clearboth',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '0',
      'description' => __('The connector line starting point x offset', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Offset Start Y', 'victheme_history'),
      'param_name' => 'starty',
      'edit_field_class' => 'vc_col-xs-3',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '0',
      'description' => __('The connector line starting point y offset', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Offset End X', 'victheme_history'),
      'param_name' => 'endx',
      'edit_field_class' => 'vc_col-xs-3',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '0',
      'description' => __('The connector line ending point x offset', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Offset End Y', 'victheme_history'),
      'param_name' => 'endy',
      'edit_field_class' => 'vc_col-xs-3',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '0',
      'description' => __('The connector line ending point y offset', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Line Width', 'victheme_history'),
      'param_name' => 'linewidth',
      'edit_field_class' => 'vc_col-xs-6 vc_clearboth',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => true,
      'value' => '10',
      'description' => __('The connector line width in pixel', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __( 'Line Type', 'victheme_history'),
      'param_name' => 'linetype',
      'edit_field_class' => 'vc_col-xs-6',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => true,
      'value' => array(
        __('Round', 'victheme_history') => 'round',
        __('Square', 'victheme_history') => 'square',
        __('Butt', 'victheme_history') => 'butt',
      ),
      'description' => __('The connector line type', 'victheme_history')
    );

    $options['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Line Connector Color One', 'victheme_history'),
      'param_name' => 'gradientone',
      'group' => __('Pointer', 'victheme_history'),
      'edit_field_class' => 'vc_col-xs-6 vc_clearboth',
      'description' => __('Set the first color for the line connector gradient', 'victheme_history'),
    );

    $options['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Line Connector Color Two', 'victheme_history'),
      'param_name' => 'gradienttwo',
      'group' => __('Pointer', 'victheme_history'),
      'edit_field_class' => 'vc_col-xs-6',
      'description' => __('Set the second color for the line connector gradient', 'victheme_history'),
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


class WPBakeryShortCode_History extends WPBakeryShortCodesContainer {}