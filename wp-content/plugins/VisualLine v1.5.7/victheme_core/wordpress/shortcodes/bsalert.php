<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap alert element
 *
 * how to use :
 *
 * [bsalert alert_type="success|info|warning|danger"
 *          button="false|html entity for button text"
 *          id="some-id"
 *          class="someclass"]
 *
 * The label text
 *
 * [/bsalert]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsAlert
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {


  protected $booleans = array(
    'button',
  );

  /**
   * Extending parent method
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {
    if (isset($this->atts['alert_type'])) {
      $this->atts['alert-type'] = $this->atts['alert_type'];
      unset($this->atts['alert_type']);
    }

    if (!isset($this->atts['button'])) {
      $this->atts['button'] = false;
    }

    if ($this->content) {
      $this->atts['text'] = do_shortcode($this->content);
    }
  }

  public function buildObject() {
    $this->object = new VTCore_Bootstrap_Element_BsAlert($this->atts);
  }
}