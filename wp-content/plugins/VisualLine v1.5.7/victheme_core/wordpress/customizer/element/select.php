<?php
/**
 * Extending WP Customizer control for lightweight
 * select element

 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Select
extends WP_Customize_Control {

  public $type = 'vtcore_select';

  public function render_content() {

    $object = new VTCore_Bootstrap_Form_BsSelect(array(
      'text' => $this->label,
      'description' => $this->description,
      'value' => $this->value(),
      'input_elements' => array(
        'data' => array(
          'customize-setting-link' => $this->settings['default']->id,
        ),
      ),
      'options' => $this->choices,
    ));

    $object->render();

  }

}