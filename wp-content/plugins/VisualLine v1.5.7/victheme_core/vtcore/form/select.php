<?php
/**
 * Helper Class for building the Select Form Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Form_Select
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'type' => 'select',
    'value' => '',
    'attributes' => array(
      'id' => false,
      'class' => array(),
      'name' => '',
      'size' => false,
      'multiple' => false,
      'required' => false,
    ),
    'options' => array(),
  );

  

  public function addOption(VTCore_Form_Option $object) {
    if (in_array($object->getAttribute('value'), (array) $this->getAttribute('value'))) {
      $object->addAttribute('selected', 'selected');
    }
    $this->addChildren($object);
    unset($object);
    
    return $this;
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
        $this->addOption(new VTCore_Form_Option($option));

      }
    }

    // Fix user forgot to add [] as the select attributes name
    // causing the post only return non array results.
    if ($this->getAttribute('multiple') == true
        && strrpos($this->getAttribute('name'), '[]', -2) === false) {

      $this->addAttribute('name', $this->getAttribute('name') . '[]');
      $this->context['attributes']['name'] = $this->getAttribute('name') . '[]';

    }


    if ($this->getAttribute('value')) {
      $this->removeAttribute('value');
    }
  }



  public function setValue($value) {
    $value = (array) $value;

    foreach ($this->getChildrens() as $object) {
      if ($object->getType() == 'option') {
        $object->removeAttribute('selected');
        if (in_array($object->getAttribute('value'), $value)) {
          $object->addAttribute('selected', 'selected');
        }
      }
    }
  }
}