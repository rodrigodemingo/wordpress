<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap row element
 *
 * how to use :
 *
 * [bsrow tag="div or other valid html tag" id="some-id" class="someclass"]
 * some content, preferably the [column] shortcode
 * [/bsrow]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsRow
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes{

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
    $this->object = new VTCore_Bootstrap_Grid_BsRow($this->atts);
    $this->object->addChildren(do_shortcode($this->content));
  }
}