<?php
/**
 * Building a single select element for a flatten
 * single taxonomy terms.
 *
 *
 * @author jason.xie@victheme.com
 * @method WpTerms($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Wordpress_Form_WpTermsHS
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $overloaderPrefix = array(
    'VTCore_Wordpress_Form_'
  );

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'description' => false,
    'required' => false,

    'name' => false,
    'id' => false,
    'class' => array('form-control'),

    // Bootstrap Rules
    'label' => true,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-termshs'
       ),
    ),

    // Marking for manual processor
    // so setValue will be invoked
    // during processForm
    'processor' => 'manual',

    'value' => array(),
    'taxonomies' => array(),
    'arguments' => array(),
    'children_attributes' => array(),
  );


  private $childContext = array();
  private $taxonomies = array();
  private $lastTermId;


  /**
   * Shortcut function for retrieving children attributes
   */
  private function getChildAttributes($delta) {
    return isset($this->context['children_attributes'][$delta]) ? $this->context['children_attributes'][$delta] : FALSE;
  }


  /**
   * Shortcut function for retrieving value per delta
   */
  private function getValuePerDelta($delta) {
    return isset($this->context['value'][$delta]) ? $this->context['value'][$delta] : FALSE;
  }


  /**
   * Overriding parent build element
   */
  public function buildElement() {

    VTCore_Wordpress_Utility::loadAsset('wp-ajax');

    $this->addAttributes($this->getContext('attributes'));
    $this->addAttribute('id', 'wphs-element-' . $this->getMachineID());
    $this->addData('taxonomies', $this->getContext('taxonomies'));


    if ($this->getContext('label_elements')) {
      $this->addChildren(new VTCore_Form_Label($this->getContext('label_elements')));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription($this->getContext('description_elements')));
    }

    if (!is_array($this->context['value'])) {
      $this->context['value'] = array($this->context['value']);
    }

    // Remove empty (0) terms
    array_filter($this->context['value']);

    // Force build dumb blank element if last stored value has children
    if (!empty($this->context['value'])) {
      $this->lastTermId = end($this->context['value']);
    }

    if ($this->getContext('taxonomies')) {
      foreach ($this->getContext('taxonomies') as $taxonomy) {
        $this->taxonomies[$taxonomy] = _get_term_hierarchy($taxonomy);

        if (isset($this->taxonomies[$taxonomy][$this->lastTermId])) {
          $this->context['value'][] = 'new_blank_item';
        }
      }
    }

    // Force build dumb blank element on empty form;
    if (empty($this->context['value'])) {
      $this->context['value'][] = 'new_blank_item';
    }

    foreach ($this->getContext('value') as $delta => $tid) {

      $this->childContext = $this->getChildAttributes($delta);

      $context = array(
        'arguments' => $this->getContext('arguments'),
        'taxonomies' => $this->getContext('taxonomies'),
        'value' => is_numeric($tid) ? $tid : false,
        'name' => $this->getContext('name'),
        'selectpicker' => $this->getContext('selectpicker'),
        'attributes' => array(
          'id' => $this->getAttribute('id') . '-' . $delta,
        ),
        'data' => array(
          'taxonomies' => $this->getContext('taxonomies'),
          'parent' => $this->getValuePerDelta($delta - 1),
          'target' => '#' . $this->getAttribute('id'),
        ),
        'input_elements' => array(
          'attributes' => array(
            'class' => array('btn-ajax-change'),
          ),
          'data' => array(
            'ajax-mode' => 'data',
            'ajax-target' => '#' . $this->getAttribute('id') . '-' . $delta,
            'ajax-loading-text' => __('Retrieving Terms', 'victheme_core'),
            'ajax-object' => 'VTCore_Wordpress_Ajax_Processor_HS',
            'ajax-action' => 'vtcore_ajax_framework',
            'ajax-queue' => array('retrieving_child_term'),
            'ajax-value' => base64_encode(json_encode($this->getContexts())),
            'nonce' => wp_create_nonce('vtcore-ajax-nonce-admin'),
            'ajax-marker' => array(
              'id' => '#' . $this->getAttribute('id'),
              'mode' => 'wpterms-hs',
            ),
          ),
        ),
      );

      $context['arguments']['parent'] = $this->getValuePerDelta($delta - 1);

      $this->childContext = VTCore_Utility::arrayMergeRecursiveDistinct($context, $this->childContext);

      // added title to the first element
      if ($delta == 0) {
        $this->childContext['input_elements']['attributes']['title'] = $this->getContext('text');
      }

      $context = NULL;
      unset($context);

      $this->addChildren(new VTCore_Wordpress_Form_WpTerms($this->childContext));

      // Only Stops ajax when options has no children
      // on the last select element. This is needed
      // to effectively clean the select box when user
      // choose different tree to drill on.
      if (!isset($this->context['value'][$delta + 1])) {
        foreach ($this->lastChild()->findChildren('type', 'option') as $object) {
          if ($object->getData('has-children') == false) {
            $object->addData('ajax-stop', true);
          }
        }
      }

    }

    if ($this->getContext('togglelabel')) {
      VTCore_Wordpress_Utility::loadAsset('bootstrap-toggle-label');
      $this->addData('toggle-label', array(
        'parent' => false,
      ));
    }
  }


  /**
   * Overriding the processor parent method
   * This will only work if the context array
   * has :
   *
   * 'processor' => 'manual'
   * 'name' => the same name as all the select child element
   *
   * @see VTCore_Form_Base::setValue()
   */
  public function setValue($value) {
    // Rebuild the element
    if (!empty($value) && is_array($value)) {
      $this->addContext('value', $value);
      $this->resetChildren();
      $this->buildElement();
    }

    return $this;
  }
}