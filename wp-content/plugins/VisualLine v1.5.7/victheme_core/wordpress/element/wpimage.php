<?php
/**
 * VTCore Extension for building Wordpress
 * image attachment.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Element_WpImage
  extends VTCore_Html_Image {

  protected $context = array(
    'type' => 'img',
    'size' => 'thumbnail',
    'attachment_id' => false,
    'attributes' => array(
      'src' => '',
      'alt' => '',
      'width' => '',
      'height' => '',
      'ismap' => false,
      'usemap' => false,
    ),
    'lazysizes' => false,
    'responsive' => true,
    'crop' => true,
    'force' => array(
      'square' => false,
    ),
  );

  protected $src;
  protected $width;
  protected $height;
  protected $type;
  protected $attr;
  protected $resize = false;
  static protected $responsiveEligible = null;


  /**
   * Force fixed size
   */
  protected function maybeForceSize() {

    // Force image to square
    if ($this->getContext('force.square')
      && $this->width != $this->height) {

      if ($this->width > $this->height) {
        $this->width = $this->height;
      }
      else {
        $this->height = $this->width;
      }

      $this->resize = true;
    }

    if ($this->getContext('attachment_id') && $this->resize) {
      $this->addContext('resized', VTCore_Wordpress_Utility::wpResizeImage(
        VTCore_Wordpress_Utility::wpGetAttachmentOriginalImagePath($this->getContext('attachment_id')),
        $this->width,
        $this->height,
        $this->getContext('crop'),
        $this->width . 'x' . $this->height));

      if ($this->getContext('resized.url')) {
        $this->src = $this->getContext('resized.url');
      }
    }

    return $this;
  }


  /**
   * Try to detect if user provides custom attachment size
   * like 100x100.
   *
   * @return $this
   */
  protected function maybeCustomSize() {
    $size = $this->getContext('size');
    if (is_string($size)) {
      $maybeCustom = explode('x', $size);
      if (isset($maybeCustom[0])
        && isset($maybeCustom[1])
        && is_numeric($maybeCustom[0])
        && is_numeric($maybeCustom[1])) {

        $this->width = $maybeCustom[0];
        $this->height = $maybeCustom[1];

        $this->resize = TRUE;
      }
    }

    return $this;
  }


  /**
   * Overriding parent method
   * @see VTCore_Html_Base::buildElement
   */
  public function buildElement() {

    if (self::$responsiveEligible === null) {
      self::$responsiveEligible = function_exists('wp_calculate_image_srcset');
    }

    $this
      ->addAttributes($this->getContext('attributes'));

    if ($this->getContext('responsive') === 'none') {
      $this->addContext('responsive', false);
    }

    if ($this->getContext('attachment_id')) {

      list($this->src, $this->width, $this->height) = wp_get_attachment_image_src($this->getContext('attachment_id'), $this->getContext('size'));
      $this
        ->maybeCustomSize()
        ->maybeForceSize();

      // Build srcsets!
      if ($this->getContext('responsive') && self::$responsiveEligible) {
        $image_meta = get_post_meta((int) $this->getContext('attachment_id'), '_wp_attachment_metadata', TRUE);
        $size_array = array(absint($this->width), absint($this->height));
        $attr = $this->getContext('attributes');
        $attachment = get_post($this->getContext('attachment_id'));

        if ($srcset = wp_calculate_image_srcset($size_array, $this->src, $image_meta, $this->getContext('attachment_id'))) {
          $attr['srcset'] = $srcset;
        }

        if ($sizes = wp_calculate_image_sizes($size_array, $this->src, $image_meta, $this->getContext('attachment_id'))) {
          $attr['sizes'] = $sizes;
        }

        $attr = apply_filters('wp_get_attachment_image_attributes', $attr, $attachment, $this->getContext('size'));
        $this->addAttributes($attr);
      }

      $this->addAttribute('src', $this->src);

      if (!empty($this->width)) {
        $this->addAttribute('width', $this->width);
      }

      if (!empty($this->height)) {
        $this->addAttribute('height', $this->height);
      }
    }

    elseif ($this->getAttribute('src')) {

      $image = @file_get_contents($this->getAttribute('src'));
      if ($image) {

        $im = imagecreatefromstring($image);
        if ($im !== FALSE) {

          $this->width = imagesx($im);
          $this->height = imagesy($im);
          imagedestroy($im);

          if (!empty($this->width)) {
            $this->addAttribute('width', $this->width);
          }

          if (!empty($this->height)) {
            $this->addAttribute('height', $this->height);
          };
        }
      }

      // Build retina support manually
      if ($this->getContext('responsive')) {
        $path = pathinfo($this->getAttribute('src'));
        $retina = str_replace($path['filename'], $path['filename'] . '@2x', $this->getAttribute('src'));

        if (@file_exists($retina)) {
          $this->addAttribute('srcset', $retina . ' 2x');
        }
      }
    }

    if ($this->getAttribute('alt') == '') {
      $this->addAttribute('alt', basename($this->src));
    }

    if ($this->getContext('lazysizes') && $this->getContext('responsive')) {

      VTCore_Wordpress_Utility::loadAsset('js-lazysizes');

      $this->addClass('lazyload');

      if ($this->getAttribute('sizes')) {
        // Let js decide the right size
        $this->addData('sizes', 'auto');
        $this->removeAttribute('sizes');
      }

      if ($this->getAttribute('src')) {
        $this->addData('src', $this->getAttribute('src'));
        $this->removeAttribute('src');
      }

      if ($this->getAttribute('srcset')) {
        $this->addData('srcset', $this->getAttribute('srcset'));
        $this->removeAttribute('srcset');
      }
    }

    // Clean if not responsive
    if (!$this->getContext('responsive')) {
      $this->removeAttribute('srcset');
      $this->removeAttribute('sources');
    }
  }
}