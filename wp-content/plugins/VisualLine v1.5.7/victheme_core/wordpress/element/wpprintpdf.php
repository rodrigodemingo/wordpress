<?php
/**
 * VTCore Extension for building the PrintToPdf Button
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Element_WpPrintPdf
extends VTCore_Html_HyperLink {

  protected $context = array(
    'type' => 'a',
    'text' => '',
    'icons' => array(
      'icon' => 'print',
      'family' => 'fontawesome',
    ),
    'data' => array(
      'printpdf' => 'trigger',
      'pdf-filename' => '',
      'template' => '',
      'ajax-mode' => 'selfData',
      'ajax-object' => 'pdf',
      'ajax-loading-text' => '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
      'ajax-target' => false,
      'ajax-action' => 'vtcore_ajax_framework',
      'ajax-value' => 'wp-pdf',
      'ajax-marker' => 'wp-pdf',
      'ajax-queue' => array(
        'render',
      ),
    ),
    'attributes' => array(
      'href' => '#',
      'title' => '',
      'class' => array(
        'wp-printpdf-button',
        'btn',
        'btn-ajax',
        'btn-primary'
      )
    ),
  );

  public function buildElement() {

    global $post;

    VTCore_Wordpress_Utility::loadAsset('js-jspdf');
    VTCore_Wordpress_Utility::loadAsset('js-html2canvas');
    VTCore_Wordpress_Utility::loadAsset('wp-ajax');
    VTCore_Wordpress_Utility::loadAsset('wp-printpdf');

    $this
      ->addData('nonce', wp_create_nonce('vtcore-ajax-nonce-admin'))
      ->addData('id', $post->ID);

    // Build icons
    if ($this->getContext('icons')) {
      $this
        ->addChildren(new VTCore_Wordpress_Element_WpIcon($this->getContext('icons')))
        ->addChildren($this->getContext('text'))
        ->removeContext('text');
    }

    parent::buildElement();
  }
}