<?php
/**
 * Class for building the centerline inner content.
 *
 * @author jason.xie@victheme.com
 * @method HsInner($context)
 */
class VTCore_CenterLine_Element_ClInner
extends VTCore_Bootstrap_Grid_BsColumn {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'centerline-content',
      ),
    ),
    'data' => array(
      'circle-start' => 3,
      'circle-end' => 4,
      'circle-opaque' => 10,
      'circle-opacity' => 0.6,
      'line-color' => '#158FBF',
      'line-width' => 1,
      'line-type' => 'round',
      'dot-color' => '#158FBF',
      'position-start' => 'center',
      'position-end' => 'top',
      'offset-control-x' => 0,
      'offset-control-y' => 100,
      'offset-start-x' => 0,
      'offset-start-y' => 0,
      'offset-end-x' => 0,
      'offset-end-y' => 0,
    ),
    'grids' => array(
      'columns' => array(
        'mobile' => 4,
        'tablet' => 4,
        'small' => 4,
        'large' => 4,
      ),
    ),
  );


  protected $content;
  private $grids;

  public function buildElement() {

    $this->grids = new VTCore_Bootstrap_Grid_Column($this->getContext('grids'));
    $this->addClass($this->getGrid()->getClass());
    $this->addClass('centerline-wrapper');

    $this->content = $this->BsElement(array(
        'type' => 'div',
        'data' => $this->getContext('data'),
      ))
      ->lastChild();

    $this->cleanDatas();
    $this->removeContext('data');
    $this->content->addAttributes($this->getContext('attributes'));

    $this->setChildrenPointer('content');
  }

  public function getGrid() {
    return $this->grids;
  }

}