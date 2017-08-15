<?php
/**
 * The main input form for the WpMedia
 * form element. Don't call this directly!
 * instead use the WpMedia form element.
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Wordpress_Form_WpMedia
 * @see VTCore_Form_Text
 * @see VTCore_Form_Instance
 */
class VTCore_Wordpress_Form_WpMediaInput
extends VTCore_Form_Text {

  /**
   * Extending the parent class setValue
   * for calling parent wrapper setValue
   * method for updating the preview box.
   *
   * @see VTCore_Form_Base::setValue()
   */
	public function setValue($value) {
	  parent::setValue($value);
	  $this->getParent()->setValue($value);
	}
}