<?php
/**
 * Model class for creating a class that
 * contains multiple factory and use dotted
 * notation to fetch, add and destroy registered
 * factory.
 *
 * @author jason.xie@victheme.com
 *
 */
abstract class VTCore_Wordpress_Models_Factories {

  /**
   * Variable for storing the factories
   * staticly
   * @var array|\VTCore_Wordpress_Objects_Array
   */
  static protected $factories;

  public function __construct() {

    if (empty(self::$factories)) {
      self::$factories = new VTCore_Wordpress_Objects_Array();
    }

    $this->register();
  }


  /**
   * Register the factories in this method
   * @return mixed
   */
  abstract function register();


  /**
   * Allow user to inject Factory Dynamically
   * @param $name
   * @param $object
   */
  public static function setFactory($name, $object) {
    if (is_object($object)) {
      self::$factories->add($name, $object);
    }
  }


  /**
   * Retrieves stored factory singleton object.
   * @param string $type the factory type
   * @return stored factory object.
   */
  public static function getFactory($type) {
    return self::$factories->get($type);
  }


  /**
   * Get all available factories
   */
  public static function getFactories() {
    return self::$factories->extract();
  }


  /**
   * Get the factory collection object.
   * @return array|\VTCore_Wordpress_Objects_Array
   */
  public static function getObject() {
    return self::$factories;
  }


  /**
   * Clear all factory caches
   */
  public static function factoriesClearCache() {
    foreach (self::getFactories() as $factory) {
      if ($factory instanceof VTCore_Wordpress_Interfaces_Factory) {
        $factory->clearCache();
      }
    }
  }
}