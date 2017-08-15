<?php
/**
 * Extending WP Customizer control for building
 * textarea element
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Textarea
extends WP_Customize_Control {

  public $type = 'vtcore_textarea';

  public function render_content() {

    $object = new VTCore_Bootstrap_Form_BsTextarea(array(
      'text' => $this->label,
      'description' => $this->description,
      'value' => $this->value(),
      'row' => 5,
      'raw' => true,
      'input_elements' => array(
        'raw' => true,
        'data' => array(
          'customize-setting-link' => $this->settings['default']->id,
        ),
      ),
    ));

    $object->render();
  }

}