<?php
/**
 * Singleton Class for processing GET data
 * and flatten the array into an array keyed
 * with form input name.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Form_Get
extends VTCore_Form_Post {

  private $post = array();
  private static $processedPost = array();
  private $iteratorPost = '';

  public function __construct() {
    $this->setPost($_GET);
    $this->setIterator();

    // @optimize Set this to run once no matter what
    if (empty(self::$processedPost)) {
      $this->processPost();
    }
  }
}