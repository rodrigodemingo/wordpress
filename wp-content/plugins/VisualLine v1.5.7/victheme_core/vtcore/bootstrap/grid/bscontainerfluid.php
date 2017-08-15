<?php
/**
 * Class for building the Bootstrap Fluid Grid Container element.
 *
 * This is just for creating a div wrapper with class container-fluid
 * as bootstrap requires for proper fluid grid
 *
 * @author jason.xie@victheme.com
 * @method BsContainerFluid($context)
 */
class VTCore_Bootstrap_Grid_BsContainerFluid
extends VTCore_Bootstrap_Grid_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'container-fluid',
      ),
    ),
  );

}