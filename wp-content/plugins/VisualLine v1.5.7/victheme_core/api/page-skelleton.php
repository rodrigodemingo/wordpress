<?php
die('no direct access');
/**
 * A Simple configuration page skelleton
 * This can be used to build a simple configuration
 * page and must use the specific CSS to properly
 * styles the page.
 *
 * Best used in conjunction with VTCore_Wordpress_Actions system
 * and define the configuration menu page from the action classes.
 *
 * @author jason.xie@victheme.com
 */
class Simple_Configuration_Page {

  private $form;
  private $header;
  private $messages;



  /**
   * Page callbacks
   * @see add_submenu_page()
   * @see VTCore_Headline_Actions_Admin__Menu
   */
  public function buildPage() {

    // Load our css'es
    VTCore_Wordpress_Utility::loadAsset('wp-bootstrap');
    VTCore_Wordpress_Utility::loadAsset('example-admin-page');

    // Build messaging center
    $this->messages = new VTCore_Bootstrap_BsMessages();

    // Building the header, form and process the form
    $this
      ->buildHeader()
      ->buildForm()
      ->processForm()
      ->processError(true, true);


    // Grab any errors
    $errors = $this->form->getErrors();

    // Save the form
    if (empty($errors) && isset($_POST['exampleButtonSubmit'])) {

      // Set the messages
      $this->messages->setNotice('Configuration saved to database');

      // Save to database
      update_option('example_database', $_POST);
    }

    // Reset Database
    if (isset($_POST['exampleResetSubmit'])) {
      $this->messages->setNotice('Configuration deleted from database and retrieving the default configuration value.');

      delete_option('example_database');
    }

    // Process error messages
    if (!empty($errors)) {
      foreach ($errors as $error) {
        $this->messages->setError($error);
      }
    }

    // Add messages
    $this->form->prependChild($this->messages->render());

    // Render the HTML
    echo $this->header->render() . $this->form->render();
  }



  /**
   * Build the page header
   */
  private function buildHeader() {

    $this->header = new VTCore_Bootstrap_Grid_BsContainerFluid(array(
      'type' => 'div',
      'attributes' => array(
        'id' => 'importer-options-header',
      ),
    ));

    $this->header
      ->BsRow()
      ->lastChild()
      ->BsColumn(array(
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 12,
            'small' => 12,
            'large' => 6,
          )
        ),
      ))
      ->lastChild()
      ->addOverloaderPrefix('VTCore_Fontawesome_')
      ->faIcon(array(
        'icon' => 'edit',
        'shape' => 'circle',
        'position' => 'pull-left',
      ))
      ->BsHeader(array(
        'text' => 'Some Header',
        'small' => 'some version',
      ))
      ->getParent()
      ->BsColumn(array(
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 12,
            'small' => 12,
            'large' => 6,
          )
        ),
      ));

    return $this;
  }



  /**
   * Build the form elements
   */
  private function buildForm() {

    // Build the form
    $this->form = new VTCore_Bootstrap_Form_BsInstance(array(
      'attributes' => array(
        'id' => 'example-configuration-form',
        'method' => 'post',
        'action' => $_SERVER['REQUEST_URI'],
        'class' => array('container-fluid')
      ),
    ));


    $this->form
      ->BsPanel(array(
        'text' => 'Example Panel',
      ))
      ->Submit(array(
        'attributes' => array(
          'name' => 'exampleSaveSubmit',
          'value' => __('Save', 'victheme_core'),
          'class' => array('btn', 'btn-primary')
        ),
      ))
      ->Submit(array(
        'attributes' => array(
          'name' => 'exampleResetSubmit',
          'value' => __('Reset', 'victheme_core'),
          'class' => array('btn', 'btn-danger')
        ),
      ));


    // Notice that we return the form instead this for chaining purposes.
    return $this->form;
  }



}