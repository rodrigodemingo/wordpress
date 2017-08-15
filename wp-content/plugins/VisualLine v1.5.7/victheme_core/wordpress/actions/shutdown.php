<?php
/**
 * Action wp_footer for VTCore_Wordpress
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Shutdown
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 999;

  public function hook() {

    $object = new VTCore_Wordpress_Objects_Cache();
    $object->cacheCoreClasses();

    if (defined('VTCORE_CLEAR_CACHE') && VTCORE_CLEAR_CACHE) {
      VTCore_Wordpress_Init::factoriesClearCache();
      delete_transient('vtcore_autoloader_maps');
      VTCore_Autoloader::resetMapCache();
    }

    set_transient('vtcore_autoloader_maps', VTCore_Autoloader::getMapCache(), VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);
  }

}