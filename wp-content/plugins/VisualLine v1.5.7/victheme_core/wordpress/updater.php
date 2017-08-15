<?php
/**
 * Updating VisualPlus
 *
 * @see VTCore_Wordpress_Factory_Updater
 * Class VTCore_Wordpress_Models_Updater
 */
class VTCore_Wordpress_Updater
extends VTCore_Wordpress_Models_Updater {

  protected function update_1_7_5() {

    global $wpdb;

    // Migrate the old zeus custom template meta entry
    if (get_theme_support('vtcore_custom_template')) {
      $results = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = 'vtcore_wordpress_custom_template'"));
      if (empty($results)) {
        $wpdb->query($wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_key=%s WHERE meta_key=%s", array('vtcore_wordpress_custom_template', 'vtcore_zeus_custom_template')));
      }
    }

    return true;
  }
}