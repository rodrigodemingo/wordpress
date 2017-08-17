<?php
/**
 * EasyBlog Module
 * 
 * @copyright 2015 CarAn
 * @author <anbesp23@gmail.com>
 *
 */

/**
 * Configurator
 *
 */
class ControllerModuleEasyBlog extends Controller {

    private $error = array();

    public function index() {
        //Load the language file for this module
        $this->load->language('module/easy_blog');

        //Set the title from the language file $_['heading_title'] string
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('setting/setting');
		$this->load->model('extension/module');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('easy_blog', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

            $this->model_setting_setting->editSettingValue('easy_blog', 'easy_blog_article_limit', $this->request->post['easy_blog_article_limit']);
//            $this->model_setting_setting->editSettingValue('easy_blog', 'easy_blog_meta_title', $this->request->post['easy_blog_meta_title']);
            $this->model_setting_setting->editSettingValue('easy_blog', 'easy_blog_meta_description', $this->request->post['easy_blog_meta_description']);
            $this->model_setting_setting->editSettingValue('easy_blog', 'easy_blog_meta_keyword', $this->request->post['easy_blog_meta_keyword']);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
				$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_article_limit'] = $this->language->get('entry_article_limit');
        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_name'] = $this->language->get('entry_name');
        $data['help_article_limit'] = $this->language->get('help_article_limit');
        $data['help_meta_title'] = $this->language->get('help_meta_title');
        $data['help_meta_description'] = $this->language->get('help_meta_description');
        $data['help_meta_keyword'] = $this->language->get('help_meta_keyword');
		$data['entry_status'] = $this->language->get('entry_status');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['article_limit'])) {
            $data['error_article_limit'] = $this->error['article_limit'];
        } else {
            $data['error_article_limit'] = '';
        }


        //SET UP BREADCRUMB TRAIL. YOU WILL NOT NEED TO MODIFY THIS UNLESS YOU CHANGE YOUR MODULE NAME.
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/easy_blog', 'token=' . $this->session->data['token'], 'SSL'),
        );

		$data['action'] = $this->url->link('module/easy_blog', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
			
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
        if (isset($this->request->post['easy_blog_article_limit'])) {
            $data['easy_blog_article_limit'] = $this->request->post['easy_blog_article_limit'];
        } else {
            $data['easy_blog_article_limit'] = $this->config->get('easy_blog_article_limit');
        }

        // if (isset($this->request->post['easy_blog_meta_title'])) {
            // $data['easy_blog_meta_title'] = $this->request->post['easy_blog_meta_title'];
        // } else {
            // $data['easy_blog_meta_title'] = $this->config->get('easy_blog_meta_title');
        // }

        if (isset($this->request->post['easy_blog_meta_description'])) {
            $data['easy_blog_meta_description'] = $this->request->post['easy_blog_meta_description'];
        } else {
            $data['easy_blog_meta_description'] = $this->config->get('easy_blog_meta_description');
        }

        if (isset($this->request->post['easy_blog_meta_keyword'])) {
            $data['easy_blog_meta_keyword'] = $this->request->post['easy_blog_meta_keyword'];
        } else {
            $data['easy_blog_meta_keyword'] = $this->config->get('easy_blog_meta_keyword');
        }
		
				
	

        //Send the output.
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/easy_blog.tpl', $data));
    }
    

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/easy_blog')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['easy_blog_article_limit']) {
            $this->error['article_limit'] = $this->language->get('error_article_limit');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    public function install() {
        $this->load->model('blog/easy_blog');
        $this->load->model('setting/setting');
        $this->load->model('extension/extension');

        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'blog/article');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'blog/article');

        $this->model_blog_easy_blog->install();

        $data = array(
            'easy_blog_article_limit' => '10',
            'easy_blog_meta_title'    => 'Blog',
            'easy_blog_meta_description' => '',
            'easy_blog_meta_keyword'    => ''
        );
        $this->model_setting_setting->editSetting('easy_blog', $data, 0);

    }

    public function uninstall() {
        $this->load->model('blog/easy_blog');
        $this->load->model('setting/setting');
        $this->load->model('extension/extension');
        $this->load->model('extension/event');

        $this->model_blog_easy_blog->uninstall();
        $this->model_extension_extension->uninstall('easy_blog', $this->request->get['extension']);
        $this->model_setting_setting->deleteSetting($this->request->get['extension']);
    }
    
}
