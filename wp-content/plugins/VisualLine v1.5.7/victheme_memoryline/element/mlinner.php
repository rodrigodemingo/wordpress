<?php
/**
 * Class for building the memoryline inner content.
 *
 * @author jason.xie@victheme.com
 * @method HsInner($context)
 */
class VTCore_MemoryLine_Element_MlInner
extends VTCore_Bootstrap_Grid_BsColumn {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'memoryline-content',
      ),
    ),
    'data' => array(
      'dot-direction' => '',
      'dot-radius' => '',
      'dot-color' => '',
      'dot-offset-x' => '',
      'dot-offset-y' => '',
      'line-color' => '',
      'line-width' => '',
      'line-type' => '',
    ),
    'title_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'memoryline-title',
        ),
      ),
      'raw' => true,
      'grids' => array(
        'columns' => array(
          'mobile' => 12,
          'tablet' => 4,
          'small' => 4,
          'large' => 4,
        ),
      ),
    ),
    'text_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'memoryline-text',
        ),
      ),
      'raw' => true,
      'grids' => array(
        'columns' => array(
          'mobile' => 12,
          'tablet' => 8,
          'small' => 8,
          'large' => 8,
        ),
      ),
    ),
    'grids' => array(
      'columns' => array(
        'mobile' => 12,
        'tablet' => 4,
        'small' => 4,
        'large' => 4,
      ),
    ),
  );


  protected $content;
  private $grids;

  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    $this->grids = new VTCore_Bootstrap_Grid_Column($this->getContext('grids'));
    $this->addClass($this->getGrid()->getClass());

    $this
      ->BsElement($this->getContext('title_element'))
      ->BsElement($this->getContext('text_element'));
  }

  public function getGrid() {
    return $this->grids;
  }

}