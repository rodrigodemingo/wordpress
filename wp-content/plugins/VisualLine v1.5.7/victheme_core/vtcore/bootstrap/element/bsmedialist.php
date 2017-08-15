<?php
/**
 * Build bootstrap media list object
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Element_BsMediaList
extends VTCore_Html_List {

  protected $context = array(
    'type' => 'ul',
    'contents' => array(), // Must be array of BsMediaObject contexes
    'attributes' => array(
      'class' => array('media-list')
    ),
  );


  /**
   * Overriding parent method
   * @see VTCore_Html_List::addContent()
   */
  public function addContent($data) {

    $this->addChildren(new VTCore_Bootstrap_Element_BsMediaObject($data));
    $this->lastChild()->setType('li');

    return $this;
  }


  /**
   * Overriding parent method
   * @see VTCore_Html_List::prependContent()
   */
  public function prependContent($object) {
    $this->prependChild($this->prepareContent($data));

    return $this;
  }

}