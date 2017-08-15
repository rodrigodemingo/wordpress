<?php
/**
 * Helper class for building HTML head element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Head
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'head',
    'meta' => array(),
    'title' => false,
    'script' => array(),
    'link' => array(),
  );

  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    // Build Title
    $this->addChildren(new VTCore_Html_Title($this->getContext('title')));

    // Build Metas
    foreach ($this->getContext('meta') as $context) {
      $this->addChildren(new VTCore_Html_Meta($context));
    }

    // Build Links
    foreach ($this->getContext('link') as $context) {
      $this->addChildren(new VTCore_Html_Link($context));
    }

    // Build Scripts
    foreach ($this->getContext('script') as $context) {
      $this->addChildren(new VTCore_Html_Script($context));
    }

  }
}