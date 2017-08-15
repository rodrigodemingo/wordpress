<?php
/**
 * Helper class for building WP Media Uploader
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_WpMedia
extends VTCore_Wordpress_Form_Base {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'name' => '',
    'value' => '',
    'description' => false,
    'button' => true,
    'media_source' => '',
    'data' => array(
      'type' => 'image',
      'autoplay' => false,
      'input' => false,
      'multiple' => false,
      'preview' => true,
      'mode' => 'id',
      'placeholder' => false,
    ),
    'attributes' => array(
      'class' => array(
        'form-wpmedia',
        'input-group',
      ),
    ),
    'media_settings' => array(),
  );

  protected $id;
  protected $preview;
  protected $content;
  protected $metadata;





  /**
   * Build media preview element.
   * Valid media type are Image, Video and Audio.
   *
   * This function will attempt to convert WordPress
   * attachment id into valid url or inject valid url
   * directly into the element object.
   *
   * @param string $type the media type to build.
   */
  private function buildPreview($type) {

    if (is_numeric($this->getContext('value'))) {
      $context['attributes']['src'] = wp_get_attachment_url($this->getContext('value'));

      $this->metadata = wp_get_attachment_metadata($this->getContext('value'));

      if (isset($this->metadata['poster']) && !empty($this->metadata['poster'])) {
        $context['attributes']['poster'] = $this->imageResize($this->metadata['poster']);
      }
    }

    elseif (filter_var($this->getContext('value'), FILTER_VALIDATE_URL) !== FALSE) {
      $context['attributes']['src'] = $this->getContext('value');
    }
    else {
      $this->preview->addClass('wpmedia-preview-empty');
      return;
    }

    switch ($type) {

      case 'image' :

        $this
          ->preview
          ->addChildren(new VTCore_Html_Image($context));

        break;

      case 'video' :

        $context['attributes']['controls'] = true;
        $context['attributes']['preload'] = 'none';

        $this
          ->preview
          ->addChildren(new VTCore_Html_Video($context));

        break;


      case 'audio' :

        $context['attributes']['controls'] = true;
        $context['attributes']['preload'] = 'none';

        $this
          ->preview
          ->addChildren(new VTCore_Html_Audio($context));

        break;

    }

    $this->addContext('media_source', $context['attributes']['src']);

  }


  /**
   * Method for forcing the thumbnail poster image
   * not larger than 300px due to slow loading for
   * very large image combined with base64 encoded image.
   *
   * @param $string
   * @return string
   */
  private function imageResize($string) {

    $src = imagecreatefromstring(base64_decode(preg_replace('#^data:image/[^;]+;base64,#', '',$string)));

    if ($src != FALSE) {
      $size = 300;
      $width = imagesx($src);
      $height = imagesy($src);
      $aspect_ratio = $height / $width;

      $new_w = $size;
      $new_h = abs($new_w * $aspect_ratio);

      if ($width <= $size) {
        $new_w = $width;
        $new_h = $height;
      }

      $img = imagecreatetruecolor($new_w, $new_h);
      imagecopyresized($img, $src, 0, 0, 0, 0, $new_w, $new_h, $width, $height);

      // determine image type and send it to the client
      ob_start();
      imagejpeg($img, NULL, 60);
      $data = ob_get_contents();
      ob_end_clean();

      imagedestroy($img);
      imagedestroy($src);

      $string = 'data:image/jpg;base64,' . base64_encode($data);

    }

    return $string;
  }


  /**
   * Overriding HTML object build element to build the
   * special element for WP Media Form
   *
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    wp_enqueue_media($this->getContext('media-settings'));
    VTCore_Wordpress_Utility::loadAsset('wp-media');

    $this->id = 'wp-media-' . $this->getMachineID();
    $this->addAttributes($this->getContext('attributes'));

    $this->addChildren(new VTCore_Html_Element(array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('wp-media-wrapper'),
      ),
    )));

    $this->content = $this->lastChild();
    $this->setChildrenPointer('content');

    $datas = $this->getContext('data');

    foreach ($datas as $key => $data) {
      $this->addAttribute('data-media-' . $key, $data);
    }

    if ($this->getContext('text')) {
      $this
        ->addChildren(new VTCore_Form_Label(array(
          'text' => $this->getContext('text'),
          'attributes' => array(
            'for' => 'wp-media-' . $this->getMachineID(),
          ),
        )));
    }

    // Build preview
    if ($this->getData('preview')) {
      $this->preview = $this->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'data-media-type' => 'preview',
        ),
      )))
      ->lastChild();

      $this->buildPreview($datas['type']);
    }


    $fileurl = $this->getContext('media_source');
    $filename = '';
    if (!empty($fileurl)) {
      $filename = basename($fileurl);
    }

    // Build the input element, note that
    // we use special WpMediaInput instead
    // of plain Input element for setValue
    // overriding purpose.
    $this
      ->addChildren(new VTCore_Wordpress_Form_WpMediaInput(array(
        'attributes' => array(
          'id' => 'wp-media-storage-' . $this->getMachineID(),
          'name' => $this->getContext('name'),
          'value' => $this->getContext('value'),
          'data-media-type' => 'storage',
          'data-media-url' => $fileurl,
          'data-media-filename' => $filename,
          'data-media-filetype' => $this->getContext('data.type'),
          'placeholder' => $datas['placeholder'],
          'class' => array(
            'form-control',
            ($datas['input'] == false) ? 'hidden' : 'show',
          ),
        ),
      )));


    if ($this->getContext('description')) {
      $this
        ->addChildren(new VTCore_Bootstrap_Form_BsDescription(array(
          'text' => $this->getContext('description'),
        )));
    }

    if ($this->getContext('button')) {
      $this
        ->addChildren(new VTCore_Bootstrap_Form_BsSuffix())
        ->lastChild()
        ->addChildren(new VTCore_Fontawesome_faIcon(array(
          'icon' => 'plus-square',
          'attributes' => array(
            'data-media-type' => 'add',
          ),
        )))
        ->addChildren(new VTCore_Fontawesome_faIcon(array(
          'icon' => 'minus-square',
          'attributes' => array(
            'data-media-type' => 'remove',
          ),
        )));
    }
  }



  /**
   * This method actually will not be called
   * from the processForm() method directly.
   *
   * Instead it will be chained and called from
   * the child WpMediaInput Object.
   *
   * The purpose is to update the preview box
   * when form value changes.
   *
   * @see VTCore_Form_Base::setValue()
   */
  public function setValue($value) {

    // Set the value to the context
    // This is needed for sane preview building
    // during form submission refreshing page.
    $this->addContext('value', $value);

    // Build the preview element
    $datas = $this->getContext('data');
    if ($datas['preview']) {
      $this->preview->removeClass('wpmedia-preview-empty')->resetChildren();
      $this->buildPreview($datas['type']);

      $children = $this->findChildren('type', 'input');

      foreach ($children as $object) {
        $object->addAttribute('data-media-url', $this->getContext('media_source'));
      }
    }
  }
}