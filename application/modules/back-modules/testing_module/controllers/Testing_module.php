
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Testing_module extends BackendController
{
    var $module_name        = 'testing_module';
    var $module_directory   = 'testing_module';
    var $module_js          = ['testing_module','print'];
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

    public function index()
    {
        $this->app_data['page_title'] = 'Modular Test';
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run('security/is_ajax');
        $data = [];
        Modules::run('security/is_ajax');
        $ouput= array(
            'data' => $data
        );
        echo json_encode($ouput);
    }
    
}
            