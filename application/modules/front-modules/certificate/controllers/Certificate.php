<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificate extends FrontendController
{
    var $module_name        = 'certificate';
    var $module_directory   = 'certificate';
    var $module_js          = ['certificate'];
    var $app_data           = [];

    public function __construct()
    {
        parent::__construct();
        Modules::run('security/common_security');
        $this->_init();
    }
    private function _init()
    {
        $this->app_data['module_js']    = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }

    public function check($encrypted = null)
    {

        $key = json_decode(base64_decode(urldecode($encrypted)));

        $data = null;
        if($key) {
            $data = Modules::run('database/find', 'tb_account_has_certificate', ['id_account' => $key->id_account, 'id_batch_course' => $key->id_batch_course])->row();
        }

        $this->app_data['page_title'] = "Sertifikat";
        $this->app_data['view_file'] = 'main_view';
        $this->app_data['data'] = $data;
        echo Modules::run('template/main_layout_extern', $this->app_data);
    }
}
