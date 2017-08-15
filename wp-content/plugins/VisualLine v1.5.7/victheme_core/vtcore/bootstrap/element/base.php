<?php
/**
 * Extending Html base class for handling the
 * bootstrap element subclass
 *
 * All bootstrap element subclass must extend this class.
 *
 * @author jason.xie@victheme.com
 *
 * @method BsAccordion
 *  Building bootstrap accordion element
 * @method BsAlert
 *  Building bootstrap alert element
 * @method BsBadge
 *  Building bootstrap badge element
 * @method BsElement
 *  Building generic element
 * @method BsGlyphicon
 *  Building glyphicon element
 * @method BsHeader
 *  Building header element
 * @method BsJumbotron
 *  Building jumbotron element
 * @method BsLabel
 *  Building label element
 * @method BsListGroup
 *  Building list group element
 * @method BsListObject
 *  Building list object for list group element
 * @method BsMediaList
 *  Building media list element
 * @method BsMediaObject
 *  Building media object for media list element
 * @method BsPanel
 *  Building panel element
 * @method BsProgressBar
 *  Building progress bar element
 * @method BsTabs
 *  Building tabs element
 * @method BsThumbnail
 *  Building thumbnail element
 * @method BsWell
 * Building well element.
 *
 */
class VTCore_Bootstrap_Element_Base
extends VTCore_Html_Base {

  protected $overloaderPrefix = array(
    'VTCore_Bootstrap_Element_',
    'VTCore_Bootstrap_Form_',
    'VTCore_Bootstrap_Grid_',
    'VTCore_Form_',
    'VTCore_Html_',
  );

  /**
   * Constructing the object and processing
   * the context array
   */
  public function __construct($context = array()) {
    $this->buildObject($context);
    $this->buildElement();
    $this->buildGrid();
  }


  /**
   * Method for building the grid css classes
   * @return VTCore_Bootstrap_Element_Base
   */
  public function buildGrid() {
    // Processing Grids
    if ($this->getContext('grids')) {
      $grids = new VTCore_Bootstrap_Grid_Column($this->getContext('grids'));
      $this->addClass($grids->getClass(), 'grids');
    }

    return $this;
  }
}