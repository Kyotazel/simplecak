<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends BackendController
{
    var $module_name        = 'home';
    var $module_directory   = 'home';
    var $module_js          = ['home'];
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
        $view_file = 'on_course';

        $this->app_data['page_title']   = 'dashboard';
        $this->app_data['view_file']    = $view_file;
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }
}
