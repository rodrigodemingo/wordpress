<?php
/**
 *
 *
 * @see VTCore_Wordpress_Element_WpLoop
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Ajax_Processor_WpUpdater
extends VTCore_Wordpress_Models_Ajax {

  protected $render = array();
  protected $post;


  protected function processAjax() {

    switch ($this->post['queue']) {
      case 'update-table' :

        $markup = new VTCore_Wordpress_Pages_Config();
        $panel = $markup->databaseUpdaterPanel();
        $this->addRender('action', array(
          'mode' => 'replace',
          'target' => '#' . $panel->getAttribute('id'),
          'content' => $panel->__toString(),
        ));
        break;

      default :

        list($plugin, $version) = explode('##', $this->post['queue']);
        $result = VTCore_Wordpress_Init::getFactory('updater')->doUpdate($plugin, $version);

        if ($result) {
          $message = new VTCore_Bootstrap_Element_BsAlert(array(
            'text' => sprintf(__('Updating %s successful', 'victheme_core'), VTCore_Wordpress_Init::getFactory('updater')->get('registry.' . $plugin . '.updates.' . $version)),
            'alert-type' => 'success',
          ));
        }
        else {
          $message = new VTCore_Bootstrap_Element_BsAlert(array(
            'text' => sprintf(__('Updating %s failed', 'victheme_core'), VTCore_Wordpress_Init::getFactory('updater')->get('registry.' . $plugin . '.updates.' . $version)),
            'alert-type' => 'danger',
          ));
        }

        $this->addRender('action', array(
          'mode' => 'prepend',
          'target' => '#vtcore-configuration-form',
          'content' => $message->__toString(),
        ));

        break;
    }
  }

}