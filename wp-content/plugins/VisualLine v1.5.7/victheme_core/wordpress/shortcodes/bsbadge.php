<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap badge element
 *
 * how to use :
 *
 * [bsbadge
 *   id="some-id"
 *   class="someclass"
 * ]
 *
 *   The label text
 *
 * [/bsbadge]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsBadge
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {
    if ($this->content) {
      $this->atts['text'] = do_shortcode($this->content);
    }
  }



  public function buildObject() {
    $this->object = new VTCore_Bootstrap_Element_BsBadge($this->atts);
  }
}