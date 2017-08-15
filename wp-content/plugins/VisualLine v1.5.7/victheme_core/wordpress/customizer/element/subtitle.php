<?php
/**
 * Extending WP Customizer control for building a subtitle
 * elements.
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Subtitle
extends WP_Customize_Control {

  public $type = 'vtcore_subtitle';

  public function render_content() {
    $element = new VTCore_Html_Base();

    $element
      ->Element(array(
        'type' => 'hr',
        'attributes' => array(
          'class' => array(
            'customizer-separator',
          ),
        ),
      ))
      ->Element(array(
        'type' => 'h2',
        'attributes' => array(
          'class' => array(
            'customizer-title',
          ),
        ),
      ))
      ->lastChild()
      ->setText($this->label)
      ->getParent()
      ->Element(array(
        'type' => 'hr',
        'attributes' => array(
          'class' => array(
            'customizer-separator',
          ),
        ),
      ))
      ->render();
  }

}