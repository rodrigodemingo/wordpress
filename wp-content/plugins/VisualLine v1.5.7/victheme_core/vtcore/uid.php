<?php
/**
 *
 * Class for building unique id
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Uid {

  public static $uid = 0;
  private $time = 0;
  private $decimals = 0;
  private $converter = 1;



  /**
   * Construct and increase the id
   */
  public function __construct() {
    if (self::$uid == 0) {
      $this->setID();
    }
  }




  /**
   * Build first time unique id based on microtime
   */
  private function setID() {
    $this->time = microtime(true);
    $this->decimals = strlen(substr(strrchr($this->time, "."), 1));

    for ($i=0; $i < $this->decimals; $i++) {
      $this->converter = $this->converter * 10;
    }

    self::$uid = $this->time * $this->converter;

    // Seems user server doesn't support microtime try using time
    if (self::$uid == 0) {
      self::$uid = time();
    }

    // user server doesn't support time or microtime use plain number instead
    if (self::$uid == 0) {
      self::$uid = 1;
    }
  }




  /**
   * Retrieve current unique id
   */
  public function getID() {
    return self::$uid++;
  }


}
