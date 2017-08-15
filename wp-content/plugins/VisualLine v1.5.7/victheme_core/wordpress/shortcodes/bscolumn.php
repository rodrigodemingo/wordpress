<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap column element
 *
 * how to use :
 *
 * [bscolumn tag="div or other valid html tags"
 *       columns_mobile="X" columns_tablet="X" columns_small="X" columns_large="X"
 *       offset_mobile="X" offset_tablet="X" offset_small="X" offset_large="X"
 *       push_mobile="X" push_tablet="X" push_small="X" push_large="X"
 *       pull_mobile="X" pull_tablet="X" pull_small="X" pull_large="X"]
 *
 *
 *  note that if X value is zero for mobile, tablet, small, large then it will use
 *  hidden-xx as the class
 *
 *  [/column]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsColumn
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {
    $this->atts['type'] = 'div';
    if (isset($this->atts['tag']) && !empty($this->atts['tag'])) {
      $this->atts['type'] = $this->atts['tag'];
      unset($this->atts['tag']);
    }
  }

  public function buildObject() {
    $this->object = new VTCore_Bootstrap_Grid_BsColumn($this->atts);
    $this->object->addChildren(do_shortcode($this->content));
  }
}