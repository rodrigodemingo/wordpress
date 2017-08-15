<?php
/**
 * Hooking into Visual Composer Front Editor
 * for loading admin script
 *
 * @author jason.xie@victheme.com
 */
class VTCore_BubbleLine_Actions_Vc__Frontend__Editor__Enqueue__Js__Css
  extends VTCore_Wordpress_Models_Hook {

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('jquery-bubbleline');
    VTCore_Wordpress_Utility::loadAsset('bubbleline-admin');
    VTCore_Wordpress_Utility::loadAsset('bubbleline-front');
  }
}