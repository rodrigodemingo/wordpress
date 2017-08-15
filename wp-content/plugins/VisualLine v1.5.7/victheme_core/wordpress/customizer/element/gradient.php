<?php
/**
 * Extending WP Customizer control for building
 * gradient picker element
 *
 * Not working!
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Gradient
extends WP_Customize_Control {

  public $type = 'vtcore_gradient';

  public function enqueue() {

    VTCore_Wordpress_Utility::loadAsset('jquery-table-manager');
    VTCore_Wordpress_Utility::loadAsset('wp-gradientpicker');
    VTCore_Wordpress_Init::getFactory('assets')->process();
  }

  public function render_content() {

    $unique = new VTCore_Uid();
    $id = $unique->getID();

    $gradient = new VTCore_Wordpress_Form_WpGradient(array(
      'text' => $this->label,
      'value' => $this->value(),
      'preview' => false,
      'data' => array(
        'gradient-target' => $this->settings['default']->id,
        'gradient-customizer' => true,
      ),
    ));


    foreach ($gradient->findChildren('class', 'bootstrap-colorpicker') as $key => $object) {
      $object->addData('container', true);
    }

    // Build the dummy gradient controller
    $gradient->render();

    // Build the actual hidden elements
    $hidden = new VTCore_Form_Hidden(array(
      'data' => array(
        'customize-setting-link' => $this->settings['default']->id,
      ),
    ));

    $hidden->render();
  }

}