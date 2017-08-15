<?php
/**
 * Factory class for building the proper Layout
 * object using VTCore rules
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Factory_Layout
extends VTCore_Bootstrap_Element_BsElement
implements VTCore_Wordpress_Interfaces_Factory {

  protected $context = array(
    'type' => 'div',
    'attributes' => array(
      'id' => 'page',
    ),
    'areas' => array(),
    'regions' => array(),
    'blocks' => array(),
  );


  /**
   * Overriding parent method.
   * Building the layout structures
   */
  public function buildElement() {

    // Building the areas
    // Do not attempt to cache the object!. WP + APC will break
    // upon object deserialization!.
    foreach ($this->getContext('areas') as $name => $context) {
      $object = new VTCore_Wordpress_Layout_Area($context);
      $object->setMachineID('area-' . $name);
      $this->addChildren($object);
      unset($object);
    }


    // Building the Regions and inject to its parent areas
    foreach ($this->getContext('regions') as $name => $context) {
      $object = new VTCore_Wordpress_Layout_Region($context);
      $object->addContext('regionId', $name);
      $object->setMachineID('region-' . $name);

      $parent = $this->getChildren('area-' . $object->getContext('parent'));
      if ($parent) {
        $parent->addChildren($object);
      }

      unset($parent);
      unset($object);
    }


    // Building the Blocks and inject it to the parent Regions
    foreach ($this->getContext('blocks') as $name => $context) {
      $name = 'VTCore_Wordpress_Layout_Block';
      if (class_exists($context['object'], true)) {
        $name = $context['object'];
      }
      $object = new $name($context);

      $parents = $this->findChildren('id', 'region-' . $object->getContext('parent'));

      foreach ($parents as $parent) {
        $parent->addChildren($object);
      }
      unset($object);
    }


    $this->sortElements();

  }



  /**
   * Method for checking if class should bypass cache
   * @return VTCore_Wordpress_Factory_Layout
   */
  public function maybeByPassCache() {
    return $this;
  }


  /**
   * Method for loading from cache
   * @return VTCore_Wordpress_Factory_Layout
   */
  public function loadCache() {
    return $this;
  }


  /**
   * Method for clearing cached elements
   * @return VTCore_Wordpress_Factory_Layout
   */
  public function clearCache() {
    return $this;
  }




  /**
   * Sorting elements based on it weight context
   * @return VTCore_Wordpress_Factory_Layout
   */
  private function sortElements() {

    $areas = $this->getChildrens();

    // Sorting regions, and blocks.
    foreach ($areas as $area) {

      $regions = $area->getChildrens();

      foreach ($regions as $region) {
        $blocks = $region->getChildrens();

        if (!empty($blocks)) {
          // Sorting blocks
          uasort($blocks, array($this, 'sortByWeight'));
          $region->setChildren($blocks);
        }
        unset($blocks);
      }

      // Sorting Regions
      if (!empty($regions)) {
        uasort($regions, array($this, 'sortByWeight'));
        $area->setChildren($regions);
        unset($regions);
      }
    }

    // Sorting Areas
    uasort($areas, array($this, 'sortByWeight'));
    $this->setChildren($areas);
    unset($areas);



    return $this;
  }




  /**
   * Helper function for comparing weight value between
   * a and b
   * @return number
   */
  private function sortByWeight($a, $b) {
    return $a->getContext('weight') > $b->getContext('weight') ? 1 : -1;
  }

}