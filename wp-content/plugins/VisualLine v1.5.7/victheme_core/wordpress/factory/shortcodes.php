<?php
/**
 * Factory class for registering all VTCore related
 * shortcodes into wordpress.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Factory_Shortcodes
extends VTCore_Wordpress_Models_Config
implements VTCore_Wordpress_Interfaces_Factory {

  protected $database = 'vtcore_registered_shortcode';
  protected $filter = 'vtcore_register_shortcode';

  /**
   * Private vars for statically storing
   * available subclasses
   * @performance this is for autoloader perfomance improvement only.
   */
  private static $classes = array();


  /**
   * Registering shortcodes to WordPress
   */
  protected function register(array $options) {

    $this->options = array(
      'bsalert' => 'VTCore_Wordpress_Shortcodes_BsAlert',
      'bsbadge' => 'VTCore_Wordpress_Shortcodes_BsBadge',
      'bsbutton' => 'VTCore_Wordpress_Shortcodes_BsButton',
      'bscolumn' => 'VTCore_Wordpress_Shortcodes_BsColumn',
      'bsglyphicon' => 'VTCore_Wordpress_Shortcodes_BsGlyphicon',
      'bsheader' => 'VTCore_Wordpress_Shortcodes_BsHeader',
      'bsjumbotron' => 'VTCore_Wordpress_Shortcodes_BsJumbotron',
      'bslabel' => 'VTCore_Wordpress_Shortcodes_BsLabel',
      'bslistgroup' => 'VTCore_Wordpress_Shortcodes_BsListGroup',
      'bslistobject' => 'VTCore_Wordpress_Shortcodes_BsListObject',
      'bsmedialist' => 'VTCore_Wordpress_Shortcodes_BsMediaList',
      'bsmediaobject' => 'VTCore_Wordpress_Shortcodes_BsMediaObject',
      'bspanel' => 'VTCore_Wordpress_Shortcodes_BsPanel',
      'bsrow' => 'VTCore_Wordpress_Shortcodes_BsRow',
      'bswell' => 'VTCore_Wordpress_Shortcodes_BsWell',
      'fontawesome' => 'VTCore_Wordpress_Shortcodes_Fontawesome',
      'wpimage' => 'VTCore_Wordpress_Shortcodes_WpImage',
    );

    // Merge the user supplied options
    $this->merge($options);
  }

  /**
   * Registering shortcodes to wordpress
   */
  public function initialize() {
    foreach ($this->options as $shortcode => $class) {
      // Old way
      if (is_numeric($shortcode)) {
        add_shortcode($class, array($this, ucfirst($class)), 10, 2);
      }

      // New faster way
      else {
        add_shortcode($shortcode, array($this, $class . 'xxxdirectxxx'), 10, 2);
      }
    }
  }

  /**
   * Overloading method that is declared on child subclass
   * but not in this main class
   */
  public function __call($method, $context) {

    // Check if we should bypass cache
    $this->maybeByPassCache();

    // Load cache
    $this->loadCache();
    if (isset(self::$classes[$method]) || strpos($method, 'xxxdirectxxx') !== false) {
      $name = str_replace('xxxdirectxxx', '', $method);
      self::$classes[$method] = true;
    }

    else {

      $overloader = $this->getOverloader();
      $count = count($overloader);

      for ($s=0; $s < $count; $s++) {
        $prefix = $overloader[$s];
        $class = $prefix . $method;

        if (isset(self::$classes[$class])) {

          if (self::$classes[$class]) {
            $name = $class;
            break;
          }
          else {
            continue;
          }
          break;
        }
        elseif (class_exists($class, TRUE)) {
          $name = $class;
          self::$classes[$class] = TRUE;
          break;
        }
        else {
          self::$classes[$class] = FALSE;
        }
      }
    }

    if (isset($name)) {
      $object = new $name($context[0], $context[1], $method);
      $object->buildObject();
    }
    else {
      throw new Exception('Error Class VTCore_Wordpress_Shortcodes_' . $method . ' does\'t exists');
    }

    set_transient('vtcore_shortcode_class_map', self::$classes, VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);

    return $object->getMarkup();
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
    self::$classes = get_transient('vtcore_shortcode_class_map');
    return $this;
  }


  /**
   * Method for clearing cached elements
   * @return VTCore_Wordpress_Factory_Layout
   */
  public function clearCache() {
    delete_transient('vtcore_shortcode_class_map');
    return $this;
  }




  /**
   * Retrieving registered overloader class
   *
   * @todo remove the filter once the registration process is automated via spl observer
   */
  private function getOverloader() {

    // @hook allow other class to register custom overloader prefix
    //       for shortcode class use.
    return apply_filters('vtcore_register_shortcode_prefix', array(
      'VTCore_Wordpress_Shortcodes_'
    ));
  }

}