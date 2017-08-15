<?php
/**
 * Base class for standard configuration
 * management that can be used as the base
 * for sub-plugin configuration array management
 *
 * @author jason.xie@victheme.com
 *
 */
abstract class VTCore_Wordpress_Models_Config
extends VTCore_Wordpress_Models_Dot {

  protected $database;
  protected $filter;
  protected $action = 'config_object_';
  protected $loadFunction = 'get_option';
  protected $saveFunction = 'update_option';
  protected $deleteFunction = 'delete_option';


  /**
   * Main Construct method.
   * Overriding parent method.
   * @param array $options
   */
  public function __construct($options = array()) {
    $this->register($options);
    $this->sanitizer = new $this->sanitizerClass();
  }



  /**
   * Child class must extend this method
   * to register their object information
   *
   * @param array $options
   * @return VTCore_Wordpress_Config_Base
   */
  protected function register(array $options) {

    // Define the database name
    $this->database = '';

    // Set the default options
    $this->options = array();

    // Set the hookable filter name
    $this->filter = '';

    // Merge the user supplied options
    $this->merge($options);

    // Apply the hookable filter
    $this->filter();

    // Inject from database
    $this->load();

    // Invoke action hook
    $this->action('register');

    return $this;
  }


  /**
   * Load array from database and merge it to the stored
   * array.
   *
   * @return $this
   */
  public function load() {
    if ($this->database) {
      $function = $this->loadFunction;
      $results = $function($this->database, array());
      if (!empty($results)) {
        $this->merge($results);
      }

      $this->action('load');
    }
    return $this;
  }


  /**
   * Save the stored array to the database
   *
   * @return $this
   */
  public function save() {
    if ($this->database) {
      $function = $this->saveFunction;
      $function($this->database, $this->options);
      $this->action('save');
    }
    return $this;
  }


  /**
   * Delete the stored array in the database only.
   * Invoke the reset() too to completely remove the
   * stored array from the object.
   *
   * @return $this
   */
  public function delete() {
    if ($this->database) {
      $function = $this->deleteFunction;
      $function($this->database);
      $this->action('delete');
    }
    return $this;
  }


  /**
   * Invoke Wordpress Filter hook for this object
   *
   * @return $this
   */
  public function filter() {
    if ($this->filter) {
      $this->options = apply_filters($this->filter, $this->options);
    }
    return $this;
  }


  /**
   * Invoke Wordpress action filter for this object.
   */
  public function action($subkey = '') {
    if ($this->action) {
      do_action($this->action . $subkey, $this);
    }
    return $this;
  }

}