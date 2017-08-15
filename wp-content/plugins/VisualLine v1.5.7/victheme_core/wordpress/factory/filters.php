<?php
/**
 * Class for encapsulating all Wordpress
 * filter action in one place.
 *
 * The filter class should follow the
 * Autoloader naming convention and
 * extend the VTCore_Wordpress_Base class
 *
 * @see VTCore_Wordpress_Models_Hooks
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Factory_Filters
extends VTCore_Wordpress_Models_Hooks {

  protected $registry = array(
    'wp_generate_attachment_metadata',
    'delete_attachment',
    'icl_wpml_config_array',
    'vc_wpb_getimagesize',
    'template_include',
    'is_protected_meta',
  );


  protected $overloaderPrefix = array(
    'VTCore_Wordpress_Filters_'
  );


  protected $loaded = array();
  protected $hookFunction = 'add_filter';

}