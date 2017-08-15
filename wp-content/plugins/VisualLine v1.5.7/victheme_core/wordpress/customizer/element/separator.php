<?php
/**
 * Extending WP Customizer control for building a separator elements
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Separator
extends WP_Customize_Control {

  public $type = 'vtcore_separator';

  public function render_content() {
    $element = new VTCore_Html_Base(array(
      'type' => 'hr',
      'attributes' => array(
        'class' => array(
          'customizer-separator',
        ),
      ),
    ));

    $element->render();
  }

}