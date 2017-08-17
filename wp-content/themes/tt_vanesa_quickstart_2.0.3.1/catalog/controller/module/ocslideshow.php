<?php
class ControllerModuleOcslideshow extends Controller {
	public function index($setting) { 
		static $module = 0;	
		$this->language->load('module/ocslideshow'); 
		$this->load->model('ocslideshow/slide');
		$this->load->model('tool/image');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/opentheme/ocslideshow/ocslideshow.css')) {
			$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/opentheme/ocslideshow/ocslideshow.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/opentheme/ocslideshow/ocslideshow.css');
		}

		$data['ocslideshows'] = array();
		$data['animate'] = 'animate-in';
		$results = $this->model_ocslideshow_slide->getocslideshow($setting['banner']);
		if($results ) {
			$store_id  = $this->config->get('config_store_id');
			foreach ($results as $result) {
			//	if (file_exists(DIR_IMAGE . $result['image'])) {
			  $banner_store = array();
			  if(isset($result['banner_store'])) {
				$banner_store = explode(',',$result['banner_store']);
			  }
			  if(in_array($store_id,$banner_store)) {
					$data['ocslideshows'][] = array(
						'title' => $result['title'],
						'sub_title' => $result['sub_title'],
						'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
						'link'  => $result['link'],
						'type'  => $result['type'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
						'small_image' => $this->config->get('config_url'). 'image/' . $result['small_image']
					);
			 }
					
				//}
				
				$data['slide_setting'] = $this->model_ocslideshow_slide->getSettingSlide($result['ocslideshow_id']);
			}
			
					
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ocslideshow.tpl')) {
						return $this->load->view($this->config->get('config_template') . '/template/module/ocslideshow.tpl', $data);
					} else {
						return $this->load->view('default/template/module/ocslideshow.tpl', $data);
			}
		
		}
		
		
	}
}