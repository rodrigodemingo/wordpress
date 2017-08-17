<?php
class ControllerModuleVermegamenu extends Controller {
	public function index($setting) { 
		$this->language->load('module/vermegamenu'); 
      	$data['heading_title'] = $this->language->get('heading_title');
		$this->load->model('catalog/category'); 
		$this->load->model('tool/image');
		$this->load->model('vermegamenu/menu');
			$mobile = $this->model_vermegamenu_menu->getblockCategTree(); 
			
			$html  = null; 
			$html .='<ul id="ma-mobilemenu" class="mobilemenu nav-collapse collapse">'; 
				
				foreach($mobile['children'] as $m) { 
					//echo "<pre>"; print_r($m); echo "</pre>"; 
					if(!isset($m["name"])) $m["name"] = 'Root';
					$html .='<li><span class="grower CLOSE"><a href="#">'.$m["name"].'</span></a>';
							
							if(isset($m['children'])) {
								//echo "<pre>"; print_r($m); echo "</pre>"; 
								$sub1 = $m['children'] ;
								$html .='<ul class="level2">'; 
									if(isset($sub1)) {
										foreach($sub1 as $child1) { 
											$html .='<li><span class="grower CLOSE"><a href="#">'.$child1["name"].'</span></a></li>';									
										}
									}
								$html .='</ul>';
								
						    }
					$html .='</li>';
				} 
			$html .='</ul>'	;
        
		$lang_id = (int)$this->config->get('config_language_id');
		$top_menu = $this->model_vermegamenu_menu->getMenuCustomerLink($lang_id,$setting) ;
		$data['vermegamenu'] = $top_menu;
		$data['top_offset'] = 20; 
		$data['effect'] = 1; 
		$data['_menu'] = $html; 
		
		// $this->document->addScript('catalog/view/javascript/opentheme/vermegamenu/custommenu.js');
		// $this->document->addScript('catalog/view/javascript/opentheme/vermegamenu/mobile_menu.js');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/opentheme/vermegamenu/css/ocsvegamenu.css')) {
			$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/opentheme/vermegamenu/css/ocsvegamenu.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/opentheme/vermegamenu/css/ocsvegamenu.css');
		}
		

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/vermegamenu.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/vermegamenu.tpl', $data);
			} else {
				return $this->load->view('default/template/module/vermegamenu.tpl', $data);
			}
		

		
	}
}
?>