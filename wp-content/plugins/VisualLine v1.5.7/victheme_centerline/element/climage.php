<?php
/**
 * Class for building the centerline inner content.
 *
 * @author jason.xie@victheme.com
 * @method HsInner($context)
 */
class VTCore_CenterLine_Element_ClImage
extends VTCore_Bootstrap_Grid_BsColumn {

  protected $context = array(
    'type' => 'figure',
    'attributes' => array(
      'class' => array('centerline-centerpoint'),
    ),
    'image_element' => array(
      'size' => 'full',
      'attributes' => array(
        'class' => array('centerline-image'),
      ),
    ),
    'image_style' => false,
    'grids' => array(
      'columns' => array(
        'mobile' => 12,
        'tablet' => 12,
        'small' => 12,
        'large' => 12,
      ),
    ),
    'raw' => true,
  );


  public function buildElement() {

    parent::buildElement();

    // Load front end script
    if (!get_theme_support('vtcore_centerline')) {
      VTCore_Wordpress_Utility::loadAsset('centerline-front');
    }

    $this->addAttributes($this->getContext('attributes'));

    // Visual Composer image styling
    $style = $this->getContext('image_style');
    if (strpos($style, '_circle_2') !== false || $style == 'diamond') {
      $this->addContext('image_element.force.square', true);
      $style = str_replace('_circle_2', '_circle', $style);
    }

    $style_box3d = '';
    if ($style == 'vc_box_shadow_3d') {
      $style_box3d = 'vc_box_shadow_3d_wrap';
    }

    if ($this->getContext('border_color') && $this->getContext('image_style')) {
      $style .= ' vc_box_border_' . $this->getContext('border_color');
    }

    $this
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'wpb_single_image'
          )
        )
      )))
      ->lastChild()
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'vc_single_image-wrapper',
            $style,
          ),
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'span',
        'attributes' => array(
          'class' => array(
            $style_box3d,
          ),
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Wordpress_Element_WpImage($this->getContext('image_element')));


  }

}