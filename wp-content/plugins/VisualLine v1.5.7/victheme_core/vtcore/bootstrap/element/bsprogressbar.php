<?php
/**
 * Building progress bar with bootstrap rules
 *
 * Shortcut Method : BsProgressBar($context)
 *
 * This class must be called from VTCore_Bootstrap_Form_BsInstance() as
 * the main form wrapper class if shortcut method is used.
 *
 * Otherwise a full invocation of the class name must be used
 * when building the object, and addChildren() method must be
 * used for registering the object into the parent form wrapper.
 *
 * Shortcut context available :
 *
 * mintext       : (string) the minimum text
 * maxtext       : (string) the maximum text
 * stripped      : (boolean) make the bar stripped
 * animated      : (boolean) make the bar animated
 *
 * contents      : (array) use this if you wanted stacked progress bar
 *    text       : (string) the title text for the contents delta
 *    width      : (string) the size of the bar
 *    class      : (array) progress-bar progress-bar-success progress-bar-info progress-bar-warning progress-bar-danger
 *    hidetext   : (boolean) hide the text
 *    attributes : (array) array of attributes for the elements
 *
 *
 * @author jason.xie@victheme.com
 * @method BsProgressBar($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Bootstrap_Element_BsProgressBar
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(

    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-progress-bar'
      ),
    ),

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'mintext' => false,
    'maxtext' => false,
    'stripped' => false,
    'animated' => false,
    'contents' => array(),

    // Wrapper element
    'wrapper_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('progress'),
      ),
    ),

    // MinMaxText elements
    'minmaxtext_elements' => array(
      'type' => 'span',
      'attributes' => array(
        'class' => array(
          'badge',
        ),
      ),
    ),

    'progressbar_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('progress-bar'),
        'role' => 'progressbar',
       ),
    ),

  );

  private $wrapper;


  public function buildBar($progressbar) {
    $element = new VTCore_Html_Element($this->getContext('progressbar_elements'));

    if (isset($progressbar['attributes'])) {
      $element->addAttributes($progressbar['attributes']);
    }

    if (isset($progressbar['class'])) {
      foreach ($progressbar['class'] as $class) {
        $element->addClass($class);
      }
    }

    if (isset($progressbar['width'])) {
      $element->addStyle('width', $progressbar['width'] . '%');
    }

    if (isset($progressbar['text'])) {
      $text = $element->addChildren(new VTCore_Html_Element(array(
        'text' => $progressbar['text'],
        'type' => 'span',
      )));

      if (isset($progressbar['hidetext']) && $progressbar['hidetext'] == true) {
        $text->addClass('sr-only');
      }
    }

    return $element;
  }



  public function addBar($progressbar) {
    $this->wrapper->addChildren($this->buildBar($progressbar));
  }


  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    $this
      ->addChildren(new VTCore_Bootstrap_Element_BsElement($this->getContext('wrapper_elements')));

    $this->wrapper = $this->lastChild();

    if ($this->getContext('stripped')) {
      $this->wrapper->addClass('progress-stripped');
    }

    if ($this->getContext('animated')) {
      $this->wrapper->addClass('active animated');
    }

    foreach ($this->getContext('contents') as $progressbar) {
      $this->addBar($progressbar);
    }

    if ($this->getContext('mintext') || $this->getContext('maxtext')) {
      $this->addChildren(new VTCore_Bootstrap_Element_BsElement(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'form-min-max-wrapper',
          ),
        ),
      )));

      $minmax = $this->lastChild();
    }

    if ($this->getContext('mintext')) {
      $minmax
        ->addChildren(new VTCore_Html_Element($this->getContext('minmaxtext_elements')))
        ->lastChild()
        ->addClass('pull-left')
        ->setText($this->getContext('mintext'));
    }

    if ($this->getContext('maxtext')) {
      $minmax
        ->addChildren(new VTCore_Html_Element($this->getContext('minmaxtext_elements')))
        ->lastChild()
        ->addClass('pull-right')
        ->setText($this->getContext('maxtext'));
    }
  }
}