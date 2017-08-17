<?php
class ControllerModuleBannersequence extends Controller {
	public function index($setting) { 
		static $module = 0;	
		$this->language->load('module/bannersequence'); 
		$this->load->model('bannersequence/slide');
		$this->load->model('tool/image');
		
		$data['bannersequences'] = array();
		$data['animate'] = 'animate-in';
		$results = $this->model_bannersequence_slide->getBannersequence($setting['banner']);
		if($results ) {
			$store_id  = $this->config->get('config_store_id');
			foreach ($results as $result) {
			//	if (file_exists(DIR_IMAGE . $result['image'])) {
				$banner_store = array();
				 if(isset($result['banner_store'])) {
					$banner_store = explode(',',$result['banner_store']);
				}
				if($result['type'] ==1) {
					$data['bannersequences'][] = array(
						'title' => $result['title'],
						'sub_title' => $result['sub_title'],
						'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
						'link'  => $result['link'],
						'slider_link1' => $this->language->get('slider_link1'),
						'type'  => $result['type'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
						'image1' => $this->model_tool_image->resize($result['image1'], 540, 285),
						'image-food' => $this->model_tool_image->resize($result['image1'], 474,368),
					);
				}
				
				if($result['type'] ==2) {
					$data['bannersequences'][] = array(
						'title' => $result['title'],
						'sub_title' => $result['sub_title'],
						'description' => $result['description'],
						'link'  => $result['link'],
						'slider_link2' => $this->language->get('slider_link2'),
						'type'  => $result['type'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
						'image1' => $this->model_tool_image->resize($result['image1'], 554,205),
						'image-food' => $this->model_tool_image->resize($result['image1'], 474,368),
					);
				}
				
				if($result['type'] ==3) {
					$data['bannersequences'][] = array(
						'title' => $result['title'],
						'sub_title' => $result['sub_title'],
						'description' => $result['description'],
						'link'  => $result['link'],
						'slider_link3' => $this->language->get('slider_link3'),
						'type'  => $result['type'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
						'image1' => $this->model_tool_image->resize($result['image1'], 400, 250),
					);
				}
					
				//}
				
				$data['slide_setting'] = $this->model_bannersequence_slide->getSettingSlide($result['bannersequence_id']);
			}
			
			$data['module'] = $module++;
					
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/bannersequence.tpl')) {
						return $this->load->view($this->config->get('config_template') . '/template/module/bannersequence.tpl', $data);
					} else {
						return $this->load->view('default/template/module/bannersequence.tpl', $data);
			}
		
		}
		
		
	}
}