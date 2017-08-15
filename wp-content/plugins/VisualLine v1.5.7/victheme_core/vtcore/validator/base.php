<?php
/**
 * String validation main class
 * This class is not meant to be called directly
 * instead the subclasses must be called to perform
 * the text validation.
 *
 * Subclasses must extend the validateText method
 * for defining the validation logic.
 *
 * Use the $text property for the actual text
 * for validation and $error property for the
 * error text message.
 *
 * validateText method must return boolean true
 * or false to reflect the validation result.
 *
 * @author jason.xie@victheme.com
 */
abstract class VTCore_Validator_Base {

  private $text;
  private $error;


  /**
   * Construct method, define the validated
   * text in $text property and the error message in
   * the $error property.
   *
   * @param string $text
   * @param string $error
   */
  public function __construct($text = '', $error = 'Validation Error') {
    $this->setError($error);
    $this->setText($text);
  }


  /**
   * The method for the main validation logic,
   * subclass must extend this method, perform
   * the validation logic and return boolean to
   * reflect the validation result.
   */
  abstract public function validateText();



  /**
   * Method for retrieving the stored validation text
   */
  public function getText() {
    return $this->text;
  }


  /**
   * Method for injecting validation text
   * to private property
   *
   * @param string $text
   */
  public function setText($text) {
    $this->text = $text;
  }


  /**
   * Method for retriving validation error
   * message text stored in private property
   */
  public function getError() {
    return $this->error;
  }



  /**
   * Method for storing validation error text
   * message to private property
   *
   * @param string $text
   */
  public function setError($text) {
    $this->error = $text;
  }
}