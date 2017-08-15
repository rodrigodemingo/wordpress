<?php
/**
 * Extending WP Customizer control for lightweight
 * font selector, this is needed for better performance
 * since google has very large amount of font available
 * to select from and building it into vtcore select
 * element is very slow.

 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Customizer_Element_Font
extends WP_Customize_Control {

  public $type = 'vtcore_font';
  protected $fontMarkup;
  protected $fontArray;


  public function render_content() {

    $this->fontMarkup = get_transient('vtcore_customizer_font_options');

    if (empty($this->fontMarkup)) {
      $this->fontArray = array(
        '' => __('Not set', 'victheme_core'),
        "Georgia, serif" => "Georgia",
        "'Palatino linotype', 'Book Antiqua', serif" => "Palatino",
        "times new romans, Times, serif" => "Times new romans",
        "Arial, Helvetica, sans-serif" => "Arial",
        "'Arial Black', Gadget, sans-serif" => "Arial Black",
        "'Comic Sans MS', cursive, sans-serif" => "Comic Sans",
        "Impact, Charcoal, sans-serif" => "Impact",
        "'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "Lucida",
        "Tahoma, Geneva, san-serif" => "Tahoma",
        "'Trebuchet MS', helvetica, sans-serif" => "Trebuchet MS",
        "Verdana, Geneva, sans-serif" => "Geneva",
        "'Courier New', Courier, monospace" => "Courier",
        "'Lucida Console', Monaco, monospace" => "Lucida",
      );

      $this->fontArray += VTCore_Wordpress_Init::getFactory('fonts')->getCustomizerOptions();


      foreach ($this->fontArray as $value => $text) {
        $object = new VTCore_Form_Option(array(
          'text' => $text,
          'attributes' => array(
            'value' => $value,
          ),
        ));

        $this->fontMarkup .= $object->__toString();

      }

      set_transient('vtcore_customizer_font_options', $this->fontMarkup, VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime') * HOUR_IN_SECONDS);
    }

    $markup = $this->fontMarkup;
    $markup = str_replace('value="' . $this->value() . '"', 'value="' . $this->value() . '" selected="true"', $markup);


    $object = new VTCore_Bootstrap_Form_BsSelect(array(
      'text' => $this->label,
      'description' => $this->description,
      'value' => $this->value(),
      'input_elements' => array(
        'children' => array($this->fontMarkup),
        'data' => array(
          'customize-setting-link' => $this->settings['default']->id,
        ),
      ),
    'options' => array(),
    ));

    $object->render();

    $object = NULL;
    unset($object);

  }

}