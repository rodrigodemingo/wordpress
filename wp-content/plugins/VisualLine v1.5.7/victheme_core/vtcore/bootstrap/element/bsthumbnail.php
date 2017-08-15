<?php
/**
 * Class for building the Bootstrap Thumbnail element.
 *
 * @author jason.xie@victheme.com
 * @method BsThumbnail($context)
 */
class VTCore_Bootstrap_Element_BsThumbnail
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'figure',

    // Shortcut methods
    'image' => false,
    'text' => false,
    'caption' => false,

    'attributes' => array(
      'id' => '',
      'class' => array(
        'thumbnail',
      ),
    ),

    // Use this array if embedding as object
    'contents' => array(),

    'heading_elements' => array(
      'type' => 'h3',
    ),

    'caption_elements' => array(
      'type' => 'p',
    ),

    'content_elements' => array(
      'type' => 'figcaption',
      'attributes' => array(
        'class' => array(
          'caption',
        ),
      ),
    ),

  );

  protected $content = '';

  /**
   * Main Function for building the element
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));;

    $this->content = $this
      ->addChildren(new VTCore_Html_Element($this->getContext('content_elements')))
      ->lastChild();

    $this->setChildrenPointer('content');

    // Build shortcut first
    if ($this->getContext('image')) {
      $image = $this->getContext('image');

      if (is_object($image)) {
        $this->addChildren($image);
      }
      elseif (is_array($image) && isset($image['src'])) {
        $this->addChildren(new VTCore_Html_Image($image));
      }
      elseif (is_string($image)) {
        $context['attributes'] = @getimagesize($image);
        $this->addChildren(new VTCore_Html_Image($context));
      }
    }

    if ($this->getContext('text')) {
      $this
        ->addChildren(new VTCore_Html_Element($this->getContext('heading_elements')))
        ->lastChild()
        ->addText($this->getContext('text'));
    }

    if ($this->getContext('caption')) {
      $this
        ->addChildren(new VTCore_Element_Element($this->getContext('caption_elements')))
        ->lastChild()
        ->addText($this->getContext('caption'));
    }

    // Process direct content injection
    foreach ($this->getContext('contents') as $object) {
      $this->addChildren($object);
    }
  }

}