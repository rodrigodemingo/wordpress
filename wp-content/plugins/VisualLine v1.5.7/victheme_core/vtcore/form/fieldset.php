<?php
/**
 * Helper Class for building the Fieldset Form Elements
 *
 * @todo refactor this to use the latest technique
 * @author jason.xie@victheme.com
 * @see VTCore_Html_Form interface
 */
class VTCore_Form_Fieldset
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'text' => '',
    'type' => 'fieldset',
    'collapsible' => false,
    'attributes' => array(
      'id' => false,
      'class' => array(),
    ),
    'contents' => array(),
    'content_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('fieldset-content'),
      ),
    ),
    'legend_elements' => array(),
  );

  private $content = array();



  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('collapsible')) {
      $this->addClass('collapsible');
    }

    $this
      ->addChildren(new VTCore_Form_Legend($this->getContext('legend_elements')))
      ->firstChild()
      ->addText($this->getContext('text'));

    $this->content = $this->addChildren(new VTCore_Html_Element($this->getContext('content_attributes')))->lastChild();
    $this->setChildrenPointer('content');

    foreach ($this->getContext('contents') as $object) {
      $this->addChildren($object);
    }
  }
}