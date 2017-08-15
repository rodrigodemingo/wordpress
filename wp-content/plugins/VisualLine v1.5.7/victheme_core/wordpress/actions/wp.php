<?php
/**
 * Class for hooking to WP action
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Actions_Wp
extends VTCore_Wordpress_Models_Hook {

  public function hook() {

    // Define the custom template file
    // @see VTCore_Zeus_Template_Factory
    if (!defined('VTCORE_WORDPRESS_CUSTOM_TEMPLATE_FILE')) {
      global $wp_query;

      if (isset($wp_query->post) && isset($wp_query->post->ID)) {
        define('VTCORE_WORDPRESS_CUSTOM_TEMPLATE_FILE', get_post_meta($wp_query->post->ID, 'vtcore_wordpress_custom_template', true));
      }
      else {
        define('VTCORE_WORDPRESS_CUSTOM_TEMPLATE_FILE', 'none');
      }
    }
  }
}