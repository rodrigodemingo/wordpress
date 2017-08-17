<?php 
class ControllerModuleOcproductrotator extends Controller
{
	private $error = array();

    public function install() {
        $config = array(
            'ocproductrotator_status'   => 1,
            'ocproductrotator_width'    => '300',
            'ocproductrotator_height'   => '300'
        );
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('ocproductrotator', $config);
    }

    public function index() {
        $this->load->language('module/ocproductrotator');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        $this->load->model('extension/module');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $post_data = $this->request->post;

            // Parse all the coming data to Setting Model to save it in database.
            $this->model_setting_setting->editSetting('ocproductrotator', $post_data);

            // To display the success text on data save
            $this->session->data['success'] = $this->language->get('text_success');

            // Redirect to the Module Listing
            $this->response->redirect($this->url->link('module/ocproductrotator', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_width'] = $this->language->get('entry_width');
        $data['entry_height'] = $this->language->get('entry_height');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['width'])) {
            $data['error_width'] = $this->error['width'];
        } else {
            $data['error_width'] = '';
        }

        if (isset($this->error['height'])) {
            $data['error_height'] = $this->error['height'];
        } else {
            $data['error_height'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );


        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/ocproductrotator', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('module/ocproductrotator', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['ocproductrotator_width'])) {
            $data['ocproductrotator_width'] = $this->request->post['ocproductrotator_width'];
        } else {
            $data['ocproductrotator_width'] = $this->config->get('ocproductrotator_width');
        }

        if (isset($this->request->post['ocproductrotator_height'])) {
            $data['ocproductrotator_height'] = $this->request->post['ocproductrotator_height'];
        } else {
            $data['ocproductrotator_height'] = $this->config->get('ocproductrotator_height');
        }

        if (isset($this->request->post['ocproductrotator_status'])) {
            $data['ocproductrotator_status'] = $this->request->post['ocproductrotator_status'];
        } else {
            $data['ocproductrotator_status'] = $this->config->get('ocproductrotator_status');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/ocproductrotator.tpl', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/ocproductrotator')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['ocproductrotator_width']) {
            $this->error['width'] = $this->language->get('error_width');
        }

        if (!$this->request->post['ocproductrotator_height']) {
            $this->error['height'] = $this->language->get('error_height');
        }

        return !$this->error;
    }
}