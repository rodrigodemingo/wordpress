<?php
/**
 * Class for managing asset library information
 * This class will auto cache the library information
 * array to database to save performance.
 *
 * To clear the cache please invoke the delete() method
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Objects_Library
extends VTCore_Wordpress_Models_Config {

  protected $options = array();
  protected $database = '';
  protected $filter = '';

  private $hash;
  private $ssl;
  private $allowed = array();


  protected function register(array $options) {
    $this->options = array(
      'cache' => array(),
    );

    $this->ssl = is_ssl();

    $this->load();
  }


  /**
   * Method for iterating to user specified folders
   * and scan for proper asset files.
   *
   * This method respect caching system to avoid
   * expensive directory iterators multiple time

   * @return VTCore_Wordpress_Objects_Library
   */
  public function detect($path, $base, $override = false, $map = false) {

    // Let browser detect the protocol
    // @bugfix is_ssl() is not reliable to detect ssl
    $base = preg_replace('#^\w+://#', '//', $base);

    $this->hash = md5($path . $base);

    if (!$this->get('cache.' . $this->hash) || (defined('WP_DEBUG') && WP_DEBUG) || (defined('VTCORE_CLEAR_CACHE') && VTCORE_CLEAR_CACHE)) {

      // Load from map
      if (!empty($map)) {
        $mapObject = new $map();
        $mapArray = $mapObject->extract();
        foreach ($mapArray as $key => $assets) {
          foreach ($assets as $type => $data) {
            foreach ($data as $id => $location) {
              $this->add($key . '.' . $type . '.' . $id, array(
                'url' => $base . '/' . $location['url'],
                'path' => $path . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,  $location['path']),
              ));
            }
          }
        }
      }

      // Do expensive searching
      else {
        $directories = new RecursiveDirectoryIterator($path);

        foreach (new RecursiveIteratorIterator($directories) as $file) {

          $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
          $libName = $directories->getSubPathname();

          if (!empty($override)) {
            $libName = $override;
          }

          if (in_array($ext, $this->allowed)) {

            $this->add($libName . '.' . $ext . '.' . pathinfo(str_replace(array('.', '#'), '-', $file->getFilename()), PATHINFO_FILENAME), array(
              'url' => $base . '/' . $directories->getSubPathname() . '/' . $ext . '/' . $file->getFilename(),
              'path' => $path . DIRECTORY_SEPARATOR . $directories->getSubPathName() . DIRECTORY_SEPARATOR . $ext . DIRECTORY_SEPARATOR . $file->getFilename(),
            ));
          }
        }
      }

      $this->add('cache.' . $this->hash, true);

      $this->save();
    }

    return $this;
  }




  /**
   * Allow user to change the trapped file extension
   */
  public function allowed($allowed) {
    $this->allowed = (array) $allowed;
    return $this;
  }




  /**
   * Allow user to change the database name for caching the result
   */
  public function database($database) {
    $this->database = $database;
    return $this;
  }

}