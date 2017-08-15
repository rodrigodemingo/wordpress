<?php
/**
 * Class for hooking into is_protected_meta
 * to disallow certain metakey to be modified
 * via custom fields metabox directly
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Filters_Is__Protected__Meta
extends VTCore_Wordpress_Models_Hook {

  protected $weight = 10;
  protected $argument = 3;

  public function hook($protected = NULL, $meta_key = NULL, $meta_type = NULL) {

    // Protect all meta started with vtcore_ prefix
    if (strpos($meta_key,'vtcore_') !== false) {
      $protected = true;
    }

    return $protected;

  }
}