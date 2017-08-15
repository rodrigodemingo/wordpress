<?php
/**
 * Class for building the Advanced Bootstrap Accordion element specific for
 * Wordpress usage.
 *
 * Extending the VTCore_Bootstrap_Element_BsAccordion Class and adding
 * capabilities to lazy load the accordion content using ajax for faster
 * performance.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Element_WpAccordion
extends VTCore_Bootstrap_Element_BsAccordion {

  protected $context = array(
    'type' => 'div',
    'prefix' => 'accordion',
    'attributes' => array(
      'id' => '',
      'class' => array(
        'panel-group',
        'panel-accordion',
        'wp-accordion',
      ),
    ),
    'contents' => array(),
    'active' => false,

    // Ajax Data
    'ajax' => false,
    'ajaxData' => array(
      'ajax-mode' => 'data',
      'ajax-object' => 'accordion',
      'ajax-loading-text' => 'Loading...',
      'ajax-target' => false,
      'ajax-action' => 'vtcore_ajax_framework',
      'ajax-value' => 'accordion',
      'ajax-queue' => array(
        'append',
      ),

      'panelObject' => 'vtcore_html_base',
    ),

    // Default elements context only override when needed

    // Heading wrapper element
    'heading_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('panel-heading'),
      ),
    ),

    // Heading title element
    'title_elements' => array(
      'type' => 'h4',
      'attributes' => array(
        'class' => array('panel-title'),
      ),
    ),

    // Heading link element
    'link_elements' => array(
      'type' => 'a',
      'attributes' => array(
        'data-toggle' => 'collapse',
        'data-parent' => '',
        'href' => '',
      ),
    ),

    // Content Wrapper element
    'content_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel-collapse',
          'collapse',
        ),
      ),
    ),

    // Content body element
    'body_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array('panel-body'),
      ),
    ),

    // Main Panel wrapper element
    'panel_elements' => array(
      'type' => 'div',
      'attributes' => array(
        'class' => array(
          'panel',
          'panel-default',
        ),
      ),
    ),
  );


  /**
   * Function for building the accordion content. This function
   * cannot be called outside the class and cannot be extended
   * as well as the designed.
   *
   * @param string $delta
   * @param string / object $content
   * @return VTCore_Html_Element
   */
  public function addContent($delta, $contents) {

    VTCore_Wordpress_Utility::loadAsset('wp-ajax');

    $wrapper = new VTCore_Html_Base($this->getContext('content_elements'));
    $wrapper
      ->addAttribute('id', $this->unique . '-' . $delta)
      ->addClass(($this->getContext('active') === $delta) ? 'in' : '')
      ->addChildren(new VTCore_Html_Element($this->getContext('body_elements')));

    if ($this->getContext('ajax') && $this->getContext('active') !== $delta) {

      $button = $this->findChildren('attributes', 'href', '#' . $wrapper->getAttribute('id'));
      $button = array_shift($button);

      if (is_object($button)) {

        // Prepare the ajax target
        $wrapper
          ->lastChild()
          ->addAttribute('id', 'panel-target-' . $wrapper->getAttribute('id'))
          ->addData('panel-delta', $delta)
          ->addData('panelObject', base64_encode($this->getContext('ajaxData.panelObject')));

        // Prepare the button trigger (panel heading)
        foreach ($this->getContext('ajaxData') as $key => $data) {
          $button->addData($key, $data);
        }

        $button
          ->addClass('btn-ajax')
          ->addData('ajax-value', base64_encode(serialize($contents)))
          ->addData('ajax-group', $this->getAttribute('id'))
          ->addData('ajax-target', '#panel-target-' . $wrapper->getAttribute('id'))
          ->addData('nonce', wp_create_nonce('vtcore-ajax-nonce-admin'));
      }

    }
    else {

      foreach ((array) $contents as $content) {
        $wrapper
          ->lastChild()
          ->addChildren($content);
      }
    }

    return $wrapper;
  }

}