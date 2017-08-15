<?php
/**
 * Build bootstrap media object
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Element_BsMediaObject
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'pull' => 'left',
    'img' => false, // insert image object or image context per VTCore_Html_Image() requirement
    'contents' => array(),

    'attributes' => array(
      'class' => array('media')
    ),

    'body_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('media-body'),
      ),
    ),

    'heading_elements' => array(
      'type' => 'h4',
      'attributes' => array(
        'class' => array('media-heading'),
      ),
    ),
  );


  protected $contents;


  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('img')) {
      if (is_object($this->getContext('img'))) {
        $this->addChildren($this->getContext('img'));
      }

      if (is_array($this->getContext('img'))) {
        $this->addChildren(new VTCore_Html_Image($this->getContext('img')));
      }

      $this
        ->lastChild()
        ->addClass('pull-' . $this->getContext('pull'))
        ->addClass('media-object');
    }


    $this->contents = $this
      ->addChildren(new VTCore_Html_Element($this->getContext('body_elements')))
      ->lastChild();

    $this->setChildrenPointer('contents');

    if ($this->getContext('text')) {
      $this->contents
        ->addChildren(new VTCore_Html_Element($this->getContext('heading_elements')))
        ->lastChild()
        ->addChildren($this->getContext('text'));
    }

    if ($this->getContext('contents')) {
      foreach ($this->getContext('contents') as $content) {
        $this->addChildren($content);
      }
    }

  }

}