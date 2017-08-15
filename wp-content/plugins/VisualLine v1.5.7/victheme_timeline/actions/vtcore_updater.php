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
class VTCore_Timeline_Actions_VTCore__Updater
extends VTCore_Wordpress_Models_Hook {

  public function hook($updater = NULL) {

    // Perform updates
    $updater
      ->execute(array(
        'version' => VTCORE_TIMELINE_VERSION,
        'object' => 'VTCore_Timeline_Updater',
        'plugin' => 'victheme_timeline',
      ));

  }
}