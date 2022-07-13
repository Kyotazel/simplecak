<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Schedule extends FrontendController
{
    var $module_name        = 'schedule';
    var $module_directory   = 'schedule';
    var $module_js          = ['schedule'];
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
        $this->app_data['page_title'] = "Jadwal Kapal";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
    public function page()
    {
        $slug = $this->input->get('data');
        $get_data = Modules::run('database/find', 'tb_cms_page', ['slug' => $slug])->row();
        if (empty($get_data)) {
            redirect(base_url());
        }

        $this->app_data['data_post'] = $get_data;
        $this->app_data['page_title'] = $get_data->title;
        $this->app_data['view_file'] = 'view_page';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
}
