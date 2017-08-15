<?php
/**
 * Class for building layout region.
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Wordpress_Layout_Region
extends VTCore_Bootstrap_Grid_BsColumn {

  protected $context = array(
    'type' => 'div',
    'text' => '',
    'mode' => 'dynamic',
    'parent' => '',
    'weight' => '',
    'attributes' => array(),
    'grids' => array(
      'columns' => array(
        'mobile' => '12',
        'tablet' => '12',
        'small' => '12',
        'large' => '12',
      ),
    ),
    'arguments' => array(
      'name' => false,
      'id' => false,
      'description' => false,
      'class' => false,
      'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
      'after_widget' => '</div>',
      'before_title' => '<h2 class="widgettitle">',
      'after_title' => '</h2>',
    ),
  );



  public function registerSidebar() {
    // Only register sidebar with valid id
    if ($this->getContext('arguments.id')) {
      register_sidebar($this->getContext('arguments'));
    }
  }



  public function getArgument($key) {
    return isset($this->context['arguments'][$key]) ? $this->context['arguments'][$key] : FALSE;
  }



  public function retrieveSidebar() {
    ob_start();
    dynamic_sidebar($this->getArgument('id'));
    $content = ob_end_clean();
    $this->setText($content);
  }




  public function isActive() {
    $widgetcolumns = wp_get_sidebars_widgets();
    return (!empty($widgetcolumns[$this->getArgument('id')]));
  }
}