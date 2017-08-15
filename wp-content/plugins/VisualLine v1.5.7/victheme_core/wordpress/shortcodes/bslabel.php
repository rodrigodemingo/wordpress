<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap label element
 *
 * how to use :
 *
 * [bslabel
 *   label_type="default|primary|success|info|warning|danger"
 *   id="some-id"
 *   class="someclass"]
 *
 * The label text
 *
 * [/bslabel]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsLabel
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {


  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {
    if (isset($this->atts['label_type'])) {
      $this->atts['label'] = $this->atts['label_type'];
      unset($this->atts['label_type']);
    }

    if ($this->content) {
      $this->atts['text'] = do_shortcode($this->content);
    }
  }



  public function buildObject() {
    $this->object = new VTCore_Bootstrap_Element_BsLabel($this->atts);
  }
}