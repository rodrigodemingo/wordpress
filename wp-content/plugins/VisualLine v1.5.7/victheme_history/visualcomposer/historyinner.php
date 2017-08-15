<?php
/**
 * Class extending the Visualcomposer base class
 * for building the historyinner element
 *
 * how to use :

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
 * This shortcode must be inside the timeline shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_History_Visualcomposer_HistoryInner
extends VTCore_Wordpress_Models_VC {


  public function registerVC() {

    $options = array(
      'name' => __('History Content', 'victheme_history'),
      'description' => __('The content element for history', 'victheme_history'),
      'base' => 'historyinner',
      'icon' => 'icon-historyinner',
      'category' => __('VisualLine', 'victheme_history'),
      'as_child' => array(
        'only' => 'history',
      ),
      'is_container' => true,
      'js_view' => 'VTCoreContainer',
    );


    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'direction',
      'name' => 'direction',
      'core_class' => 'VTCore_Bootstrap_Form_BsSelect',
      'core_context' => array(
        'text' => __('Direction', 'victheme_history'),
        'name' => 'direction',
        'options' => array(
          'left' => __('Left', 'victheme_history'),
          'right' => __('Right', 'victheme_history'),
          'center' => __('Center', 'victheme_history'),
        ),
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'direction', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Enable Title', 'victheme_history'),
      'param_name' => 'enable___title',
      'admin_label' => false,
      'value' => array(
        __('Enable', 'victheme_history') => 'true',
        __('Disable', 'victheme_history') => 'false',
      ),
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Enable SubTitle', 'victheme_history'),
      'param_name' => 'enable___subtitle',
      'admin_label' => false,
      'value' => array(
        __('Enable', 'victheme_history') => 'true',
        __('Disable', 'victheme_history') => 'false',
      ),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Title', 'victheme_history'),
      'param_name' => 'title',
      'value' => '',
      'admin_label' => true,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Title Extra CSS Class', 'victheme_history'),
      'param_name' => 'title_class',
      'admin_label' => false,
    );


    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Sub Title', 'victheme_history'),
      'param_name' => 'subtitle',
      'value' => '',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Subtitle Extra CSS Class', 'victheme_history'),
      'param_name' => 'subtitle_class',
      'admin_label' => false,
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

    /** Image option group **/
    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Enable Image', 'victheme_history'),
      'param_name' => 'enable___image',
      'admin_label' => false,
      'group' => __('Image options', 'victheme_history'),
      'value' => array(
        __('Enable', 'victheme_history') => 'true',
        __('Disable', 'victheme_history') => 'false',
      ),
    );


    $options['params'][] = array(
      'type' => 'attach_image',
      'heading' => __('Image', 'victheme_history'),
      'param_name' => 'image_attachmentid',
      'value' => '',
      'description' => __('Select image from media library.', 'victheme_history'),
      'admin_label' => false,
      'group' => __('Image options', 'victheme_history'),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Image size', 'victheme_history'),
      'param_name' => 'image_size',
      'description' => __('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'victheme_history'),
      'admin_label' => false,
      'group' => __('Image options', 'victheme_history'),
    );


    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Image alignment', 'victheme_history'),
      'param_name' => 'image_position',
      'admin_label' => false,
      'group' => __('Image options', 'victheme_history'),
      'value' => array(
        __('Left', 'victheme_history') => 'left',
        __('Center', 'victheme_history') => 'center',
        __('Right', 'victheme_history') => 'right',
      ),
    );



    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Image style', 'victheme_history'),
      'param_name' => 'image_style',
      'admin_label' => false,
      'group' => __('Image options', 'victheme_history'),
      'value' => getVcShared('single image styles'),
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Border color', 'victheme_history'),
      'param_name' => 'border_color',
      'value' => getVcShared( 'colors' ),
      'group' => __('Image options', 'victheme_history'),
      'std' => 'grey',
      'admin_label' => false,
      'description' => __('Border color.', 'victheme_history'),
      'param_holder_class' => 'vc_colored-dropdown'
    );


    /** Icon option group **/
    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Enable Icon', 'victheme_history'),
      'param_name' => 'enable___icon',
      'admin_label' => false,
      'group' => __('Icon options', 'victheme_history'),
      'value' => array(
        __('Enable', 'victheme_history') => 'true',
        __('Disable', 'victheme_history') => 'false',
      ),
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon_icon',
      'name' => 'icon_icon',
      'group' => __('Icon options', 'victheme_history'),
      'core_class' => 'VTCore_Fontawesome_Form_faIcon',
      'edit_field_class' => 'vc_col-xs-3',
      'core_context' => array(
        'text' => __('Icon', 'victheme_history'),
        'name' => 'icon_icon',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon_icon', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon_size',
      'name' => 'icon_size',
      'group' => __('Icon options', 'victheme_history'),
      'core_class' => 'VTCore_Fontawesome_Form_faSize',
      'edit_field_class' => 'vc_col-xs-3',
      'core_context' => array(
        'text' => __('Size', 'victheme_history'),
        'name' => 'icon_size',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon_size', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon_rotate',
      'name' => 'icon_rotate',
      'group' => __('Icon options', 'victheme_history'),
      'core_class' => 'VTCore_Fontawesome_Form_faRotate',
      'edit_field_class' => 'vc_col-xs-3',
      'core_context' => array(
        'text' => __('Rotate', 'victheme_history'),
        'name' => 'icon_rotate',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon_rotate', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon_flip',
      'name' => 'icon_flip',
      'group' => __('Icon options', 'victheme_history'),
      'core_class' => 'VTCore_Fontawesome_Form_faFlip',
      'edit_field_class' => 'vc_col-xs-3',
      'core_context' => array(
        'text' => __('Flip', 'victheme_history'),
        'name' => 'icon_flip',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon_flip', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon_spin',
      'name' => 'icon_spin',
      'group' => __('Icon options', 'victheme_history'),
      'core_class' => 'VTCore_Fontawesome_Form_faSpin',
      'edit_field_class' => 'vc_col-xs-3 clearboth',
      'core_context' => array(
        'text' => __('Spin', 'victheme_history'),
        'name' => 'icon_spin',
        'attributes' => array(
          'class' => array(
            'clearboth'
          ),
        ),
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon_spin', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon_border',
      'name' => 'icon_border',
      'group' => __('Icon options', 'victheme_history'),
      'core_class' => 'VTCore_Fontawesome_Form_faBorder',
      'edit_field_class' => 'vc_col-xs-3',
      'core_context' => array(
        'text' => __('Border', 'victheme_history'),
        'name' => 'icon_border',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon_border', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon_shape',
      'name' => 'icon_shape',
      'group' => __('Icon options', 'victheme_history'),
      'core_class' => 'VTCore_Fontawesome_Form_faShape',
      'edit_field_class' => 'vc_col-xs-3',
      'core_context' => array(
        'text' => __('Shape', 'victheme_history'),
        'name' => 'icon_shape',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon_shape', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'vtcore',
      'param_name' => 'icon_position',
      'name' => 'icon_position',
      'group' => __('Icon options', 'victheme_history'),
      'core_class' => 'VTCore_Fontawesome_Form_faPosition',
      'edit_field_class' => 'vc_col-xs-3',
      'core_context' => array(
        'text' => __('Position', 'victheme_history'),
        'name' => 'icon_position',
        'input_elements' => array(
          'attributes' => array(
            'class' => array('wpb_vc_param_value', 'wpb-dropdown', 'icon_position', 'vtcore_field')
          ),
        ),
      ),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'group' => __('Icon options', 'victheme_history'),
      'heading' => __('Inner Padding', 'victheme_history'),
      'description' => __('Example : 10px 10px 10px 10px', 'victheme_history'),
      'param_name' => 'icon_inner_padding',
      'edit_field_class' => 'vc_col-xs-3 clearboth',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'group' => __('Icon options', 'victheme_history'),
      'heading' => __('Font size', 'victheme_history'),
      'description' => __('Example: 12px or 12em', 'victheme_history'),
      'param_name' => 'icon_font',
      'edit_field_class' => 'vc_col-xs-3',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'group' => __('Icon options', 'victheme_history'),
      'heading' => __('Width', 'victheme_history'),
      'description' => __('Example: 48px', 'victheme_history'),
      'param_name' => 'icon_width',
      'edit_field_class' => 'vc_col-xs-3',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'group' => __('Icon options', 'victheme_history'),
      'heading' => __('Height', 'victheme_history'),
      'description' => __('Example: 30px', 'victheme_history'),
      'param_name' => 'icon_height',
      'edit_field_class' => 'vc_col-xs-3',
      'admin_label' => false,
    );



    $options['params'][] = array(
      'type' => 'colorpicker',
      'group' => __('Icon options', 'victheme_history'),
      'heading' => __('Icon Color', 'victheme_history'),
      'param_name' => 'icon_color',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'group' => __('Icon options', 'victheme_history'),
      'heading' => __('Background Color', 'victheme_history'),
      'param_name' => 'icon_background',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'group' => __('Icon options', 'victheme_history'),
      'heading' => __('Border Color', 'victheme_history'),
      'param_name' => 'icon_border_color',
      'admin_label' => false,
    );


    /** Label group options **/
    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Enable Label', 'victheme_history'),
      'param_name' => 'enable___label',
      'admin_label' => false,
      'group' => __('Label options', 'victheme_history'),
      'value' => array(
        __('Enable', 'victheme_history') => 'true',
        __('Disable', 'victheme_history') => 'false',
      ),
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __('Label Text', 'victheme_history'),
      'group' => __('Label options', 'victheme_history'),
      'param_name' => 'label_text',
      'description' => __('Input the text for the label element.', 'victheme_history'),
      'value' => '',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __('Label Type', 'victheme_history'),
      'group' => __('Label options', 'victheme_history'),
      'param_name' => 'label_label',
      'admin_label' => false,
      'description' => __('Select the pre-defined color for the label element', 'victheme_history'),
      'value' => array(
        __('Default', 'victheme_history') => 'default',
        __('Primary', 'victheme_history') => 'primary',
        __('Success', 'victheme_history') => 'success',
        __('Info', 'victheme_history') => 'info',
        __('Warning', 'victheme_history') => 'warning',
        __('Danger', 'victheme_history') => 'danger',
      ),
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'group' => __('Label options', 'victheme_history'),
      'heading' => __('Font Color', 'victheme_history'),
      'param_name' => 'label_fontcolor',
      'admin_label' => false,
    );

    $options['params'][] = array(
      'type' => 'colorpicker',
      'group' => __('Label options', 'victheme_history'),
      'heading' => __('Background Color', 'victheme_history'),
      'param_name' => 'label_background',
      'admin_label' => false,
    );



    $options['params'][] = array(
      'type' => 'css_editor',
      'heading' => __('Css', 'victheme_history'),
      'param_name' => 'css',
      'admin_label' => false,
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

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Quadratic Curve X', 'victheme_history'),
      'param_name' => 'data_curve_x',
      'edit_field_class' => 'vc_col-xs-6',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '0',
      'description' => __('The connector line quadratic curve point x coordinates related to starting point', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Quadratic Curve Y', 'victheme_history'),
      'param_name' => 'data_curve_y',
      'edit_field_class' => 'vc_col-xs-6',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '100',
      'description' => __('The connector line quadratic curve point y coordinates related to starting point', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Offset Start X', 'victheme_history'),
      'param_name' => 'data_offset_start_x',
      'edit_field_class' => 'vc_col-xs-3 clearboth',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '0',
      'description' => __('The connector line starting point x offset', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Offset Start Y', 'victheme_history'),
      'param_name' => 'data_offset_start_y',
      'edit_field_class' => 'vc_col-xs-3',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '0',
      'description' => __('The connector line starting point y offset', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Offset End X', 'victheme_history'),
      'param_name' => 'data_offset_end_x',
      'edit_field_class' => 'vc_col-xs-3',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '0',
      'description' => __('The connector line ending point x offset', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Offset End Y', 'victheme_history'),
      'param_name' => 'data_offset_end_y',
      'edit_field_class' => 'vc_col-xs-3',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '0',
      'description' => __('The connector line ending point y offset', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'textfield',
      'heading' => __( 'Line Width', 'victheme_history'),
      'param_name' => 'data_linewidth',
      'edit_field_class' => 'vc_col-xs-6 clearboth',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
      'value' => '10',
      'description' => __('The connector line width in pixel', 'victheme_history')
    );

    $options['params'][] = array(
      'type' => 'dropdown',
      'heading' => __( 'Line Type', 'victheme_history'),
      'param_name' => 'data_linetype',
      'edit_field_class' => 'vc_col-xs-6',
      'group' => __('Pointer', 'victheme_history'),
      'admin_label' => false,
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
      'param_name' => 'data_gradientone',
      'group' => __('Pointer', 'victheme_history'),
      'edit_field_class' => 'vc_col-xs-6 clearboth',
      'admin_label' => false,
      'description' => __('Set the first color for the line connector gradient', 'victheme_history'),
    );

    $options['params'][] =  array(
      'type' => 'colorpicker',
      'heading' => __('Line Connector Color Two', 'victheme_history'),
      'param_name' => 'data_gradienttwo',
      'group' => __('Pointer', 'victheme_history'),
      'edit_field_class' => 'vc_col-xs-6',
      'admin_label' => false,
      'description' => __('Set the second color for the line connector gradient', 'victheme_history'),
    );


    // Left and right grids
    $position = array(
      'grids' => __('Element Grids', 'victheme_history'),
      'left_grids' => __('Left Grids', 'victheme_history'),
      'right_grids' => __('Right Grids', 'victheme_history'),
    );
    $keys = array('columns', 'offset', 'push', 'pull');
    $sizes = array('mobile', 'tablet', 'small', 'large');

    foreach ($position as $delta => $group) {
      foreach ($keys as $key) {
        foreach ($sizes as $size) {

          $name = $delta . '___' . $key . '___' . $size;

          $value = 0;
          if ($key == 'columns' && $delta == 'left_grids') {
            $value = 4;
          }
          if ($key == 'columns' && $delta == 'right_grids') {
            $value = 8;
          }

          if ($key == 'columns' && $delta == 'grids') {
            $value = 12;
          }

          $options['params'][] = array(
            'type' => 'vtcore',
            'param_name' => $name,
            'heading' => ucfirst($key) . ' ' . ucfirst($size),
            'name' => $name,
            'group' => $group,
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
    }

    return $options;
  }
}


class WPBakeryShortCode_HistoryInner extends WPBakeryShortCodesContainer {}