<?php
/**
 * Extending WP Customizer control for hidden form element
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Hidden
extends WP_Customize_Control {

  public $type = 'vtcore_hidden';

  public function render_content() {

    $object = new VTCore_Form_Hidden(array(
      'data' => array(
        'customize-setting-link' => $this->settings['default']->id,
      ),
      'attributes' => array(
        'value' => $this->value(),
      ),
    ));

    $object->render();

  }

}