<?php
/**
 * Class for managing VTCore Assets libraries
 * Centralizing the assets record so other plugin
 * can just load the asset by folder name.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Factory_Fonts
implements VTCore_Wordpress_Interfaces_Factory {

  protected $googleFonts;
  protected $methods = array();

  public function __construct() {

    // Check if we should bypass caching
    $this->maybeByPassCache();

    $this->loadCache();

    if (empty($this->googleFonts)) {
      $this->googleFonts = new VTCore_Wordpress_Data_Google_Fonts();
      set_transient('vtcore_google_fonts_cache', $this->googleFonts, VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);
    }

    $this->methods = get_class_methods('VTCore_Wordpress_Data_Google_Fonts');

    return $this;
  }


  public function __call($method, $context) {
    if (in_array($method, $this->methods)) {
      return call_user_func_array(array($this->googleFonts, $method), $context);
    }
  }



   /**
    * Method for checking if we should bypass cache
    * @return VTCore_Wordpress_Factory_Assets
    */
   public function maybeByPassCache() {

     if (defined('VTCORE_CLEAR_CACHE') && VTCORE_CLEAR_CACHE) {
       $this->clearCache();
     }

     return $this;
   }



   /**
    * Load compressed asset from cache
    * @return VTCore_Wordpress_Objects_Assets_Loader
    */
   public function loadCache() {
     // @bugfix APC prematurely loading cached object
     if (class_exists('VTCore_Wordpress_Data_Google_Fonts') && !function_exists('apc_add')) {
       $this->googleFonts = get_transient('vtcore_google_fonts_cache');
     }
     return $this;
   }



   /**
    * Removing all compressed assets
    */
   public function clearCache() {
     delete_transient('vtcore_google_fonts_cache');
     return $this;
   }

}