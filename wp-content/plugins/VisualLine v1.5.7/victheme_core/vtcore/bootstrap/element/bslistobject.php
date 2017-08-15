<?php
/**
 * Class for building the Bootstrap List group object element.
 *
 * This class is capable for building Bootstrap List Group
 * children object element and all of its possible options.
 *
 * Context variable :
 * - mode    : success|warning|info|danger
 * - badge   : badge text
 * - heading : heading text
 * - contents: array of contents or content string text
 * - href    : href for the element
 * - text    : text for simple list mode
 *
 *
 * @author jason.xie@victheme.com
 * @method BsListObject($context)
 */
class VTCore_Bootstrap_Element_BsListObject
extends VTCore_Html_List {

  protected $context = array(
    'type' => 'li',

    'mode' => false,
    'badge' => false,
    'heading' => false,
    'active' => false,
    'text' => false,
    'contents' => array(),
    'href' => false,

    'attributes' => array(
      'href' => '#',
      'class' => array(
        'list-group-item',
       ),
    ),


    // Internal use, override when needed
    'badge_elements' => array(),

    'heading_elements' => array(
      'type' => 'h4',
      'attributes' => array(
        'class' => array(
          'list-group-item-heading',
        ),
      ),
    ),

    'content_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'list-group-item-text',
        ),
      ),
    ),
  );


  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('href')) {
      $this->addAttribute('href', $this->getContext('href'));
    }

    if ($this->getContext('type') == 'li') {
      $this->removeAttribute('href');
    }

    if ($this->getContext('mode')) {
      $this->addClass('list-group-item-' . $this->getContext('mode'));
    }

    if ($this->getContext('active')) {
      $this->addClass('active');
    }

    if ($this->getContext('badge')) {
      $this
        ->addChildren(new VTCore_Bootstrap_Element_BsBadge($this->getContext('badge_elements')))
        ->lastChild()
        ->addChildren($this->getContext('badge'));
    }

    if ($this->getContext('text')) {
      $this->addText($this->getContext('text'));
    }

    if ($this->getContext('heading')) {
      $this
        ->addChildren(new VTCore_Html_Element($this->getContext('heading_elements')))
        ->lastChild()
        ->addChildren($this->getContext('heading'));
    }

    $contents = $this->getContext('contents');

    if (!is_array($contents)) {
      $contents = (array) $contents;
    }

    if (!empty($contents)) {

      foreach ($contents as $content) {
        $this
          ->addChildren(new VTCore_Html_Element($this->getContext('content_elements')))
          ->lastChild()
          ->addChildren($content);
      }
    }
  }
}