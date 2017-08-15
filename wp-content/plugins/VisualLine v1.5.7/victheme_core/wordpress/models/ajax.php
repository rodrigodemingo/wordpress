<?php
/**
 * Ajax helper models for handling the VTCore ajax
 * processing.
 *
 * This is related to the VTCore AJAX API and wp-ajax.js
 *
 * @author jason.xie@victheme.com
 */
abstract class VTCore_Wordpress_Models_Ajax {

  protected $post;
  protected $render = array();


  /**
   * Ajax callback method
   */
  public function renderAjax($post) {
    $this->post = $post;
    $this->processAjax();
    return $this->render;
  }

  /**
   * Ajax callback function
   * Subclass must extend this
   */
  abstract protected function processAjax();


  /**
   * Get private property
   */
  public function get($type) {
    return isset($this->{$type}) ? $this->{$type} : false;
  }



  /**
   * Set private property
   */
  public function set($type, $value) {
    $this->{$type} = $value;
    return $this;
  }



  /**
   * Delete private property
   */
  public function delete($type) {
    if (isset($this->{$type})) {
      unset($this->{$type});
    }

    return $this;
  }



  /**
   * Add render action to the object
   */
  public function addRender($key, $render) {
    $this->render[$key][] = $render;
    return $render;
  }



  /**
   * Remove render action from the object
   */
  public function removeRender($delta) {
    if (isset($this->render[$delta])) {
      unset($this->render[$delta]);
    }

    return $this;
  }


  /**
   * Replacing a render with x delta with new value
   */
  public function replaceRender($delta, $value) {
    if (isset($this->render[$delta])) {
      $this->render[$delta] = $value;
    }

    return $this;
  }


  /**
   * Retrieving a single delta value
   */
  public function getRender($delta) {
    return isset($this->render[$delta]) ? $this->render[$delta] : false;
  }


  /**
   * Retrieving all render actions.
   */
  public function extractRender() {
    return $this->render;
  }
}