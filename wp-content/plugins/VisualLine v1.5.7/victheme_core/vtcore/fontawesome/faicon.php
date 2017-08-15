<?php
/**
 * Helper class for building Fontawesome icon with extra wrapper
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Fontawesome_faIcon
extends VTCore_Fontawesome_Base {

  protected $context = array(
    'type' => 'div',
    'icon' => false,
    'spin' => false,
    'border' => false,
    'size' => false,
    'rotate' => false,
    'flip' => false,
    'shape' => false,
    'position' => false,
    'color' => false,
    'border-color' => false,
    'background' => false,
    'margin' => false,
    'padding' => false,
    'font' => false,
    'class' => array(),
    'attributes' => array(
      'class' => array(
        'faplus',
        'clearfix',
      ),
    ),
  );

  private $container;
  private $icon;

  /**
   * Building the attributes for the span wrapper
   */
  private function buildContainer() {

    $this
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'span',
        'attributes' => array(
          'class' => array('fa'),
        ),
      )));

    $this->container = $this->lastChild();

    if ($this->getContext('border')) {
      $this->container->addClass('fa-border');
    }

    if ($this->getContext('color')) {
      $this->container->addStyle('color', $this->getContext('color'));
    }

    if ($this->getContext('background')) {
      $this->container->addStyle('background', $this->getContext('background'));
    }

    if ($this->getContext('border-color')) {
      $this->container->addStyle('border-color', $this->getContext('border-color'));
    }

    if ($this->getContext('border-width')) {
      $this->container->addStyle('border-width', $this->getContext('border-width'));
    }

    if ($this->getContext('border-radius')) {
      $this->container->addStyle('border-radius', $this->getContext('border-radius'));
    }

    if ($this->getContext('shape')) {
      $this->container->addClass('faplus-shape-' . $this->getContext('shape'));
    }

    if ($this->getContext('padding')) {
      $this->container->addStyle('padding', $this->getContext('padding'));
    }

    if ($this->getContext('width')) {
      $this->container->addStyle('width', $this->getContext('width'));
    }

    if ($this->getContext('height')) {
      $this->container->addStyle('height', $this->getContext('height'));
    }

    return $this;

  }

  /**
   * Building the attributes for the main wrapper
   */
  private function buildWrapper() {

    $this->addClass('fa');

    if (isset($attributes['class'])) {
      $class = explode(' ', $attributes['class']);
    }

    foreach ($this->getContext('class') as $class) {
      $this->addClass($class);
    }

    if ($this->getContext('size')) {
      $this->addClass('fa-' . $this->getContext('size'));
    }

    if ($this->getContext('position')) {
      $this->addClass($this->getContext('position'));
    }

    if ($this->getContext('font')) {
      $this->addStyle('font-size', $this->getContext('font'));
      $this->addStyle('line-height', $this->getContext('font'));
    }

    if ($this->getContext('margin')) {
      $this->addStyle('margin', $this->getContext('margin'));
    }

    return $this;
  }

  /**
   * Building the i element attributes
   */
  private function buildIcon() {

    $this->container->addChildren(new VTCore_Html_Element(array(
      'type' => 'i',
      'attributes' => array(
        'class' => array('fa'),
      ),
    )));

    $this->icon = $this->container->lastChild();


    if ($this->getContext('icon')) {
      $this->icon->addClass('fa-' . $this->getContext('icon'));
    }

    if ($this->getContext('spin')) {
      $this->addClass('fa-spin');
    }

    if ($this->getContext('rotate')) {
      $this->addClass('fa-rotate-'. $this->getContext('rotate'));
    }

    if ($this->getContext('flip')) {
      $this->addClass('fa-flip-'. $this->getContext('flip'));
    }

    return $this;
  }


  public function buildElement() {

    // Load the fontawesome font CSS
    VTCore_Wordpress_Utility::loadAsset('font-awesome');

    $this
      ->addAttributes($this->getContext('attributes'))
      ->buildWrapper()
      ->buildContainer()
      ->buildIcon();

    return $this;
  }
}