<?php
/**
 * Initialize the vtcore classes once for each projects.
 *
 * This class will determine if VTCore is initialized
 * or not and will load the first time it is called.
 *
 * The downfall is only the first VTCore instance found
 * will be used for all projects.
 *
 * Thus user and developer must ensure that all projects
 * has updated version of vtcore.
 *
 * To initialized the VTCore example :
 *
 * include_once(dirname(__FILE__) . '/vtcore/init.php');
 * $vtcore = new VTCore_Init();
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Init {

  private static $corePath;
  private static $coreURL;

  protected static $assetLoader;



  /**
   * Construct and register the main autoloader path
   */
  public function __construct($context = array()) {

    self::$corePath = dirname(__FILE__);

    if (isset($context['corePath'])) {
      $this->setCorePath($context['corePath']);
    }

    if (isset($context['coreURL'])) {
      $this->setCoreURL($context['coreURL']);
    }

    include_once(self::$corePath . DIRECTORY_SEPARATOR . 'autoloader.php');

    $core = new VTCore_Autoloader('VTCore', str_replace(DIRECTORY_SEPARATOR . 'vtcore', '',self::$corePath));

    // Inject class path maps for faster performance
    if (isset($context['classMap']) && is_array($context['classMap']) && !empty($context['classMap'])) {
      VTCore_Autoloader::setMapCache($context['classMap']);
    }

    $core->register();

    // Booting asset loader and make it available for subclass to use.
    if (isset($context['loadAsset']) && !empty($context['loadAsset'])) {
      self::$assetLoader = new VTCore_Assets();
    }
  }


  /**
   * Set the core path
   */
  public function setCorePath($path) {
    self::$corePath = $path;
  }



  /**
   * Set the core URL
   */
  public function setCoreURL($url) {
    self::$coreURL = $url;
  }




  /**
   * Retrieving core path
   */
  public static function getCorePath() {
    return self::$corePath;
  }




  /**
   * Retrieving core url
   */
  public static function getCoreURL() {
    return self::$coreURL;
  }



  /**
   * Register assets per path
   * @see VTCore_Assets()
   */
  public static function detectAssets($path, $base) {
    return self::getAssetObject()->detectAssets($path, $base);
  }


  public static function getAssetObject() {
    return self::$assetLoader;
  }
}