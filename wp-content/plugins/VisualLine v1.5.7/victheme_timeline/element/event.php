<?php
/**
 * Building CSS only time line event
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Timeline_Element_Event
extends VTCore_Timeline_Models_Event {

  protected $context = array(
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'timeline-events',
      ),
    ),
    'classtype' => 'event',
    'datetime' => '',
    'day' => '',
    'month' => '',
    'year' => '',
    'date' => '',
    'icon' => '',
    'text' => '',
    'content' => '',
    'direction' => 'left',
    'image' => '',
    'size' => '',
    'style' => '',

    'image_element' => array(
      'attributes' => array(
        'class' => array('timeline-image'),
      ),
    ),
  );

  protected $content;

  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    $this
      ->addChildren(new VTCore_Html_Time(array(
        'attributes' => array(
          'datetime' => $this->getContext('datetime'),
          'class' => array(
            'timeline-time',
            'clearfix'
          ),
        ),
      )));

    if ($this->getContext('date')) {
      $this
        ->lastChild()
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'span',
          'text' => $this->getContext('date'),
          'attributes' => array(
            'class' => array('timeline-date'),
          ),
        )));
    }

    if ($this->getContext('day')) {
      $this
        ->lastChild()
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'span',
          'text' => $this->getContext('day'),
          'attributes' => array(
            'class' => array(
              'timeline-day'
            ),
          ),
        )));
    }

    if ($this->getContext('month')) {
      $this
        ->lastChild()
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'span',
          'text' => $this->getContext('month'),
          'attributes' => array(
            'class' => array(
              'timeline-month'
            ),
          ),
        )));
    }

    if ($this->getContext('year')) {
      $this
        ->lastChild()
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'span',
          'text' => $this->getContext('year'),
          'attributes' => array(
            'class' => array(
              'timeline-year'
            ),
          ),
        )));
    }

    if ($this->getContext('icon')) {
      $this
        ->addChildren(new VTCore_Fontawesome_faIcon(array(
          'icon' => $this->getContext('icon'),
          'shape' => 'circle',
          'attributes' => array(
            'class' => array(
              'timeline-icon'
            ),
          ),
          'data' => array(
            'timeline' => 'icon'
          ),
        )));
    }

    if ($this->getContext('image')) {

      if ($this->getContext('size')) {
        $size = explode('x', $this->getContext('size'));
        if (isset($size[0])) {
          $width = $size[0];
        }

        if (isset($size[1])) {
          $height = $size[1];
        }

        if (isset($width) && is_numeric($width)
          && isset($height) && is_numeric($height)) {
          $this->addContext('size', array($width, $height));
        }

        $this->addContext('image_element.size', $this->getContext('size'));
      }

      $styleClass = array();
      $style_box3d = '';
      if ($this->getContext('style')) {
        $style = $this->getContext('style');
        if (strpos($style, '_circle_2') !== false || $style == 'diamond') {
          $this->addContext('image_element.force.square', true);
          $style = str_replace('_circle_2', '_circle', $style);
        }

        $styleClass = array(
          'wrapper' => 'vc_single_image-wrapper',
          'style' => $style,
        );

        $style_box3d = '';
        if ($style == 'vc_box_shadow_3d') {
          $style_box3d = 'vc_box_shadow_3d_wrap';
        }

        if ($this->getContext('border_color')) {
          $styleClass['border'] = ' vc_box_border_' . $this->getContext('border_color');
        }
      }

      $this->addContext('image_element.attachment_id', $this->getContext('image'));

      $image = new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'wpb_single_image'
          )
        )
      ));

      $image
        ->Element(array(
          'type' => 'div',
          'attributes' => array(
            'class' => $styleClass,
          ),
        ))
        ->lastChild()
        ->Element(array(
          'type' => 'span',
          'attributes' => array(
            'class' => array(
              $style_box3d,
            ),
          ),
        ))
        ->lastChild()
        ->addChildren(new VTCore_Wordpress_Element_WpImage($this->getContext('image_element')));

      $this->addChildren($image);

      unset($image);
      $image = null;
    }

    if ($this->getContext('text')) {
      $this
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'h2',
          'text' => $this->getContext('text'),
          'attributes' => array(
            'class' => array('timeline-title'),
          ),
        )));
    }

    $this->content = $this->addChildren(new VTCore_Html_Element(array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('timeline-content'),
      ),
    )))
      ->lastChild();

    if ($this->getContext('content')) {
      $this->content
        ->addChildren(new VTCore_Html_Element(array(
          'type' => 'div',
          'text' => $this->getContext('content'),
          'raw' => true,
        )));
    }

    // Reverse the content
    $this->addData('timeline-content', 'normal');

    if ($this->getContext('direction') == 'bottom') {
      $this->content
        ->setChildren(array_reverse($this->content->getChildrens(), true));
      $this->setChildren(array_reverse($this->getChildrens(), true));
      $this->addData('timeline-content', 'inversed');
    }

    // After initialization, all content
    // must be injected to inner div
    $this->setChildrenPointer('content');


  }
}