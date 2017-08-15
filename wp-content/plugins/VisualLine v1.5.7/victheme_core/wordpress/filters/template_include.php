<?php
/**
 * Class for filtering template from template_include filter
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Filters_Template__Include
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 10;

  public function hook($template = NULL) {

    // Load custom template
    // @see hook action WP
    if (is_singular() && defined('VTCORE_WORDPRESS_CUSTOM_TEMPLATE_FILE')) {

      $library = VTCore_Wordpress_Init::getFactory('template')->get(VTCORE_WORDPRESS_CUSTOM_TEMPLATE_FILE);

      if (is_object($library) && property_exists($library, 'default') && @file_exists($library->default)) {
        $template = VTCore_Wordpress_Init::getFactory('template')->locate($library->default);
      }
    }

    return $template;
  }
}