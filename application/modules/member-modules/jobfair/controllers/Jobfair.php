<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jobfair extends CommonController
{
    var $module_name        = 'jobfair';
    var $module_directory   = 'jobfair';
    var $module_js          = ['jobfair'];
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
        $array_vacancy = [
            "select" => "*",
            "from" => "tb_job_vacancy",
            "where" => ['vacancy_status' => 1],
            "order_by" => "id,desc"
        ];

        $vacancy = Modules::run('database/get', $array_vacancy)->result();
        $this->app_data['vacancy'] = $vacancy;
        $this->app_data['page_title']   = "Lowongan Kerja";
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function detail($data)
    {

        $array_job = [
            "select" => "a.*, b.*, b.name as company_name, c.name as work_field_name, a.id as job_id",
            "from" => "tb_job_vacancy a",
            "join" => [
                "tb_industry b, a.id_industry = b.id, left",
                "tb_work_field c, a.work_field = c.id, left"
            ],
            "where" => ['a.id' => $data]
        ];
        $get_job = Modules::run('database/get',$array_job)->row();

        $this->app_data['job']          = $get_job;
        $this->app_data['page_title']   = "Detail Lowongan kerja";
        $this->app_data['view_file']    = 'detail_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }
}
