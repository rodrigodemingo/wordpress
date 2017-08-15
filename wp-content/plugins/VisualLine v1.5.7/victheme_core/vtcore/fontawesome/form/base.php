<?php
/**
 * Fontawesome form base
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Fontawesome_Form_Base
extends VTCore_Bootstrap_Form_Base {

  protected $overloaderPrefix = array(
    'VTCore_Fontawesome_Form_',
    'VTCore_Fontawesome_',
    'VTCore_Bootstrap_Form_',
    'VTCore_Bootstrap_Element_',
    'VTCore_Bootstrap_Grid_',
    'VTCore_Form_',
    'VTCore_Html_',
  );

  protected $options = array();

  public function buildElement() {

    VTCore_Wordpress_Utility::loadAsset('font-awesome');
    VTCore_Wordpress_Utility::loadAsset('jquery-iconpicker');

    $this->buildOptions();

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('prefix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsPrefix($this->getContext('prefix_elements')));
    }

    $this->addContext('input_elements.options', $this->options);

    $this->addChildren(new VTCore_Form_Select($this->getContext('input_elements')));

    if ($this->getContext('suffix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsSuffix($this->getContext('suffix_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription($this->getContext('description_elements')));
    }

    // Free up resources as they already
    // transfered to child elements.
    unset($this->context);
    unset($this->options);
    $this->options = array();
    $this->context = array();

  }

}