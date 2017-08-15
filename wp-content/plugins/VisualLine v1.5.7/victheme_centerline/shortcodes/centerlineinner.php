<?php
/**
 * Class extending the Shortcodes base class
 * for building the centerlineinner element
 *
 * how to use :

 * [centerlineinner
 *   id="x"
 *   class="class_one class_two"
 *   mobile="X" tablet="X" small="X" large="X"
 *   mobile_offset="X" tablet_offset="X" small_offset="X" large_offset="X"
 *   mobile_push="X" tablet_push="X" small_push="X" large_push="X"
 *   mobile_pull="X" tablet_pull="X" small_pull="X" large_pull="X"
 *   data___circle_start="3"
 *   data___circle_end="4"
 *   data___circle_opaque="10"
 *   data___circle_opacity="0.6"
 *   data___line_color= "#158FBF"
 *   data___line_width="1"
 *   data___line_type= "round"
 *   data___dot_color= "#158FBF"
 *   data___position_begin= "center"
 *   data___position_end= "top"
 *   data___offset_control_x="0"
 *   data___offset_control_y="100"
 *   data___offset_start_x="0"
 *   data___offset_start_y="0"
 *   data___offset_end_x="0"
 *   data___offset_end_y="0"
 * ]
 *
 *   some content for the inner shortcodes allowed
 *
 * [/centerlineinner]
 *
 * This shortcode must be inside the centerline shortcode
 * otherwise it will produce invalid HTML markup
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CenterLine_Shortcodes_CenterLineInner
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {

    // Convert the bootstrap classes into vc compatible one
    $this->convertVCGrid = !get_theme_support('bootstrap');

    foreach ($this->atts as $key => $value) {
      if (strpos($key, 'data___') !== false) {
        list($type, $mode) = explode('___', $key);
        $this->atts['data'][str_replace('_', '-', $mode)] = $value;
        unset($this->atts[$key]);
      }
    }
  }

  public function buildObject() {
    $this->object = new VTCore_CenterLine_Element_ClInner($this->atts);
    $this->object->addChildren(do_shortcode($this->content));
  }
}