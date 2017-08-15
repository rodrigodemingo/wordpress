<?php
/**
 * CSSBuilder Rules object for defining css position rules.
 * 
 * Just extending the Rules Abstract as each keys
 * can be built using the abstract class

 * Available keys :
 * position
 * top
 * left
 * bottom
 * right
 * 
 * @author jason.xie@victheme.com
 *
 */
class VTCore_CSSBuilder_Rules_Position
extends VTCore_CSSBuilder_Rules_Abstract {
  
  protected $type = 'position';
  
}