<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap medialist element
 *
 * how to use :
 *
 * [bsmedialist
 *     id="some-id"
 *     class="someclass"]
 *
 * [bsmediaobject type="li" img="x" text="some header text"]somecontent[/bsmediaobject]
 * [bsmediaobject type="li" img="x" text="some header text"]somecontent[/bsmediaobject]
 * [bsmediaobject type="li" img="x" text="some header text"]somecontent[/bsmediaobject]
 *
 * [/bsmedialist]
 *
 * notice : the children must only be bsmediaobject shortcode and must define type = li for
 *          valid html markup!.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsMedialist
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {

  public function buildObject() {

    $this->object = new VTCore_Bootstrap_Element_BsMediaList($this->atts);
    $this->object->addChildren(do_shortcode($this->content));

  }
}