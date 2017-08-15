<?php
/**
 * Building form for selecting Border related
 * css styles, the final output is
 * an array that is suitable for CSSBuilder_Rules_Border
 *
 * You can use the CSSBuilder_Factory for building the
 * final CSS for the border.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Form_WpBorder
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'text' => false,
    'description' => false,
    'required' => false,

    'name' => false,
    'id' =>  false,
    'class' => array('form-control'),
    'label' => true,

    'type' => 'div',

    // Wrapper Element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-border',
      ),
    ),

    'value' => array(
      'border' => array(
        'width' => '',
        'style' => '',
        'color' => '',
        'radius' => '',
      ),
    ),

    'element_grids' =>  array(
      'columns' => array(
        'mobile' => 3,
        'tablet' => 3,
        'small' => 3,
        'large' => 3,
      )
    ),
  );


  public function buildElement() {

    parent::buildElement();

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription($this->getContext('description_elements')));
    }

    $this
      ->BsRow()
      ->lastChild()
      ->addChildren(new VTCore_Wordpress_Form_BsText(array(
        'text' => __('Width', 'victheme_core'),
        'name' => $this->getContext('name') . '[border][width]',
        'description' => __('Input the icon border size width in pixel. eg 1px', 'victheme_core'),
        'value' => $this->getContext('value.border.width'),
        'grids' => $this->getContext('element_grids')
      )))
      ->addChildren(new VTCore_Wordpress_Form_BsSelect(array(
        'text' => __('Style', 'victheme_core'),
        'description' => __('Select the border style', 'victheme_core'),
        'name' => $this->getContext('name') . '[border][style]',
        'value' => $this->getContext('value.border.style'),
        'grids' => $this->getContext('element_grids'),
        'options' => array(
          '' => __('Not set', 'victheme_core'),
          'none' => __('None', 'victheme_core'),
          'inherit' => __('Inherit', 'victheme_core'),
          'solid' => __('Solid', 'victheme_core'),
          'dotted' => __('Dotted', 'victheme_core'),
          'dashed' => __('Dashed', 'victheme_core'),
          'double' => __('Double', 'victheme_core'),
          'ridge' => __('Ridge', 'victheme_core'),
          'inset' => __('Inset', 'victheme_core'),
          'outset' => __('Outset', 'victheme_core'),
          'groove' => __('Groove', 'victheme_core'),
        ),
      )))
      ->addChildren(new VTCore_Wordpress_Form_BsColor(array(
        'text' => __('Color', 'victheme_core'),
        'name' => $this->getContext('name') . '[border][color]',
        'description' => __('Choose the border color', 'victheme_core'),
        'value' => $this->getContext('value.border.color'),
        'grids' => $this->getContext('element_grids')
      )))
      ->addChildren(new VTCore_Wordpress_Form_BsText(array(
        'text' => __('Radius', 'victheme_core'),
        'name' => $this->getContext('name') . '[border][radius]',
        'description' => __('Set the border radius in the format of top left, top right, bottom right and bottom left eg. 1px 2px 3px 4px', 'victheme_core'),
        'value' => $this->getContext('value.border.radius'),
        'grids' => $this->getContext('element_grids')
      )));
  }
}