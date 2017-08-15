<?php

die('No direct access allowed');

/**
 * The social share icon is built on top of
 * the VTCore_SocialShare_Base Class, it is designed so
 * user can easily add more icon type into the
 * main build.
 * 
 * Example for addingnew icon :
 * The fake social network data :
 *   Name = Example
 *   sharelinks = http://example.com/share/share.php
 *   query key = url
 *   fontawesome icon = gears
 *   
 * Then need to build a class extending VTCore_SocialShare_Base
 * with name of VTCore_SocialShare_Example
 * 
 * The default class naming is linked to VTCore autoloading
 * mechanism, so if the class file is placed outside the
 * socialshare folder, you will need to load the file manually
 * or create a custom autoloader.
 * 
 * see the following example class
 * 
 * @author jason.xie@victheme.com
 *
 */
class VTCore_SocialShare_Example
extends VTCore_SocialShare_Base {

  // Define the default context for this icon
  protected $context = array(
    
    // Default hyperlink attributes
    'type' => 'a',
    'text' => '',
    'queries' => array(),
    'attributes' => array(
      'href' => 'http://example.com/share/share.php',
    ),

    // Default icon attributes
    'icon_attributes' => array(
      'type' => 'div',
      'icon' => 'gear',
      'shape' => 'round',
      'background' => '',
      'color' => '',
      'position' => 'left',
      'margin' => '0 10px 0 0',
    ),
  );

  // Define the social networking query key
  protected $querykey = 'url';


  /**
   * Override the default buildElement() method if
   * you need to implement custom query for links
   * or custom icon attributes.
   * 
   * Otherwise it is ok to use the default parent
   * method by removing this method extension.
   * 
   * @see VTCore_SocialShare_Base::buildElement()
   */
  public function buildElement() {
    
    // Example for calling parent method
    parent::buildElement();
    
    // Example adding attributes into the context
    // @see VTCore_Html_Base class for more information
    $this->addAttributes($this->getContext('attributes'));
    
    // Calling parent method to build queries
    $this->buildQueries();
    
    // Build the icon and add it as children of the parent
    // link elements.
    $this->faIcon($this->getContext('icon_attributes'));

    // Set any text that user set beside the icon element.
    if ($this->getContext('text')) {
      $this->addChildren($this->getContext('text'));
    }
  }
}






/**
 * Examples for building the social share link buttons
 */

// The easiest way is to use the VTCore_Wordpress_Element_WpSocialShare class
// which is a factory builder class for building the social share element.
$social = new VTCore_Wordpress_Element_WpSocialShare();
$social->render();


// Advanced way of building, by invoking the icon one by one
$example = new VTCore_SocialShare_Example(array(
  ..... some context ....
))
->render();
