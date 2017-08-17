<?php
class ControllerCatalogTestimonial extends Controller {
	private $error = array();

  	public function index() {
		$this->load->language('catalog/testimonial');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/testimonial');
		$this->getList();
  	}

  	public function insert() {
    	$this->load->language('catalog/testimonial');
    	$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/testimonial');
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
           // echo "<pre>".print_r($this->request->post,1);die;
			$this->model_catalog_testimonial->addTestimonial($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
            $this->response->redirect($this->url->link('catalog/testimonial', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
    	$this->getForm();
  	}

  	public function update() {
    	$this->load->language('catalog/testimonial');
    	$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/testimonial');
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
         //   echo "<pre>".print_r($this->request->post,1);die;
			$test = $this->model_catalog_testimonial->editTestimonial($this->request->get['testimonial_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			$this->response->redirect($this->url->link('catalog/testimonial', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			
		}
    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->language('catalog/testimonial');

    	$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/testimonial');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $testimonial_id) {
				$this->model_catalog_testimonial->deleteTestimonial($testimonial_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$this->response->redirect($this->url->link('catalog/testimonial', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}

    protected function getList() {

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'td.customer_last_name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		$data['testimonials'] = array();
		$data = array(
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);
		$testimonial_total = $this->model_catalog_testimonial->getTotalTestimonials($data);
		$results = $this->model_catalog_testimonial->getTestimonials($data);
     //   echo"<pre>".print_r($results,1);die;
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('catalog/testimonial', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
//echo"<pre>".print_r($data['breadcrumbs']);die;
        $data['insert'] = $this->url->link('catalog/testimonial/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('catalog/testimonial/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
  //      $data['edit'] = $this->url->link('catalog/testimonial/update', '&testimonial_id=' . $results['testimonial_id'].'token=' . $this->session->data['token'] . $url, 'SSL');
        foreach ($results as $result) {
			$action = array();
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/testimonial/update', 'token=' . $this->session->data['token'] . '&testimonial_id=' . $result['testimonial_id'])
				);
      		$data['testimonials'][] = array(
				'testimonial_id' => $result['testimonial_id'],
				'customer_name'       => $result['customer_name'],
				'sort_order'      => $result['sort_order'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['testimonial_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
   //     echo "<pre>".print_r($data['testimonials']);die;
        $data['entry_name'] = $this->language->get('entry_name');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');
        $data['button_edit'] = $this->language->get('button_edit');
		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['text_confirm'] = $this->language->get('text_confirm');
 		$data['token'] = $this->session->data['token'];
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $testimonial_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=catalog/testimonial&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['sort'] = $sort;
		$data['order'] = $order;
        $data['results'] = sprintf($this->language->get('text_pagination'), ($testimonial_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($testimonial_total - $this->config->get('config_limit_admin'))) ? $testimonial_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $testimonial_total, ceil($testimonial_total / $this->config->get('config_limit_admin')));
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/testimonial_list.tpl', $data));



  	}

  	private function getForm() {
    	$data['heading_title'] = $this->language->get('heading_title');
    	$data['text_form'] = $this->language->get('text_form');

    	$data['text_enabled'] = $this->language->get('text_enabled');
    	$data['text_disabled'] = $this->language->get('text_disabled');
        $data['entry_image'] = $this->language->get('entry_image');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
    	$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

    	$data['button_save'] = $this->language->get('button_save');
    	$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		
    	$data['tab_general'] = $this->language->get('tab_general');
    	$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_design'] = $this->language->get('tab_design');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

   		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/testimonial', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);


		if (!isset($this->request->get['testimonial_id'])) {
			$data['action'] = $this->url->link('catalog/testimonial/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/testimonial/update', 'token=' . $this->session->data['token'] . '&testimonial_id=' . $this->request->get['testimonial_id']);
		}
		
		$data['cancel'] = $this->url->link('catalog/testimonial', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['testimonial_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$testimonial_info = $this->model_catalog_testimonial->getTestimonial($this->request->get['testimonial_id']);
              //  echo "<pre>".print_r($testimonial_info,1);die;
    	}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['testimonial_description'])) {
			$data['testimonial_description'] = $this->request->post['testimonial_description'];
		} elseif (isset($this->request->get['testimonial_id'])) {
			$data['testimonial_description'] = $this->model_catalog_testimonial->getTestimonialDescriptions($this->request->get['testimonial_id']);
		} else {
			$data['testimonial_description'] = array();
		}
      // echo "<pre>".print_r($data['testimonial_description'],1);die;
		if (isset($this->request->post['sort_order'])) {
      		$data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (isset($testimonial_info) && !empty($testimonial_info)) {
      		$data['sort_order'] = $testimonial_info['sort_order'];
    	} else {
			$data['sort_order'] = 1;
		}

    	if (isset($this->request->post['status'])) {
      		$data['status'] = $this->request->post['status'];
    	} else if (isset($testimonial_info)&& !empty($testimonial_info)) {
			$data['status'] = $testimonial_info['status'];
		} else {
      		$data['status'] = 1;
    	}
//echo "<pre>".print_r($this->request->post);die;

        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif ( isset($testimonial_info) && !empty($testimonial_info)) {
            $data['image'] = $testimonial_info['image'];
        } else {
            $data['image'] = '';
        }

        $this->load->model('tool/image');
        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($testimonial_info) && is_file(DIR_IMAGE . $testimonial_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($testimonial_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');
        $data['column_left'] = $this->load->controller('common/column_left');
        $this->response->setOutput($this->load->view('catalog/testimonial_form.tpl', $data));
  	}
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/testimonial')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
            $testimonial = $this->request->post['testimonial_description'];
      		if ((strlen(utf8_decode($testimonial['customer_name'])) < 3) || (strlen(utf8_decode($testimonial['customer_name'])) > 255)) {
        		$this->error['customer_name']= $this->language->get('error_name');
      		}
			if ((strlen(utf8_decode($testimonial['content'])) < 3)) {
				$this->error['content'] = $this->language->get('error_description');
			}


    	if (!$this->error) {
			return TRUE;
    	} else {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_required_data');
			}
      		return FALSE;
    	}
  	}

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/testimonial')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}
}
?>