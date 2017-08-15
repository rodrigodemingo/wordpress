<?php
/**
 * Building Client Logo Element that can be
 * wrapped inside slick carousel or just a
 * single element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Element_WpLinkedImage
extends VTCore_Wordpress_Models_Element {

  protected $context = array(
    'type' => 'div',
    'image' => false,
    'href' => false,
    'size' => 'full',
  );


  protected $content;

  /**
   * Overriding base method.
   * Building the actual logic for assembling the objects
   *
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('href')) {
      $this->content = $this->Hyperlink(array(
        'attributes' => array(
          'href' => $this->getContext('href'),
        ),
      ))
      ->lastChild();

      $this->setChildrenPointer('content');
    }

    $this->WpImage(array(
      'attachment_id' => $this->getContext('image'),
      'size' => $this->getContext('size'),
    ));
  }

}