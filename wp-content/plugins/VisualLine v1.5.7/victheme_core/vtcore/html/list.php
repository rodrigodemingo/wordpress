<?php
/**
 * Build a standard list HTML element
 *
 * It can be ul or ol list elements depending on the passed
 * context set by user.
 *
 * For adding element that is wrapped by li element user
 * must invoke the addContent() or prependContent() method
 * instead of using the addChildren() base method.
 *
 * If user wanted to add custom li element that is outside
 * the original list element set by context when the class
 * is initiated, they must use the addChildren() base method
 * with separately built object containing the li element
 * and its childrens.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_List
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'ul',
    'contents' => array(),
    'attributes' => array(),

    'list_elements' => array(
      'type' => 'li',
      'attributes' => array(),
    ),
  );


  public function addContent($object) {
    $li = new VTCore_Html_Element($this->getContext('list_elements'));
    $li->addChildren($object);

    if ($li->getType() !== false) {
      $li->setType('li');
    }

    $this->addChildren($li);
    unset($li);
    return $this;
  }

  public function prependContent($object) {
    $li = new VTCore_Html_Base($this->getContext('list_elements'));
    $li->addChildren($object);
    if ($li->getType() !== false) {
      $li->setType('li');
    }
    $this->prependChild($li);
    unset($li);
    return $this;
  }

  public function buildElement() {
    parent::buildElement();
    foreach ($this->getContext('contents') as $object) {
      $this->addContent($object);
    }
  }
}