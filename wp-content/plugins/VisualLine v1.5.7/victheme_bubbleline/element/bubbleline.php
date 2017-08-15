<?php
/**
 * Class for building the bubble line wrapper
 *
 * @author jason.xie@victheme.com
 * @method Bubbleline($context)
 */
class VTCore_BubbleLine_Element_BubbleLine
extends VTCore_Bootstrap_Element_BsElement {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'attributes' => array(
      'class' => array(
        'bubbleline-elements',
        'bubbleline-connector',
      ),
    ),
  );

  public function buildElement() {

    // Load the default plugin assets
    // Themer can disable this by declaring support to victheme_bubbleline
    // or create the same assets name to override the default one.
    if (!get_theme_support('victheme_bubbleline')) {
      VTCore_Wordpress_Utility::loadAsset('bubbleline-front');
    }

    VTCore_Wordpress_Utility::loadAsset('jquery-custom-scrollbar');
    VTCore_Wordpress_Utility::loadAsset('jquery-bubbleline');

    $this->addAttributes($this->getContext('attributes'));

  }

}