<?php
/**
 * Building a list of social share links
 * with font awesome icon
 *
 * To style the icons via this class you can
 * define the icon_attributes context and
 * follow the fontawesome class context rules.
 *
 * for styling the ul and list element, you can
 * define the attributes and list_attributes
 * following the VTCore_Html_List context rules.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Element_WpSocialIcon
extends VTCore_Html_List {

  protected $context = array(
    'type' => 'ul',
    'size' => 'thumbnail',
    'attributes' => array(
      'class' => array(
        'social-links',
        'unstyled',
        'inline',
      ),
    ),

    'social' => array(),
    'icon_attributes' => array(),
    'link_attributes' => array(),
    'list_elements' => array(
      'type' => 'li',
      'attributes' => array(),
    ),
  );



  /**
   * Build the list element containing icons
   * @see VTCore_Html_List::buildElement()
   */
  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    $socials = $this->getContext('social');

    if (is_array($socials)) {
      foreach ($socials as $social) {
        $this->addContext('object', $social);

        // Broken social context skip!
        if (!$this->getContext('object.icon') || !$this->getContext('object.href')) {
          continue;
        }

        if (!$this->getContext('object.target')) {
          $this->addContext('object.target', '_self');
        }

        $this
          ->addContext('icon_attributes.icon', $this->getContext('object.icon'))
          ->addContext('link_attributes.attributes.href', $this->getContext('object.href'))
          ->addContext('link_attributes.attributes.target', $this->getContext('object.target'))
          ->addContext('link_attributes.children.0', new VTCore_Fontawesome_faIcon($this->getContext('icon_attributes')))
          ->addContent(new VTCore_Html_HyperLink($this->getContext('link_attributes')));
      }
    }
  }
}