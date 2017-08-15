<?php
/**
 * Class extending the Shortcodes base class
 * for building the memoryline element
 *
 * how to use :
 *
 * [memoryline
 *   class="some class"
 *   id="someid"
 *   data___line_color="x"
 *   data___line_width="x"
 *   data___line_type="x"
 *   data___line_offset_x="x"
 *   data___line_offset_y="y"
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
 * [memorylineinner
 *   id="x"
 *   class="class_one class_two"
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
 * [/memoryline]
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_MemoryLine_Shortcodes_MemoryLine
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

    $object = new VTCore_Wordpress_Objects_Array($this->atts);
    if ($object->get('data')) {
      foreach ($object->get('data') as $key => $value) {
        $newkey = str_replace('_', '-', $key);
        $object->remove('data.' . $key);
        $object->add('data.' . $newkey, $value);
      }
    }

    $this->atts = $object->extract();
    unset($object);
    $object = null;
  }


  public function buildObject() {
    $this->object = new VTCore_MemoryLine_Element_MlElement($this->atts);
    $this->object->addChildren(do_shortcode($this->content));
  }
}