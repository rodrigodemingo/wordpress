<?php
/**
 * Helper class for building WP Multiple Media Uploader
 *
 * This class doesn't inherit all BsPanel parent class feature!
 * Only support attachment id at the moment!
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Form_WpMultipleMedia
extends VTCore_Bootstrap_Element_BsPanel {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'name' => '',
    'value' => array(507),
    'button_text' => '',
    'description' => false,
    'attributes' => array(
      'class' => array(
        'panel',
        'panel-default',
        'form-wpmultiplemedia',
      ),
    ),

    'data' => array(
      'media-type' => 'image',
      'media-title' => 'Select Image',
      'media-button' => 'Select',
    ),
    'table' => array(
      'data' => array(
        'wp-multipe-uploader' => 'target',
      ),
    ),

    'title_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel-heading',
        ),
      ),
    ),
    'heading_elements' => array(
      'type' => 'h3',
      'text' => '',
      'attributes' => array(
        'class' => array(
          'panel-title',
        ),
      ),
    ),

    'content_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel-body',
        ),
      ),
    ),

  );



  /**
   * Overriding HTML object build element to build the
   * special element for WP MultipleMedia Form
   *
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    wp_enqueue_media();
    VTCore_Wordpress_Utility::loadAsset('wp-multiplemedia');

    $this->id = 'wp-multiplemedia-' . $this->getMachineID();
    $this
      ->addData('media-name', $this->getContext('name'))
      ->addAttributes($this->getContext('attributes'))
      ->buildTemplateRow()
      ->addChildren(new VTCore_Html_Element($this->getContext('title_elements')));

    if ($this->getContext('text')) {
      $this
        ->lastChild()
        ->addChildren(new VTCore_Html_Element($this->getContext('heading_elements')))
        ->lastChild()
        ->addChildren($this->getContext('text'));
    }

    if (!$this->getContext('button_text')) {
      $this->addContext('button_text', __('Add Media'));
    }

    $this
      ->lastChild()
      ->addChildren(new VTCore_Bootstrap_Form_BsButton(array(
        'text' => $this->getContext('button_text'),
        'size' => 'xs',
        'data' => array(
          'wp-multiple-uploader' => 'add'
        ),
      )));

    if ($this->getContext('description')) {
      $this
        ->addChildren(new VTCore_Html_Element($this->getContext('content_elements')))
        ->lastChild()
        ->addChildren(new VTCore_Bootstrap_Form_BsDescription(array(
          'text' => $this->getContext('description'),
        )));
    }


    if ($this->getContext('value')) {
      $this->buildMediaRows();
    }

    $this->addTable($this->getContext('table'));
  }


  /**
   * Generating javascript template row
   */
  protected function buildTemplateRow() {

    $this
      ->addContext('table.rows.placeholder.attributes.class.hidden', 'hidden')
      ->addContext('table.rows.placeholder.data.wp-multiple-uploader', 'template')
      ->addContext('table.rows.placeholder.table-drag.content', '')
      ->addContext('table.rows.placeholder.table-drag.attributes.class.drag', 'drag-icon')
      ->addContext('table.rows.placeholder.thumbnail', new VTCore_Wordpress_Form_WpMedia(array(
        'button' => false,
        'data' => array(
          'preview' => true,
          'input' => false,
          'multiple' => false,
        ),
      )))
      ->addContext('table.rows.placeholder.filename', $this->buildInformationBox('', ''))
      ->addContext('table.rows.placeholder.delete', new VTCore_Fontawesome_faIcon(array(
        'icon' => 'minus-square',
        'attributes' => array(
          'data-wp-multiple-uploader' => 'remove',
        ),
      )));

    return $this;
  }


  /**
   * Helper function for building the information box
   * @param $type
   * @param $url
   * @return \VTCore_Html_Element
   */
  protected function buildInformationBox($type, $url) {
    $information = new VTCore_Html_Element();
    $information
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'wp-multiplemedia-info'
          ),
        ),
        'raw' => true,
        'text' => sprintf(__('<span class="wp-multiplemedia-label">Type : </span><span class="wp-multiplemedia-type">%s</span>', 'victheme_core'), $type),
      )))
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'wp-multiplemedia-info'
          ),
        ),
        'raw' => true,
        'text' => sprintf(__('<span class="wp-multiplemedia-label">Filename : </span><span class="wp-multiplemedia-filename">%s</span>', 'victheme_core'), basename($url)),
      )))
      ->addChildren(new VTCore_Html_Element(array(
        'type' => 'div',
        'attributes' => array(
          'class' => array(
            'wp-multiplemedia-info'
          ),
        ),
        'raw' => true,
        'text' => sprintf(__('<span class="wp-multiplemedia-label">File location : </span><span class="wp-multiplemedia-url">%s</span>', 'victheme_core'), $url),
      )));

    return $information;
  }

  /**
   * Generating media rows
   */
  protected function buildMediaRows() {

    // Build the media rows
    foreach ((array) $this->getContext('value') as $index => $media) {

      $type = false;
      if (wp_attachment_is('image', $media)) {
        $type = 'image';
      }
      elseif (wp_attachment_is('video', $media)) {
        $type = 'video';
      }
      elseif (wp_attachment_is('audio', $media)) {
        $type = 'audio';
      }

      $url = wp_get_attachment_url($media);
      $this
        ->addContext('table.rows.' . $index . '.table-drag.content', '')
        ->addContext('table.rows.' . $index . '.table-drag.attributes.class.drag', 'drag-icon')
        ->addContext('table.rows.' . $index . '.thumbnail', new VTCore_Wordpress_Form_WpMedia(array(
          'value' => $media,
          'name' => $this->getContext('name'),
          'button' => false,
          'data' => array(
            'type' => $type,
            'preview' => true,
            'input' => false,
            'multiple' => false,
          ),
        )))
        ->addContext('table.rows.' . $index . '.filename', $this->buildInformationBox($type, $url))
        ->addContext('table.rows.' . $index . '.delete', new VTCore_Fontawesome_faIcon(array(
          'icon' => 'minus-square',
          'attributes' => array(
            'data-wp-multiple-uploader' => 'remove',
          ),
        )));
    }

    return $this;
  }

  /** Disabled since this object doesn't suppor these */
  final public function getContent() {}
  final public function addContent($object) {}
  final public function addFooter($object)  {}
}