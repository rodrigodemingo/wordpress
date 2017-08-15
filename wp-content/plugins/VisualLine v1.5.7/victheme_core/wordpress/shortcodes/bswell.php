<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap well element
 *
 * how to use :
 *
 * [bswell size="small|normal|large"
 *         id="some-id"
 *         class="someclass"]
 *
 * some content can be inserted here
 *
 * [/bswell]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsWell
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {


  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {

    if (isset($this->atts['size'])) {
      if ($this->atts['size'] == 'small') {
        $this->atts['size'] = 'well-sm';
      }
      elseif ($this->atts['size'] == 'large') {
        $this->atts['size'] = 'well-lg';
      }
    }

  }



  public function buildObject() {

    $this->object = new VTCore_Bootstrap_Element_BsWell($this->atts);
    $this->object->addChildren(do_shortcode($this->content));
  }
}