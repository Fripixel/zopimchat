<?php
class ControllerModuleZopimChat extends Controller
{
    private $error = array();
    
    // This is used to set the errors, if any.
    
    public function index() {
        
        // Default function
        $this->language->load('module/zopimchat');
        
        // Loading the language file of zopimchat
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        // Set the title of the page to the heading title in the Language file i.e., Hello World
        
		$this->load->model('setting/setting');
        
        // Load the Setting Model  (All of the OpenCart Module & General Settings are saved using this Model )
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting("zopimchat", $this->request->post);			

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
            
        }
        
        // End If
        
        /*Assign the language data for parsing it to view*/
        $data['heading_title'] = $this->language->get('heading_title');
        
		$data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_zopimchat_code'] = $this->language->get('entry_zopimchat_code');
        $data['entry_zopimchat_status'] = $this->language->get('entry_zopimchat_status'); 

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
        
        /*This Block returns the error code if any*/
        if (isset($this->error['error_zopimchat_code'])) {
            $data['error_zopimchat_code'] = $this->error['error_zopimchat_code'];
        } 
        else {
            $data['error_zopimchat_code'] = '';
        }

        /*End Block*/

        /*Post Block*/

		if (isset($this->request->post['zopimchat_code'])) {
			$data['zopimchat_code'] = $this->request->post['zopimchat_code'];
		} 
		else {
			$data['zopimchat_code'] = $this->config->get('zopimchat_code');
		}

		if (isset($this->request->post['zopimchat_status'])) {
			$data['zopimchat_status'] = $this->request->post['zopimchat_status'];
		} 
		else {
			$data['zopimchat_status'] = $this->config->get('zopimchat_status');
		}

        /*Post Block*/
        
        /* Making of Breadcrumbs to be displayed on site*/
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home') ,
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL') ,
            'separator' => false
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module') ,
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL') ,
            'separator' => ' :: '
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title') ,
            'href' => $this->url->link('module/zopimchat', 'token=' . $this->session->data['token'], 'SSL') ,
            'separator' => ' :: '
        );
        
        /* End Breadcrumb Block*/
        
        $data['action'] = $this->url->link('module/zopimchat', 'token=' . $this->session->data['token'], 'SSL');
        
        // URL to be directed when the save button is pressed
        
        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        
        // URL to be redirected when cancel button is pressed
        
        /* End Block*/
        
        $this->template = 'module/zopimchat.tpl';
        
        // Loading the zopimchat.tpl template
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->template, $data));
        
    }
    
    /* Function that validates the data when Save Button is pressed */
    protected function validate() {
        
        /* Block to check the user permission to manipulate the module*/
        if (!$this->user->hasPermission('modify', 'module/zopimchat')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        /* End Block*/
        
		if ((utf8_strlen($this->request->post['zopimchat_code']) < 1)) {
			$this->error['zopimchat_code'] = $this->language->get('error_zopimchat_code');
		}
        
        /* End Block*/
        
        /*Block returns true if no error is found, else false if any error detected*/
        return !$this->error;
        /* End Block*/
    }
    
    /* End Validation Function*/
}
?>