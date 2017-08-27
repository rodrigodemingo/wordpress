<?php
namespace Aepro;

class Ae_Theme{

    public $_page_type = '';
    public $_override = 'partial'; // 'full' or 'partial'
    public $_use_canvas = false;

    function manage_actions(){
        remove_action( 'generate_before_content','generate_featured_page_header_inside_single', 10);
        remove_action( 'generate_after_entry_title', 'generate_post_meta' );
        remove_action( 'generate_after_entry_content', 'generate_footer_meta' );
        remove_action( 'generate_after_entry_content', 'generate_footer_meta' );
        remove_action( 'generate_before_content','generate_featured_page_header_inside_single' );

        add_filter( 'generate_show_title', [ $this, 'ae_gp_show_title'] );

        // Template File Overrides
        add_filter('template_include', [$this, 'load_archive_template']);
        add_filter('single_template', [$this, 'load_single_template']);

        return true;
    }


    function load_archive_template($template_include){

        if(is_page()){
            return $this->load_single_template($template_include);
        }

        if(is_archive() || ($this->_page_type == 'blog')){
            if($this->_override == 'partial'){
                $template_include = AE_PRO_PATH . 'includes/themes/generatepress/archive.php';
            }else{
                if($this->_use_canvas){
                    $template_include = AE_PRO_PATH . 'includes/themes/canvas-archive.php';
                }else{
                    $template_include = AE_PRO_PATH . 'includes/themes/generatepress/archive-full.php';
                }

                // set template with no sidebar
                add_filter('generate_sidebar_layout',function($layout){
                     return 'no-sidebar';
                });

                add_filter('body_class',function($classes){
                        $classes[] = 'full-width-content';
                        return $classes;
                });
            }
        }

        if(is_404()){
            if($this->_use_canvas){
                $template_include = AE_PRO_PATH . 'includes/themes/canvas-404.php';
            }else{
                $template_include = AE_PRO_PATH . 'includes/themes/generatepress/404.php';
                // set template with no sidebar
                add_filter('generate_sidebar_layout',function($layout){
                    return 'no-sidebar';
                });

                add_filter('body_class',function($classes){
                    $classes[] = 'full-width-content';
                    return $classes;
                });
            }


        }
        return $template_include;
    }

    function load_single_template($single_template){
        $single_template = AE_PRO_PATH . 'includes/themes/generatepress/single.php';
        return $single_template;
    }

    function ae_gp_show_title(){
        return false;
    }

    function theme_hooks($hook_positions){
        $hook_positions['generate_before_header'] = __('GP Before Header', 'ae-pro');
        $hook_positions['generate_before_header_content'] = __('GP Before Header Content', 'ae-pro');
        $hook_positions['generate_after_header_content'] = __('GP After Header Content', 'ae-pro');
        $hook_positions['generate_after_header'] = __('GP After Header', 'ae-pro');
        $hook_positions['generate_inside_container'] = __('GP Inside Container', 'ae-pro');
        $hook_positions['generate_before_footer'] = __('GP Before Footer', 'ae-pro');
        $hook_positions['generate_before_footer_content'] = __('GP Before Footer Content', 'ae-pro');
        $hook_positions['generate_after_footer_widgets'] = __('GP After Footer Widgets', 'ae-pro');
        $hook_positions['generate_credits'] = __('GP Credits', 'ae-pro');
        $hook_positions['generate_after_footer_content'] = __('GP After Footer Content', 'ae-pro');
        $hook_positions['generate_before_main_content'] = __('GP Before Main Content', 'ae-pro');
        $hook_positions['generate_before_content'] = __('GP Before Content', 'ae-pro');
        $hook_positions['generate_after_entry_header'] = __('GP After Entry Header', 'ae-pro');
        $hook_positions['generate_after_content'] = __('GP After Content', 'ae-pro');
        $hook_positions['generate_after_main_content'] = __('GP After Main Content', 'ae-pro');
        $hook_positions['generate_sidebars'] = __('GP Sidebars', 'ae-pro');
        $hook_positions['generate_archive_title'] = __('GP Archive Title', 'ae-pro');
        $hook_positions['generate_inside_comments'] = __('GP Inside Comments', 'ae-pro');
        $hook_positions['generate_below_comments_title'] = __('GP Below Comments Title', 'ae-pro');
        $hook_positions['generate_before_entry_title'] = __('GP Before Entry Title', 'ae-pro');
        $hook_positions['generate_after_entry_title'] = __('GP After Entry Title', 'ae-pro');
        $hook_positions['generate_after_entry_content'] = __('GP After Entry Content', 'ae-pro');
        $hook_positions['generate_before_right_sidebar_content'] = __('GP Before Right Sidebar Content', 'ae-pro');
        $hook_positions['generate_after_right_sidebar_content'] = __('GP After Right Sidebar Content', 'ae-pro');
        $hook_positions['generate_before_left_sidebar_content'] = __('GP Before Left Sidebar Content', 'ae-pro');
        $hook_positions['generate_after_left_sidebar_content'] = __('GP After Left Sidebar Content', 'ae-pro');
        $hook_positions['generate_inside_navigation'] = __('GP Inside Navigation', 'ae-pro');
        $hook_positions['generate_inside_mobile_menu'] = __('GP inside Mobile Menu', 'ae-pro');
        $hook_positions['generate_paging_navigation'] = __('GP Paging Navigation', 'ae-pro');
        $hook_positions['generate_before_logo'] = __('GP Before Logo', 'ae-pro');
        $hook_positions['generate_after_logo'] = __('GP After Logo', 'ae-pro');
        $hook_positions['generate_before_archive_title'] = __('GP Before Archive Title', 'ae-pro');
        $hook_positions['generate_after_archive_title'] = __('GP After Archive Title', 'ae-pro');
        $hook_positions['generate_after_archive_description'] = __('GP After Archive Description', 'ae-pro');
        return $hook_positions;
    }
}