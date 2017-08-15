<?php
/**
 * Class for building valid currency value.
 * It will format the currency as ISO 4217
 * format.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Element_WpCurrency
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'wp-currency',
      ),
    ),

    // Text before the price
    'prefix' => false,

    // Text after the price / duration
    'suffix' => false,

    // Currency must be ISO 4217 currency code
    'code' => false,

    // The amount of the value.
    'number' => false,

    // This will be auto populated
    // for the correct iso formats
    'iso' => false,

    'number_elements' => array(
      'type' => 'span',
      'attributes' => array(
        'class' => array(
          'wpcurrency-number',
        ),
      ),
    ),

    'sign_elements' => array(
      'type' => 'span',
      'attributes' => array(
        'class' => array(
          'wpcurrency-sign',
        ),
      ),
    ),

    'prefix_elements' => array(
      'type' => 'span',
      'attributes' => array(
        'class' => array(
          'wpcurrency-prefix',
        ),
      ),
    ),

    'suffix_elements' => array(
      'type' => 'span',
      'attributes' => array(
        'class' => array(
          'wpcurrency-suffix',
        ),
      ),
    ),
  );


  static protected $currency = false;


  /**
   * Overriding parent method for building
   * the currency object markup
   *
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    if (empty(self::$currency)) {
      self::$currency = new VTCore_Wordpress_Data_Currency_Iso();
    }

    parent::buildElement();

    if ($this->getContext('code') && self::$currency->getCurrency(strtolower($this->getContext('code')))) {
      $this->addContext('iso', (array) self::$currency->getCurrency(strtolower($this->getContext('code'))));
    }

    // Build and format according to iso
    if ($this->getContext('iso')) {

      // Build the number
      $this->addChildren(new VTCore_Html_Element($this->getContext('number_elements')));
      $this->lastChild()->setText(number_format(
        doubleval($this->getContext('number')),
        substr_count($this->getContext('iso.subunit_to_unit'), '0'),
        $this->getContext('iso.decimal_mark'),
        $this->getContext('iso.thousands_separator')
      ));

      // Build symbol
      if ($this->getContext('iso.symbol')) {
        if ($this->getContext('iso.symbol_first')) {
          $this->prependChild(new VTCore_Html_Element($this->getContext('sign_elements')));
          $this->firstChild()->setText($this->getContext('iso.symbol'));
        }
        else {
          $this->addChildren(new VTCore_Html_Element($this->getContext('sign_elements')));
          $this->lastChild()->setText($this->getContext('iso.symbol'));
        }
      }
    }

    // No iso found just use the data as is
    else {

      if ($this->getContext('code')) {
        $this->addChildren(new VTCore_Html_Element($this->getContext('sign_elements')));
        $this->lastChild()->setText($this->getContext('code'));
      }

      $this->addChildren(new VTCore_Html_Element($this->getContext('number_elements')));
      $this->lastChild()->setText($this->getContext('number'));
    }


    // Support for prefix text
    if ($this->getContext('prefix')) {
      $this->prependChild(new VTCore_Html_Element($this->getContext('prefix_elements')));
      $this->firstChild()->setText($this->getContext('prefix'));
    }


    // Support for suffix text
    if ($this->getContext('suffix')) {
      $this->addChildren(new VTCore_Html_Element($this->getContext('suffix_elements')));
      $this->lastChild()->setText($this->getContext('suffix'));
    }
  }
}