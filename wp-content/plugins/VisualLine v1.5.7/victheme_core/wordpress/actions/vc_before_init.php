<?php
/**
 * Hooking into Visual Composer Before init
 * before it got initialized
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Actions_Vc__Before__Init
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 30;

  public function hook() {

    // Booting the visual composer factory
    // This is expensive!, only load when we are truly
    // on vc edit mode, normal view mode doesn't need this
    // as normal WP shortcode will handle it.
    if (VTCore_Wordpress_Init::getFactory('visualcomposer')
      && VTCore_Wordpress_Init::getFactory('visualcomposer')->isVCEditor()) {

      VTCore_Wordpress_Init::getFactory('visualcomposer')
        ->register()
        ->processShortcodes()
        ->registerExtraForm();

    }

  }
}