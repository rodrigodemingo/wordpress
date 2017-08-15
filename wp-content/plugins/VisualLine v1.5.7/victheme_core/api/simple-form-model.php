<?php
die('no direct access');

/**
 * Example class for building the whole form as
 * a single class by extending the VTCore_Bootstrap_Form_BsInstance or
 * VTCore_Form_Instance class.
 *
 * This model is useful if we need to easily call the form
 * instance by using a single class eg.
 *
 * by invoking :
 * $form = new Simple_Form_Model($context)
 *
 * result is a fully built form model.
 *
 *
 * @author jason.xie@victheme.com
 *
 */
class Simple_Form_Model
extends VTCore_Bootstrap_Form_BsInstance {


  /**
   * Overrides VTCore_Form_Instance construct method
   * to force element to invoke buildElement method.
   *
   * The original VTCore_Form_Instance class will not invoke
   * the build method directly by design thus in this
   * simple form we need the class to auto build the
   * children.
   *
   * This can be achieved by overriding the default
   * form_instance __construct() method and invoke
   * the buildElement() method manually.
   *
   * @see VTCore_Form_Instance()
   */
  public function __construct($context = array()) {

    // Set the default contexes. Note that
    // we do it here instead in the context variables
    // because of the need to use function to grab
    // the actions url.
    // This is optional, the class can still use
    // the contexts array when it is initialized.
    $context['attributes'] = array(
      'id' => 'importer-configuration-form',
      'method' => 'post',
      'action' => $_SERVER['REQUEST_URI'],
      'class' => array('container-fluid')
    );


    $this->buildObject($context);
    if (isset($context['attributes'])) {
      $this->addAttributes($context['attributes']);
    }

    $this->addProcessor('post', new VTCore_Form_Post());


    // Force to build element
    $this->buildElement();
  }




  /**
   * Example where we inject the form elements into the objects
   * @see VTCore_Html_Base::buildElement()
   */
  public function buildElement() {

    $this
      ->BsPanel(array(
        'text' => 'Example Panels',
      ))
      ->lastChild()
      ->addContent(new VTCore_Bootstrap_Form_BsDescription(array(
        'text' => 'Example description',
      )))
      ->BsText(array(
        'name' => 'example',
        'value' => 'example',
        'text' => 'Example Textfield',
      ))
      ->getParent()
      ->Submit(array(
        'attributes' => array(
          'name' => 'importerSaveSubmit',
          'value' => __('Process', 'victheme_core'),
          'class' => array('btn', 'btn-primary')
        ),
      ));
  }


}