<?php
/**
 * Models for creating factory for hookable
 * system.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Models_Hooks
implements VTCore_Wordpress_Interfaces_Factory {


  protected $classes = array();
  protected $registry = array();
  protected $overloaderPrefix = array();
  protected $loaded = array();
  protected $hookFunction;
  protected $updateCache = false;
  protected $classMap = array();
  protected $activePrefix = false;
  protected $activeHookBlock = array();

  protected $hooks = array();


  /**
   * Construct method
   */
  public function __construct() {

    // Check if we should bypass cache
    $this->maybeByPassCache();

    // Load cache
    $this->loadCache();

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
    $this->classes = get_transient('vtcore_hook_classes_registry_' . $this->hookFunction);
    $this->classMap = get_transient('vtcore_autoloader_maps');
    return $this;
  }


  /**
   * Method for setting up class cache
   * @return $this
   */
  public function setCache() {
    set_transient('vtcore_hook_classes_registry_' . $this->hookFunction, $this->classes, VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);
    return $this;
  }


  /**
   * Method for clearing cached elements
   * @return VTCore_Wordpress_Factory_Layout
   */
  public function clearCache() {
    delete_transient('vtcore_hook_classes_registry_' . $this->hookFunction);
    return $this;
  }


  /**
   * Use VTCore Stored PHP class map to determine if the
   * class string is a valid class
   *
   * @param $class
   * @return bool
   */
  public function maybeMapped($class) {
    return ((array) $this->classMap === $this->classMap && isset($this->classMap[$class]));
  }


  /**
   * Register the hook into registry
   * @param bool $resetActivePrefix
   */
  public function register($resetActivePrefix = true) {

    if (!empty($this->activePrefix)) {
      $this->registerFromActiveBlock();
    }

    else {
      $this->detectAndRegister();
    }

    if ($resetActivePrefix == true) {
      $this->activePrefix = false;
      $this->activeHookBlock = array();
    }

  }

  /**
   * Method for registering hook from activePrefix and activeBlock
   * instead of looping for all possible match.
   *
   * This can only works if either :
   *    - User register the prefix with $setActive = true
   *    - User register the hooks immediatelly
   *    - User invoke the register() imeediatelly
   *
   */
  protected function registerFromActiveBlock() {

    $this->updateCache = false;

    foreach ($this->activeHookBlock as $registered) {

      $name = $this->activePrefix . str_replace(array('_','-'), array('__', '__'), ucfirst($registered));
      $found = isset($this->classes[$name]) ? $this->classes[$name] : false;

      if (empty($found)) {

        if (class_exists($name, true)) {
          $object = new $name;
          $found = array(
            'hook' => $registered,
            'class' => $name,
            'weight' => $object->getWeight(),
            'argument' => $object->getArgument(),
          );
        }
        else {
          $this->classes[$name] = false;
        }

        $this->updateCache = true;
      }

      if ($found) {
        $this->classes[$name] = $found;
        $this->updateCache = true;
        $this->registerHook($found);
      }
    }

    if ($this->updateCache) {
      $this->setCache();
    }

    return $this;
  }

  /**
   * Method for detecting the correct class per prefix + hook name
   *
   * This is slow and will only be fired if user didnt define
   * active prefix when registering the prefix and / or via setActivePrefix();
   *
   */
  protected function detectAndRegister() {
    foreach ($this->registry as $registered) {
      foreach ($this->overloaderPrefix as $prefix) {

        // Stop too much looping early
        $class = $prefix . str_replace(array('_','-'), array('__', '__'), ucfirst($registered));

        $name = '';

        // Dont bother to proceed, cache already mark this class to non-existant
        if (isset($this->classes[$class])
            && $this->classes[$class] == false) {
          continue;
        }

        if (isset($this->classes[$class])) {
          if ($this->classes[$class]) {
            $name = $class;
          }
        }
        elseif ($this->maybeMapped($class)) {
          $name = $class;

          $object = new $name;
          $this->classes[$class] = array(
            'hook' => $registered,
            'class' => $name,
            'weight' => $object->getWeight(),
            'argument' => $object->getArgument(),
          );

          $this->updateCache = true;
        }
        else {

          if (class_exists($class)) {
            $name = $class;

            $object = new $name;
            $this->classes[$class] = array(
              'hook' => $registered,
              'class' => $name,
              'weight' => $object->getWeight(),
              'argument' => $object->getArgument(),
            );

          }
          else {
            $this->classes[$class] = false;
          }

          $this->updateCache = true;
        }

        // Prevent double loading
        if (empty($name)) {
          continue;
        }

        // Dont double load
        if (isset($this->loaded[$name])) {
          continue;
        }

        // Register the hook
        if (!empty($this->classes[$class])) {
          $this->registerHook($this->classes[$class]);
        }

      }
    }

    if ($this->updateCache) {
      $this->setCache();
    }

    return $this;
  }


  /**
   * Magic method, this object will call the magic
   * class name as method, we redirect them to the
   * correct class here.
   *
   * @param $class
   * @param $args
   * @return mixed|string
   */
  public function __call($class, $args) {

    $loaded = $this->getLoaded($class);
    $value = '';

    if (isset($args[1])) {
      $value = $args[1];
    }

    if ($loaded) {
      if (!isset($loaded['object'])) {
        $object = new $loaded['class'];
        $this->loaded[$class]['object'] = $object;
      }
      else {
        $object = $loaded['object'];
      }
      $value = call_user_func_array(array($object, 'hook'), $args);
    }

    return $value;
  }


  /**
   * Logic for promise the hook
   * @param $name
   * @param $registered
   * @return $this
   */
  protected function registerHook($arguments) {

    if (isset($arguments['class'])
        && isset($arguments['hook'])
        && isset($arguments['weight'])
        && isset($arguments['argument'])) {

      $function = $this->hookFunction;
      $function($arguments['hook'], array(
        $this,
        $arguments['class']
      ), $arguments['weight'], $arguments['argument']);

      $this->addLoaded($arguments['class'], $arguments);
    }

    return $this;
  }


  /**
   * Method for checking if the action is already
   * loaded into Wordpress or not.
   */
  public function checkLoaded($name) {
    return isset($this->loaded[$name]);
  }



  /**
   * Method for adding action class name
   * into loaded array database
   */
  protected function addLoaded($name, array $context) {
    if (!isset($this->loaded[$name])) {
      $this->loaded[$name] = $context;
    }

    return $this;
  }


  protected function getLoaded($name) {
    return isset($this->loaded[$name]) ? $this->loaded[$name] : false;
  }

  /**
   * Method for adding a new action into the
   * action array database.
   */
  public function addHook($hook) {

    if (!in_array($hook, $this->registry)) {
      $this->registry[] = $hook;
    }

    if (!empty($this->activePrefix)) {
      $this->activeHookBlock[] = $hook;
    }

    return $this;
  }


  /**
   * Registering multiple actions at once
   */
  public function addHooks(array $hooks) {
    $this->registry = array_merge($this->registry, $hooks);
    if (!empty($this->activePrefix)) {
      $this->activeHookBlock = $hooks;
    }
    return $this;
  }


  /**
   * Method for removing action
   * This method must be invoked after register()
   * and valid child action class name must be
   * passed as the argument
   *
   * @param string $name
   */
  public function removeHook($name) {
    if (isset($this->loaded[$name])) {

      $hook = $weight = $hash = $argument = '';
      extract($this->loaded[$name]);

      if (isset($GLOBALS['wp_filter'][$hook][$weight][$hash])) {
        unset($GLOBALS['wp_filter'][$hook][$weight][$hash]);

        if (empty($GLOBALS['wp_filter'][$hook][$weight])) {
          unset($GLOBALS['wp_filter'][$hook][$weight]);
        }

        if (empty($GLOBALS['wp_filter'][$hook])) {
          $GLOBALS['wp_filter'][$hook] = array();
        }

        unset($GLOBALS['merged_filters'][$hook]);
      }
    }

    return $this;
  }


  /**
   * Method for adding a new class prefix so
   * the autoloader can pickup and invoke the
   * class when this class is trying to add
   * the action into wordpress
   *
   * @performance
   * Use setActive = false to just register the prefix
   * without setting them to active, if after addPrefix
   * you invoke register() immediatelly use setActive = true
   * to minimize recursion and performance lost.
   */
  public function addPrefix($prefix, $setActive = true) {
    if (!in_array($prefix, $this->overloaderPrefix)) {
      $this->overloaderPrefix[] = $prefix;
    }

    if ($setActive) {
      $this->activePrefix = $prefix;
    }
    return $this;
  }
}