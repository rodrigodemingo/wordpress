<?php
/**
 * Class for building the snakeline inner content.
 *
 * @author jason.xie@victheme.com
 * @method SnakeLineItem($context)
 */
class VTCore_SnakeLine_Element_SnakeLineItem
extends VTCore_Bootstrap_Grid_BsColumn {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'snakeline-content',
      ),
    ),
    'date' => array(
      'text' => '',
      'color' => '',
    ),
    'content' => array(
      'text' => '',
      'color' => '',
    ),
    'dot' => array(
      'color' => '#ffffff',
      'background' => '#1E477B',
      'link' => '',
      'text' => '',
    ),
    'dot_element' => array(
      'type' => 'div',
      'data' => array(
        'snakeline-dot' => true,
      ),
      'attributes' => array(
        'class' => array(
          'snakeline-dot',
        ),
      ),
      'raw' => true,
    ),
    'content_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'snakeline-text',
        ),
      ),
      'raw' => true,
    ),
    'date_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'snakeline-date',
        ),
      ),
      'raw' => true,
    ),
    'wrapper_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'snakeline-wrapper',
        ),
      ),
    ),
  );

  public function buildElement() {

    if ($this->getContext('dot.link')) {
      $this
        ->addContext('dot_element.type', 'a')
        ->addContext('dot_element.attributes.href', $this->getContext('dot.link'));
    }

    $this
      ->addAttributes($this->getContext('attributes'))

      ->addContext('date_element.text', $this->getContext('date.text'))
      ->addContext('date_element.styles.color', $this->getContext('date.color'))

      ->addContext('content_element.text', $this->getContext('content.text'))
      ->addContext('content_element.styles.color', $this->getContext('content.color'))

      ->addContext('dot_element.text', $this->getContext('dot.text'))
      ->addContext('dot_element.styles.color', $this->getContext('dot.color'))
      ->addContext('dot_element.styles.background-color', $this->getContext('dot.background'))


      ->addChildren(new VTCore_Html_Element($this->getContext('wrapper_element')))
      ->lastChild()
      ->addChildren(new VTCore_Html_Element($this->getContext('date_element')))
      ->addChildren(new VTCore_Html_Element($this->getContext('content_element')))
      ->getParent()
      ->addChildren(new VTCore_Html_Element($this->getContext('dot_element')));

  }

}