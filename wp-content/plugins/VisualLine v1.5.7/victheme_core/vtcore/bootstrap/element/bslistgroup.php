<?php
/**
 * Class for building the Bootstrap Listgroup element.
 *
 * This class is capable for building Bootstrap List Group
 * element and all of its possible options.
 *
 * Context variable :
 * active    : set the list item delta to get the active class the delta
 *             must match the deltas in the contents array key.
 * mode      : ul|div Bootstrap list group support ul + li or div + a
 *             set it here to switch
 *
 * contents  : array of context as specified in the VTCore_Bootstrap_Element_BsListObject().
 * - mode    : success|warning|info|danger
 * - badge   : badge text
 * - heading : heading text
 * - contents: array of contents or content string text
 * - href    : href for the element
 * - text    : text for simple list mode
 *
 * @author jason.xie@victheme.com
 * @method BsListGroup($context)
 */
class VTCore_Bootstrap_Element_BsListGroup
extends VTCore_Html_List {

  protected $context = array(
    'type' => 'ul',

    // Custom settings
    'active' => '1',
    'mode' => 'ul',

    // Array of contents
    'contents' => array(),

    'attributes' => array(
      'class' => array(
        'list-group',
      ),
    ),

  );

  /**
   * Overriding parent method
   * @see VTCore_Html_List::addContent()
   */
  public function addContent($object) {
    $this->addChildren($object);

    return $this;
  }


  /**
   * Overriding parent method
   * @see VTCore_Html_List::prependContent()
   */
  public function prependContent($object) {
    $this->prependChild($object);

    return $this;
  }


  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    $this->setType($this->getContext('mode'));

    foreach ($this->getContext('contents') as $delta => $context) {
      $object = new VTCore_Bootstrap_Element_BsListObject($context);

      if ($this->getContext('active') == $delta) {
        $object->addClass('active');
      }

      if ($this->getContext('mode') == 'div') {
        $object->setType('a');
      }

      $this->addContent($object);
    }
  }
}