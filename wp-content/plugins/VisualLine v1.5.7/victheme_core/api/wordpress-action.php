<?php
/**
 * This is an example where we can use the
 * VTCore_Wordpress_Actions system to register
 * actions to wordpress in clean and easy way.
 */


/**
 * Step one :
 * Register the actions hooks into VTCore, this is
 * recommended to be performed inside a class
 * that is invoked before anything else or init class
 */

class Example_Init {
  private $actions = array(
    'init',
    'admin_init',
  );

  /**
   * We register the actions in the construct method
   * in this example but this is not mandatory, you can
   * invoke the registration action anywhere you see fit.
   */
  public function __construct() {

    // Hooking into VTCore_Wordpress_Init via static
    // method to register the global registration for
    // actions hook registry.
    VTCore_Wordpress_Init::getFactory('actions')

      // Define the class name prefix, this is recommended
      // to use VTCore_Autoloader class name conventions
      // but basically this is just to tell VTCore how to
      // load the class related to actions.
      ->addPrefix('Example_Actions_')

      // Add the array of actions name into the global action
      // registration registry.
      ->addHooks($this->actions)

      // Tell VTCore to perform the registration to WordPress.
      ->register();
  }
}



/**
 * Step Two:
 *
 * Create the corresponding class to act on each actions.
 * in this example we define 2 actions :
 * 1. init
 * 2. admin_init.
 *
 * With prefix of Example_Actions_
 *
 * then VTCore will look and attempt to autoload these classes :
 *
 * 1. Example_Actions_Init
 * 2. Example_Actions_Admin__Init // notice the double underscore
 *
 */

class Example_Actions_Init
extends VTCore_Wordpress_Models_Hook {

  protected $argument = 1; // Tell VTCore How many arguments should the action handle
  protected $weight = 10; // Tell VTCore what is the weight of this action

  /**
   * The method that will be called upon action invocation
   * note the $args is not mandatory to have but if you define it, it must have
   * null or array() or anything as the default value to avoid PHP throwing error.
   *
   * @see VTCore_Wordpress_Models_Hook::action()
   */
  public function hook($args1 = NULL, $args2 = null) {
    // do some php function that will be invoked on Wordpress Action Init invocation.
  }

}

class Example_Actions_Admin__Init
extends VTCore_Wordpress_Models_Hook {

  protected $argument = 1; // Tell VTCore How many arguments should the action handle
  protected $weight = 10; // Tell VTCore what is the weight of this action

  /**
   * The method that will be called upon action invocation
   * note the $args is not mandatory to have but if you define it, it must have
   * null or array() or anything as the default value to avoid PHP throwing error.
   *
   * @see VTCore_Wordpress_Models_Hook::action()
   */
  public function hook($args1 = NULL, $args2 = null) {
    // do some php function that will be invoked on Wordpress Action Init invocation.
  }

}

