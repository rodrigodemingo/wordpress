<?php
/**
 * VTCore Extension for building the Video
 * attachment easily.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Element_WpVideo
extends VTCore_Html_Video {

  protected $context = array(
    'type' => 'video',
    'cover' => false,
    'poster' => false,
    'imagecover' => array(
      'attachment_id' => false,
      'size' => false,
    ),
    'attachment_id' => false,
    'attributes' => array(
      'controls' => true,
      'width' => '',
      'height' => '',
      'preload' => 'none',
      'poster' => '',
      'loop' => false,
      'muted'=> false,
      'cover' => '',
    ),
    'videos' => array(),
    'media-element' => true,
    'media-skins' => 'wp-video-shortcode',
    'image_element' => array(),
  );

  protected $metadata = array();


  public function buildElement() {

    parent::buildElement();

    // Auto build media element using wp core asset
    if ($this->getContext('media-element')) {
      wp_enqueue_style( 'wp-mediaelement' );
      wp_enqueue_script( 'wp-mediaelement' );

      $this->addClass($this->getContext('media-skins'));

      if ($this->getAttribute('id') == false) {
        $unique = new VTCore_Uid();
        $this->addAttribute('id', 'video-js-' . $unique->getID());
      }
    }

    // Check if we got automated posters
    if (!$this->getContext('poster')) {
      $this->metadata = wp_get_attachment_metadata($this->getContext('attachment_id'));
    }
    else {
      $this->metadata['poster'] = $this->getContext('poster');
    }

    if (isset($this->metadata['poster']) && !empty($this->metadata['poster'])) {
      $this->addAttribute('poster', $this->metadata['poster']);
    }

    if ($this->getContext('attachment_id')) {

      $src = wp_get_attachment_url($this->getContext('attachment_id'));

      if (!empty($src)) {
        $this
          ->Source(array(
            'attributes' => array(
              'src' => $src,
            ),
          ));
      }

    }

    if ($this->getContext('videos') != array()) {
      foreach ($this->getContext('videos') as $src) {

        if (is_numeric($src)) {
          $src = wp_get_attachment_url($src);
        }

        if (empty($src)) {
          continue;
        }

        $this
          ->Source(array(
            'attributes' => array(
              'src' => $src,
            ),
          ));
      }
    }



    if ($this->getContext('cover')) {
      $this
        ->addOverloaderPrefix('VTCore_Wordpress_Element_')
        ->WpImage($this->getContext('imagecover'));
    }
  }
}