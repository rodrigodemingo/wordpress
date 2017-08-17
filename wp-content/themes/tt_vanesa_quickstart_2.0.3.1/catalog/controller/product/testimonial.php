<?php
class ControllerProductTestimonial extends Controller {
    private $page_limit = 7;
    private $error = array();
    public function index() {

        $this->load->language('product/testimonial');
        $this->load->model('catalog/testimonial');
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home'),
            'separator' => false
        );

        $testimonial_total = $this->model_catalog_testimonial->getTotalTestimonials();

        if ($testimonial_total) {

            $this->document->setTitle($this->language->get('heading_title'));
            $data['text_no_testimonials'] = $this->language->get('text_no_testimonials');
            $data['breadcrumbs'][] = array(
                'href'      => $this->url->link('product/testimonial'),
                'text'      => $this->language->get('heading_title'),
                'separator' => $this->language->get('text_separator')
            );
            $data['heading_title'] = $this->language->get('heading_title');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['continue'] = (HTTP_SERVER . 'index.php?route=common/home');
            if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
            } else {
                $page = 1;
            }
            $data['testimonials'] = array();
            $results = $this->model_catalog_testimonial->getTestimonials(($page - 1) * $this->page_limit, $this->page_limit);
            $this->load->model('tool/image');
            foreach ($results as $result) {
                if (is_file(DIR_IMAGE . $result['image'])) {
                    $data['testimonials'][] = array(
                        'customer_name'    => $result['customer_name'],
                        'image' => $this->model_tool_image->resize($result['image'],170,170),
                        'content'	=> html_entity_decode($result['content'], ENT_QUOTES, 'UTF-8')
                    );
                }
            }
            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
			$limit = $this->page_limit;

            $pagination = new Pagination();
            $pagination->total = $testimonial_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = $this->url->link('product/testimonial&page={page}');

