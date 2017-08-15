<?php
/**
 * Hooking into Visual Composer Front Editor
 * for loading admin script
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Actions_Vc__Frontend__Editor__Enqueue__Js__Css
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 30;

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('wp-visualcomposer-front');
    VTCore_Wordpress_Utility::loadAsset('wp-query');
  }
}