<?php
/**
 * Models for standard configuration page
 *
 * The initialization is on buildPage method.
 *
 * @author jason.xie@victheme.com
 *
 */
abstract class VTCore_Wordpress_Models_Page {

  protected $form;
  protected $headers;
  protected $messages;

  protected $saveKey;
  protected $resetKey;
  protected $actionFormKey;
  protected $actionHeaderKey;

  protected $headerText;
  protected $headerSmallText = null;
  protected $headerIcon;


  /**
   * Menu callback methods
   * Override this if form needs custom routing logic.
   */
  public function buildPage() {

    // Loading Assets
    $this->loadAssets();

    // Registering class property
    $this->register();

    // Overloading messages
    $this->messages = new VTCore_Bootstrap_BsMessages();

    // Perform reseting
    if (isset($_POST[$this->resetKey])) {
      $this->reset();
    }

    // Perform saving
    if (isset($_POST[$this->saveKey])) {
      $this->save();
    }

    // Build Header
    $this->generateHeader();

    // Build, validate and render form
    $this->generateForm();

  }



  /**
   * Private method for bridging the header building
   * object.
   *
   * Use buildHeader method instead for building the header object.
   *
   * @return $this
   */
  private function generateHeader() {
    $this->buildHeader();

    // Allow alteration before rendering
    add_action($this->actionHeaderKey, $this->headers);

    // Render the header HTML Markup
    if (!empty($this->headers) && is_a($this->headers, 'VTCore_Html_Base')) {
      $this->headers->render();
    }

    return $this;
  }


  /**
   * Private method for bridging the form building object
   * Use BuildForm method instead for building the form object.
   *
   * @return $this
   */
  private function generateForm() {

    // Build Form
    $this->buildForm();

    if (!empty($this->form) && is_a($this->form, 'VTCore_Form_Base')) {

      // Process Form
      $this->form
        ->processForm();

      // Process Error
      $this->form
        ->processError(TRUE, TRUE);


      // Grab any errors
      $errors = $this->form->getErrors();

      // Puke in errors
      if (!empty($errors)) {
        foreach ($errors as $error) {
          $this->messages->setError($error);
        }
      }

      // Inject error messages to markup
      $this->form->prependChild($this->messages->render());

      // Let other alter this page
      add_action($this->actionFormKey, $this->form);

      // Spit out the Form HTML Markup
      $this->form->render();
    }

    return $this;
  }

  /**
   * Method for registering property value
   * to the class object.
   *
   * Use this method for injecting property value
   * such as headerText and headerIcon
   */
  abstract protected function register();


  /**
   * Method for loading additional assets
   * SubClass must extend this.
   */
  abstract protected function loadAssets();


  /**
   * Method for saving the form
   * SubClass must extend this.
   */
  abstract protected function save();


  /**
   * Method for resetting the form
   * SubClass must extend this.
   */
  abstract protected function reset();


  /**
   * Method for supporting ajax callback
   * via VTCore Ajax API
   * SubClass must extend this.
   */
  abstract public function renderAjax($post);


  /**
   * Method for building the form
   * The storage point must be in property::form
   * SubClass must extend this.
   */
  abstract protected function buildForm();



  /**
   * Build the page header elements
   *
   * Alteration Point :
   *  - victheme-configuration-header
   *  - vtcore-configuration-header-row
   *  - vtcore-configuration-header-column-one
   *  - vtcore-configuration-header-column-two
   *
   * SubClass can override this for complete different markup,
   * use $header as the entry point for VTCore HTML Objects.
   *
   * To use the default markup, register the property :
   *  - headerIcon = valid fontawesome object icon name
   *  - headerText = the header text, prefered to be translated first.
   */
  protected function buildHeader() {

    $this->headers = new VTCore_Bootstrap_Grid_BsContainerFluid(array(
      'id' => 'victheme-configuration-header',
      'type' => 'div',
      'attributes' => array(
        'id' => 'victheme-configuration-header',
        'class' => array(
          'vtcore-configuration-header-skins',
        ),
      ),
    ));

    $this->headers

      // Alter point, you can use findChildren method with context id
      // to retrieve this row
      ->addChildren(new VTCore_Bootstrap_Grid_BsRow(array(
        'id' => 'vtcore-configuration-header-row',
      )))
      ->lastChild()

      // Alter point, you can use findChildren method with context id
      // to retrieve this column
      ->addChildren(new VTCore_Bootstrap_Grid_BsColumn(array(
        'id' => 'vtcore-configuration-header-column-one',
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 12,
            'small' => 12,
            'large' => 6,
          )
        ),
      )))
      ->lastChild()
      ->addChildren(new VTCore_Fontawesome_faIcon(array(
        'icon' => $this->headerIcon,
        'shape' => 'circle',
        'position' => 'pull-left',
      )))
      ->addChildren(new VTCore_Bootstrap_Element_BsHeader(array(
        'text' => $this->headerText,
        'small' => $this->headerSmallText,
      )))
      ->getParent()


      // Alter point, you can use findChildren method with context id
      // to retrieve this column
      ->addChildren(new VTCore_Bootstrap_Grid_BsColumn(array(
        'id' => 'vtcore-configuration-header-column-two',
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 12,
            'small' => 12,
            'large' => 6,
          )
        ),
      )));

    return $this;
  }



}