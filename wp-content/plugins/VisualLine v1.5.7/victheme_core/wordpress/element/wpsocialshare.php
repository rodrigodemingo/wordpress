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
class VTCore_Wordpress_Element_WpSocialShare
extends VTCore_Html_List {

  protected $context = array(
    'type' => 'ul',
    'size' => 'thumbnail',
    'attributes' => array(
      'class' => array('social-links', 'unstyled', 'inline')
    ),
    'google' => true,
    'linkedin' => true,
    'pinterest' => true,
    'facebook' => true,
    'twitter' => true,
    'renren' => true,
    'weibo' => true,
    'vk' => true,
    'excerpt' => true,

    // Allow user to override urls
    'urls' => array(),

    'icon_attributes' => array(),
    'list_elements' => array(
      'type' => 'li',
      'attributes' => array(),
    ),
    'link_elements' => array(
      'type' => 'a',
      'attributes' => array(
        'target' => '_blank',
      ),
    )

  );

  private $queries = array();
  private $post_id = '';
  private $media = '';
  private $registered = array(
    'google',
    'linkedin',
    'pinterest',
    'facebook',
    'twitter',
    'renren',
    'weibo',
    'vk',
  );


  /**
   * Formatting queries for SocialShare class usage.
   */
  private function buildQueries() {
    $this->post_id = get_the_ID();

    $this->queries['url'] = urlencode(get_permalink($this->post_id));

    if ($this->getContext('excerpt')) {
      $this->queries['description'] = get_the_excerpt();
    }
    else {
      $this->queries['description'] = get_the_title();
    }

    $this->media = get_attached_media('images', $this->post_id);

    // Try other attached media
    $arguments = array_pop($this->media);
    if (is_object($arguments)) {
      $arguments = $arguments->ID;
    }

    // Fallback to thumbnail
    if (empty($arguments)) {
      $arguments = get_post_thumbnail_id($this->post_id);
    }

    if (!empty($arguments)) {
      $image = wp_get_attachment_image_src($arguments);
      $this->queries['media'] = $image[0];
    }

    $this->queries = array_filter($this->queries);

  }




  /**
   * Use this method to retrieve of what kind of
   * social network that this class support.
   */
  public function getRegisteredSocial() {
    return $this->registered;
  }





  /**
   * Build the list element containing icons
   * @see VTCore_Html_List::buildElement()
   */
  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    $this->buildQueries();

    foreach ($this->getRegisteredSocial() as $type) {
      if ($this->getContext($type)) {

        $context = $this->getContext('link_elements');
        $context['queries'] = $this->queries;
        $context['icon_attributes'] = $this->getContext('icon_attributes');
        $context['attributes']['class']['social'] = 'social-' . $type;

        if ($this->getContext('urls.' . $type)) {
          $context['attributes']['href'] = $this->getContext('urls.' . $type);
        }

        $name = 'VTCore_SocialShare_' . ucfirst($type);
        $this->addContent(new $name($context));
        $this->lastChild()->addClass('social-icon');
      }
    }
  }
}