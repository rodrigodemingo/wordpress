<?php
/**
 * Class for building the bubbleline inner content.
 *
 * @author jason.xie@victheme.com
 * @method BubbleLineItem($context)
 */
class VTCore_BubbleLine_Element_BubbleLineItem
extends VTCore_Bootstrap_Grid_BsColumn {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'bubbleline-content',
      ),
    ),
    'bubble' => array(
      'date' => '',
      'text' => '',
      'color' => '',
      'size' => '',
      'style' => '',
      'text_color' => '',
    ),
    'dot' => array(
      'color' => '',
      'border_color' => '',
    ),
    'line' => array(
      'color' => '',
      'width' => '',
      'type' => '',
    ),
    'bubble_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'bubbleline-bubble',
        ),
      ),
      'raw' => true,
    ),
    'text' => array(
      'color' => '',
    ),
    'connector_element' => array(
      'type' => 'div',
      'data' => array(
        'connector-line' => true,
      ),
      'attributes' => array(
        'class' => array(
          'bubbleline-item-connector',
        ),
      ),
      'raw' => true,
    ),
    'date_element' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'bubbleline-date',
        ),
      ),
      'raw' => true,
    ),
  );

  public function buildElement() {

    if ($this->getContext('link')) {
      $this
        ->addContext('bubble_element.type', 'a')
        ->addContext('bubble_element.attributes.href', $this->getContext('link'));
    }

    $this
      ->addContext('attributes.class.size', 'bubble-size-' . $this->getContext('bubble.size'))
      ->addContext('attributes.class.style', 'bubble-style-' . $this->getContext('bubble.style'))
      ->addAttributes($this->getContext('attributes'))
      ->addData('line', $this->getContext('line'))
      ->addContext('date_element.text', $this->getContext('bubble.date'))
      ->addContext('date_element.styles.color', $this->getContext('text.color'))
      ->addContext('connector_element.styles.border-color', $this->getContext('dot.border_color'))
      ->addContext('connector_element.styles.background', $this->getContext('dot.color'))
      ->addContext('bubble_element.text', $this->getContext('bubble.text'))
      ->addContext('bubble_element.attributes.class.style', 'bubble-style-' . $this->getContext('bubble.style'))
      ->addContext('bubble_element.styles.background-color', $this->getContext('bubble.color'))
      ->addContext('bubble_element.styles.border-color', $this->getContext('bubble.color'))
      ->addContext('bubble_element.styles.color', $this->getContext('bubble.text_color'))
      ->addChildren(new VTCore_Html_Element($this->getContext('bubble_element')))
      ->addChildren(new VTCore_Html_Element($this->getContext('connector_element')))
      ->addChildren(new VTCore_Html_Element($this->getContext('date_element')));

  }

}