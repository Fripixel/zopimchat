<?php
class ControllerModuleZopimChat extends Controller {
    public function index() {
        
        $data['zopimchat_status'] = $this->config->get('zopimchat_status');
        $data['zopimchat_code'] = $this->config->get('zopimchat_code');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/zopimchat.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/module/zopimchat.tpl', $data);
        } 
        else {
            return $this->load->view('default/template/module/zopimchat.tpl', $data);
        }
    }
}
?>