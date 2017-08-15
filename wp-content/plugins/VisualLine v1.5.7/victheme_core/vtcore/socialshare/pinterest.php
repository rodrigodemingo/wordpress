<?php
/**
 * Class for building Pinterest Share icon 
 * button.
 * 
 * User must provide the queries context
 * especially one with url as its key that
 * defines the actual share url to be given
 * to pinterest.
 *       
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SocialShare_Pinterest
extends VTCore_SocialShare_Base {

  protected $context = array(
    'type' => 'a',
    'text' => '',
    'queries' => array(),
    'queryKey' => 'url',
    'attributes' => array(
      'href' => 'http://www.pinterest.com/pin/create/button',
    ),
    
    'icon_attributes' => array(
      'type' => 'div',
      'icon' => 'pinterest',
      'shape' => 'round',
      'background' => '',
      'color' => '',
      'position' => 'left',
      'margin' => '0 10px 0 0',    
    ),
  );

  /**
   * Overriding parent method
   * @see VTCore_SocialShare_Base::buildQueries()
   */
  protected function buildQueries() {
    
    $query = array($this->getContext('querykey') . '=' . $this->getContext('queries.url'));
    
    if ($this->getContext('queries.media')) {
      $query[] = 'media=' . $this->getContext('queries.media');
    }
    
    if ($this->getContext('queries.description')) {
      $query[] = 'description=' . $this->getContext('queries.description');
    }
    
    $href = $this->getContext('attributes.href') . '?' . implode('&', $query);
    $this->addAttribute('href', $href);
  }

}