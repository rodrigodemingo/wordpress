<?php
/**
 * Extending WP Customizer control for lightweight
 * checkbox switch element

 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Switch
extends WP_Customize_Control {

  public $type = 'vtcore_switch';

  public function enqueue() {
    VTCore_Wordpress_Utility::loadAsset('bootstrap-switch');
    VTCore_Wordpress_Init::getFactory('assets')->process();
  }

  public function render_content() {

    $element = new VTCore_Bootstrap_Form_BsCheckbox(array(
      'text' => $this->label,
      'description' => $this->description,
      'checked' => (boolean) $this->value(),
      'offvalue' => NULL,
      'switch' => true,
      'input_elements' => array(
        'data' => array(
          'customize-setting-link' => $this->settings['default']->id,
        ),
      ),
    ));

    $element->render();

  }

}