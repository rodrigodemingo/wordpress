<?php
/**
 * Class for hooking to VTCore Updater
 * This action will be called when user is
 * updating plugin.
 *
 * @see VTCore_Wordpress_Actions_Upgrader__Process__Complete
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_VTCore__Updater
extends VTCore_Wordpress_Models_Hook {

  public function hook($updater = NULL) {

    // Perform updates
    $updater
      ->execute(array(
        'version' => VTCORE_PLUGIN_VERSION,
        'object' => 'VTCore_Wordpress_Updater',
        'plugin' => 'victheme_core',
      ));

  }
}