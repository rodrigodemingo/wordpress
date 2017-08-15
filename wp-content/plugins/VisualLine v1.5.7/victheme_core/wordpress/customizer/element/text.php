<?php
/**
 * Extending WP Customizer control for text element

 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Text
extends WP_Customize_Control {

  public $type = 'vtcore_text';

  public function render_content() {

    $object = new VTCore_Bootstrap_Form_BsText(array(
      'text' => $this->label,
      'description' => $this->description,
      'value' => $this->value(),
      'input_elements' => array(
        'data' => array(
          'customize-setting-link' => $this->settings['default']->id,
        ),
      ),
    ));

    $object->render();

  }

}