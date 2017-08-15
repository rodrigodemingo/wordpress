<?php
/**
 * Class extending the Shortcodes base class
 * for building the Bootstrap List Group element
 *
 * how to use :
 *
 * [bslistgroup
 *     id="some-id"
 *     class="someclass"
 *     mode="ul|div"
 * ]
 *
 *   [bslistobject
 *     type="li|a"
 *     active="true|false"
 *     mode="success|warning|info|danger"
 *     badge="some badge text"
 *     heading="some heading text"
 *     href="the url to link this object"]somecontent[/bslistobject]
 *
 * [/bslistgroup]
 *
 * notice : the children must only be bslistobject shortcode and must define
 *          the right type (li for ul and a for div) valid html markup!.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Shortcodes_BsListGroup
extends VTCore_Wordpress_Models_Shortcodes
implements VTCore_Wordpress_Interfaces_Shortcodes {


  public function buildObject() {

    $this->object = new VTCore_Bootstrap_Element_BsListGroup($this->atts);
    $this->object->addChildren(do_shortcode($this->content));

  }
}