<?php
/**
 * Hooking into Visual Composer Front Editor
 * for loading admin script
 *
 * @author jason.xie@victheme.com
 */
class VTCore_MemoryLine_Actions_Vc__Frontend__Editor__Enqueue__Js__Css
  extends VTCore_Wordpress_Models_Hook {

  public function hook() {
    VTCore_Wordpress_Utility::loadAsset('jquery-memoryline');
    VTCore_Wordpress_Utility::loadAsset('memoryline-admin');
    VTCore_Wordpress_Utility::loadAsset('memoryline-front');
  }
}