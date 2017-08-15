<?php
/**
 * Building CSS only time line element
 *
 * Final product markup :
 *
 * <ul class="timeline>
 *   <li class="timeline-major">Some text to mark the major event eg. year</li>
 *   <li class="timeline-events" data-direction="left|right">
 *     <time datetime="YYYY-MM_DDTHH:MM">
 *       <span>Date</span>
 *       <span>Time</span>
 *     </time>
 *
 *     <i class="fa fa-xxx"></i>
 *
 *     <div class="timeline-content">
 *     <h2>Some text for the event title</h2>
 *     <p>Some text for the event description</p>
 *     </div>
 *
 *   </li>
 * </ul>
 *
 *
 * To inject the events via $context['contents'] array example :
 *
 * $context['contents'][] = array(
 *   'major' => string of major headline or valid Html object and it subclasses,
 *   'events' => array(
 *     array(
 *       'datetime' => the datetime attribute for time element,
 *       'time' => the text for the time span,
 *       'date' => the text for the date span,
 *       'icon' => fontawesome font class,
 *       'text' => string of text for event heading,
 *       'content' => string of text for event content,
 *       'direction' => left|right,
 *      ),
 *    ),
 * );
 *
 *
 * This class can be used with building the event manually, example :
 *
 * $timeline = new VTCore_Timeline_Element();
 * $timeline->addStart(array(
 *   'text' => '',
 *   'direction' => 'center',
 * );
 * $timeline->addMajor(array(
 *   'text' => 'Major text',
 *   'direction' => 'center',
 * ));
 * $timeline->addEvent(array(
 *   'datetime' => the datetime attribute for time element,
 *   'time' => the text for the time span,
 *   'date' => the text for the date span,
 *   'icon' => fontawesome font class,
 *   'text' => string of text for event heading,
 *   'content' => string of text for event content,
 *   'direction' => left|right,
 * ));
 * $timeline->addEnd(array(
 *  'text' => 'End',
 *  'direction' => 'center',
 * );
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Timeline_Element_TimeLine
extends VTCore_Html_Element {

  protected $context = array(
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'timeline-main-wrapper',
        'timeline-skin'
      ),
    ),
    'child_elements' => array(
      'type' => 'li',
      'attributes' => array(
        'class' => array(
          'timeline-items',
        ),
      ),
      'data' => array(
        'timeline' => 'items',
      ),
    ),
    'data' => array(
      'align' => 'center',
      'layout' => 'vertical',
      'timeline' => 'wrapper',
    ),
    'events' => array(),
  );


  protected $content;


  /**
   * Shortcut method for adding the start bubble
   * @param $context
   * @return $this
   */
  public function addStart($context) {
    $this->addObject(new VTCore_Timeline_Element_Start($context));
    return $this;
  }


  /**
   * Shortcut method for adding the major bubble element
   * @param $context
   */
  public function addMajor($context) {
    $this->addObject(new VTCore_Timeline_Element_Major($context));
    return $this;
  }


  /**
   * Shortcut method for adding the events row
   * @param $context
   */
  public function addEvent($context) {
    $this->addObject(new VTCore_Timeline_Element_Event($context));
    return $this;
  }

  /**
   * Shortcut method for adding the ending element bubble
   * @param $context
   */
  public function addEnd($context) {
    $this->addObject(new VTCore_Timeline_Element_End($context));
    return $this;
  }


  /**
   * The main method for adding anykind of event type object
   * to the timeline. for easy usage please use the shortcut method
   *
   * Adding Object Children
   * @param array $data array of context as VTCore_Timeline_Event() context
   */
  public function addObject(VTCore_Timeline_Models_Event $object) {

    $this
      ->addChildren(new VTCore_Html_Element($this->getContext('child_elements')))
      ->lastChild()
      ->addChildren($object);

    if ($object->getContext('direction')) {
      $this->lastChild()->addData('direction', $object->getContext('direction'));
    }

    if ($object->getContext('classtype')) {
      $this->lastChild()->addData('type', $object->getContext('classtype'));
    }

    $object = null;
    unset($object);

    return $this;
  }


  /**
   * Overriding base method.
   * Building the actual logic for assembling the objects
   *
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    // Load Assets
    if ($this->getContext('layout') == 'horizontal') {
      VTCore_Wordpress_Utility::loadAsset('jquery-custom-scrollbar');
    }

    VTCore_Wordpress_Utility::loadAsset('timeline-front');
    VTCore_Wordpress_Utility::loadAsset('timeline-skins');


    // Horizontal mode doesn't support alignment
    if ($this->getContext('data.layout') == 'horizontal') {
      $this->removeContext('data.align')->removeData('align');
    }

    $this->addAttributes($this->getContext('attributes'));
    $this->addChildren(new VTCore_Html_Element(array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'timeline-bar',
        ),
      ),
      'data' => array(
        'timeline' => 'bar',
      ),
    )));

    $this->content = $this->addChildren(new VTCore_Html_Element(array(
      'type' => 'ul',
      'attributes' => array(
        'class' => array(
          'timeline',
          'clearfix'
        ),
      ),
      'data' => array(
        'timeline' => 'element',
      ),
    )))
    ->lastChild();

    $this->setChildrenPointer('content');

    foreach ($this->getContext('events') as $object) {

      // Try to convert context into true object
      if (is_array($object) && isset($object['object'])) {
        $context = $object;
        $name = $context['object'];
        unset($context['object']);

        if (class_exists($name, true)) {
          $object = new $name($context);
        }

        unset($context);
        $context = null;
      }

      // Detect via object
      if (is_object($object)
          && (is_a('VTCore_Timeline_Element_End', $object)
          || is_a('VTCore_Timeline_Element_Major', $object)
          || is_a('VTCore_Timeline_Element_Event', $object))) {

        $this->addObject($object);
      }

      // Free Memory
      unset($object);
    }

  }
}