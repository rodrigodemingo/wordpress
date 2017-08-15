<?php
/**
 * Class for dynamically registering configuration
 * from wp-options table into WPML
 *
 * When calling this factory please make sure that
 * WPML is actually loaded, since this class will
 * not check if icl_xml2array exists or not.
 *
 * Victheme core will hook into updated_option action
 * hook for refreshing the transient when ever registered
 * options is updated.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Factory_WPML
implements VTCore_Wordpress_Interfaces_Factory {

  protected $options = array();
  protected $storage = array();
  protected $arrays = array();

  private $transient = 'vtcore_wmpl_integration';

  /**
   * Add configuration to WPML
   *
   * $key must be the name of the entry name as
   * specified in the get_option() function
   *
   * $option must follow WPML array structure :
   *
   * $option = array(
   *  'type' => 'plugin' or 'theme',
   *  'atid' => the plugin or theme base name,
   *  'default' => the default array value
   * );
   *
   * $allowed is optional, where you can specify
   * the only array key allowed for translation
   *
   *
   *
   * @param string $key
   * @param array $option
   * @return VTCore_Wordpress_Factory_WPML
   */
  public function add($key, array $option) {
    $this->options[$key] = $option;

    return $this;
  }




  /**
   * Deregister hook
   */
  public function remove($key) {
    if (isset($this->options[$key])) {
      unset($this->options[$key]);
    }

    return $this;
  }



  /**
   * Method for checking if option is
   * registered or not.
   */
  public function check($key) {
    return isset($this->options[$key]);
  }


  /**
   * Generating valid array for WPML
   * This method is expensive so always
   * use transient to store the data
   */
  public function render() {

    // Check if we should bypass cache
    $this->maybeByPassCache();

    // Load cache
    $this->loadCache();

    if (empty($this->storage)) {

      foreach ($this->options as $key => $option) {

        if (!isset($option['map'])) {
          continue;
        }

        $object = new VTCore_Html_Base(array(
          'type' => 'key',
          'attributes' => array(
            'name' => $key,
          ),
        ));

        $this->generateConfig($option['map'], $object);

        $mainobject = new VTCore_Html_Base(array(
          'type' => 'admin-texts',
        ));

        $mainobject->addChildren($object);

        $config = icl_xml2array('<wpml-config>' . $mainobject->__toString() . '</wpml-config>');

        $type = $option['type'];
        $atid = $option['atid'];

        if( !is_numeric(@key(@current($config['wpml-config']['admin-texts'])))){
          $config['wpml-config']['admin-texts']['key']['type'] = $type;
          $config['wpml-config']['admin-texts']['key']['atid'] = $atid;
          $this->storage['wpml-config']['admin-texts']['key'][] = $config['wpml-config']['admin-texts']['key'];
        }

        else{
          foreach($config['wpml-config']['admin-texts']['key'] as $cf){
            $cf['type'] = $type;
            $cf['atid'] = $atid;
            $this->storage['wpml-config']['admin-texts']['key'][] = $cf;
          }
        }

        unset($object);
        $object = NULL;

        unset($mainobject);
        $mainobject = NULL;
      }

      set_transient($this->transient, $this->storage, VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);
    }

    return $this->storage;

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
    $this->storage = get_transient($this->transient);
    return $this;
  }



  /**
   * Reset the stored transient, user may
   * need to recall the render function to
   * regenerate the WPML array again.
   */
  public function clearCache() {
    delete_transient($this->transient);
    return $this;
  }



  /**
   * Building valid XML using VTCore objects
   * This method results must be passed to icl_xml2array
   * function to ensure the validity of the wmpl
   * array structure.
   *
   * @param array $config
   * @param object $object
   * @return object
   */
  public function generateConfig(array $config, VTCore_Html_Base &$object) {

    foreach ($config as $key => $value) {

      $subobject = $object->Element(array(
        'type' => 'key',
        'attributes' => array(
          'name' => $key,
        ),
      ))
      ->lastChild();

      if (is_array($value)) {
        $this->generateConfig($value, $subobject);
      }
      else {
        $subobject->addSelfClosers('key');
      }

      unset($subobject);
      $subobject = NULL;
    }

    return $object;
  }
}