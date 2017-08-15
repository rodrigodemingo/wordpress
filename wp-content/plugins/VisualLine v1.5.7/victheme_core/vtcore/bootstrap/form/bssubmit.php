<?php
/**
 * Building form submit field with bootstrap rules
 * This class also support Bootstrap Confirmation Popup
 * User must load the bootstrap-confirmation asset to autoload
 * the javascript related to confirmation box.
 *
 * This class is direct child class from Form_Submit class
 * all the contextes rules applicable to the parent class is
 * also applicable to this class with some exception :
 *
 * mode           : (string) primary | success | info | warning | danger | link
 * size           : (string) lg | sm | xs
 * confirmation   : (boolean) true | false, enable the confirmation popover
 * title          : (string) confirmation popover title
 * ok             : (string) confirmation ok button text
 * cancel         : (string) confirmation cancel button text
 * placement      : (string) left | right | top | bottom, popover location
 *
 * User can always define custom data from the $attributes context directly to
 * override the default bootstrap confirmation javascript for more advanced
 * features.
 *
 * Shortcut Method : BsSubmit($context)
 *
 * @author jason.xie@victheme.com
 * @method BsSubmit($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Bootstrap_Form_BsSubmit
extends VTCore_Form_Submit
implements VTCore_Form_Interface {

  protected $context = array(

    'type' => 'input',
    'attributes' => array(
      'id' => false,
      'class' => array('btn'),
      'name' => '',
      'value' => '',
      'type' => 'submit',
    ),

    // Button mode
    'mode' => 'primary',

    // Button size
    'size' => false,

    // Build confirmation box
    'confirmation' => false,
    'title' => false,
    'ok' => false,
    'cancel' => false,
    'placement' => 'right',

  );

  public function buildElement() {

    parent::buildElement();

    if ($this->getContext('confirmation')) {
      $this->addAttribute('data-toggle', 'confirmation');

      if ($this->getContext('ok')) {
        $this->addAttribute('data-btnOkLabel', $this->getContext('ok'));
      }

      if ($this->getContext('cancel')) {
        $this->addAttribute('data-btnCancelLabel', $this->getContext('cancel'));
      }

      if ($this->getContext('title')) {
        $this->addAttribute('data-title', $this->getContext('title'));
      }

      if ($this->getContext('placement')) {
        $this->addAttribute('data-placement', $this->getContext('placement'));
      }

      if (!$this->getAttribute('id')) {
        $uid = new VTCore_Uid();
        $this->addAttribute('id', 'vtcore-confirmation-submit-' . $uid->getID());
      }
    }

    $this->addClass('btn-' . $this->getContext('mode'));

    if ($this->getContext('size')) {
      $this->addClass('btn-' . $this->getContext('size'));
    }
  }
}