<?php
/**
 * VTCore API Ajax Factory Abstract Base
 *
 * This is the base AJAX framework for VTCore router gateway.
 * It will only handles the routing from AJAX callback made with
 * wp-ajax assets, route the data to the correct class and return
 * the processed data back to ajax script.
 *
 * Valid input data must be a $_POST with these array
 *
 *   data   - The main data to be passed to the routed object,
 *            the data type can be anything that the routed object
 *            understands
 *
 *   object - The object class name, this will be used to invoke the
 *            routed object.
 *
 *   nonce  - the Wordpress Nonce value, must be paired with the
 *            exact string as the routing class (admin or anon).
 *
 *
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Wordpress_Ajax_Anon
 * @see VTCore_Wordpress_Ajax_Admin
 * @see VTCore_Wordpress_Actions_Wp__Ajax__VTCore__Ajax__Framework
 * @see VTCore_Wordpress_Actions_Wp__Ajax__Nopriv__VTCore__Ajax__Framework
 *
 *
 * @todo hash the object array for better security
 *
 */
abstract class VTCore_Wordpress_Models_Router {

  private $processors = array(
    'hs' => 'VTCore_Wordpress_Ajax_Processor_HS',
    'loop' => 'VTCore_Wordpress_Ajax_Processor_WpLoop',
    'accordion' => 'VTCore_Wordpress_Ajax_Processor_WpAccordion',
    'carousel' => 'VTCore_Wordpress_Ajax_Processor_WpCarousel',
    'icon' => 'VTCore_Wordpress_Ajax_Processor_WpIcon',
    'updater' => 'VTCore_Wordpress_Ajax_Processor_WpUpdater',
    'pdf' => 'VTCore_Wordpress_Ajax_Processor_WpPDF',
  );

  /**
   * Process the post data into this (or child) object
   */
  public function processData() {
    $this->post = $_POST;
    $this->processors = apply_filters('vtcore_wordpress_ajax_processor', $this->processors);

    if (isset($this->processors[$this->post['object']])) {
      $this->post['object'] = $this->processors[$this->post['object']];
    }

    return $this;
  }



  /**
   * Check if we got valid input data
   */
  public function checkValidity() {

    if (!isset($this->post['object'])
        || !isset($this->post['data'])
        || !class_exists($this->post['object'], true)) {

      die(__('Invalid request', 'victheme_core'));

    }

    return $this;

  }



  /**
   * Check if user has permission to do ajax
   * This is designed to be overridden in the child class
   */
  abstract function checkPermission();




  /**
   * Process and return the results
   */
  public function render() {
    $this->convertPost();
    $this->object = new $this->post['object']();

    die(' <---JSON-STARTS---->' . json_encode($this->object->renderAjax($this->post)));
  }




  /**
   * Convert the jquery.param() back to php array.
   */
  public function convertPost() {
    $this->post['data'] = VTCore_Wordpress_Utility::wpParseLargeArgs($this->post['data']);
  }

}