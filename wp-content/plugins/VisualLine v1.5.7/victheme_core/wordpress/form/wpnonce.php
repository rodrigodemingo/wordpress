<?php
/**
 * Helper Class for building the Wordpress Nonce field Elements
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Html_Form interface
 */
class VTCore_Wordpress_Form_WpNonce
extends VTCore_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'type' => 'input',
    'action' => 'form_nonce',
    'attributes' => array(
      'type' => 'hidden',
      'name' => '_nonce',
      'value' => '',
    ),
  );

  private $nonce = '';

  private function setNonce() {
    $this->nonce = wp_create_nonce($this->getContext('action'));
    $this->setValue($this->getNonce());
  }


  public function getNonce() {
    return $this->nonce;
  }

  public function buildElement() {
      $this->addAttributes($this->getContext('attributes'));
      $this->setNonce();
  }
}