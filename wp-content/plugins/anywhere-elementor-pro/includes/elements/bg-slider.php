<?php
namespace Aepro;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;

class Aepro_Bg_Slider{
    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        add_action('elementor/element/before_section_start',[ $this, '_add_controls'],10,3);

        add_action( 'elementor/frontend/element/before_render', [ $this, '_before_render'],10,1);

        add_action( 'elementor/element/print_template', [ $this, '_print_template'],10,2);

    }

    public function _add_controls($element,$section_id, $args)
    {
        if (('section' === $element->get_name() && 'section_advanced' === $section_id) || ('column' === $element->get_name() && 'section_advanced' === $section_id)) {

            $element->start_controls_section(
                '_aepro_section_bg_slider',
                [
                    'label' => __( 'Background Slider', 'elementor' ),
                    'tab' => Aepro_Control_Manager::TAB_AE_PRO,
                ]
            );

            $element->add_control(
                'aepro_bg_slider_images',
                [
                    'label' => __( 'Add Images', 'aepro' ),
                    'type' => Controls_Manager::GALLERY,
                    'default' => [],
                ]
            );

            $element->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'thumbnail',
                ]
            );

            /*$slides_to_show = range( 1, 10 );
            $slides_to_show = array_combine( $slides_to_show, $slides_to_show );

            $element->add_control(
                'slides_to_show',
                [
                    'label' => __( 'Slides to Show', 'aepro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '3',
                    'options' => $slides_to_show,
                ]
            );*/
			/*$element->add_control(
                'slide',
                [
                    'label' => __( 'Initial Slide', 'aepro' ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
					'placeholder' => __( 'Initial Slide', 'aepro' ),
					'default' => __( '0', 'aepro' ),
                ]
            );*/

            $element->add_control(
                'slider_transition',
                [
                    'label' => __( 'Transition', 'aepro' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'fade' => __( 'Fade', 'aepro' ),
                        'fade2' => __( 'Fade2', 'aepro' ),
                        'slideLeft' => __( 'slide Left', 'aepro' ),
                        'slideLeft2' => __( 'Slide Left 2', 'aepro' ),
                        'slideRight' => __( 'Slide Right', 'aepro' ),
                        'slideRight2' => __( 'Slide Right 2', 'aepro' ),
                        'slideUp' => __( 'Slide Up', 'aepro' ),
                        'slideUp2' => __( 'Slide Up 2', 'aepro' ),
                        'slideDown' => __( 'Slide Down', 'aepro' ),
                        'slideDown2' => __( 'Slide Down 2', 'aepro' ),
                        'zoomIn' => __( 'Zoom In', 'aepro' ),
                        'zoomIn2' => __( 'Zoom In 2', 'aepro' ),
                        'zoomOut' => __( 'Zoom Out', 'aepro' ),
                        'zoomOut2' => __( 'Zoom Out 2', 'aepro' ),
                        'swirlLeft' => __( 'Swirl Left', 'aepro' ),
                        'swirlLeft2' => __( 'Swirl Left 2', 'aepro' ),
                        'swirlRight' => __( 'Swirl Right', 'aepro' ),
                        'swirlRight2' => __( 'Swirl Right 2', 'aepro' ),
                        'burn' => __( 'Burn', 'aepro' ),
                        'burn2' => __( 'Burn 2', 'aepro' ),
                        'blur' => __( 'Blur', 'aepro' ),
                        'blur2' => __( 'Blur 2', 'aepro' ),
                        'flash' => __( 'Flash', 'aepro' ),
                        'flash2' => __( 'Flash 2', 'aepro' ),
                        'random' => __( 'Random', 'aepro' )
                    ],
                    'default' => 'fade',
                ]
            );
            $element->add_control(
                'slider_animation',
                [
                    'label' => __( 'Animation', 'aepro' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'kenburns' => __( 'Kenburns', 'aepro' ),
                        'kenburnsUp' => __( 'Kenburns Up', 'aepro' ),
                        'kenburnsDown' => __( 'Kenburns Down', 'aepro' ),
                        'kenburnsRight' => __( 'Kenburns Right', 'aepro' ),
                        'kenburnsLeft' => __( 'Kenburns Left', 'aepro' ),
                        'kenburnsUpLeft' => __( 'Kenburns Up Left', 'aepro' ),
                        'kenburnsUpRight' => __( 'Kenburns Up Right', 'aepro' ),
                        'kenburnsDownLeft' => __( 'Kenburns Down Left', 'aepro' ),
                        'kenburnsDownRight' => __( 'Kenburns Down Right', 'aepro' ),
                        'random' => __( 'Random', 'aepro' )
                    ],
                    'default' => 'kenburns',
                ]
            );
			
			$element->add_control(
				'custom_overlay_switcher',
				[
					'label' => __( 'Custom Overlay', 'aepro' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'label_on' => __( 'Show', 'aepro' ),
					'label_off' => __( 'Hide', 'aepro' ),
					'return_value' => 'yes',
				]
			);
			/*$element->add_control(
				'custom_overlay',
				[
					'label' => __( 'Overlay Image', 'aepro' ),
					'type' => Controls_Manager::MEDIA,
					'condition' => [
						'custom_overlay_switcher' => 'yes',
					]
				]
			);*/
			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'slider_custom_overlay',
					'label' => __( 'Overlay Image', 'aepro' ),
					'types' => [ 'none', 'classic','gradient' ],
					'selector' => '{{WRAPPER}} .vegas-overlay',
					'condition' => [
						'custom_overlay_switcher' => 'yes',
					]
				]
			);
            $element->add_control(
                'slider_overlay',
                [
                    'label' => __( 'Overlay', 'aepro' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
						'' => __( 'None', 'aepro' ),
                        '01' => __( 'Style 1', 'aepro' ),
                        '02' => __( 'Style 2', 'aepro' ),
                        '03' => __( 'Style 3', 'aepro' ),
                        '04' => __( 'Style 4', 'aepro' ),
                        '05' => __( 'Style 5', 'aepro' ),
                        '06' => __( 'Style 6', 'aepro' ),
                        '07' => __( 'Style 7', 'aepro' ),
                        '08' => __( 'Style 8', 'aepro' ),
                        '09' => __( 'Style 9', 'aepro' )
                    ],
                    'default' => '01',
					'condition' => [
						'custom_overlay_switcher' => '',
					]
                ]
            );
			$element->add_control(
                'slider_cover',
                [
                    'label' => __( 'Cover', 'aepro' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'true' => __( 'True', 'aepro' ),
                        'false' => __( 'False', 'aepro' )
                    ],
                    'default' => 'true',
                ]
            );
			$element->add_control(
				'slider_delay',
				[
					'label' => __( 'Delay', 'aepro' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'placeholder' => __( 'Delay', 'aepro' ),
					'default' => __( '5000', 'aepro' ),
				]
			);
			$element->add_control(
                'slider_timer_bar',
                [
                    'label' => __( 'Timer', 'aepro' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'true' => __( 'True', 'aepro' ),
                        'false' => __( 'False', 'aepro' )
                    ],
                    'default' => 'true',
                ]
            );

            $element->end_controls_section();

        }
    }

    function _before_render(\Elementor\Element_Base $element){
        if($element->get_name() != 'section' && $element->get_name() != 'column'){
            return;
        }
        $settings = $element->get_settings();

        $element->add_render_attribute('_wrapper', 'class', 'has_ae_slider');
        $element->add_render_attribute('aepro-bs-background-slideshow-wrapper','class','aepro-bs-background-slideshow-wrapper');

        $element->add_render_attribute('aepro-bs-backgroundslideshow','class','aepro-at-backgroundslideshow');


        if ( empty( $settings['aepro_bg_slider_images'] ) )
            return;

        $slides = [];

        foreach ( $settings['aepro_bg_slider_images'] as $attachment ) {
            $image_url = Group_Control_Image_Size::get_attachment_image_src( $attachment['id'], 'thumbnail', $settings );
            $slides[] = ['src'=> $image_url];

        }

        if ( empty( $slides ) ) {
            return;
        }
		//echo '<pre>'; print_r($settings); echo '</pre>';
        ?>

        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery(".elementor-element-<?php echo $element->get_id(); ?>").prepend('<div class="aepro-section-bs"><div class="aepro-section-bs-inner"></div></div>');
				var bgimage = '<?php echo $settings["slider_custom_overlay_image"]['url']; ?>';
                if('<?php echo $settings["custom_overlay_switcher"]; ?>' == 'yes'){
					
                    //if(bgimage == ''){
                    //    var bgoverlay = '<?php echo $settings["slider_custom_overlay_image"]['url']; ?>';
                    //}else{
                       var bgoverlay = '<?php echo plugins_url()."/anywhere-elementor-pro/includes/assets/lib/vegas/overlays/00.png"; ?>';
                   // }
                }else{
                    if('<?php echo $settings["slider_overlay"]; ?>'){
                        var bgoverlay = '<?php echo plugins_url()."/anywhere-elementor-pro/includes/assets/lib/vegas/overlays/".$settings["slider_overlay"].".png"; ?>';
                    }else{
                        var bgoverlay = '<?php echo plugins_url()."/anywhere-elementor-pro/includes/assets/lib/vegas/overlays/00.png"; ?>';
                    }
                }


                jQuery(".elementor-element-<?php echo $element->get_id(); ?>").children( '.aepro-section-bs').children('.aepro-section-bs-inner').vegas({
                    slides: <?php echo json_encode($slides) ?>,
                    transition: '<?php echo $settings['slider_transition']; ?>',
                    animation: '<?php echo $settings['slider_animation']; ?>',
                    overlay: bgoverlay,
                    cover: <?php echo $settings['slider_cover']; ?>,
                    delay: <?php echo $settings['slider_delay']; ?>,
                    timer: <?php echo $settings['slider_timer_bar']; ?>
                });
				if('<?php echo $settings["custom_overlay_switcher"]; ?>' == 'yes'){
					jQuery(".elementor-element-<?php echo $element->get_id(); ?>").children( '.aepro-section-bs').children('.aepro-section-bs-inner').children('.vegas-overlay').css('background-image', '');
				}
            });
        </script>
        <?php
    }

    function _print_template($template,$widget){
        if($widget->get_name() != 'section' && $widget->get_name() != 'column'){
            return $template;
        }

        $old_template = $template;
        ob_start();
        ?>
            <#

                var rand_id = Math.random().toString(36).substring(7);
                var slides_path_string = '';
				var aepro_transition = settings.slider_transition;
				var aepro_animation = settings.slider_animation;	
				var aepro_custom_overlay = settings.custom_overlay_switcher;
				var aepro_overlay = '';
				var aepro_cover = settings.slider_cover;
				var aepro_delay = settings.slider_delay;
				var aepro_timer = settings.slider_timer_bar;
                if(settings.aepro_bg_slider_images.length){
                    var slider_data = [];
                    slides = settings.aepro_bg_slider_images;
                    for(var i in slides){
                        slider_data[i]  = slides[i].url;
                    }
                    slides_path_string = slider_data.join();
                    //console.log(slides_path_string);
                }

				if(settings.custom_overlay_switcher == 'yes'){
					//if(settings.slider_custom_overlay_image.url){
						//aepro_overlay = settings.slider_custom_overlay_image.url;
					//}else{
						aepro_overlay = '00.png';
					//}
				}else{
					if(settings.slider_overlay){
						aepro_overlay = settings.slider_overlay + '.png';
					}else{
						aepro_overlay = '00.png';
					}
				}
				
				
            #>
			
            <div class="aepro-section-bs">
				<div class="aepro-section-bs-inner"
					data-aepro-bg-slider="{{ slides_path_string }}"
					data-aepro-bg-slider-transition="{{ aepro_transition }}"
					data-aepro-bg-slider-animation="{{ aepro_animation }}"
					data-aepro-bg-custom-overlay="{{ aepro_custom_overlay }}"
					data-aepro-bg-slider-overlay="{{ aepro_overlay }}"
					data-aepro-bg-slider-cover="{{ aepro_cover }}"
					data-aepro-bs-slider-delay="{{ aepro_delay }}"
					data-aepro-bs-slider-timer="{{ aepro_timer }}"
				></div>
			</div>

        <?php
        $slider_content = ob_get_contents();
        ob_end_clean();
        $template = $slider_content.$old_template;
        return $template;
    }
}

Aepro_Bg_Slider::instance();