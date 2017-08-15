<?php
/**
 * Class for managing VTCore Assets libraries
 * Centralizing the assets record so other plugin
 * can just load the asset by folder name.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Assets {

   private static $libraries = array();
   private static $assetPath = '';
   private static $assetURL = '';

   private static $CSSQueues = array(
     'admin' => array(),
     'front' => array(),
     'footer' => array(),
   );


   private static $JSQueues = array(
     'admin' => array(),
     'front' => array(),
     'footer' => array(),
   );



   /**
    * Constructs and detect the VTCore Assets
    */
   public function __construct() {
     self::$assetPath = VTCore_Init::getCorePath() . DIRECTORY_SEPARATOR . 'assets';
     self::$assetURL = VTCore_Init::getCoreURL() . '/assets';
     $this->detectAssets(self::$assetPath, self::$assetURL);
   }



   /**
    * Search and detect asset files based on specified path
    * @param string $path
    */
   public function detectAssets($path, $base) {
     $files = new RecursiveDirectoryIterator($path);
     foreach (new RecursiveIteratorIterator($files) as $directory) {

       // Compatibility with 5.2
       if (method_exists($directory, 'getExtension')) {
         $ext = $directory->getExtension();
       }
       else {
         $ext = pathinfo($directory->getFilename(), PATHINFO_EXTENSION);
       }

       if (in_array($ext, array('css', 'js'))) {
         $this->addLibrary($files->getSubPathname(), $ext, $directory->getFilename(), $base, $directory->getPath());
       }
     }
   }




   /**
    * Register assets to library
    * @param string $name   Asset machine name
    * @param string $type   Asset type
    * @param string $file   Asset file path
    */
   public function addLibrary($name, $type, $file, $baseUrl, $basePath) {
     self::$libraries[$name][$type][] = $file;
     self::$libraries[$name]['base'] = $baseUrl;
     self::$libraries[$name]['path'] = dirname($basePath);
   }





   /**
    * Retrieving all registered libraries
    */
   public function getRegisteredLibraries() {
     return self::$libraries;
   }



   public function getLibrary($name) {
     return isset(self::$libraries[$name]) ? self::$libraries[$name] : false;
   }




   /**
    * Remove asset from library
    */
   public function removeLibrary($name) {
     if (isset(self::$libraries[$name])) {
       unset(self::$libraries[$name]);
     }
   }


   /**
    * Get css queued object
    */
   public function getQueues($location, $type) {
     if ($type == 'css') {
       return self::$CSSQueues[$location];
     }

     if ($type == 'js') {
       return self::$JSQueues[$location];
     }
   }



   /**
    * Add to queues
    */
   public function addQueue($location, $type, $file, $data) {
     if ($type == 'css') {
       self::$CSSQueues[$location][$file] = $data;
     }

     if ($type == 'js') {
       self::$JSQueues[$location][$file] = $data;
     }
   }
}