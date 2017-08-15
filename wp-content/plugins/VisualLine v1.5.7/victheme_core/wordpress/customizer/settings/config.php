<?php
/**
 * Extending Wordpress Customizer Settings for acting
 * as a bridge between the VTCore_Wordpress_Models_Config
 * sub classes and Wordpress Customizer Settings.
 *
 * This class expect user to overload the class with
 * a VTCore_Wordpress_Models_Config instance and sub
 * instances.
 *
 *
 * Class VTCore_Wordpress_Customizer_Settings_Config
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Customizer_Settings_Config
extends WP_Customize_Setting {

  /**
   * Inject the overloader here.
   * To inject the overloader, define
   * it via the constructor args array under
   * config key.
   *
   * @var VTCore_Wordpress_Models_Config
   */
  public $VTCoreConfig;


  /**
   * Inject a filter for value method result.
   * To inject the filter, define it via
   * the constructor args array under the
   * filter key.
   *
   * @var string
   */
  public $VTCoreFilter = false;


  /**
   * Inject the dotted notation for use with
   * VTCore_Wordpress_Models_Config.
   * @var bool
   */
  public $VTCoreKeys = false;

  /**
   * Overloading parent method.
   * @param WP_Customize_Manager $manager
   * @param string $id
   * @param array $args
   */
  public function __construct($manager, $id, $args = array()) {

    parent::__construct($manager, $id, $args);

    if (isset($args['configKey'])) {
      $this->VTCoreKeys = $args['configKey'];
    }

    if (isset($args['config']) && $args['config'] instanceof VTCore_Wordpress_Models_Config) {
      $this->VTCoreConfig = $args['config'];
    }

    if (isset($args['filter'])) {
      $this->VTCoreFilter = $args['filter'];
    }

    if (is_object($this->VTCoreConfig) && $this->VTCoreKeys) {
      $this->default = $this->VTCoreConfig($this->VTCoreKeys);
    }

    return $this;
  }

  /**
   * Overloading Parent method
   * @return mixed The value.
   */
  public function value() {

    // Use overloaded Object
    if (is_object($this->VTCoreConfig) && $this->VTCoreKeys) {
      $value = $this->VTCoreConfig->get($this->VTCoreConfig);
    }

    // Fallback to default parent method
    else {
      $value = parent::value();
    }

    switch ($this->VTCoreFilter) {
      case 'boolean' :
        $value = (boolean) $value;
        break;

      case 'string' :
        $value = (string) $value;
        break;

      case 'int' :
        $value = (int) $value;
        break;

      case 'array' :
        $value = (array) $value;
        break;
    }

    return $value;


  }

}