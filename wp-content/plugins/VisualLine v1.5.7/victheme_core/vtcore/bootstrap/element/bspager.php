<?php
/**
 * Helper class for building bootstrap pager
 * element.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Element_BsPager
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'div',
    'attributes' => array(
      'class' => array('pagination')
    ),

    'ul_elements' => array(
      'type' => 'ul',
      'contents' => array(),
      'attributes' => array(),

      'list_elements' => array(
        'type' => 'li',
        'attributes' => array(),
      ),
    ),
  );

  protected $content;

  public function addContent($object) {
    $this->content->addContent($object);
  }

  public function prependContent($object) {
    $this->content->prependContent($object);
  }

  public function buildElement() {
    parent::buildElement();
    $this->content = $this->addChildren(new VTCore_Html_List($this->getContext('ul_elements')))->lastChild();
  }
}