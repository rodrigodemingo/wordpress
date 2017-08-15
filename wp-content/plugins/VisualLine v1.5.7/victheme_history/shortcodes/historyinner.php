<?php
/**
 * Class extending the Shortcodes base class
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
 *   enable___image="true|false"
 *   enable___icon="true|false"
 *   enable___label="true|false"
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
 * This shortcode must be inside the history shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_History_Shortcodes_HistoryInner
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {


  protected $processDottedNotation = true;
  protected $booleans = array(
    'enable.icon',
    'enable.label',
    'enable.subtitle',
    'enable.image',
    'enable.title',
  );

  protected $defaults = array(
    'image_position' => 'left',
    'label_label' => 'default',
    'data_linetype' => 'round',
  );

  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {

    // Convert the bootstrap classes into vc compatible one
    $this->convertVCGrid = !get_theme_support('bootstrap');

    $this->atts = wp_parse_args($this->atts, $this->defaults);

    foreach ($this->atts as $key => $value) {

      // Processing icons
      if (strpos($key, 'icon_') !== false) {
        $name = str_replace('icon_', '', $key);

        if (strpos($name, 'inner_padding') !== false) {
          $name = 'padding';
        }
        $this->atts['icon_element'][$name] = $value;

        unset($this->atts[$key]);
        continue;
      }

      if ($key == 'label_background') {
        $this->atts['label_element']['styles']['background'] = $value;
        unset($this->atts[$key]);
        continue;
      }

      if ($key == 'label_fontcolor') {
        $this->atts['label_element']['styles']['color'] = $value;
        unset($this->atts[$key]);
        continue;
      }

      // Processing label
      if (strpos($key, 'label_') !== false) {
        $name = str_replace('label_', '', $key);
        $this->atts['label_element'][$name] = $value;

        unset($this->atts[$key]);
        continue;
      }

      // Processing image
      if ($key == 'image_attachmentid') {
        $this->atts['image_element']['attachment_id'] = $value;
        unset($this->atts[$key]);
        continue;
      }

      if ($key == 'image_size') {

        $size = explode('x', $value);

        if (isset($size[0])) {
          $width = $size[0];
        }

        if (isset($size[1])) {
          $height = $size[1];
        }

        if (isset($width) && is_numeric($width)
            && isset($height) && is_numeric($height)) {
          $this->atts['image_element']['size'] = array($width, $height);
        }
        else {
          $this->atts['image_element']['size'] = $value;
        }
        unset($this->atts[$key]);
        continue;
      }

      if ($key == 'image_position') {
        if ($value == 'left' || $value == 'right') {
          $value = 'pull-' . $value;
        }
        else {
          $value = 'text-' . $value;
        }
        $this->atts['image_wrapper_element']['attributes']['class'][] = $value;

        unset($this->atts[$key]);
        continue;
      }

      // Title element
      if ($key == 'title_class') {
        $this->atts['title_element']['attributes']['class'][] = $value;
        unset($this->atts[$key]);
        continue;
      }

      if ($key == 'title') {
        $this->atts['title_element']['text'] = $value;
        unset($this->atts[$key]);
        continue;
      }


      // Subtitle element
      if ($key == 'subtitle_class') {
        $this->atts['subtitle_element']['attributes']['class'][] = $value;
        unset($this->atts[$key]);
        continue;
      }

      if ($key == 'subtitle') {
        $this->atts['subtitle_element']['text'] = $value;
        unset($this->atts[$key]);
        continue;
      }

      // Data element
      if (strpos($key, 'data_') !== false) {
        $this->atts['data'][str_replace(array('data_', '_'), array('', '-'), $key)] = $value;
        unset($this->atts[$key]);
        continue;
      }

    }

  }

  public function buildObject() {
    $this->atts['content'] = do_shortcode($this->content);
    $this->object = new VTCore_History_Element_HsInner($this->atts);
  }
}