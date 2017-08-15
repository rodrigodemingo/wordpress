<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap button element
 *
 * how to use :
 *
 * [bsbutton
 *   size="lg|sm|xs"
 *   mode="default|primary|success|info|warning|danger"
 *   href=''
 *   target='_parent|_blank|_self|_top"
 *   id="some-id"
 *   class="someclass"]
 *
 * The button text, you can also supply icon shortcode here
 *
 * [/bsbutton]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsButton
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {


  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {

    // Convert as link
    if (isset($this->atts['href'])
        && !empty($this->atts['href'])) {

      $this->atts['type'] = 'a';
      $this->atts['attributes']['href'] = $this->atts['href'];

      if (isset($this->atts['target'])
          && !empty($this->atts['target'])) {
        $this->atts['attributes']['target'] = $this->atts['target'];
      }
    }

    if ($this->content) {
      $this->atts['text'] = do_shortcode($this->content);
    }
  }



  public function buildObject() {
    $this->object = new VTCore_Bootstrap_Form_BsButton($this->atts);
  }
}