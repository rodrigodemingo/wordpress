<?php
/**
 * Class for building the Bootstrap Tabs element.
 *
 * To use this class properly, the main object should
 * be VTCore_Bootstrap_Form_Base or VTCore_Bootstrap_Form_Instance or
 * VTCore_Bootstrap_Element_Base
 *
 * Shotcut overloading method "BsTabs($context)" will be available
 * for use if the parent object is either VTCore_Bootstrap_Form_Instance
 * or VTCore_Bootstrap_Form_Base or VTCore_Bootstrap_Element_Base.
 *
 * @author jason.xie@victheme.com
 * @method BsTabs($context)
 */
class VTCore_Bootstrap_Element_BsTabs
extends VTCore_Bootstrap_Element_Base {

  protected $context = array(
    'type' => 'div',
    'prefix' => 'tabs',
    'attributes' => array(
      'id' => '',
      'class' => array(
        'tabs-wrapper',
      ),
    ),
    'contents' => array(),
    'active' => 0,

    'ul_elements' => array(
      'attributes' => array(
        'class' => array(
          'nav',
          'nav-tabs'
        ),
      ),
    ),

    'link_elements' => array(
      'attributes' => array(
        'data-toggle' => 'tab',
      ),
    ),

    'tabs_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'tab-content',
          'clearfix',
        ),
      ),
    ),

    'tabcontent_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'tab-pane',
          'fade',
        ),
      ),
    ),
  );

  protected $unique = '';
  protected $header;
  protected $content;

  private $activeDelta = 0;

  public function getDelta() {
    return $this->activeDelta;
  }


  public function setDelta() {
    $this->activeDelta++;
  }


  public function buildHeaderWrapper() {
    $link = new VTCore_Html_HyperLink($this->getContext('link_elements'));
    $link
      ->addAttribute('href', '#' . $this->unique . '-' . $this->getDelta());

    return $link;
  }


  public function buildChildWrapper() {
    $element =  new VTCore_Html_Element($this->getContext('tabcontent_elements'));
    $element
      ->addAttribute('id', $this->unique . '-' . $this->getDelta());

    return $element;
  }


  public function addHeader($object) {
    $this->header->addContent($this->buildHeaderWrapper()->addChildren($object));
    return $this;
  }


  public function prependHeader($object) {
    $this->header->prependContent($this->buildHeaderWrapper()->addChildren($object));
    return $this;
  }


  public function prependContent($object) {
    $this->content->prependChild($this->buildChildWrapper()->addChildren($object));
    return $this;
  }


  public function addContent($object) {
    $this->content->addChildren($this->buildChildWrapper()->addChildren($object));
    return $this;
  }


  public function getContentKey($delta) {
    $childrens = $this->content->getChildrens();
    $keys = array_keys($childrens);
    return (isset($keys[$delta])) ? $keys[$delta] : NULL;
  }

  public function getHeaderKey($delta) {
    $childrens = $this->header->getChildrens();
    $keys = array_keys($childrens);
    return (isset($keys[$delta])) ? $keys[$delta] : NULL;
  }


  public function setActiveTabs() {

    for ($i=0;$i<=$this->getDelta();$i++) {

      $content = $this->content->getChildren($this->getContentKey($i));
      $header = $this->header->getChildren($this->getHeaderKey($i));

      if ($content == NULL || $header == NULL) {
        continue;
      }

      if ($i == $this->getContext('active')) {
        $content->addClass('in active');
        $header->addClass('active');
      }
      else {
        $content->removeClass('in active');
        $header->removeClass('active');
      }
    }
  }


  public function buildElement() {

    $uid = new VTCore_Uid();
    $this->addAttributes($this->getContext('attributes'));
    $this->unique = $this->getContext('prefix') . '-' . $uid->getID();

    // Set children, don't use the addChildren method
    // because it is overriden to allow user to inject
    // directly to tabs_elements children
    $this->setChildren(array(
      'header-element' => new VTCore_Html_List($this->getContext('ul_elements')),
      'content-element' => new VTCore_Bootstrap_Element_BsElement($this->getContext('tabs_elements')),
    ));

    $this->header = $this->getChildren('header-element');
    $this->content = $this->getChildren('content-element');

    $this->header->addAttribute('id', 'list-' . $this->unique);

    if ($this->getContext('contents')) {
      foreach ($this->getContext('contents') as $data) {
        $this->addHeader($data['title']);
        $this->addContent($data['content']);
        $this->setDelta();
      }
    }

    $this->setActiveTabs();
  }

}