            $data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($testimonial_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($testimonial_total - $limit)) ? $testimonial_total : ((($page - 1) * $limit) + $limit), $testimonial_total, ceil($testimonial_total / $limit));

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');
            $data['home_top'] = $this->load->controller('common/home_top');

			
	
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/testimonial.tpl')) {
				
                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/testimonial.tpl', $data));
			
            } else {
			
                $this->response->setOutput($this->load->view('default/template/product/testimonial.tpl', $data));
            }

        } else {

            $data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_error'),
                'href'      => $this->url->link('testimonial/testimonial'),
                'separator' => $this->language->get('text_separator')
            );

            $this->document->setTitle = $this->language->get('text_error');


            $data['text_error'] = $this->language->get('text_error');


            $data['button_continue'] = $this->language->get('button_continue');

            $data['continue'] = (HTTP_SERVER . 'index.php?route=common/home');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
            } else {
                $this->template = 'default/template/error/not_found.tpl';
            }
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/testimonial.tpl')) {
                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/testimonial.tpl', $data));
            } else {
                $this->response->setOutput($this->load->view('default/template/product/testimonial.tpl', $data));
            }

        }
    }

    public function form(){
        $this->load->language('product/testimonial');
        $this->load->model('catalog/testimonial');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            unset($this->session->data['captcha']);
            $this->request->post['image'] = "catalog/demo/testimonial/".$_FILES["media"]["name"] ;
            $this->model_catalog_testimonial->addTestimonial($this->request->post);
            $this->response->redirect($this->url->link('product/testimonial/success'));
        }
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/contact')
        );
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_location'] = $this->language->get('text_location');
        $data['text_store'] = $this->language->get('text_store');
        $data['text_contact'] = $this->language->get('text_contact');
        $data['text_address'] = $this->language->get('text_address');
        $data['text_telephone'] = $this->language->get('text_telephone');
        $data['text_fax'] = $this->language->get('text_fax');
        $data['text_open'] = $this->language->get('text_open');
        $data['text_comment'] = $this->language->get('text_comment');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_image'] = $this->language->get('entry_image');
        $data['entry_email'] = $this->language->get('entry_email');
        if (isset($this->request->post['content'])) {
            $data['content'] = $this->request->post['content'];
        } else {
            $data['content'] = '';
        }
        $data['entry_content'] = $this->language->get('entry_content');
        $data['entry_captcha'] = $this->language->get('entry_captcha');
        $data['button_map'] = $this->language->get('button_map');
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }
        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }

        if (isset($this->error['content'])) {
            $data['error_content'] = $this->error['content'];
        } else {
            $data['error_content'] = '';
        }

        if (isset($this->error['captcha'])) {
            $data['error_captcha'] = $this->error['captcha'];
        } else {
            $data['error_captcha'] = '';
        }
        if (isset($this->error['error_image'])) {
            $data['error_image'] = $this->error['error_image'];
        } else {
            $data['error_image'] = '';
        }
        if (isset($this->error['error_size_image'])) {
            $data['error_size_image'] = $this->error['error_size_image'];
        } else {
            $data['error_size_image'] = '';
        }

        if (isset($this->error['error_type_image'])) {
            $data['error_type_image'] = $this->error['error_type_image'];
        } else {
            $data['error_type_image'] = '';
        }
        if (isset($this->error['error_upload'])) {
            $data['error_upload'] = $this->error['error_upload'];
        } else {
            $data['error_upload'] = '';
        }

        $data['button_submit'] = $this->language->get('button_submit');

        $data['action'] = $this->url->link('product/testimonial/form');

        $this->load->model('tool/image');

        if ($this->config->get('config_image')) {
            $data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get('config_image_location_width'), $this->config->get('config_image_location_height'));
        } else {
            $data['image'] = false;
        }
        $data['store'] = $this->config->get('config_name');
        $data['address'] = nl2br($this->config->get('config_address'));
        $data['geocode'] = $this->config->get('config_geocode');
        $data['telephone'] = $this->config->get('config_telephone');
        $data['fax'] = $this->config->get('config_fax');
        $data['open'] = nl2br($this->config->get('config_open'));
        $data['comment'] = $this->config->get('config_comment');

        $data['locations'] = array();

        $this->load->model('localisation/location');

        foreach((array)$this->config->get('config_location') as $location_id) {
            $location_info = $this->model_localisation_location->getLocation($location_id);

            if ($location_info) {
                if ($location_info['image']) {
                    $image = $this->model_tool_image->resize($location_info['image'], $this->config->get('config_image_location_width'), $this->config->get('config_image_location_height'));
                } else {
                    $image = false;
                }
                $data['locations'][] = array(
                    'location_id' => $location_info['location_id'],
                    'name'        => $location_info['name'],
                    'address'     => nl2br($location_info['address']),
                    'geocode'     => $location_info['geocode'],
                    'telephone'   => $location_info['telephone'],
                    'fax'         => $location_info['fax'],
                    'image'       => $image,
                    'open'        => nl2br($location_info['open']),
                    'comment'     => $location_info['comment']
                );
            }
        }



        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } else {
            $data['name'] = $this->customer->getFirstName();
        }

        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } else {
            $data['email'] = $this->customer->getEmail();
        }

        if (isset($this->request->post['enquiry'])) {
            $data['enquiry'] = $this->request->post['enquiry'];
        } else {
            $data['enquiry'] = '';
        }
        if (isset($this->request->post['media'])) {
            $data['media'] = $this->request->post['media'];
        } else {
            $data['media'] = '';
        }
        if (isset($this->request->post['captcha'])) {
            $data['captcha'] = $this->request->post['captcha'];
        } else {
            $data['captcha'] = '';
        }
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/formtestimonial.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/formtestimonial.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/product/formtestimonial.tpl', $data));
        }
    }

    public function success() {
        $this->load->language('product/testimonial');
        $this->load->model('catalog/testimonial');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('product/testimonial')
        );
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_message'] = $this->language->get('text_success');
        $data['button_continue'] = $this->language->get('button_continue');
        $data['continue'] = $this->url->link('common/home');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
        }
    }

    protected function validate() {
        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
            $this->error['name'] = $this->language->get('error_name');
        }
        if (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
            $this->error['email'] = $this->language->get('error_email');
        }
        if ((utf8_strlen($this->request->post['content']) < 10) || (utf8_strlen($this->request->post['content']) > 3000)) {
            $this->error['content'] = $this->language->get('error_content');
        }
        if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
            $this->error['captcha'] = $this->language->get('error_captcha');
        }
        $target_dir = DIR_IMAGE."catalog/demo/testimonial/";
        $target_file = $target_dir. basename($_FILES["media"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = @getimagesize($_FILES["media"]["tmp_name"]);

// Check file size
        if($_FILES["media"]["tmp_name"] != '') {
            if($check === false) {
                $this->error['error_image'] =  $this->language->get('error_image');
            }
            if ($_FILES["media"]["size"] > 500000) {
                $this->error['error_size_image'] =  $this->language->get('error_size_image');
            }
// Allow certain file formats*/
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $this->error['error_image'] = $this->language->get('error_image');
            }
            if (!move_uploaded_file($_FILES["media"]["tmp_name"],$target_file)) {
                $this->error['error_image'] =  $this->language->get('error_image');
            }
        }
        return !$this->error;
    }

}
?>