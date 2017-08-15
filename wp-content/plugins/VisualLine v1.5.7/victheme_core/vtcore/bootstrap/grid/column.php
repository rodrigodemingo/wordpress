<?php
/**
 * Class for processing column grid configured by user
 *
 * To use this with Bootstrap Element or Form elements
 * user must define the columns array in the object context.
 *
 * Sample of columns array :
 *
 * columns => array(
 *   mobile => 12,
 *   tablet => 12,
 *   small => 6,
 *   large => 6,
 * ),
 *
 * Example of using this class :
 *
 * $class = new VTCore_Bootstrap_Grid_Column($context);
 * $class->getClass();
 *
 * This class is not extensible and or be used as a shortcut
 * as the design is intended to be singleton
 *
 * @author jason.xie@victheme.com
 *
 */
final class VTCore_Bootstrap_Grid_Column {

  private $context = array(
    'columns' => array(
      'mobile' => false,
      'tablet' => false,
      'small' => false,
      'large' => false,
    ),
    'push' => array(
      'mobile' => false,
      'tablet' => false,
      'small' => false,
      'large' => false,
    ),
    'pull' => array(
      'mobile' => false,
      'tablet' => false,
      'small' => false,
      'large' => false,
    ),
    'offset' => array(
      'mobile' => false,
      'tablet' => false,
      'small' => false,
      'large' => false,
    ),
    'hidden' => array(
      'mobile' => false,
      'tablet' => false,
      'small' => false,
      'large' => false,
    ),
    'visible' => array(
      'mobile' => false,
      'tablet' => false,
      'small' => false,
      'large' => false,
    ),
  );

  private $cleanMode = array(
    'push',
    'pull',
    'hidden',
    'visible',
  );


  private $columnsPrefix = array(
    'mobile' => 'col-xs-',
    'tablet' => 'col-sm-',
    'small' => 'col-md-',
    'large' => 'col-lg-',
  );

  private $hiddenPrefix = array(
    'mobile' => 'hidden-xs',
    'tablet' => 'hidden-sm',
    'small' => 'hidden-md',
    'large' => 'hidden-lg',
  );

  private $visiblePrefix = array(
    'mobile' => 'visible-xs',
    'tablet' => 'visible-sm',
    'small' => 'visible-md',
    'large' => 'visible-lg',
  );

  private $pushPrefix = array(
    'mobile' => 'col-xs-push-',
    'tablet' => 'col-sm-push-',
    'small' => 'col-md-push-',
    'large' => 'col-lg-push-',
  );

  private $pullPrefix = array(
    'mobile' => 'col-xs-pull-',
    'tablet' => 'col-sm-pull-',
    'small' => 'col-md-pull-',
    'large' => 'col-lg-pull-',
  );

  private $offsetPrefix = array(
    'mobile' => 'col-xs-offset-',
    'tablet' => 'col-sm-offset-',
    'small' => 'col-md-offset-',
    'large' => 'col-lg-offset-',
  );

  private $class = '';

  public function __construct($context) {
    $this->setContext($context);
    $this->buildColumnAttributes();
  }

  public function setContext($context) {

    // @performance dumb down the array merge for performance since
    // grids is pretty strict in array rules.
    $count = count($context);
    $keys = array_keys($context);
    for ($i=0; $i < $count; $i++) {
      $key = $keys[$i];
      $this->context[$key] = $context[$key];
    }

    return $this;
  }

  public function cleanContext() {
    $this->context = array();
    return $this;
  }

  private function getPrefix($type, $subType) {
    $types = $this->$type;
    return isset($types[$subType]) ? $types[$subType] : '';
  }

  /**
   * @performance maximum microseconds performance sacrificing beautiful code!
   */
  public function buildColumnAttributes() {

    // Clean the class first since this method
    // is accesible multiple time now
    $this->class = '';

    // Only clean offset if no xs-offset is set.
    // This is to fix bug all size follows mobile offset
    if (isset($this->context['offset']) && empty($this->context['offset']['mobile'])) {
      $this->cleanMode[] = 'offset';
    }

    $count = count($this->cleanMode);
    for ($i=0; $i < $count; $i++) {

      $cleanIndex = $this->cleanMode[$i];

      if (!isset($this->context[$cleanIndex])) {
        continue;
      }

      if (isset($this->context[$cleanIndex]['mobile']) && $this->context[$cleanIndex]['mobile'] === false) {
        unset($this->context[$cleanIndex]['mobile']);
      }

      if (isset($this->context[$cleanIndex]['tablet']) && $this->context[$cleanIndex]['tablet'] === false) {
        unset($this->context[$cleanIndex]['tablet']);
      }

      if (isset($this->context[$cleanIndex]['small']) && $this->context[$cleanIndex]['small'] === false) {
        unset($this->context[$cleanIndex]['small']);
      }

      if (isset($this->context[$cleanIndex]['large']) && $this->context[$cleanIndex]['large'] === false) {
        unset($this->context[$cleanIndex]['large']);
      }

      if (empty($this->context[$cleanIndex])) {
        unset($this->context[$cleanIndex]);
      }
    }

    $count = count($this->context);
    $keys = array_keys($this->context);
    for ($i=0; $i < $count; $i++) {

      $type = $keys[$i];
      $settings = $this->context[$type];

      $settingCount = count($settings);
      $settingKeys = array_keys($settings);

      for ($x=0; $x < $settingCount; $x++) {
        $mode = $settingKeys[$x];
        $setting = $settings[$mode];

        if ($setting == 'none') {
          continue;
        }

        $prefixType = $type;
        if ($type == 'columns' && empty($setting)) {
          $prefixType = 'hidden';
        }

        $prefix = isset($this->{$prefixType . 'Prefix'}[$mode]) ? $this->{$prefixType . 'Prefix'}[$mode] : '';
        $this->class .= ' ' . $prefix;

        if ($prefixType != 'hidden' && $prefixType != 'visible') {
          $this->class .= $setting;
        }
      }
    }
  }

  public function getClass() {
    return trim($this->class);
  }
}