<?php
/**
 * Extending Html base class for handling the
 * bootstrap Grid Structure
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Bootstrap_Grid_Base
extends VTCore_Html_Base {

  protected $overloaderPrefix = array(
    'VTCore_Bootstrap_Grid_',
    'VTCore_Bootstrap_Element_',
    'VTCore_Bootstrap_Form_',
    'VTCore_Form_',
    'VTCore_Html_',
  );
}