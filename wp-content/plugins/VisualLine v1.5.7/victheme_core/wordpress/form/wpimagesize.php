<?php
/**
 * Helper class for building WP Image
 * Size configuration form
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_WpImageSize
extends VTCore_Bootstrap_Form_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'name' => '',
    'value' => '',
    'description' => false,
    'width' => '',
    'height' => '',
    'crop' => false,
    'attributes' => array(
      'class' => array(
        'form-wpimagesize',
        'form-multi-group',
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

    if ($this->getContext('value.width')) {
      $this->addContext('width', $this->getContext('value.width'));
    }
    
    if ($this->getContext('value.height')) {
      $this->addContext('height', $this->getContext('value.height'));
    }
    
    if ($this->getContext('value.crop')) {
      $this->addContext('crop', $this->getContext('value.crop'));
    }
    
    if ($this->getContext('text')) {
      $this
        ->Label(array(
          'text' => $this->getContext('text'),
        ));
    }

    if ($this->getContext('description')) {
      $this
        ->BsDescription(array(
          'text' => $this->getContext('description'),
        ));
    }

    $this
      ->BsRow()
      ->lastChild()
      ->BsText(array(
        'text' => __('Width', 'victheme_core'),
        'name' => $this->getContext('name') . '[width]',
        'value' => $this->getContext('width'),
        'suffix' => 'px',
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '4',
            'small' => '4',
            'large' => '4',
          ),
        ),
        'validators' => array(
          'number' => __('Only numerical value allowed', 'victheme_core'),
        ),
      ))
      ->BsText(array(
        'text' => __('Height', 'victheme_core'),
        'name' => $this->getContext('name') . '[height]',
        'value' => $this->getContext('height'),
        'suffix' => 'px',
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '4',
            'small' => '4',
            'large' => '4',
          ),
        ),
        'validators' => array(
          'number' => __('Only numerical value allowed', 'victheme_core'),
        ),
      ))
      ->BsSelect(array(
        'text' => __('Crop', 'victheme_core'),
        'name' => $this->getContext('name') . '[crop]',
        'value' => $this->getContext('crop'),
        'options' => array(
          true => __('Crop Image', 'victheme_core'),
          false => __('Don\'t Crop Image', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => '12',
            'tablet' => '4',
            'small' => '4',
            'large' => '4',
          ),
        ),
      ));
  }
}