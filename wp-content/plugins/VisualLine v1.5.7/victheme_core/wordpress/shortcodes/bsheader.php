<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap Heading element
 *
 * how to use :
 *
 * [bsheader
 *        tag="h1-h6"
 *        small="some text displayed as small text"
 *        id="some-id"
 *        class="someclass"]
 *
 * The main title text
 *
 * [/bsheader]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsHeader
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  protected $processTag = false;

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

    $this->object = new VTCore_Bootstrap_Element_BsHeader($this->atts);

  }
}