<?php
/**
 * Helper Class for building the Select Form Elements
 *
 * This method also support integration
 * to bootstrap select javascript. To enable
 * it add selectpicker to the context array
 *
 * Example :
 *
 * Use select picker without any options
 * $context['selectpicker'] = true
 *
 * Use select picker and define custom
 * options
 * $context['selectpicker'] = array(
 *
 *   // Define maximum selectable options
 *   // for multiple selects.
 *   'max-options' => 2,
 *
 *   // Define the select styles using
 *   // bootstrap button styling
 *   // such as btn-warning, btn-info, btn-danger
 *   // btn-primary, btn-success and btn-inverse
 *   'style' => 'btn-primary',
 *
 *   // Define to use search box or not
 *   'live-search' => 'true',
 *
 *   // Define the placeholder text to use
 *   'title' => 'some text',
 *
 *
 *   // Use custom selected text format
 *   // such as count or count>2
 *   'selected-text-format' => 'count',
 *
 *   // Display tick on selected option
 *   'show-tick' => true,
 *
 *   // Display the menu arrow
 *   'show-menu-arrow' => true,
 *
 *   // Use custom width
 *   'width' => pixel or percent or auto
 *
 *   // Set the dropdown height
 *   'size' => 'auto',
 *
 *   // set text as header for the options dropdown
 *   'header' => 'some text',
 *
 *   // move the dropdown to up when possible
 *   'dropup' => true,
 * );
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Bootstrap_Form_BsSelect
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'prefix' => false,
    'suffix' => false,
    'description' => false,
    'required' => false,
    'value' => false,
    'id' => false,
    'class' => array('form-control'),
    'name' => false,
    'size' => false,
    'multiple' => false,
    'options' => array(),

    // BootStrap Rules
    'label' => true,

    'togglelabel' => false,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array('form-group'),
    ),

    // Internal use, Only override if needed
    'input_elements' => array(),
    'label_elements' => array(),
    'description_elements' => array(),
    'prefix_elements' => array(),
    'suffix_elements' => array(),
    'required_elements' => array(),
  );

  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('prefix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsPrefix($this->getContext('prefix_elements')));
    }

    $this->addContext('input_elements.options', $this->getContext('options'));

    if ($this->getContext('selectpicker')) {
      $this->processPickerContext();
    }

    $this->addChildren(new VTCore_Form_Select($this->getContext('input_elements')));

    if ($this->getContext('suffix_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsSuffix($this->getContext('suffix_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription($this->getContext('description_elements')));
    }

    if ($this->getContext('togglelabel')) {

      if (class_exists('VTCore_Wordpress_Utility')) {
        VTCore_Wordpress_Utility::loadAsset('bootstrap-toggle-label');
      }

      $this->addData('toggle-label', array(
        'parent' => false,
      ));
    }
  }


  protected function processPickerContext() {

    if (class_exists('VTCore_Wordpress_Utility')) {
      VTCore_Wordpress_Utility::loadAsset('bootstrap-select');
    }

    $this
      ->addClass('bootstrap-selectpicker-group')
      ->addContext('input_elements.attributes.class.selectpicker', 'selectpicker');

    if (is_array($this->getContext('selectpicker'))) {

      if ($this->getContext('selectpicker.show-tick')) {
        $this->addContext('input_elements.attributes.class.show-tick', 'show-tick');
      }

      if ($this->getContext('selectpicker.show-menuarrow')) {
        $this->addContext('input_elements.attributes.class.show-menuarrow', 'show-menuarrow');
      }

      if ($this->getContext('selectpicker.dropup')) {
        $this->addContext('input_elements.attributes.class.dropup', 'dropup');
      }

      foreach ($this->getContext('selectpicker') as $key => $value) {

        if ($key == 'show-menuarrow' || $key == 'show-tick' || $key == 'dropup') {
          continue;
        }

        $this->addContext('input_elements.data.' . $key, $value);
      }
    }

    return $this;
  }
}