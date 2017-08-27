<?php

namespace Aepro;

use Aepro\Aepro_Post_List;
use Elementor\Plugin;

class Post_Helper{
    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        add_action('wp_ajax_ae_post_data',[ $this, 'ajax_post_data']);
        add_action('wp_ajax_nopriv_ae_post_data',[ $this, 'ajax_post_data']);
    }

    public function ajax_post_data(){
        $fetch_mode = $_REQUEST['fetch_mode'];

        $results = [];
        switch($fetch_mode){
            case 'posts' :  $params = $query_params = [
                                            's'         => $_REQUEST['q'],
                                        ];
                            $query = new \WP_Query( $params );

                            foreach ( $query->posts as $post ) {
                                $results[] = [
                                    'id'   => $post->ID,
                                    'text' => $post->post_title,
                                ];
                            }
                            break;

            case 'paged' : //print_r($_POST);
                           ob_start();
                           $this->get_widget_output($_POST['pid'],$_POST['wid']);
                           $results = ob_get_contents();
                           ob_end_clean();
                           break;

            case 'selected_posts' : $args = array('post__in' => $_POST['selected_posts']);
                                    $posts = get_posts($args);
                                    if(count($posts)){
                                        foreach($posts as $p){
                                            $results[] = [
                                                'id'    => $p->ID,
                                                'text'  => $p->post_title
                                            ];
                                        }
                                    }
                                    break;

        }

        wp_send_json_success( $results );
    }

    function get_widget_output($post_id,$widget_id){
        $elementor = Plugin::$instance;


        $meta = Plugin::instance()->db->get_plain_editor( $post_id );
        $widget = $this->find_element_recursive( $meta, $widget_id );


        $widget_instance = $elementor->elements_manager->create_element_instance( $widget );
        $widget['settings'] = $widget_instance->get_active_settings();


        if(isset($widget['settings'])){
            require_once AE_PRO_PATH . 'includes/elements/post-blocks.php';

            $post_list  = new Aepro_Post_Blocks();
            $post_list->generate_output($widget['settings'],false);
        }
    }

    private function find_element_recursive( $elements, $widget_id ) {
        foreach ( $elements as $element ) {
            if ( $widget_id === $element['id'] ) {
                return $element;
            }

            if ( ! empty( $element['elements'] ) ) {
                $element = $this->find_element_recursive( $element['elements'], $widget_id );

                if ( $element ) {
                    return $element;
                }
            }
        }

        return false;
    }

    public function get_taxonomy_terms($taxonomy){

        $tax_array = [];
        $terms = get_terms([
            'taxonomy'  => $taxonomy,
            'hide_empty' => false
        ]);

        if(count($terms)){
            //echo $taxonomy.'<br/><pre>'; print_r($terms); echo '</pre><hr/>';
            foreach($terms as $term){
                $tax_array[$term->term_id] = $term->name;
            }
        }

        return $tax_array;
    }


}

Post_Helper::instance();