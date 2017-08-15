<?php
/**
 * Helper class for building the timeline major elements
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Timeline_Element_Major
extends VTCore_Timeline_Models_Event {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'classtype' => 'major',
    'direction' => 'center',
    'attributes' => array(
      'class' => array(
        'timeline-major'
      ),
    ),
  );

  protected $content;

  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    $this->content = $this
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('timeline-major-wrapper'),
        ),
      )))
      ->lastChild();

    $this->content->setText($this->getContext('text'));
    $this->setChildrenPointer('content');

  }
}