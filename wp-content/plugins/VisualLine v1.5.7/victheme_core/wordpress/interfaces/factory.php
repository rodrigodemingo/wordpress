<?php
/**
 * Class to act as the main interface
 * for the VTCore_Wordpress_Factory_**
 *
 * All factory must use this interface
 * and implement all the interface methods.
 */
interface VTCore_Wordpress_Interfaces_Factory {


  /**
   * Method for bypassing cache
   */
  public function maybeByPassCache();

  /**
   * Method for implementing sub class
   * loading cache logic
   */
  public function loadCache();


  /**
   * Method for implementing sub class
   * clearing cache logic
   */
  public function clearCache();

}