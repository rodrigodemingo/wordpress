<?php
/**
 * Helper class for building HTML5 Track element
 * for Video and Audio element
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Track
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'track',
    'attributes' => array(
      'src' => '',
      'label' => '',
      'kind' => '',
      'srclang' => '',
      'default' => false,
    ),
  );
}