<?php
/**
 * Class for building the Bootstrap Modal element.
 *
 * To use this class properly, the main object should
 * be VTCore_Bootstrap_Form_Base or VTCore_Bootstrap_Form_Instance or
 * VTCore_Bootstrap_Element_Base
 *
 * Shotcut overloading method "BsModal($context)" will be available
 * for use if the parent object is either VTCore_Bootstrap_Form_Instance
 * or VTCore_Bootstrap_Form_Base or VTCore_Bootstrap_Element_Base.
 *
 * Use $contents array to add the panel content with valid Html
 * and its subclasses object.
 *
 * Any object that are added on afterwards via addChildren() will
 * be added after the panel-content wrapper
 *
 *
 * @author jason.xie@victheme.com
 * @method BsModal($context)
 */
class VTCore_Bootstrap_Element_BsModal
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'close' => true,
    'size' => false,
    'show' => false,

    'content' => false,
    'footer' => false,
    'attributes' => array(
      'tabindex' => '-1',
      'aria-hidden' => 'true',
      'class' => array(
        'modal',
      ),
    ),


    'header_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'modal-header',
        ),
      ),
    ),

    'title_elements' => array(
      'type' => 'h4',
      'attributes' => array(
        'class' => array(
          'modal-title',
        ),
      ),
    ),

    'content_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'modal-body',
        ),
      ),
    ),

    'footer_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'modal-footer',
        ),
      ),
    ),

    'close_elements' => array(
      'type' => 'button',
      'text' => '&times;',
      'raw' => true,
      'attributes' => array(
        'type' => 'button',
        'data-dismiss' => 'modal',
        'aria-hidden' => "true",
        'class' => array(
          'close'
        ),
      ),
    ),

  );

  protected $wrapper;
  protected $header;
  protected $content;
  protected $footer;


  public function addHeader($object) {
    $this->header->addChildren($object);
    return $this;
  }

  public function addContent($object) {
    $this->content->addChildren($object);
    return $this;
  }

  public function addFooter($object) {
    $this->footer->addChildren($object);
    return $this;
  }

  /**
   * Main Function for building the accordion element
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    $size = '';
    if ($this->getContext('size')) {
      $size = 'modal-' . $this->getContext('size');
    }

    if ($this->getContext('show')) {
      $this->addClass('in');
      $this->addClass('fade');
    }

    $this->wrapper = $this
      ->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('modal-dialog', $size),
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array('modal-content'),
        ),
      )))
      ->lastChild();


    $this->setChildrenPointer('wrapper');

    $this->header = $this
      ->addChildren(new VTCore_Bootstrap_Element_BsElement($this->getContext('header_elements')))
      ->lastChild();

    if ($this->getContext('close')) {
      $this->addHeader(new VTCore_Bootstrap_Element_BsElement($this->getContext('close_elements')));
    }

    if ($this->getContext('text')) {
      $text = new VTCore_Bootstrap_Element_BsElement($this->getContext('title_elements'));
      $text->addText($this->getContext('text'));
      $this->addHeader($text);
    }

    $this->content = $this
      ->addChildren(new VTCore_Bootstrap_Element_BsElement($this->getContext('content_elements')))
      ->lastChild();

    if ($this->getContext('content')) {
      $contents = (array) $this->getContext('content');
      foreach ($contents as $content) {
        $this->addContent($content);
      }
    }

    $this->footer = $this
      ->addChildren(new VTCore_Bootstrap_Element_BsElement($this->getContext('footer_elements')))
      ->lastChild();

    if ($this->getContext('footer')) {
      $footers = (array) $this->getContext('footer');
      foreach ($footers as $footer) {
        $this->addFooter($footer);
      }
    }

  }

}