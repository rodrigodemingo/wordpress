<?php
/**
 * Simple class for plugin or theme to use
 * when overloading the updater factory.
 *
 * When extending the register method,
 * define the plugin in the options
 * array as the main key for the map array
 * stored by vtcore.
 *
 * When creating the object define an array
 * with version as the key and the target
 * version as the value.
 *
 * for the actuall updating login, add a method
 * in the extending object with update_{version}
 * as the method name.
 *
 * @see VTCore_Wordpress_Factory_Updater
 * Class VTCore_Wordpress_Models_Updater
 */
abstract class VTCore_Wordpress_Models_Updater
extends VTCore_Wordpress_Models_Dot {

  /**
   * Method for executing the updating process
   * this method will search for update_{version}
   * method in the extending object.
   * @return bool
   */
  final public function execute($method) {

    $result = false;

    // Do the updating if we got valid method
    // to invoke the updating process
    if (method_exists($this, $method)) {
      $result = $this->$method();
    }

    return $result;
  }

}