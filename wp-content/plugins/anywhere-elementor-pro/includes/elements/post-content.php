<?php

namespace Aepro;

use Elementor;
use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;

class Aepro_Post_Content extends Widget_Base{
    public function get_name() {
        return 'ae-post-content';
    }

    public function get_title() {
        return __( 'AE - Post Content', 'ae-pro' );
    }

    public function get_icon() {
        return 'eicon-align-left';
    }

    public function get_categories() {
        return [ 'ae-template-elements' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_layout_settings',
            [
                'label' => __( 'Layout Settings', 'ae-pro' )
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => __( 'Show Excerpt', 'ae-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __( 'Yes', 'ae-pro' ),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __( 'No', 'ae-pro' ),
                        'icon' => 'fa fa-ban',
                    ]
                ],
                'default' => '0'
            ]
        );

        $this->add_control(
            'excerpt_size',
            [
                'label' => __( 'Excerpt Size', 'ae-pro' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '10',
                'condition' => [
                    'show_excerpt' => '1',
                ]

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_general_style',
            [
                'label' => __( 'Content', 'ae-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'content_color',
            [
                'label' => __( 'Content Color', 'ae-pro' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ae-element-post-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_align',
            [
                'label' => __( 'Content Align', 'ae-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'ae-pro' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'ae-pro' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'ae-pro' ),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .ae-element-post-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => __( 'Content Typography', 'ae-pro' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .ae-element-post-content',
            ]
        );

        $this->end_controls_section();
    }

    protected function render( ) {
        $settings = $this->get_settings();
        $helper = new Helper();
        $post_data = $helper->get_demo_post_data();

        if($post_data->post_type == 'elementor_library'){
            return false;
        }
        $post_excerpt = wpautop($post_data->post_excerpt);
        
        $post_content = wpautop($post_data->post_content);

        $this->add_render_attribute( 'post-content-class', 'class', 'ae-element-post-content' );
        ?>
        <?php if($settings['show_excerpt']): ?>
            <div <?php echo $this->get_render_attribute_string('post-content-class');?>>
            <?php if($post_excerpt != ''):?>
                    <?php echo wp_trim_words( $post_excerpt, $settings['excerpt_size'], '...' );?>
                <?php else:?>
                    <?php echo wp_trim_words( $post_content, $settings['excerpt_size'], '...' );?>
                <?php endif; ?>
            </div>
        <?php else:?>
            <div <?php echo $this->get_render_attribute_string('post-content-class');?>>
                <?php
                    if(Plugin::$instance->db->is_built_with_elementor( $post_data->ID )){
                        echo Plugin::instance()->frontend->get_builder_content($post_data->ID);
                    }else{
                        echo do_shortcode($post_content);
                    }
                ?>
            </div>
        <?php endif; ?>
        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Aepro_Post_Content() );