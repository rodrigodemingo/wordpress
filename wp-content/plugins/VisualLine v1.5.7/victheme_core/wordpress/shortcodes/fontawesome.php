<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap column element
 *
 * how to use :
 *
 * [fontawesome
 *   class="someclass"
 *   font="fontsize-in-px-or-em"
 *   icon="fontawesome-icon-name"
 *   border="boolean"
 *   spin="boolean"
 *   flip="horizontal|vertical"
 *   shape="custom-wrapper-shape"
 *   position="left|right|center"
 *   color="hex-color-for-icon"
 *   border_color="hex-color-for-border"
 *   background="hex-color-for-background"
 *   size="fa-font-size eg lg|2x|3x|4x|5x"
 *   rotate="90|180|270"
 *   padding="padding in pixel"
 *   margin="margin in pixel"]
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_Fontawesome
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  public function buildObject() {
    $this->object = new VTCore_Fontawesome_faIcon($this->atts);
  }

}