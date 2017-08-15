<?php
/**
 * Hooking into Wordpress added_option
 * action for performing core logic
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Added__Option
extends VTCore_Wordpress_Models_Hook {

  protected $argument = 2;

  public function hook($option = NULL, $value = NULL) {

    // WPML integration
    if (defined('ICL_SITEPRESS_VERSION')) {

      $object = VTCore_Wordpress_Init::getFactory('wpml');

      // Reset transient if option is updated
      if ($object instanceof VTCore_Wordpress_Factory_WPML) {
        if (VTCore_Wordpress_Init::getFactory('wpml')->check($option)) {
          VTCore_Wordpress_Init::getFactory('wpml')->clearCache();
        }
      }
    }

  }

}