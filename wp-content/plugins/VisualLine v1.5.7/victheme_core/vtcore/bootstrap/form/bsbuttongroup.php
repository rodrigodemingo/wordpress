<?php
/**
 * Building Bootstrap button group element.
 *
 * This class will build the wrapper for multiple
 * button elements. The button elements will use
 * the BsButton object. All contexes for the buttons
 * must follow the BsButton valid context rule
 * @see VTCore_Bootstrap_Form_BsButton
 *
 * The default fallback contextes for BsButton elements
 * is in the context array key 'buttons_element' this
 * array key will get overriden when user specify
 * different contextes for each button element.
 *
 * You can also inject multiple button directly from
 * context array via 'buttons' array key. This object
 * will auto inject the children if the buttons array
 * key is populated with either valid context array
 * for BsButton or the BsButton object itself.
 *
 * Shortcut Method : BsButtonGroup($context)
 *
 * @author jason.xie@victheme.com
 * @method BsButtonGroup($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Bootstrap_Form_BsButtonGroup
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'btn-group',
      ),
    ),

    // Default context for BsButton
    'buttons_element' => array(
      'mode' => 'primary',
      'size' => 'normal',
      'confirmation' => false,
      'title' => false,
      'ok' => false,
      'cancel' => false,
      'placement' => 'right',
    ),

    // User can inject multiple buttons
    'buttons' => array(),


    // Internal use, Only override if needed
    'label_elements' => array(),
    'description_elements' => array(),

  );

  /**
   * Public method for adding button children easily.
   * @param array $context
   *   - The context array must be valid array according
   *     to the VTCore_Bootstrap_Form_BsButton object.
   */
  public function addButton($context) {
    $context = VTCore_Utility::arrayMergeRecursiveDistinct($context, $this->context['button_element']);
    $this->addChildren(new VTCore_Bootstrap_Form_BsButton($context));

    return $this;
  }


  public function buildElement() {

    parent::buildElement();

    foreach ($this->getContext('buttons') as $button) {
      if (is_array($button)) {
        $this->addButton($button);
      }
      else {
        $this->addChildren($button);
      }
    }
  }
}