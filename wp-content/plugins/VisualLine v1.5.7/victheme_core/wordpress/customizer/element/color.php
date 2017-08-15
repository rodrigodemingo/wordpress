<?php
/**
 * Extending WP Customizer control for lightweight
 * color picker based on bootstrap color picker
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Color
extends WP_Customize_Control {

  public $type = 'vtcore_color';

  public function enqueue() {
    VTCore_Wordpress_Utility::loadAsset('bootstrap-colorpicker');
    VTCore_Wordpress_Init::getFactory('assets')->process();
  }

  public function render_content() {

    $object = new VTCore_Bootstrap_Form_BsColor(array(
      'text' => $this->label,
      'description' => $this->description,
      'value' => $this->value(),
      'data' => array(
        'container' => true,
        'block' => true,
      ),
      'input_elements' => array(
        'data' => array(
          'customize-setting-link' => $this->settings['default']->id,
        ),
      ),
    ));

    // Build the dummy gradient controller
    $object->render();

  }

}