<?php
/**
 * Helper class for quick shortcut in building table element
 *
 * The class supports table structure with caption, headers,
 * body and footers.
 *
 * If user wish to add more rows to headers, body or footers
 * after the class is initialized and context is processed,
 * they must use the addRows() method instead of addChildren()
 * base method.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Html_Table
extends VTCore_Html_Base {

  protected $context = array(
    'type' => 'table',
    'caption' => '',
    'headers' => array(),
    'rows' => array(),
    'footers' => array(),
    'attributes' => array(
      'class' => array('form-table'),
    ),
  );

  protected $tbody;
  protected $thead;
  protected $tfoot;



  /**
   * Method for adding more rows to the table
   * header, content or footer.
   *
   * @param string $type
   *     The type of rows such as thead, tbody or tfoot.
   *
   * @param array $datas
   *     Array of child object, must be HTML objects or its
   *     decendants.
   *
   *     The array must contain multiple arrays to simulate
   *     each of the table data (td).
   */
  public function addRows($type, array $datas) {

    if (!is_a($this->$type, 'VTCore_Html_Base')) {
      $this->addType($type);
    }

    $row = $this->$type->addChildren(new VTCore_Html_Element(array(
      'type' => 'tr',
    )))
    ->lastChild();

    foreach ($datas as $key => $data) {

      if ($key === 'data') {
        $row->setData($data);
        continue;
      }

      if ($key === 'attributes') {
        $row->addAttributes($data);
        continue;
      }

      $cell = $row->addChildren(new VTCore_Html_Element(array(
        'type' => ($type == 'thead') ? 'th' : 'td',
      )))
      ->lastChild();

      if (!is_array($data)) {
        $cell->addChildren($data);
      }
      elseif (isset($data['attributes']) && isset($data['content'])) {
        $cell->addAttributes($data['attributes']);
        $cell->addChildren($data['content']);
      }
    }

    return $this;

  }

  /**
   * Method for building the type wrapper
   * This is separated so user can inject this after
   * the buildElement
   * @param $type
   * @return $this
   */
  public function addType($type) {

    // Limit user to only able to build thead, tbody and tfoot
    // and only able to do it once.
    if (!is_a($this->$type, 'VTCore_Html_Base')
        && in_array($type, array('thead', 'tbody', 'tfoot'))) {

      switch ($type) {
        case 'thead' :
          $class = 'table-header';
          break;
        case 'tbody' :
          $class = 'table-rows';
          break;
        case 'tfoot' :
          $class = 'table-footer';
      }

      $this->$type = $this->addChildren(new VTCore_Html_Base(array(
          'type' => $type,
          'attributes' => array(
            'class' => array($class),
          ),
        )))
        ->lastChild();
    }

    return $this;
  }



  public function buildElement() {
    $this->addAttributes($this->getContext('attributes'));

    // Build Caption
    $caption = $this->getContext('caption');
    if (!empty($caption)) {
      $this->addChildren(new VTCore_Html_Base(array(
        'type' => 'caption',
      )))
      ->lastChild()
      ->addText($caption);
    }

    // Build Headers
    $headers = $this->getContext('headers');
    if ($headers) {
      $this->addType('thead');
      $this->addRows('thead', $headers);
    }

    // Build Rows
    $rows = $this->getContext('rows');
    if ($rows) {
      $this->addType('tbody');
      if (is_array($rows)) {
        foreach ($rows as $key => $data) {
          $this->addRows('tbody', $data);
        }
      }
    }

    // Build Footers
    $footers = $this->getContext('footers');
    if ($footers) {
      $this->addType('tfoot');
      $this->addRows('tfoot', $footers);
    }
  }
}