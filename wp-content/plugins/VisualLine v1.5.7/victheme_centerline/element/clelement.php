<?php
/**
 * Class for building the history wrapper
 *
 * @author jason.xie@victheme.com
 * @method ClElement($context)
 */
class VTCore_CenterLine_Element_ClElement
extends VTCore_Bootstrap_Grid_BsRow {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'row',
        'centerline-elements',
        'centerline-connector'
      ),
    ),
    'data' => array(
      'circle-start' => 3,
      'circle-end' => 4,
      'circle-opaque' => 10,
      'circle-opacity' => 0.6,
      'line-color' => '#158FBF',
      'line-width' => 1,
      'line-type' => 'round',
      'dot-color' => '#158FBF',
    ),
    'raw' => true,
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

    // Load front end script
    if (!get_theme_support('vtcore_centerline')) {
      VTCore_Wordpress_Utility::loadAsset('centerline-front');
    }

    VTCore_Wordpress_Utility::loadAsset('jquery-centerline');

    $this->addAttributes($this->getContext('attributes'));

  }

  public function getGrid() {
    return $this->grids;
  }

}