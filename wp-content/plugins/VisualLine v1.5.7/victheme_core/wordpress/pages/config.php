<?php
/**
 * Page callback class for building the VicTheme Core
 * configuration page
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Pages_Config
extends VTCore_Wordpress_Models_Page {

  protected $sidebar;
  protected $content;

  protected function register() {
    $plugin_data = get_plugin_data(VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'victheme_core.php');
    $this->headerText = __('VicTheme Core - Configuration', 'victheme_core');
    $this->headerSmallText = sprintf(__('version %s', 'victheme_core'), $plugin_data['Version']);
    $this->headerIcon = 'dashboard';
    $this->saveKey = 'vtcore-save';
    $this->resetKey = 'vtcore-reset';
    $this->actionHeaderKey = 'vtcore-configuration-header-alter';
    $this->actionFormKey = 'vtcore-configuration-form-alter';
  }

  protected function loadAssets() {
    wp_deregister_script('heartbeat');
    VTCore_Wordpress_Utility::loadAsset('wp-bootstrap');
    VTCore_Wordpress_Utility::loadAsset('wp-ajax');
    VTCore_Wordpress_Utility::loadAsset('wp-page');
    VTCore_Wordpress_Utility::loadAsset('font-awesome');
    VTCore_Wordpress_Utility::loadAsset('bootstrap-confirmation');
  }

  public function renderAjax($post) {
    return false;
  }

  protected function save() {

    $this->messages->setNotice(__('Core configuration saved', 'victheme_core'));
    update_option('vtcore_core_options', $_POST['core']);

    // Refresh the core config factory
    VTCore_Wordpress_Init::setFactory('coreConfig', new VTCore_Wordpress_Objects_Array(get_option('vtcore_core_options', array(
      'aggregate' => array(
        'frontend' => false,
        'backend' => true,
      ),
      'cachetime' => 24,
    ))));
  }

  protected function reset() {
    $this->messages->setNotice(__('Core resetted to default value', 'victheme_core'));
    delete_option('vtcore_core_options');

    // Refresh the core config factory
    VTCore_Wordpress_Init::setFactory('coreConfig', new VTCore_Wordpress_Objects_Array(get_option('vtcore_core_options', array(
      'aggregate' => array(
        'frontend' => false,
        'backend' => true,
      ),
      'cachetime' => 24,
    ))));

    return $this;
  }


  public function buildPage() {

    parent::buildPage();
  }


  protected function buildForm() {

    if (!function_exists('wp_calculate_image_srcset')) {
      $this->messages->setError(__('Responsive Image needs Wordpress version 4.4 and above to work.', 'victheme_core'));
    }

    $this->form = new VTCore_Bootstrap_Form_BsInstance(array(
      'attributes' => array(
        'id' => 'vtcore-configuration-form',
        'method' => 'post',
        'action' => $_SERVER['REQUEST_URI'],
        'class' => array('container-fluid', 'vtcore-configuration-form-skins'),
        'autocomplete' => 'off',
      ),
    ));

    $this->form
      ->addChildren(new VTCore_Bootstrap_Grid_BsRow());

    $this->content = $this->form
      ->lastChild()
      ->addChildren(new VTCore_Bootstrap_Grid_BsColumn(array(
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 8,
            'small' => 8,
            'large' => 8,
          ),
        ),
      )))
      ->lastChild();

    $this->sidebar = $this->form
      ->lastChild()
      ->addChildren(new VTCore_Bootstrap_Grid_BsColumn(array(
        'grids' => array(
          'columns' => array(
            'mobile' => 12,
            'tablet' => 4,
            'small' => 4,
            'large' => 4,
          ),
        ),
      )))
      ->lastChild();


    $this->buildCoreConfigurationPanel();

    $this->buildImagePanel();

    $this->buildSavePanel();

    $this->buildSidebarInformation();


    /** Experimental **/
    // $this->buildCompressorPanel();
  }


  /**
   * Build the form sidebar
   */
  protected function buildSidebarInformation() {

    $icon = '<i class="fa fa-check"></i>';
    $class = 'panel-success';
    $status = sprintf(__('Core is caching with %s hour expiration time', 'victheme_core'), VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime'));

    if (defined('WP_DEBUG') && WP_DEBUG) {
      $icon = '<i class="fa fa-close"></i>';
      $class = 'panel-danger';
      $status = __('<strong>WP_DEBUG</strong> is enabled in wp-config.php and set to true.<br><br>
      Core will be rebuild cache on every page load. Please disable <strong>WP_DEBUG</strong> when not on development.', 'victheme_core');
    }

    $this->sidebar
      ->addChildren(new VTCore_Bootstrap_Element_BsPanel(array(
        'text' => __('Core Cache Status', 'victheme_core') . $icon,
        'attributes' => array(
          'class' => array(
            $class
          ),
        ),
      )))
      ->lastChild()
      ->addContent($status);

    $this->buildClearCachePanel();

    $this->buildUpdateDatabasePanel();

    $this->sidebar
      ->addChildren(new VTCore_Bootstrap_Element_BsPanel(array(
        'text' => __('PHP Information', 'victheme_core'),
      )))
      ->lastChild()
      ->addContent(__('PHP information about this server', 'victheme_core'))
      ->addTable(array(
        'headers' => array(
          'Information',
          'Value',
        ),
      ))
      ->getTable()
      ->addRows('tbody', array(
        __('Version', 'victheme_core'),
        phpversion(),
      ))
      ->addRows('tbody', array(
        __('Memory Limit', 'victheme_core'),
        ini_get('memory_limit'),
      ))
      ->addRows('tbody', array(
        __('WP Max Memory Limit', 'victheme_core'),
        WP_MAX_MEMORY_LIMIT,
      ))
      ->addRows('tbody', array(
        __('Execution Time', 'victheme_core'),
        sprintf(__('%s seconds', 'victheme_core'), ini_get('max_execution_time')),
      ))
      ->addRows('tbody', array(
        __('Upload Size', 'victheme_core'),
        ini_get('upload_max_filesize'),
      ))
      ->addRows('tbody', array(
        __('Post Size', 'victheme_core'),
        ini_get('post_max_size'),
      ))
      ->addRows('tbody', array(
        __('OP Code Cache', 'victheme_core'),
        $this->detectOpCache(),
      ))
      ->addRows('tbody', array(
        __('Server', 'victheme_core'),
        $_SERVER['SERVER_SOFTWARE'],
      ));


  }


  /**
   * Method for detecting if server has opcode cache enabled.
   * @return string|void
   */
  protected function detectOpCache() {
    $cache = __('No Cache Available', 'victheme_core');

    if (function_exists('xcache_isset')) {
      $cache = 'XCache';
    }
    elseif (function_exists('wincache_fcache_fileinfo')) {
      $cache = 'WinCache';
    }
    elseif (function_exists('apc_add')) {
      $cache = 'APC Cache';
    }
    elseif ((bool)strlen(ini_get('eaccelerator.enable'))) {
      $cache = 'Eaccelerator';
    }
    elseif ((bool)strlen(ini_get('phpa'))) {
      $cache = 'IonCube';
    }
    elseif ((bool)strlen(ini_get('zend_optimizer.enable_loader'))) {
      $cache = 'ZenOptimizer';
    }
    elseif (function_exists('phpexpress')) {
      $cache = 'NuSphere';
    }
    elseif ((bool)strlen(ini_get('opcache.enable'))) {
      $cache = 'PHP OpCode';
    }

    return $cache;
  }


  /**
   * Build the main core configuration panel
   */
  protected function buildCoreConfigurationPanel() {

    $disableAggregation = VTCore_Wordpress_Init::getFactory('assets')->maybeByPassAggregate();
    $disable = false;
    $backend = __('Aggregate CSS and Javascript managed by Core when in backend', 'victheme_core');
    $frontend = __('Aggregate CSS and Javascript managed by Core when in frontend', 'victheme_core');

    if ($disableAggregation) {
      VTCore_Wordpress_Init::getFactory('coreConfig')->add('aggregate.backend', false);
      VTCore_Wordpress_Init::getFactory('coreConfig')->add('aggregate.frontend', false);
      $disable = true;
      $frontend = $backend = sprintf(__('Aggregate CSS and Javascript management is disabled because plugin <strong><em>%s</em></strong> is incompatible with it', 'victheme_core'), $disableAggregation);
    }

    $this->content
      ->addChildren(new VTCore_Bootstrap_Element_BsPanel(array(
        'text' => __('Core Configuration', 'victheme_core'),
      )))
      ->lastChild()
      ->addContent(new VTCore_Bootstrap_Form_BsCheckbox(array(
        'text' => __('Aggregate Backend Assets', 'victheme_core'),
        'description' => $backend,
        'name' => 'core[aggregate][backend]',
        'switch' => true,
        'checked' => (boolean) VTCore_Wordpress_Init::getFactory('coreConfig')->get('aggregate.backend'),
        'disabled' => $disable,
      )))
      ->addContent(new VTCore_Bootstrap_Form_BsCheckbox(array(
        'text' => __('Aggregate Frontend Assets', 'victheme_core'),
        'description' => $frontend,
        'name' => 'core[aggregate][frontend]',
        'switch' => true,
        'checked' => (boolean) VTCore_Wordpress_Init::getFactory('coreConfig')->get('aggregate.frontend'),
        'disabled' => $disable,
      )))
      ->addContent(new VTCore_Bootstrap_Form_BsNumber(array(
        'text' => __('Core Cache Expiration', 'victheme_core'),
        'description' => __('Define the global configuration for expiring the core cache, always use high number for production site and low number for development site.', 'victheme_core'),
        'name' => 'core[cachetime]',
        'suffix' => __('Hour', 'victheme_core'),
        'required' => true,
        'value' => VTCore_Wordpress_Init::getFactory('coreConfig')->get('cachetime'),
        'min' => 1,
        'step' => 1,
      )));
  }


  /**
   * Build the image configuration panel
   */
  protected function buildImagePanel() {

    $noResponsive = false;
    if (!function_exists('wp_calculate_image_srcset')) {
      VTCore_Wordpress_Init::getFactory('coreConfig')->set('images.responsive', false);
      $noResponsive = true;
    }


    $this->content
      ->addChildren(new VTCore_Bootstrap_Element_BsPanel(array(
        'text' => __('Image Configuration', 'victheme_core'),
      )))
      ->lastChild()
      ->addContent(new VTCore_Bootstrap_Form_BsCheckbox(array(
        'text' => __('Enable Responsive Image', 'victheme_core'),
        'description' => __('Responsive image will be created using HTML5 srcset attributes and you will need to regenerate thumbnails for previously uploaded image
                             to regenerate the responsives image sizes.', 'victheme_core'),
        'name' => 'core[images][responsive]',
        'switch' => true,
        'disabled' => $noResponsive,
        'checked' => (boolean) VTCore_Wordpress_Init::getFactory('coreConfig')->get('images.responsive'),
      )))
      ->addContent(new VTCore_Bootstrap_Form_BsCheckbox(array(
        'text' => __('Enable Old Javascript Retina', 'victheme_core'),
        'description' => __('Load the old style javascript retina image injection method, this is deprecated and should only be enabled when needed only.', 'victheme_core'),
        'name' => 'core[images][retinajs]',
        'switch' => true,
        'checked' => (boolean) VTCore_Wordpress_Init::getFactory('coreConfig')->get('images.retinajs'),
      )));
  }


  /**
   * Build the saving panel box
   */
  protected function buildSavePanel() {
    $this->content
      ->addChildren(new VTCore_Bootstrap_Form_BsSubmit(array(
        'attributes' => array(
          'name' => $this->saveKey,
          'value' => __('Save', 'victheme_core'),
        ),
      )))
      ->addChildren(new VTCore_Bootstrap_Form_BsSubmit(array(
        'attributes' => array(
          'name' => $this->resetKey,
          'value' => __('Reset', 'victheme_core'),
        ),
        'mode' => 'danger',
        'confirmation' => true,
        'title' => __('Are you sure?', 'victheme_core'),
        'ok' => __('Yes', 'victheme_core'),
        'cancel' => __('No', 'victheme_core'),
      )));
  }


  /**
   * Build the clear cache panel
   */
  protected function buildClearCachePanel() {
    if (isset($_POST['vtcore-clearcache'])) {
      $this->messages->setNotice(__('All Core related cached deleted', 'victheme_core'));

      // Just promise to delete on next page load
      update_option('vtcore_clear_cache', TRUE);
    }

    $this->sidebar
      ->addChildren(new VTCore_Bootstrap_Element_BsPanel(array(
        'text' => __('Core Cache', 'victheme_core'),
      )))
      ->lastChild()
      ->addContent(new VTCore_Bootstrap_Form_BsDescription(array(
        'text' => __('Caching core will be performed automatically, you can force to clear the cache by clicking the clear cache button', 'victheme_core'),
      )))
      ->addContent(new VTCore_Bootstrap_Form_BsSubmit(array(
        'attributes' => array(
          'name' => 'vtcore-clearcache',
          'value' => __('Clear Cache', 'victheme_core'),
        ),
        'mode' => 'danger',
        'confirmation' => true,
        'title' => __('Are you sure?', 'victheme_core'),
        'ok' => __('Yes', 'victheme_core'),
        'cancel' => __('No', 'victheme_core'),
      )));
  }


  /**
   * Only build the object here as this will be called via ajax too!
   * @return \VTCore_Bootstrap_Element_BsPanel
   */
  public function databaseUpdaterPanel() {
    $panel = new VTCore_Bootstrap_Element_BsPanel(array(
      'text' => __('Update Database', 'victheme_core'),
      'attributes' => array(
        'id' => 'vtcore-updater-panel'
      ),
    ));

    $ajaxQueue = array();
    $updater = VTCore_Wordpress_Init::getFactory('updater');

    if ($updater->checkUpdateNeeded()) {

      $panel
        ->addTable(array(
        'headers' => array(
          __('Available Updates', 'victheme_core'),
          __('Status', 'victheme_core'),
        ),
      ));

      $updates = VTCore_Wordpress_Init::getFactory('updater')->get('registry');

      foreach ($updates as $plugin => $data) {
        foreach ($data['updates'] as $version => $text) {
          if (!$updater->get('status.' . $plugin . '.' . $version)) {
            $panel->getTable()->addRows('tbody', array(
              array(
                'content' => $text,
                'attributes' => array(
                  'class' => array(
                    'update-text',
                  ),
                ),
              ),
              array(
                'content' => '<i class="fa fa-times-circle-o text-danger"></i>',
                'attributes' => array(
                  'data-update-key' => $plugin . '##' . $version,
                ),
              )
            ));
            $ajaxQueue[] = $plugin . '##' . $version;
          }
        }
      }

      $ajaxQueue[] = 'update-table';

      $panel
        ->addContent(new VTCore_Bootstrap_Form_BsDescription(array(
          'text' => __('Review the update log and perform database update to ensure maximum performances.', 'victheme_core'),
        )))
        ->addFooter(new VTCore_Bootstrap_Form_BsButton(array(
          'text' => __('Update Database', 'victheme_core'),
          'attributes' => array(
            'class' => array(
              'btn-ajax',
              'btn-updater',
            ),
          ),
          'disabled' => empty($ajaxQueue),
          'confirmation' => true,
          'title' => __('Are you sure?', 'victheme_core'),
          'ok' => __('Yes', 'victheme_core'),
          'cancel' => __('No', 'victheme_core'),
          'data' => array(
            'button-id' => 'updater-button',
            'ajax-mode' => 'selfData',
            'ajax-target' => '#vtcore-updater-panel',
            'ajax-loading-text' => __('Updating Database', 'victheme_demo'),
            'ajax-object' => 'updater',
            'ajax-action' => 'vtcore_ajax_framework',
            'ajax-value' => 'updater',
            'ajax-queue' => $ajaxQueue,
            'ajax-completed' => '',
            'ajax-retry' => 10,
            'nonce' => wp_create_nonce('vtcore-ajax-nonce-admin'),
          ),
        )));
    }

    // No update needed
    else {
      $panel
        ->addContent(new VTCore_Bootstrap_Form_BsDescription(array(
          'text' => __('Database is up to date, no need to perform any update.', 'victheme_core'),
        )));
    }

    return $panel;
  }

  /**
   * Build the update database panel
   */
  protected function buildUpdateDatabasePanel() {

    $this->sidebar->addChildren($this->databaseUpdaterPanel());
  }

  /**
   * Build the compressor panel
   *
   * @experimental don't use this yet!
   */
  protected function buildCompressorPanel() {

    if (isset($_POST['compress-core'])) {
      $this->compressCore();
    }

    $this->content
      ->addChildren(new VTCore_Bootstrap_Element_BsPanel(array(
        'text' => __('Merge & Compressed Core Class', 'victheme_core'),
      )))
      ->lastChild()
      ->addContent(new VTCore_Bootstrap_Form_BsDescription(array(
        'text' => __('Merging core class into a single class can improve page loading but it can increase the memory used when loading the page. Please make sure
                      that your server has high memory limit set and PHP is allowed to write into the plugin folder.', 'victheme_core'),
      )))
      ->addContent(new VTCore_Bootstrap_Form_BsSubmit(array(
        'attributes' => array(
          'name' => 'compress-core',
          'value' => __('Compress', 'victheme_core'),
        ),
        'mode' => 'danger',
        'confirmation' => true,
        'title' => __('Are you sure?', 'victheme_core'),
        'ok' => __('Yes', 'victheme_core'),
        'cancel' => __('No', 'victheme_core'),
      )));
  }

  /**
   * Method for joining multiple smaller classes found in each directory
   * into a single large file with multiple classes.
   *
   * Not all files can be merged especially one that is extending another
   * class.
   *
   * Only list directory that is safe to be combined.
   * @todo create a complete new class that can handle interface, abstract, extends and
   *       create a proper compressed class with hierarchy and comment + white space stripping.
   * @experimental Do not use this yet!
   */
  protected function compressCore() {



    $paths = array(
      'compressed-html.php' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'vtcore' . DIRECTORY_SEPARATOR . 'html',
      'compressed-form.php' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'vtcore' . DIRECTORY_SEPARATOR . 'form',
      'compressed-socialshare.php' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'vtcore' . DIRECTORY_SEPARATOR . 'socialshare',
      'compressed-validator.php' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'vtcore' . DIRECTORY_SEPARATOR . 'validator',
      'compressed-cssbuilder.php' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'vtcore' . DIRECTORY_SEPARATOR . 'cssbuilder',
      'compressed-bootstrap.php' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'vtcore' . DIRECTORY_SEPARATOR . 'bootstrap',
      'compressed-wordpress.php' => array(
        'interface' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'interfaces',
        'models' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'models',
        'objects' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'objects',
        'data' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'data',
        'ajax' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'ajax',
        'element' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'element',
        'form' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'form',
        'queries' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'queries',
        'factory' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'factory',
        'layout' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'layout',
        'metabox' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'metabox',
        'filters' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'filters',
        'actions' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'actions',
        'shortcodes' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'shortcodes',
        'widgets' => VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'wordpress'. DIRECTORY_SEPARATOR . 'widgets',
      )
    );

    $skipped = array(
      'bsmessages.php',
      'bsglyphicon.php',
      'bsicon.php'
    );

    foreach ($paths as $filename => $paths) {

      if (!is_array($paths)) {
        $paths = array('file' => $paths);
      }

      $content = '';
      foreach ($paths as $path) {
        $directories = new RecursiveDirectoryIterator($path);
        foreach (new RecursiveIteratorIterator($directories) as $file) {
          $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
          if ($ext != 'php' || in_array($file->getFilename(), $skipped)) {
            continue;
          }

          $content .= file_get_contents($file->getRealPath()) . "\n?>\n";
        }
      }

      if (!empty($content)) {
        if (!is_dir(VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'compressed')) {
          mkdir(VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'compressed');
        }
        $fileTarget = fopen(VTCORE_CORE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'compressed' . DIRECTORY_SEPARATOR . $filename, 'w');
        fwrite($fileTarget, $content);
        fclose($fileTarget);
      }

    }
  }

}