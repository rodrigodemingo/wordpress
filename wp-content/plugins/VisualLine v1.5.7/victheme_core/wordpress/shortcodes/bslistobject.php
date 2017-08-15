<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap List Object element
 *
 * This class is meant to be embedded inside the Bootstrap
 * List Group Shortcode.
 *
 * how to use :
 *
 *   [bslistobject
 *     type="li|a"
 *     active="true|false"
 *     mode="success|warning|info|danger"
 *     badge="some badge text"
 *     heading="some heading text"
 *     href="the url to link this object"]
 *
 *     somecontent
 *
 *   [/bslistobject]
 *
 * notice : Must define the right type (li for ul and a for div) valid html markup!
 *          as its parent (bootstrap list group) type.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsListObject
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  /**
   * Extending parent method.
   * @see VTCore_Wordpress_Models_Shortcodes::processCustomRules()
   */
  protected function processCustomRules() {
    $this->atts['contents'] = array(do_shortcode($this->content));
  }


  public function buildObject() {

    $this->object = new VTCore_Bootstrap_Element_BsListObject($this->atts);

  }
}