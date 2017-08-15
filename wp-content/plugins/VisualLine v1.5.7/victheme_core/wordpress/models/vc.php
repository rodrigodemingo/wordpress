<?php
/**
 * Model class for registering custom shortcode
 * as a visual composer elements
 *
 * @author jason.xie@victheme.com
 *
 */
abstract class VTCore_Wordpress_Models_VC {


  abstract function registerVC();

  /**
   * Class main connector to the VC
   */
  public function connectVC() {
    return $this->registerVC();
  }

}