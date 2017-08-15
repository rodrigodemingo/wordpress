<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap panel element
 *
 * how to use :
 *
 * [bspanel
 *     id="some-id"
 *     heading="text to serve as the panel heading"
 *     class="someclass"]
 *
 * Some contents, other shortcode will be processed
 * automatically.
 *
 *
 * [/bspanel]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsPanel
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {



  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {
    $this->atts['contents'] = array(do_shortcode($this->content));

    if (isset($this->atts['heading'])) {
      $this->atts['text'] = $this->atts['heading'];
      $this->atts['heading'] = true;
    }
    else {
      $this->atts['heading'] = false;
    }
  }



  public function buildObject() {

    $this->object = new VTCore_Bootstrap_Element_BsPanel($this->atts);

  }
}