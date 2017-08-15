<?php
/**
 * Class for building the Fotorama
 * jQuery image gallery.
 *
 * The VTCore_Wordpress_Form_WpFotorama
 * output is valid to use with this
 * element context array.
 *
 * @method WpFotorama($context)
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Element_WpFotorama
extends VTCore_Wordpress_Models_Element {

  protected $context = array(
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'fotorama',
      ),
    ),

    'data' => array(

      // Dimensions
      'width' => '',
      'height' => '',
      'ratio' => '',
      'minwidth' => '',
      'maxwidth' => '',
      'minheight' => '',
      'maxheight' => '',
      'margin' => '',
      'glimpse' => '',
      'captions' => true,

      // Animations
      'loop' => true,
      'shuffle' => true,
      'startindex' => '',
      'autoplay' => '',
      'stopautoplayontouch' => true,
      'shadows' => true,
      'transition' => 'slide', // slide | crossfade | disolve
      'clicktransition' => 'crossfade', // slide | crossfade | disolve
      'transitionduration' => '',

      // Key operations
      'keyboard' => true,
      'arrows' => 'true',
      'click' => true,
      'swipe' => true,
      'trackpad' => true,


      // Navigations
      'navposition' => 'bottom', // bottom | top
      'direction' => 'rtl', // rtl || ltr
      'nav' => 'thumbs', // false | thumbs | dot
      'navwidth' => '',

      // Full screens
      'allowfullscreen' => 'false', // false | true | native

      // Thumbnails
      'thumbwidth' => '80px',
      'thumbheight' => '80px',
      'thumbmargin' => '',
      'thumbborderwidth' => '',

      // Image fitting
      'fit' => 'contain', // contain | cover | scaledown | none
      'thumbfit' => 'cover', // contain | cover | scaledown | none

    ),

    'images_attributes' => array(),
    'videos_attributes' => array(
      'media-element' => false,
      'attributes' => array(
        'width' => '100%',
        'height' => '100%',
      ),
    ),


    // Media must be in the format of
    // array('type' => 'video|image', 'attachment_id' => wp_attachment id number, 'poster' => poster image url)
    'values' => array(),

  );


  private $poster;
  private $imageAttributes;
  private $size;


  /**
   * Tell object to convert these
   * array to HTML5 data boolean
   */
  protected $convertBool = array(
    'loop',
    'stopautoplayontouch',
    'keyboard',
    'click',
    'swipe',
    'trackpad',
    'shuffle',
    'shadows',
    'captions',
  );

  /**
   * Helper method for adding media to context
   * @param unknown $media
   */
  public function addMedia($media) {
    $this->context['values'][] = $media;
  }



  /**
   * Overriding parent method
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    VTCore_Wordpress_Utility::loadAsset('wp-fotorama');

    parent::buildElement();

    foreach ($this->getContext('values') as $media) {
      if (!isset($media['type']) || !isset($media['attachment_id'])) {
        continue;
      }

      // Convert poster to actual image url
      if (isset($media['poster'])
          && !empty($media['poster'])
          && is_numeric($media['poster'])) {

        $this->imageAttributes = $this->getContext('imagesAttributes');

        $this->size = 'full';
        if (isset($this->imageAttributes['size'])) {
          $this->size = $this->imageAttributes['size'];
        }

        $this->poster = new VTCore_Wordpress_Element_WpImage(array(
          'attachment_id' => $media['poster'],
          'size' => $this->size,
        ));

        $media['poster'] = $this->poster->getAttribute('src');

      }

      if ($media['type'] == 'image') {

        $context = $this->getContext('images_attributes');
        $context['attachment_id'] = $media['attachment_id'];

        if ($this->getContext('data.allowfullscreen') != 'false'
            && isset($media['full'])) {

          $context['data']['full'] = $media['full'];
        }

        if (isset($media['size'])) {
          $context['size'] = $media['size'];
        }


        $this->WpImage($context);

        $context = NULL;
        unset($context);
      }

      if ($media['type'] == 'video') {

        if (is_numeric($media['attachment_id'])) {

          if (!isset($media['poster']) || empty($media['poster'])) {
            $data = wp_get_attachment_metadata($media['attachment_id']);
            if (isset($data['poster'])) {
              $media['poster'] = $data['poster'];
            }
          }

          $context = $this->getContext('videos_attributes');
          $context['attachment_id'] = $media['attachment_id'];

          if (isset($media['poster']) && !empty($media['poster'])) {
            $context['poster'] = $media['poster'];
            $context['data']['img'] = $media['poster'];
          }

          $this->WpVideo($context);

          $context = null;
          unset($context);
        }

        else {
          $this
            ->HyperLink(array(
              'attributes' => array(
                'href' => $media['attachment_id'],
              ),
            ));

          if (isset($media['poster'])) {
            $this
              ->lastChild()
              ->addOverloaderPrefix('VTCore_Wordpress_Element_')
              ->WpImage(array(
                'attributes' => array(
                  'src' => $media['poster'],
                ),
              ));
          }
        }
      }
    }


  }
}