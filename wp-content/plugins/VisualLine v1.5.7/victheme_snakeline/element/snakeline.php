<?php
/**
 * Class for building the snake line wrapper
 *
 * @author jason.xie@victheme.com
 * @method Snakeline($context)
 */
class VTCore_SnakeLine_Element_SnakeLine
extends VTCore_Bootstrap_Element_BsElement {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'snakeline-elements',
        'snakeline-connector',
      ),
    ),
    'line' => array(
      'color' => '#797979',
      'width' => 4,
      'type' => 'dotted',
    ),
  );

  public function buildElement() {

    // Load the default plugin assets
    // Themer can disable this by declaring support to victheme_snakeline
    // or create the same assets name to override the default one.
    if (!get_theme_support('victheme_snakeline')) {
      VTCore_Wordpress_Utility::loadAsset('snakeline-front');
    }

    VTCore_Wordpress_Utility::loadAsset('jquery-custom-scrollbar');
    VTCore_Wordpress_Utility::loadAsset('jquery-snakeline');

    $this
      ->addData('line', $this->getContext('line'))
      ->addAttributes($this->getContext('attributes'));


  }

}