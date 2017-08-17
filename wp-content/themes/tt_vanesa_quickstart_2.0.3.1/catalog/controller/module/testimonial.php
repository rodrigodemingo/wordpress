<?php
class ControllerModuleTestimonial extends Controller {
    public function index($setting) {

        static $module = 0;
        $this->language->load('module/testimonial');
        
        $this->load->model('catalog/testimonial');
        $data['testimonials'] = array();
        //$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
        //$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
        $results = $this->model_catalog_testimonial->getTestimonials();
        $this->load->model('tool/image');
        if($results!=null){
            foreach($results as $result){
                $data['testimonials'][] = array(
                    'testimonial_id'    => $result['testimonial_id'],
                    'customer_name'    		=> $result['customer_name'],
                    'image' => $this->model_tool_image->resize($result['image'],80,80),
                    'content'   		=> html_entity_decode($result['content'])
                );
            }
        }else{
            $data['testimonials'][] = array(
                'testimonial_id' => 0,
                'customer_name' => 'No Testimonials Found',
                'content' => 'There are currently no testimonials for this store.'

            );
        }
		$data['limits'] = 3;
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_readmore'] = $this->language->get('text_readmore');
        $data['module'] = $module++;
        $data['more'] = (HTTP_SERVER . 'index.php?route=product/testimonial');
        $data['submit_testimonial'] = (HTTP_SERVER . 'index.php?route=product/testimonial/form');
        $this->id = 'testimonial';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/testimonial.tpl')) {
		
            return $this->load->view($this->config->get('config_template') . '/template/module/testimonial.tpl', $data);
        } else {
		
            return $this->load->view('default/template/module/testimonial.tpl', $data);
        }
    }

}
?>