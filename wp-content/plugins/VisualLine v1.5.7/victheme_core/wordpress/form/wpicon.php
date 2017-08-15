<?php
/**
 * Helper class for building WP Icon Selector
 * The icon will be taken from the VTCore_Wordpress_Data_Icons_Library.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_WpIcon
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'name' => '',
    'limit' => 25,
    'value' => array(
      'family' => false,
      'icon' => false,
    ),
    'description' => false,
    'attributes' => array(
      'class' => array(
        'form-wpicon',
        'form-group',
      ),
    ),
  );


  /**
   * Overriding HTML object build element to build the
   * special element for WP Media Form
   *
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    parent::buildElement();

    if (!$this->getContext('id')) {
      $this->addContext('id', 'vtcore-icon-selector-' . $this->getMachineID());
    }

    // Build default library
    if (!$this->getContext('library')) {
      $this->addContext('library', new VTCore_Wordpress_Data_Icons_Library());
    }

    // Set to default fontawesome if no value defined
    if (!$this->getContext('value.family')) {
      $this->addContext('value.family', 'fontawesome');
    }

    // Load default assets
    VTCore_Wordpress_Utility::loadAsset('wp-bootstrap');
    VTCore_Wordpress_Utility::loadAsset('wp-ajax');
    VTCore_Wordpress_Utility::loadAsset($this->getContext('library')->get($this->getContext('value.family') . '.asset'));

    // Inject the wrapper attributes
    $this->addAttributes($this->getContext('attributes'));


    // Form label
    if ($this->getContext('text')) {
      $this
        ->addChildren(new VTCore_Form_Label(array(
          'text' => $this->getContext('text'),
          'attributes' => array(
            'for' => 'wp-media-' . $this->getMachineID(),
          ),
        )));
    }

    // Form Description
    if ($this->getContext('description')) {
      $this
        ->addChildren(new VTCore_Bootstrap_Form_BsDescription(array(
          'text' => $this->getContext('description'),
        )));
    }

    $this
      ->addChildren(new VTCore_Bootstrap_Form_BsSelect(array(
        'text' => __('Family', 'victheme_core'),
        'name' => $this->getContext('name') . '[family]',
        'value' => $this->getContext('value.family'),
        'options' => $this->getContext('library')->getFontListOptions(),
        'input_elements' => array(
          'attributes' => array(
            'class' => array('btn-ajax-change', 'wp-icon-ajax-trigger'),
          ),
          'data' => array(
            'ajax-mode' => 'post',
            'ajax-target' => '#' . $this->getContext('id'),
            'ajax-loading-text' => __('Retrieving Icons', 'victheme_core'),
            'ajax-object' => 'icon',
            'ajax-action' => 'vtcore_ajax_framework',
            'ajax-value' => array(
              'name' => $this->getContext('name'),
              'limit' => $this->getContext('limit'),
            ),
            'ajax-queue' => array(
              'change'
            ),
            'nonce' => wp_create_nonce('vtcore-ajax-nonce-admin'),
          ),
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsIcon(array(
        'text' => __('Icon', 'victheme_core'),
        'name' => $this->getContext('name') . '[icon]',
        'value' => $this->getContext('value.icon'),
        'icons' => $this->getContext('library')->get($this->getContext('value.family')),
        'limit' => $this->getContext('limit'),
        'attributes' => array(
          'id' => $this->getContext('id'),
        ),
        'data' => array(
          'family' => $this->getContext('value.family'),
          'asset' => VTCore_Wordpress_Init::getFactory('assets')
            ->get('library')
            ->get($this->getContext('library')->get($this->getContext('value.family') . '.asset') . '.css'),
        ),
      )));

  }



}