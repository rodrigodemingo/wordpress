<?php
/**
 * Extending WP Customizer control for lightweight
 * color picker based on bootstrap color picker
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Video
extends WP_Customize_Control {

  public $type = 'vtcore_color';

  public function enqueue() {
    VTCore_Wordpress_Utility::loadAsset('wp-media');
    VTCore_Wordpress_Init::getFactory('assets')->process();
  }

  public function render_content() {

    $object = new VTCore_Wordpress_Form_WpMedia(array(
      'text' => $this->label,
      'description' => $this->description,
      'value' => $this->value(),
      'data' => array(
        'type' => 'video',
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