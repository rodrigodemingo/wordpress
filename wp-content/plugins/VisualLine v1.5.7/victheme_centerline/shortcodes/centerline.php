<?php
/**
 * Class extending the Shortcodes base class
 * for building the centerline element
 *
 * how to use :
 *
 * [centerline
 *   class="some class"
 *   id="someid"
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
 *   data___circle_start="x"
 *   data___circle_end="X"
 *   data___circle_opaque="X"
 *   data___circle_opacity="X"
 *   data___line_color="X"
 *   data___line_width="X"
 *   data___line_type="X"
 *   data___dot_color="X"
 * ]
 *
 * [centerlineinner
 *   id="x"
 *   class="class_one class_two"
 *   position="left|right|top|bottom"
 *   linecolor="the color for the line"
 *   dotcolor="the color for the dotted end"
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
 *   data___position_start= "center"
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
 * [/centerline]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CenterLine_Shortcodes_CenterLine
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $processDottedNotation = true;

  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {

    // Convert the bootstrap classes into vc compatible one
    $this->convertVCGrid = !get_theme_support('bootstrap');
  }



  public function buildObject() {
    $this->object = new VTCore_CenterLine_Element_ClElement($this->atts);
    $this->object->addChildren(do_shortcode($this->content));
  }
}