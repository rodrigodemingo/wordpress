<?php
/**
 * Helper Class for building the datalist Form Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_DataList
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'type' => 'datalist',
    'attributes' => array(
      'id' => false,
      'class' => array(),
    ),
    'options' => array(),
  );

  public function addOption(VTCore_Form_Option $object) {
    $this->addChildren($object);
  }

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('options')) {
      foreach ($this->getContext('options') as $key => $option) {
        if (!is_array($option)) {
          $option = array(
            'text' => $option,
            'attributes' => array(
              'value' => $key,
            ),
          );
        }

        $this->addChildren(new VTCore_Form_Option($option));
      }
    }
  }
}