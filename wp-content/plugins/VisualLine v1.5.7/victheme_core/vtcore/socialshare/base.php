<?php
/**
 * Base class for social share icons
 *
 * @author jason.xie@victeme.com
 *
 */
class VTCore_SocialShare_Base
extends VTCore_Html_Base {

  /**
   * Merging the queries into a valid url
   */
  protected function buildQueries() {
    $this->addAttribute('href', $this->getAttribute('href') . '?' . $this->getContext('querykey') . '=' . $this->getContext('queries.url'));
  }


  /**
   * Overriding base html buildElement()
   *
   * The social icon is generic enough to have common
   * build element function. If a social icon has custom
   * different build scheme, it can override this method
   *
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    parent::buildElement();
    
    $this->buildQueries();
    $this->addChildren(new VTCore_Fontawesome_faIcon($this->getContext('icon_attributes')));

    if ($this->getContext('text')) {
      $this->addChildren($this->getContext('text'));
    }
  }
}