<?php
/**
 * Class for building the Bootstrap Grid Row element.
 *
 * This is just for creating a div wrapper with class row
 * as bootstrap requires for proper fluid grid
 *
 * @author jason.xie@victheme.com
 * @method BsRow($context)
 */
class VTCore_Bootstrap_Grid_BsRow
extends VTCore_Bootstrap_Grid_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'row',
      ),
    ),
  );
}