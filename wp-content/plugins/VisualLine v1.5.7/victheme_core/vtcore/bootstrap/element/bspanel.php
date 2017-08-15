<?php
/**
 * Class for building the Bootstrap Panel element.
 *
 * To use this class properly, the main object should
 * be VTCore_Bootstrap_Form_Base or VTCore_Bootstrap_Form_Instance or
 * VTCore_Bootstrap_Element_Base
 *
 * Shotcut overloading method "Panel($context)" will be available
 * for use if the parent object is either VTCore_Bootstrap_Form_Instance
 * or VTCore_Bootstrap_Form_Base or VTCore_Bootstrap_Element_Base.
 *
 * Use $contents array to add the panel content with valid Html
 * and its subclasses object.
 *
 * Any object that are added on afterwards via addChildren() will
 * be added after the panel-content wrapper
 *
 * text         : (string) The panel heading text
 * heading      : (boolean) Toggle to use h3 element as the heading or not
 * mode         : (string) The panel type, available options :
 *                panel-default, panel-primary, panel-success, panel-info
 *                panel-warning, panel-danger
 * contents     : (array) array of object served as the content and placed
 *                inside the panel-content wrapper
 *
 * @author jason.xie@victheme.com
 * @method BsPanel($context)
 */
class VTCore_Bootstrap_Element_BsPanel
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'heading' => true,
    'mode' => 'panel-default',
    'attributes' => array(
      'id' => '',
      'class' => array(
        'panel',
      ),
    ),
    'contents' => array(),
    'footers' => array(),
    'table' => false,

    'title_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel-heading',
        ),
      ),
    ),

    'heading_elements' => array(
      'type' => 'h3',
      'text' => '',
      'attributes' => array(
        'class' => array(
          'panel-title',
        ),
      ),
    ),

    'content_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel-body',
        ),
      ),
    ),

    'footer_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel-footer',
        ),
      ),
    ),
  );

  protected $content = array();
  protected $heading = array();
  protected $footer = array();

  public function getContent() {
    return $this->content;
  }

  /**
   * The way to add children into inside of the content
   * wrapper. the original addChildren will add the content
   * outside the content wrapper.
   *
   * @param $object
   */
  public function addContent($object) {
    $this->content->addChildren($object);
    return $this;
  }


  /**
   * Adding footer to the panel wrapper
   * @param $object
   */
  public function addFooter($object) {
    $this
      ->addChildren(new VTCore_Html_Element($this->getContext('footer_elements')))
      ->lastChild()
      ->addChildren(new VTCore_Html_Element($this->getContext('content_elements')))
      ->lastChild()
      ->addChildren($object);
    return $this;
  }

  /**
   * Building table element, this is now a separated method
   * allowing user to inject table after buildElement() fired
   *
   * @param $context
   * @return $this
   */
  public function addTable($context) {
    $this->table = new VTCore_Html_Table($context);
    $this
      ->addChildren($this->table)
      ->lastChild()
      ->addClass('table table-striped');

    return $this;
  }

  /**
   * Extract the stored table element so user can inject new
   * row easily
   * @return mixed
   */
  public function getTable() {
    return $this->table;
  }

  /**
   * Main Function for building the accordion element
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));
    $this->addClass($this->getContext('mode'));

    if ($this->getContext('heading')) {
      $this
        ->addChildren(new VTCore_Html_Element($this->getContext('title_elements')));

      $this->heading = $this->lastChild()
        ->addChildren(new VTCore_Html_Element($this->getContext('heading_elements')))
        ->lastChild();

      $this->heading->addChildren($this->getContext('text'));
    }

    $this->content = $this->addChildren(new VTCore_Html_Element($this->getContext('content_elements')))->lastChild();
    foreach ($this->getContext('contents') as $object) {
      $this->addContent($object);
    }

    foreach ($this->getContext('footers') as $object) {
      $this->addFooter($object);
    }


    if ($this->getContext('table')) {
      $this->addTable($this->getContext('table'));
    }
  }

}