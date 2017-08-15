<?php
/**
 * Simple object class for linking to
 * VTCore and caching its objects.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Objects_Cache
extends VTCore_Html_Base {

  public function cacheCoreClasses() {
    set_transient('vtcore_core_classes_registry', self::$vtcore_classes, VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);
  }

  public function clearCoreClasses() {
    delete_transient('vtcore_core_classes_registry');
  }

  public function loadCoreClasses() {

    if ((defined('WP_DEBUG') && WP_DEBUG)
        || (defined('VTCORE_CLEAR_CACHE') && VTCORE_CLEAR_CACHE)) {

      $this->clearCoreClasses();
    }

    self::$vtcore_classes = get_transient('vtcore_core_classes_registry');
  }

}