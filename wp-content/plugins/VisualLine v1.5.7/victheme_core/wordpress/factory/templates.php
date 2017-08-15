<?php
/**
 * Main class for other sub plugin to use for registering
 * their own plugin templates, the template registered
 * will be registered to WordPress so when it
 *
 * This factory will be initialized from the VTCore_Wordpress_Init
 * and treated as a singleton to manage all the template registry.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Factory_Templates
implements VTCore_Wordpress_Interfaces_Factory {

  /**
   * Variables for holding the registered
   * template files
   */
  protected $templates = array();


  /**
   * Property for registering template folders
   * to scan for.
   */
  protected $folders = array();


  static $weight = 0;

  public function __construct() {
    // Check if we should bypass cache
    $this->maybeByPassCache();

    // Load cache
    $this->loadCache();
  }


  /**
   * Register a path folder to scan for
   * @param string $folder
   * @return VTCore_Wordpress_Factory_Templates
   */
  public function register($folder, $prefix) {

    if (!isset($this->folders[$folder])) {
      self::$weight++;
      $this->folders[$folder]['prefix'] = $prefix;
      $this->folders[$folder]['weight'] = self::$weight;
    }

    return $this;
  }


  /**
   * Remove a path from folder registration system
   * @param string $folder
   * @return VTCore_Wordpress_Factory_Templates
   */
  public function deregister($folder) {
    if (isset($this->folders[$folder])) {
      unset($this->folders[$folder]);
    }

    return $this;
  }


  /**
   * Scanning the registered folder and register
   * each files found to the template system
   *
   * This is pooled this way to implement caching
   * system and avoid the expensive disk search.
   */
  public function detect() {

    $this->sort();

    foreach ($this->folders as $path => $data) {

      if (isset($data['loaded'])) {
        continue;
      }

      $Directory = new RecursiveDirectoryIterator($path);
      $Iterator = new RecursiveIteratorIterator($Directory);

      foreach ($Iterator as $entry) {

        if ($entry->getBasename() == '.'
            && $entry->getBasename() == '..') {
          continue;
        }

        // Compatibility with 5.2
        if (method_exists($entry, 'getExtension')) {
          $ext = $entry->getExtension();
        }
        else {
          $ext = pathinfo($entry->getFilename(), PATHINFO_EXTENSION);
        }

        if ($ext == 'php') {
          $this->add($entry->getBasename(), array(
            'prefix' => $data['prefix'],
            'default' => $entry->getRealPath(),
          ));
        }
      }

      $this->folders[$path]['loaded'] = true;

      // Cache the scanned results
      set_transient('vtcore_template_folders_map', $this->folders, VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);
      set_transient('vtcore_template_map', $this->templates, VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);

    }

    return $this;
  }



  /**
   * Register a template information to centralized registration
   * @param $key String must match the template basename
   * @param array $context
   *   prefix => prefix to include in the path when searching for template file
   *   default => the default fallback full path if nothing else is found
   *   path => the path to scan the files
   */
  public function add($key, $context) {
    $this->templates[$key] = (object) $context;
  }



  /**
   * Remove template from registry
   */
  public function remove($key) {
    if (isset($this->templates[$key])) {
      unset($this->templates[$key]);
    }
  }




  /**
   * Retrieving stored template registry
   */
  public function get($key) {
    return isset($this->templates[$key]) ? $this->templates[$key] : false;
  }





  /**
   * Filtering the template path
   */
  public function locate($template) {

    if ($register = $this->get(basename($template))) {

      // Cached if already processed just
      // return the cached value
      if (property_exists($register, 'found')) {
        $template = $register->result;
      }

      // Search for the first time
      else {
        $template = $register->default;

        if ($themefile = locate_template(basename($template), false)) {
          $template = $themefile;
        }

        if (isset($register->prefix) && $themefile = locate_template($register->prefix . DIRECTORY_SEPARATOR . basename($template), false)) {
          $template = $themefile;
        }

        // Store to memory for caching
        $register->found = true;
        $register->result = $template;

        set_transient('vtcore_template_map', $this->templates, VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);

      }
    }

    return $template;
  }



  /**
   * Method for checking if class should bypass cache
   * @return VTCore_Wordpress_Factory_Layout
   */
  public function maybeByPassCache() {
    // Wordpress on debug mode
    if ((defined('WP_DEBUG') && WP_DEBUG)
        || (defined('VTCORE_CLEAR_CACHE') && VTCORE_CLEAR_CACHE)) {

      $this->clearCache();
    }

    return $this;
  }


  /**
   * Method for loading from cache
   * @return VTCore_Wordpress_Factory_Layout
   */
  public function loadCache() {
    $this->templates = get_transient('vtcore_template_map');

    if (!empty($this->templates)) {
      $this->folders = get_transient('vtcore_template_folders_map');
    }

    return $this;
  }


  /**
   * Method for clearing cached elements
   * @return VTCore_Wordpress_Factory_Layout
   */
  public function clearCache() {
    delete_transient('vtcore_template_map');
    delete_transient('vtcore_template_folders_map');

    return $this;
  }

  /**
   * Method for sorting
   * @return $this
   */
  public function sort() {
    uasort($this->folders, array($this, 'sortByWeight'));
    return $this;
  }


  /**
   * Method for comparing field weight
   * via uasort();
   * @param $a
   * @param $b
   * @return boolean
   */
  public function sortByWeight($a, $b) {
    return $a['weight'] > $b['weight'];
  }



  /**
   * Extract all available templates
   */
  public function getTemplates() {
    return $this->templates;
  }

}