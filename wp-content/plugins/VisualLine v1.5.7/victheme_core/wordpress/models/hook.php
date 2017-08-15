<?php
/**
 * Basic models for all the Filters and Actions
 * sub classes system.
 *
 * @see VTCore_Wordpress_Factory_Actions
 * @see VTCore_Worpdress_Factory_Filters
 * @author jason.xie@victheme.com
 *
 */
abstract class VTCore_Wordpress_Models_Hook {


  /**
   * The argument number as specified
   * in Wordpress Filters and Actions
   * @var integer
   */
  protected $argument = 1;


  /**
   * The weight or ordering number as
   * specified in Wordpress Filters
   * and Actions
   * @var integer
   */
  protected $weight = 10;


  /**
   * Abstract method for child class to
   * extend, place all the logic for
   * processing the hook here.
   *
   * This method can accept arguments
   * and the number of arguments must be
   * the same as the $argument property.
   *
   * Due to PHP limitation, all arguments
   * must use NULL as the default value.
   */
  abstract public function hook();


  /**
   * Method for retrieving the number of
   * registered argument
   */
  public function getArgument() {
    return $this->argument;
  }


  /**
   * Method for retrieving the registered
   * weight for this object.
   */
  public function getWeight() {
    return $this->weight;
  }
}