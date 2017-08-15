<?php
/**
 * Hooking into Visual Composer Backend Editor
 * before it got initialized
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Actions_Vc__Backend__Editor__Enqueue__Js__Css
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 30;

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('wp-visualcomposer');
  }
}