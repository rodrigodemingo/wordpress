<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap jumbotron element
 *
 * how to use :
 *
 * [bsjumbotron
 *         fullsize="boolean"
 *         id="some-id"
 *         class="someclass"]
 *
 * some content can be inserted here
 *
 * [/bsjumboron]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsJumbotron
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {


  public function buildObject() {
    $this->object = new VTCore_Bootstrap_Element_BsJumbotron($this->atts);
    $this->object->addChildren(do_shortcode($this->content));

  }
}