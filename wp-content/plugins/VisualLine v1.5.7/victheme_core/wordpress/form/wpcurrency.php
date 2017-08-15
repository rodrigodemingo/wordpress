<?php
/**
 * Extending Bootstrap Select Elements to build the simple
 * currency picker Select element.
 *
 * This class will retrieve the currency data from the
 * VTCore_Wordpress_Data_Iso Class and should be paired with
 * VTCore_Wordpress_Element_WpCurrency for the display element.
 *
 * Extra additional context :
 *
 * currency     : (array) array of currency iso code that will be
 *                      used to build the select options. if omitted
 *                      or set to false, object will build all available
 *                      currency
 *
 * display      : (string) the display mode for the options text, valid value
 *                       are symbol, name or iso_code
 *
 * include      : (boolean) include the currency object as html5 data-currency attributes
 *
 * @todo Make this object supports parent select javascript!
 * @see VTCore_Wordpress_Data_Iso
 * @see VTCore_Bootstrap_Form_BsSelect
 * @see VTCore_Wordpress_Element_WpCurrency
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_WpCurrency
extends VTCore_Bootstrap_Form_BsSelect
implements VTCore_Form_Interface {

  static protected $currency = false;
  static protected $codes = array();
  protected $options = array();

  public function buildElement() {

    // One currency object for all elements
    if (empty(self::$currency)) {
      self::$currency = new VTCore_Wordpress_Data_Currency_Iso();
      self::$codes = array_keys((array) self::$currency->getOptions());
    }

    // Extra class
    $this->addContext('class.currency', 'bootstrap-currency');

    // Set the display mode
    if (!$this->getContext('display') || !in_array($this->getContext('display'), array('name, iso_code', 'symbol'))) {
      $this->addContext('display', 'name');
    }

    // Fallback to all currency
    if (!$this->getContext('currency')) {
      $this->addContext('currency', self::$codes);
    }

    // Build the select options
    foreach ($this->getContext('currency') as $code) {
      if (self::$currency->get($code, 'symbol')
          && self::$currency->get($code, 'iso_code')) {

        $this->options[self::$currency->get($code, 'iso_code')] = array(
          'text' =>  self::$currency->get($code, $this->getContext('display')),
          'attributes' => array(
            'value' => $code,
          ),
        );

        if ($this->getContext('include')) {
          $this->options[self::$currency->get($code, 'iso_code')]['data']['currency'] = (array) self::$currency->getCurrency($code);
        }

      }
    }

    // Inject the select options
    $this->addContext('options', $this->options);

    // Invoke the parent method to build the element
    parent::buildElement();

  }

}