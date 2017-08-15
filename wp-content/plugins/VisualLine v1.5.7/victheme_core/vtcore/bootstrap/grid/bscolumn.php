<?php
/**
 * Class for building the Bootstrap Grid Column element.
 *
 * This is just for creating a div wrapper with class row
 * as bootstrap requires for proper fluid grid
 *
 * @author jason.xie@victheme.com
 * @method BsColumn($context)
 */
class VTCore_Bootstrap_Grid_BsColumn
extends VTCore_Bootstrap_Grid_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(),
    'grids' => array(),
  );


  private $grids;



  public function buildElement() {
    $this->setGrid($this->getContext('grids'));
    $this->addAttributes($this->getContext('attributes'));
    $this->addClass($this->getGrid()->getClass());
  }



  public function getGrid() {
    return $this->grids;
  }

  public function setGrid(array $grid) {
    $this->grids = new VTCore_Bootstrap_Grid_Column($grid);
    return $this;
  }
}