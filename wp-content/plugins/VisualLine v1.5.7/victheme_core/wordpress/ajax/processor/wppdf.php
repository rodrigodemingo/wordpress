<?php
/**
 * Ajax callback class for handling
 * PDF page building
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Ajax_Processor_WpPDF
extends VTCore_Wordpress_Models_Ajax {

  /**
   * Ajax callback function
   *
   * $this->post will hold all the data passed by ajax.
   * - taxonomies = array or string of taxonomies,
   * - elval = the taxonomy term id
   */
  protected function processAjax() {

    if (isset($this->post['data'])) {
      $object = new VTCore_Wordpress_Objects_Array($this->post['data']);

      if ($object->get('id') && $object->get('template') && $object->get('pdfFilename')) {
        global $post;
        $post = get_post($object->get('id'));
        setup_postdata($post);

        $template = $object->get('template') . '.php';
        ob_start();
        include_once VTCore_Wordpress_Init::getFactory('template')->locate($template);
        $content = ob_get_clean();

        $this->addRender('action', array(
          'mode' => 'wppdf-generate',
          'target' => '',
          'filename' => $object->get('pdfFilename'),
          'content' => $content,
        ));
      }
    }

    return $this->render;
  }

}