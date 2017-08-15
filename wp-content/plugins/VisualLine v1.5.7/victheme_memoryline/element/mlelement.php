<?php
/**
 * Class for building the history wrapper
 *
 * @author jason.xie@victheme.com
 * @method ClElement($context)
 */
class VTCore_MemoryLine_Element_MlElement
extends VTCore_Bootstrap_Grid_BsRow {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'row',
        'memoryline-elements',
        'memoryline-connector',
      ),
    ),
    'data' => array(
      'animation' => false,
      'line-time' => 600,
      'line-color' => '#f0f0f0',
      'line-width' => 10,
      'line-type' => 'round',
      'line-dash' => 'line',
      'line-offset-x' => 0,
      'line-offset-y' => 2,
      'dot-time' => 100,
      'dot-radius' => 8,
      'dot-color' => '#ff6c00'
    ),
  );

  private $grids;

  public function buildElement() {

    if ($this->getContext('grids')) {
      $this->grids = new VTCore_Bootstrap_Grid_Column($this->getContext('grids'));
      $this->addClass($this->getGrid()->getClass());
    }

    // Some theme nuking default vc grids css, load it manually
    $styles = wp_styles();
    if ((!$styles->query('js_composer_front', 'registered') || !$styles->query('js_composer_front', 'enqueued'))
      && function_exists('vc_asset_url')) {
      $front_css_file = vc_asset_url( 'css/js_composer.min.css' );
      wp_register_style('js_composer_front', $front_css_file, array(), WPB_VC_VERSION );
      wp_enqueue_style('js_composer_front');
    }

    // Load the default plugin assets
    // Themer can disable this by declaring support to victheme_memoryline
    // or create the same assets name to override the default one.
    if (!get_theme_support('victheme_memoryline')) {
      VTCore_Wordpress_Utility::loadAsset('memoryline-front');
    }

    VTCore_Wordpress_Utility::loadAsset('jquery-lazyliner');
    VTCore_Wordpress_Utility::loadAsset('jquery-memoryline');

    $this->addAttributes($this->getContext('attributes'));

  }


  public function getGrid() {
    return $this->grids;
  }

}