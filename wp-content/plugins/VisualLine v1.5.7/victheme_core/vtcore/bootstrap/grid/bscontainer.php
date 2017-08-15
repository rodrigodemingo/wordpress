<?php
/**
 * Class for building the Bootstrap Grid Container element.
 *
 * This is just for creating a div wrapper with class container
 * as bootstrap requires for proper grid
 *
 * @author jason.xie@victheme.com
 * @method BsContainer($context)
 */
class VTCore_Bootstrap_Grid_BsContainer
extends VTCore_Bootstrap_Grid_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'container',
      ),
    ),
  );
}