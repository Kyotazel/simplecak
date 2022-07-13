<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Desa extends BackendController
{
    var $module_name = 'desa';
    var $module_directory = 'desa';
    var $module_js = ['desa'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        Modules::run('security/common_security');
        $this->_init();
    }

    private function _init()
    {
        $this->app_data['module_js']  = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }

    public function index()
    {
        $this->app_data['page_title']     = "Master Desa";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/get_all', 'villages')->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->name;
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        echo json_encode($ouput);
    }
}