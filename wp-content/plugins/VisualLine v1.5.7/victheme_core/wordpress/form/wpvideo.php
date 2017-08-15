<?php
/**
 * Building form for background video.
 * The output is not a valid CSS, it will need to be passed
 * to VideoBG js in order to build the markup for the video
 * properly.
 *
 * The output will be valid arrays for CSSBuilder_Rules_Background
 * object. You can use CSSBuilde_Factory to build the final
 * CSS string output.
 *
 * @author jason.xie@victheme.com
 * @method WpBackgroundVideo($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Wordpress_Form_WpVideo
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'description' => false,
    'required' => false,

    'name' => false,
    'id' => false,
    'class' => array('form-control'),

    'preview' => true,

    // Bootstrap Rules
    'label' => true,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-background-video'
       ),
    ),

    'value' => array(
      'video' => array(
        'source' => array(
          'mp4' => '',
          'ogv' => '',
          'webm' => '',
        ),
        'poster' => '',
        'position' => 'absolute',
        'autoplay' => true,
        'loop' => '1',
        'scale' => true,
        'width' => '100%',
        'height' => '100%',
      ),
    ),
  );

  private $videos;

  public function buildElement() {

    $this->videos = $this->findContext('video');

    $this->addAttributes($this->getContext('attributes'));


    if ($this->getContext('label_elements')) {
      $this->Label($this->getContext('label_elements'));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    // Build the form
    $this
      ->BsRow()
      ->lastChild()
      ->BsColumn(array(
        'attributes' => array(
          'class' => array(
            'wp-background-video-sources'
          ),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->lastChild()
      ->addOverloaderPrefix('VTCore_Wordpress_Form_')
      ->WpMedia(array(
        'text' => __('Video MP4', 'victheme_core'),
        'name' => $this->getContext('name') . '[video][source][mp4]',
        'value' => $this->getSources('mp4'),
        'data' => array(
          'type' => 'video',
          'preview' => $this->getContext('preview'),
          'video-type' => 'mp4',
        ),
      ))
      ->WpMedia(array(
        'text' => __('Video WEBM', 'victheme_core'),
        'name' => $this->getContext('name') . '[video][source][webm]',
        'value' => $this->getSources('webm'),
        'data' => array(
          'type' => 'video',
          'preview' => $this->getContext('preview'),
          'video-type' => 'webm',
        ),
      ))
      ->WpMedia(array(
        'text' => __('Video OGV', 'victheme_core'),
        'name' => $this->getContext('name') . '[video][source][ogv]',
        'value' => $this->getSources('ogv'),
        'data' => array(
          'type' => 'video',
          'preview' => $this->getContext('preview'),
          'video-type' => 'ogv',
        ),
      ))
      ->WpMedia(array(
        'text' => __('Poster Image', 'victheme_core'),
        'name' => $this->getContext('name') . '[video][poster]',
        'value' => $this->getVideo('poster'),
        'data' => array(
          'type' => 'image',
        ),
      ))
      ->getParent()
      ->BsColumn(array(
        'attributes' => array(
          'class' => array(
            'wp-background-video-options'
          ),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->lastChild()
      ->BsSelect(array(
        'text' => __('Position', 'victheme_core'),
        'name' => $this->getContext('name') . '[video][position]',
        'value' => $this->getVideo('position'),
        'options' => array(
          'absolute' => __('Absolute', 'victheme_core'),
          'fixed' => __('Fixed', 'victheme_core'),
        ),
      ))
      ->BsSelect(array(
        'text' => __('Autoplay', 'victheme_core'),
        'name' => $this->getContext('name') . '[video][autoplay]',
        'value' => $this->getVideo('autoplay'),
        'options' => array(
          'true' => __('True', 'victheme_core'),
          'false' => __('False', 'victheme_core'),
        ),
      ))
      ->BsText(array(
        'text' => __('Loop', 'victheme_core'),
        'name' => $this->getContext('name') . '[video][loop]',
        'value' => $this->getVideo('loop'),
      ))
      ->BsSelect(array(
        'text' => __('Scale', 'victheme_core'),
        'name' => $this->getContext('name') . '[video][scale]',
        'value' => $this->getVideo('scale'),
        'options' => array(
          'true' => __('True', 'victheme_core'),
          'false' => __('False', 'victheme_core'),
        ),
      ))
      ->BsText(array(
        'text' => __('Width', 'victheme_core'),
        'name' => $this->getContext('name') . '[video][width]',
        'value' => $this->getVideo('width'),
        'suffix' => 'px',
      ))
      ->BsText(array(
        'text' => __('Height', 'victheme_core'),
        'name' => $this->getContext('name') . '[video][height]',
        'value' => $this->getVideo('height'),
        'suffix' => 'px',
      ));
  }


  /**
   * Helper function for easily retrieving
   * gradients array value based on its key
   */
  private function getVideo($type) {
    return (isset($this->videos[$type])) ? $this->videos[$type] : NULL;
  }


  private function getSources($type) {
    return (isset($this->videos['sources'][$type])) ? $this->videos['sources'][$type] : NULL;
  }

}