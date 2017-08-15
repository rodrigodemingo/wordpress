<?php
/**
 * Building form for selecting animation rule, it
 * will supports Animation CSS rules.
 *
 * The output will be valid arrays for CSSBuilder_Rules_Animation
 * object. You can use CSSBuilde_Factory to build the final
 * CSS string output.
 *
 * @author jason.xie@victheme.com
 * @method WpAnimation($context)
 * @see VTCore_Html_Form interface
 */
class VTCore_Wordpress_Form_WpAnimation
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(

    // Shortcut method
    // @see VTCore_Bootstrap_Form_Base::assignContext()
    'text' => false,
    'description' => false,

    'name' => false,
    'id' => false,
    'class' => array(
      'form-control'
    ),

      // Bootstrap Rules
    'label' => true,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-animation'
       ),
    ),

    'value' => array(
      'animation' => array(
        'name' => 'none',
        'delay' => '0s',
        'direction' => 'normal',
        'duration' => '1s',
        'fill-mode' => 'none',
        'iteration-count' => '1',
        'play-state' => 'running',
        'timing-function' => 'ease',
      ),
    ),
  );


  /**
   * Overridding parent method
   */
  public function buildElement() {

    $this->addAttributes($this->getContext('attributes'));

    if ($this->getContext('label_elements')) {
      $this->Label($this->getContext('label_elements'));
    }

    if ($this->getContext('description_elements')) {
      $this->addChildren(new VTCore_Bootstrap_Form_BsDescription(($this->getContext('description_elements'))));
    }

    // Build the form
    $this
      ->BsRow()
      ->lastChild()
      ->BsText(array(
        'text' => __('Name', 'victheme_core'),
        'name' => $this->getContext('name') . '[animation][name]',
        'value' => $this->getContext('value.animation.name'),
        'data' => array(
          'animation-type' => 'name',
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->BsText(array(
        'text' => __('Delay', 'victheme_core'),
        'name' => $this->getContext('name') . '[animation][delay]',
        'value' => $this->getContext('value.animation.delay'),
        'data' => array(
          'animation-type' => 'delay',
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->BsText(array(
        'text' => __('Duration', 'victheme_core'),
        'name' => $this->getContext('name') . '[animation][duration]',
        'value' => $this->getContext('value.animation.duration'),
        'data' => array(
          'animation-type' => 'duration',
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->BsText(array(
        'text' => __('Iteration Count', 'victheme_core'),
        'name' => $this->getContext('name') . '[animation][iteration-count]',
        'value' => $this->getContext('value.animation.iteration-count'),
        'data' => array(
          'animation-type' => 'iteration-count',
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->BsSelect(array(
        'text' => __('Direction', 'victheme_core'),
        'name' => $this->getContext('name') . '[animation][direction]',
        'value' => $this->getContext('value.animation.direction'),
        'options' => array(
          'normal' => __('Normal', 'victheme_core'),
          'reverse' => __('Reverse', 'victheme_core'),
          'alternate' => __('Alternate', 'victheme_core'),
          'alternate-reverse' => __('Alternate Reverse', 'victheme_core'),
          'initial' => __('Initial', 'victheme_core'),
          'inherit' => __('Inherit', 'victheme_core'),
        ),
        'data' => array(
          'animation-type' => 'direction',
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->BsSelect(array(
        'text' => __('Fill Mode', 'victheme_core'),
        'name' => $this->getContext('name') . '[animation][fill-mode]',
        'value' => $this->getContext('value.animation.fill-mode'),
        'options' => array(
          'none' => __('None', 'victheme_core'),
          'forwards' => __('Forwards', 'victheme_core'),
          'backwards' => __('Backwards', 'victheme_core'),
          'both' => __('Both', 'victheme_core'),
          'initial' => __('Initial', 'victheme_core'),
          'inherit' => __('Inherit', 'victheme_core'),
        ),
        'data' => array(
          'animation-type' => 'fill-mode',
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->BsSelect(array(
        'text' => __('Play State', 'victheme_core'),
        'name' => $this->getContext('name') . '[animation][play-state]',
        'value' => $this->getContext('value.animation.play-state'),
        'options' => array(
          'paused' => __('Paused', 'victheme_core'),
          'running' => __('Running', 'victheme_core'),
          'initial' => __('Initial', 'victheme_core'),
          'inherit' => __('Inherit', 'victheme_core'),
        ),
        'data' => array(
          'animation-type' => 'play-state',
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ))
      ->BsSelect(array(
        'text' => __('Timing', 'victheme_core'),
        'name' => $this->getContext('name') . '[animation][timing-function]',
        'value' => $this->getContext('value.animation.timing-function'),
        'options' => array(
          'linear' => __('Linear', 'victheme_core'),
          'ease' => __('Ease', 'victheme_core'),
          'ease-in' => __('Ease In', 'victheme_core'),
          'ease-out' => __('Ease Out', 'victheme_core'),
          'ease-in-out' => __('Ease In Out', 'victheme_core'),
          'initial' => __('Initial', 'victheme_core'),
          'inherit' => __('Inherit', 'victheme_core'),
        ),
        'data' => array(
          'animation-type' => 'timing-function',
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 6,
            'small' => 6,
            'large' => 6,
          ),
        ),
      ));

  }
}