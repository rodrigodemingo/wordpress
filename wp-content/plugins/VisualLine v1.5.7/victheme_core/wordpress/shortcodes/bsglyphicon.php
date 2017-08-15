<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap glyphicon element
 *
 * how to use :
 *
 * [bsglyphicon
 *   icon="the icon name minus the glyphicon text"
 *   size="glypicon-lg|glyphicon-2x|glyphicon-3x|glyphicon-4x|glyphicon-5x"
 *   color="valid hex color"
 * ]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsGlyphicon
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  public function buildObject() {
    $this->object = new VTCore_Bootstrap_Element_BsGlyphicon($this->atts);
  }
}