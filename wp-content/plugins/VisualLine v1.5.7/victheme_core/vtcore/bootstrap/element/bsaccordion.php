<?php
/**
 * Class for building the Bootstrap Accordion element.
 *
 * To use this class properly, the main object should
 * be VTCore_Bootstrap_Form_Base or VTCore_Bootstrap_Form_Instance or
 * VTCore_Bootstrap_Element_Base
 *
 * Shotcut overloading method "BsAccordion($context)" will be available
 * for use if the parent object is either VTCore_Bootstrap_Form_Instance
 * or VTCore_Bootstrap_Form_Base or VTCore_Bootstrap_Element_Base.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Bootstrap_Element_BsAccordion
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'div',
    'prefix' => 'accordion',
    'attributes' => array(
      'id' => '',
      'class' => array(
        'panel-group',
        'panel-accordion',
      ),
    ),
    'contents' => array(),
    'active' => false,

    // Default elements context only override when needed

    // Heading wrapper element
    'heading_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('panel-heading'),
      ),
    ),

    // Heading title element
    'title_elements' => array(
      'type' => 'h4',
      'attributes' => array(
        'class' => array('panel-title'),
      ),
    ),

    // Heading link element
    'link_elements' => array(
      'type' => 'a',
      'attributes' => array(
        'data-toggle' => 'collapse',
        'data-parent' => '',
        'href' => '',
      ),
    ),

    // Content Wrapper element
    'content_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel-collapse',
          'collapse',
        ),
      ),
    ),

    // Content body element
    'body_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('panel-body'),
      ),
    ),

    // Main Panel wrapper element
    'panel_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel',
          'panel-default',
        ),
      ),
    ),
  );

  protected $unique = '';


  /**
   * Function for building the heading element, This function cannot
   * be used outside this object as the intended design and cannot
   * be extended as well
   *
   * @param string $delta
   * @param text/object $text
   * @return VTCore_Html_Element
   */
  public function addHeading($delta, $text) {

    $wrapper = new VTCore_Html_Element($this->getContext('heading_elements'));

    $wrapper
      ->addChildren(new VTCore_Html_Element($this->getContext('title_elements')))
      ->lastChild() // move the chain to last added child (h4)
      ->addChildren(new VTCore_Html_Element($this->getContext('link_elements')))
      ->lastChild()
      ->addAttribute('data-parent', '#' . $this->unique)
      ->addAttribute('href', '#' . $this->unique . '-' . $delta)
      ->addClass(($this->getContext('active') === $delta) ? '' : 'collapsed')
      ->addChildren($text);

    return $wrapper;
  }



  /**
   * Function for building the accordion content. This function
   * cannot be called outside the class and cannot be extended
   * as well as the designed.
   *
   * @param string $delta
   * @param string / object $content
   * @return VTCore_Html_Element
   */
  public function addContent($delta, $contents) {

    $wrapper = new VTCore_Html_Base($this->getContext('content_elements'));
    $wrapper
      ->addAttribute('id', $this->unique . '-' . $delta)
      ->addClass(($this->getContext('active') === $delta) ? 'in' : '')
      ->addChildren(new VTCore_Html_Element($this->getContext('body_elements')));

    if (!is_array($contents) && is_object($contents)) {
      $contents = array($contents);
    }

    foreach ((array) $contents as $content) {
      $wrapper
        ->lastChild()
        ->addChildren($content);
    }

    return $wrapper;
  }


  /**
   * Public method for dynamically adding panels to the
   * accordion after the accordion constructed.
   */
  public function addPanel($delta, $content) {

    $this
      ->addChildren(new VTCore_Html_Base($this->getContext('panel_elements')))
      ->lastChild()
      ->addChildren($this->addHeading($delta, $content['title']))
      ->addChildren($this->addContent($delta, $content['content']));

    if (isset($content['attributes'])) {
      $this->lastChild()->addAttributes($content['attributes']);
    }

    return $this;
  }



  /**
   * Main Function for building the accordion element
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {
    $uid = new VTCore_Uid();
    $this->unique = $uid->getID();

    $this->addAttributes($this->getContext('attributes'));
    $id = $this->getAttribute('id');

    if (empty($id)) {
      $this->addAttribute('id', $this->getContext('prefix') . '-' . $this->unique);
    }

    $this->unique = $this->getAttribute('id');


    foreach ($this->getContext('contents') as $delta => $content) {
      if (isset($content['title']) && isset($content['content'])) {
        $this->addPanel($delta, $content);
      }
    }
  }

}