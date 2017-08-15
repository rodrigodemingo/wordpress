<?php
/**
 * Ajax callback class for handling
 * the hierarchical selects ajax.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Ajax_Processor_WpIcon
extends VTCore_Wordpress_Models_Ajax {

  protected $render = array();
  protected $library;

  /**
   * Ajax callback function
   *
   * $this->post will hold all the data passed by ajax.
   * - taxonomies = array or string of taxonomies,
   * - elval = the taxonomy term id
   */
  protected function processAjax() {

    $this->library = new VTCore_Wordpress_Data_Icons_Library();
    $postObject = new VTCore_Wordpress_Objects_Array($this->post);
    if ($this->library->get($postObject->get('elval'))) {

      // Inject the font asset manually.
      $assets = VTCore_Wordpress_Init::getFactory('assets')
        ->get('library')
        ->get($this->library->get($postObject->get('elval') . '.asset') . '.css');

      $object = new VTCore_Bootstrap_Form_BsIcon(array(
        'text' => __('Icon', 'victheme_core'),
        'name' => $postObject->get('value.name') . '[icon]',
        'value' => '',
        'limit' => $postObject->get('value.limit'),
        'icons' => $this->library->get($postObject->get('elval')),
        'data' => array(
          'family' => $postObject->get('elval'),
          'asset' => $assets,
        ),
        'attributes' => array(
          'id' => str_replace('#', '', $postObject->get('target')),
        ),
      ));


      if (!empty($assets)) {
        $styles = array();
        foreach ($assets as $id => $asset) {
          if (isset($asset['url'])) {
            $styles[] = array(
              'id' => $postObject->get('elval') . '-' . $id,
              'src' => $asset['url'],
            );
          }
        }
      }

      $this->render['action'][] = array(
        'mode' => 'empty',
        'target' => '[data-icon-preview="' .  str_replace('#', '', $postObject->get('target')) . '"]',
      );

      if (isset($styles) && !empty($styles)) {
        $this->render['action'][] = array(
          'mode' => 'stylesheet',
          'target' => 'head',
          'content' => $styles,
        );
      }

      $this->render['action'][] = array(
        'mode' => 'replace',
        'target' => $postObject->get('target'),
        'content' => $object->__toString(),
      );
    }

    return $this->render;
  }


}