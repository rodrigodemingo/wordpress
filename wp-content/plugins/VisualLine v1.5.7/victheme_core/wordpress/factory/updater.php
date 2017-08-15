<?php
/**
 * Class for encapsulating updater factory
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Factory_Updater
extends VTCore_Wordpress_Models_Config {

  protected $database = 'vtcore_updater_map';
  protected $filter = false;
  protected $current = '';
  protected $options = array();

  /**
   * Overloading parent method.
   * @param array $options
   * @return void|VTCore_Wordpress_Config_Base
   */
  protected function register(array $options) {
    $this->options = array(
      'status' => array(),
      'registry' => array(),
    );
    // debug
    // $this->delete();
    $this->load();

  }


  /**
   * Method for checking if we need to update
   * @return bool
   */
  public function checkUpdateNeeded() {

    $needUpdate = false;
    foreach ($this->options['registry'] as $plugin => $data) {
      foreach ($data['updates'] as $version => $text) {
        if (!$this->get('status.' . $plugin . '.' . $version)) {
          $needUpdate = TRUE;
          break;
        }
      }

      if ($needUpdate) {
        break;
      }
    }
    return $needUpdate;
  }




  /**
   * Helper function for doing mass update against registered updates
   * @return $this
   */
  public function doMassUpdate() {
    $success = 0;
    $count = 0;
    if ($this->checkUpdateNeeded()) {
      foreach ($this->options['registry'] as $plugin => $data) {
        foreach ($data['updates'] as $version => $text) {
          if (!$this->get('status.' . $plugin . '.' . $version)) {
            set_time_limit(3600);
            $count++;
            if ($this->doUpdate($plugin, $version)) {
              $success++;
            }
          }
        }
      }
    }

    $result = $count;
    if ($count === $success) {
      $result = true;
    }
    else {
      $result = false;
    }

    return $result;
  }



  /**
   * Helper method for easy calling a single update
   * @param $plugin
   * @param $version
   * @return $this
   */
  public function doUpdate($plugin, $version) {
    $result = false;
    $object = $this->get('registry.' . $plugin . '.object');
    if (!empty($object) && !empty($plugin) && !empty($version)) {
      $result = $this->execute(array(
        'plugin' => $plugin,
        'object' => $object,
        'version' => $version,
      ));
    }

    return $result;
  }



  /**
   * Method for overloading the object and invoke
   * the plugin updater.
   *
   * @param VTCore_Wordpress_Models_Updater $object
   */
  public function execute(array $plugin) {

    $result = false;

    if (!isset($plugin['version'])
      || !isset($plugin['plugin'])
      || !isset($plugin['object'])) {
      return $result;
    }

    $plugin['version'] = $this->sanitizeVersion($plugin['version']);
    $this->current = 'status.' . $plugin['plugin'] . '.' . $plugin['version'];

    if ($this->get($this->current) == false) {

      // @performance loading object will invoke disk access
      // Avoid it as much as possible.
      if (class_exists($plugin['object'])) {

        $object = new $plugin['object']();
        $result = $object->execute($plugin['version']);

        if ($result === true) {
          // Mark update is performed
          $this->add($this->current, TRUE);
          $this->save();
        }

        unset($object);
        $object = NULL;
      }
    }

    return $result;

  }



  /**
   * Sanitizing method name as per PHP class method name
   * @param $method
   * @return mixed
   */
  final protected function sanitizeVersion($method) {
    return str_replace(array('.'), array('_'), $method);
  }

}