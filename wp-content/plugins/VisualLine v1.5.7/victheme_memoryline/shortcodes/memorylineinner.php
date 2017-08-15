<?php
/**
 * Class extending the Shortcodes base class
 * for building the memorylineinner element
 *
 * how to use :

 * [memorylineinner
 *   id="x"
 *   class="class_one class_two"
 *   dotcolor="the color for the dotted end"
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
 * This shortcode must be inside the memoryline shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_MemoryLine_Shortcodes_MemoryLineInner
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $booleans = array(
    'newrow',
  );

  protected $defaults = array(
    'newrow' => false,
    'data' => array(
      'dot_direction' => 'forward',
    ),
  );

  protected $processDottedNotation = true;

  public function processCustomRules() {

    $this->convertVCGrid = !get_theme_support('bootstrap');

    $this->atts = wp_parse_args($this->atts, $this->defaults);

    if (isset($this->atts['titlecolor'])) {
      $this->atts['title_element']['styles']['color'] = $this->atts['titlecolor'];
      unset($this->atts['titlecolor']);
    }

    if (isset($this->atts['titlecss'])) {
      $this->atts['title_element']['attributes']['class'][] = $this->atts['titlecss'];
      unset($this->atts['titlecss']);
    }

    if (isset($this->atts['title'])) {
      $this->atts['title_element']['text'] = $this->atts['title'];
      unset($this->atts['title']);
    }

    if (isset($this->atts['textcolor'])) {
      $this->atts['text_element']['styles']['color'] = $this->atts['textcolor'];
      unset($this->atts['textcolor']);
    }

    if (isset($this->atts['textcss'])) {
      $this->atts['text_element']['attributes']['class'][] = $this->atts['textcss'];
      unset($this->atts['textcss']);
    }

    if (isset($this->atts['newrow'])) {
      $this->atts['data']['new-row'] = $this->atts['newrow'];
      unset($this->atts['newrow']);
    }

    foreach ($this->atts as $key => $value) {
      if (strpos($key, 'data___') !== false) {
        list($type, $mode) = explode('___', $key);
        $this->atts['data'][str_replace('_', '-', $mode)] = $value;
      }
    }
  }

  public function buildObject() {
    $this->atts['text_element']['text'] = do_shortcode($this->content);
    $this->object = new VTCore_MemoryLine_Element_MlInner($this->atts);
  }
}