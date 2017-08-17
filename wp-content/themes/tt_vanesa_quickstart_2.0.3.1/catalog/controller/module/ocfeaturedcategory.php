<?php
class ControllerModuleOcfeaturedcategory extends Controller {
	public function index($setting) {
		$this->load->language('module/ocfeaturedcategory');

		$this->load->model('module/ocfeaturedcategory');

		$this->load->model('tool/image');
		
		$this->load->model('catalog/category');

		$_featured_categories = $this->model_module_ocfeaturedcategory->getFeaturedCategories();
		$data['categories'] = array();
		$data['sub_categories'] = array();
		$data['heading_title'] = $this->language->get('heading_title');
		
		if ($_featured_categories) {
			foreach ($_featured_categories as $_category) {
				$sub_categories = array();
				
				$sub_categories = $this->model_catalog_category->getCategories($_category['category_id']);
				
				foreach($sub_categories as $sub_cate) {
					$data['sub_categories'][] = array(
						'category_id'  		=> $sub_cate['category_id'],
						'name'        		=> $sub_cate['name'],
						'href'        		=> $this->url->link('product/category', 'path=' . $sub_cate['category_id']),
					);
				}
				
				if ($_category['homethumb_image']) {
					$homethumb_image = $this->model_tool_image->resize($_category['homethumb_image'], $setting['width'], $setting['height']);
				} else {
					$homethumb_image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				$data['categories'][] = array(
					'children'			=> $data['sub_categories'],
					'category_id'  		=> $_category['category_id'],
					'homethumb_image'   => $homethumb_image,
					'name'        		=> $_category['name'],
					'description' 		=> utf8_substr(strip_tags(html_entity_decode($_category['description'], ENT_QUOTES, 'UTF-8')), 0, 80) . 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
					'href'        		=> $this->url->link('product/category', 'path=' . $_category['category_id']),
				);
			}

			$data['config_slide'] = array(
				'limit' => $setting['limit'],
			);

		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ocfeaturedcategory.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/ocfeaturedcategory.tpl', $data);
		} else {
			return $this->load->view('default/template/module/ocfeaturedcategory.tpl', $data);
		}
	}
}