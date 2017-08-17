<?php  
class ControllerModulettcountdown extends Controller {
	public  function index($setting) {
		
		if(empty($setting)) {
			$data['permission'] = false;
		} else {
			$data['permission'] = true;
		}
		
		if($data['permission']) {
			$this->load->language('module/ttcountdown');
		  //  $this->document->addScript('catalog/view/javascript/countdown.js');
			$this->document->addScript('catalog/view/javascript/jquery.plugin.js');
			$this->document->addScript('catalog/view/javascript/jquery.countdown.js');
			$this->document->addStyle('catalog/view/javascript/jquery.countdown.css');
			$this->load->model('module/ttcountdown');
		   $this->load->model('tool/image');
			$filter_data = array(
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => 10
			);
			$data['heading_title'] = $this->language->get('heading_title');
			$data['ttcountdown_width'] = $setting['width'];
			$data['ttcountdown_height'] = $setting['height'];
			$data['text_tax'] = $this->language->get('text_tax');
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$results = $this->model_module_ttcountdown->getTimeCountdown($filter_data);
			if ($results) {
				foreach ($results as $result) { 
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $data['ttcountdown_width'], $data['ttcountdown_height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $data['ttcountdown_width'],$data['ttcountdown_height']);
					}
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['orgprice'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}
					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					} 
					
					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['orgprice']);
					} else {
						$tax = false;
					}
					if ($result['date_start']!=null) {
						$date_start = $result['date_start'] ;
					} else {
						$date_start = false;
					} 
					if($result['date_end']!=null) {
						$date_end = $result['date_end'] ;
					 } else {
						$date_end = false;
					}
					
					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}
					
					/// Product Rotator /
                $product_rotator_status = (int) $this->config->get('ocproductrotator_status');
                if($product_rotator_status == 1) {
                 $this->load->model('catalog/ocproductrotator');
                 $this->load->model('tool/image');
             
                 $product_id = $result['product_id'];
                 $product_rotator_image = $this->model_catalog_ocproductrotator->getProductRotatorImage($product_id);
             
                 if($product_rotator_image) {
                  $rotator_image_width = (int) $this->config->get('ocproductrotator_width');
                  $rotator_image_height = (int) $this->config->get('ocproductrotator_height');
      $rotator_image = $this->model_tool_image->resize($product_rotator_image, $rotator_image_width,$rotator_image_height); 
                 } else {
                  $rotator_image = false;
                 } 
                } else {
                 $rotator_image = false;    
                }
                /// End Product Rotator /
					$data['products'][] = array(
						'product_id'  => $result['product_id'],
						'rotator_image' => $rotator_image,
						'thumb'       => $image,
						'name'        => $result['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'orgprice'       => $price,
						'special'     => $special,
						'date_start'  => $date_start,
						'date_end'    =>  $date_end,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				}
			}
			
		}
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ttcountdown.tpl')) {
					return $this->load->view($this->config->get('config_template').'/template/module/ttcountdown.tpl', $data);
				} else {
					return $this->load->view('default/template/module/ttcountdown.tpl',$data);
				}
		
	}
}

?>