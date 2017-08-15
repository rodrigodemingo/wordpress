<?php
/**
 * Building form for selecting Fonts related
 * css styles, the final output is
 * an array that is suitable for CSSBuilder_Rules_Font
 *
 * You can use the CSSBuilder_Factory for building the
 * final CSS for the fonts.
 *
 * @todo implement auto loading mechanism for google fonts
 * @todo implement preview box.
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Form_WpFonts
extends VTCore_Bootstrap_Form_Base
implements VTCore_Form_Interface {

  protected $context = array(
    'text' => false,
    'description' => false,
    'required' => false,

    'name' => false,
    'id' =>  false,
    'class' => array(
      'form-control'
    ),
    'label' => true,
    'preview' => true,
    'type' => 'div',

    // Wrapper Element
    'type' => 'div',
    'attributes' => array(
      'class' => array(
        'form-group',
        'wp-fonts',
        'clearfix'
      ),
    ),

    'value' => array(
      'font' => array(
        'weight' => '',
        'family' => '',
        'size' => '',
        'color' => '',
        'style' => '',
        'height' => '',
        'shadow' => '',
        'variant' => '',
        'spacing' => '',
      ),
    ),
  );

  private $families = array(
    'georgia, serif' => array(
      'text' => 'Georgia',
      'attributes' => array(
        'value' => 'georgia, serif',
      ),
    ),
    'arial, helvetica, sans-serif' => array(
      'text' => 'Arial',
      'attributes' => array(
        'value' => 'arial, helvetica, sans-serif',
      ),
    ),
    'impact, charcoal, sans-serif' => array(
      'text' => 'Impact',
      'attributes' => array(
        'value' => 'impact, charcoal, sans-serif',
      ),
    ),
    'tahoma, geneva, sans-serif' => array(
      'text' => 'Tahoma',
      'attributes' => array(
        'value' => 'tahoma, geneva, sans-serif',
      ),
    ),
    'verdana, geneva, sans-serif' => array(
      'text' => 'Verdana',
      'attributes' => array(
        'value' => 'verdana, geneva, sans-serif',
      ),
    ),
  );

  private $googleFonts;

  public function buildElement() {

    VTCore_Wordpress_Utility::loadAsset('wp-fonts');

    parent::buildElement();

    // Build google fonts
    $this->googleFonts = new VTCore_Wordpress_Data_Google_Fonts();
    $this->families += $this->googleFonts->getOptions();

    // Build the css rule for previewer
    if ($this->getContext('preview')) {

      $cssbuilder = new VTCore_CSSBuilder_Factory();
      $cssbuilder->Font($this->getContext('value.font'));

      $object = false;
      if ($this->googleFonts->get('library.' . $this->getContext('value.font.family'))) {

        $this->googleFonts
          ->add('registered.fonts.custom', $this->getContext('value.font.family'))
          ->add('registered.weight.custom', $this->getContext('value.font.weight'))
          ->add('registered.styles.custom', $this->getContext('value.font.style'));


        $object = new VTCore_Html_Link(array(
          'attributes' => array(
            'id' => 'wpfont-style-' . $this->getContext('value.font.family'),
            'href' => $this->googleFonts->buildFontString(),
          ),
        ));
      }

      $this
        ->BsElement(array(
          'type' => 'div',
          'attributes' => array(
            'class' => array(
              'wp-font-styles'
            ),
          ),
          'data' => array(
            'font-styles' => true,
          ),
          'children' => array(
            $object,
          ),
        ))
        ->BsElement(array(
          'type' => 'div',
          'text' => __('Grumpy wizards make toxic brew for the evil Queen and Jack.', 'victheme_core'),
          'attributes' => array(
            'class' => array(
              'wp-font-picker-preview'
            ),
            'style' => $cssbuilder->buildInlineStyle(),
          ),
          'data' => array(
            'font-previewer' => true,
          ),
        ));

    }

    $this
      ->BsRow()
      ->lastChild()
      ->BsColor(array(
        'text' => __('Color', 'victheme_core'),
        'name' => $this->getContext('name') . '[font][color]',
        'value' => $this->getContext('value.font.color'),
        'data' => array(
          //'font' => 'color',
          'container' => '#font-color-selector-' . $this->getMachineID(),
        ),
        'attributes' => array(
          'id' => 'font-color-selector-' . $this->getMachineID(),
          'class' => array(
            'clearboth',
            'clear',
          ),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          )
        ),
        'input_elements' => array(
          'data' => array(
            'font' => 'color',
          ),
        ),
      ))
      ->BsText(array(
        'text' => __('Size', 'victheme_core'),
        'name' => $this->getContext('name') . '[font][size]',
        'value' => $this->getContext('value.font.size'),
        'input_elements' => array(
          'data' => array(
            'font' => 'size',
          ),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          )
        ),
      ))
      ->BsSelect(array(
        'text' => __('Family', 'victheme_core'),
        'options' => array('' => __('None', 'victheme_core')) + $this->families,
        'name' => $this->getContext('name') . '[font][family]',
        'value' => $this->getContext('value.font.family'),
        'input_elements' => array(
          'data' => array(
            'font' => 'family',
          ),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          )
        ),
      ))
      ->getParent()
      ->BsRow()
      ->lastChild()
      ->BsSelect(array(
        'text' => __('Weight', 'victheme_core'),
        'name' => $this->getContext('name') . '[font][weight]',
        'value' => $this->getContext('value.font.weight'),
        'options' => array(
          '' => __('Not set', 'victheme_core'),
          'inherit' => __('Inherit','victheme_core'),
          100 => __('Thin', 'victheme_core'),
          200 => __('Extra light', 'victheme_core'),
          300 => __('Light', 'victheme_core'),
          400 => __('Normal', 'victheme_core'),
          500 => __('Medium', 'victheme_core'),
          600 => __('Demi bold', 'victheme_core'),
          700 => __('Bold', 'victheme_core'),
          800 => __('Heavy', 'victheme_core'),
          900 => __('Black', 'victheme_core'),
        ),
        'input_elements' => array(
          'data' => array(
            'font' => 'weight',
          ),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          )
        ),
      ))
      ->BsSelect(array(
        'text' => __('Style', 'victheme_core'),
        'name' => $this->getContext('name') . '[font][style]',
        'value' => $this->getContext('value.font.style'),
        'options' => array(
          '' => __('Not set', 'victheme_core'),
          'normal' => __('Normal', 'victheme_core'),
          'oblique' => __('Oblique', 'victheme_core'),
          'italic' => __('Italic', 'victheme_core'),
          'inherit' => __('Inherit','victheme_core'),
        ),
        'input_elements' => array(
          'data' => array(
            'font' => 'style',
          ),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          )
        ),
      ))
      ->BsSelect(array(
        'text' => __('Variant', 'victheme_core'),
        'name' => $this->getContext('name') . '[font][variant]',
        'value' => $this->getContext('value.font.variant'),
        'options' => array(
          '' => __('Not set', 'victheme_core'),
          'normal' => __('Normal', 'victheme_core'),
          'small-caps' => __('Small Caps', 'victheme_core'),
          'initial' => __('Initial', 'victheme_core'),
          'inherit' => __('Inherit', 'victheme_core'),
        ),
        'grids' => array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          )
        ),
        'input_elements' => array(
          'data' => array(
            'font' => 'variant',
          ),
        ),
      ))
      ->getParent()
      ->BsRow()
      ->lastChild()
      ->BsText(array(
        'text' => __('Line Height', 'victheme_core'),
        'name' => $this->getContext('name') . '[font][height]',
        'value' => $this->getContext('value.font.height'),
        'grids' => array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          )
        ),
        'input_elements' => array(
          'data' => array(
            'font' => 'line',
          ),
        ),
      ))
      ->BsText(array(
        'text' => __('Letter Spacing', 'victheme_core'),
        'name' => $this->getContext('name') . '[font][spacing]',
        'value' => $this->getContext('value.font.spacing'),
        'grids' => array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          )
        ),
        'input_elements' => array(
          'data' => array(
            'font' => 'letter',
          ),
        ),
      ))
      ->BsText(array(
        'text' => __('Shadow', 'victheme_core'),
        'name' => $this->getContext('name') . '[font][shadow]',
        'value' => $this->getContext('value.font.shadow'),
        'grids' => array(
          'columns' => array(
            'mobile' => 4,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          )
        ),
        'input_elements' => array(
          'data' => array(
            'font' => 'shadow',
          ),
        ),
      ));
  }
}