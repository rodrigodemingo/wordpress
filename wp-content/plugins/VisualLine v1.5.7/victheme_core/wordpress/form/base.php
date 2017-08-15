<?php
/**
 * Wordpress related form base
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_Base
extends VTCore_Form_Base {

  protected $overloaderPrefix = array(
    'VTCore_Wordpress_Form_',
    'VTCore_Wordpress_',
    'VTCore_Fontawesome_',
    'VTCore_Fontawesome_Form_',
    'VTCore_Bootstrap_Form_',
    'VTCore_Bootstrap_Element_',
    'VTCore_Bootstrap_Grid_',
    'VTCore_Form_',
    'VTCore_Html_',
  );

  /**
   * Constructing the object and processing
   * the context array
   */
  public function __construct($context = array()) {
    $this->buildObject($context);
    $this->buildElement();

    // Processing Grids
    if ($this->getContext('grids')) {
      $grids = new VTCore_Bootstrap_Grid_Column($this->getContext('grids'));
      $this->addClass($grids->getClass());
    }
  }

}