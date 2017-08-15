<?php
/**
 * Class for hooking into WPML
 * icl_wpml_config_array filter to
 * register custom options registered
 * via VTCore_Wordpress_Factory_WPML class
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Filters_Icl__Wpml__Config__Array
extends VTCore_Wordpress_Models_Hook {


  public function hook($config_all = NULL) {

    $options = VTCore_Wordpress_Init::getFactory('wpml')->render();

    if (!empty($options)
        && isset($options['wpml-config'])
        && isset($options['wpml-config']['admin-texts'])
        && isset($options['wpml-config']['admin-texts']['key'])) {

      foreach ($options['wpml-config']['admin-texts']['key'] as $data) {
        $config_all['wpml-config']['admin-texts']['key'][] = $data;
      }
    }

    return $config_all;
  }
}