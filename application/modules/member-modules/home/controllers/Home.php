<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CommonController
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
        $id = $this->session->userdata('member_id');

        $array_course = [
            "select" => "a.id_batch_course as id_batch_course_account, b.title as course_name, c.*",
            "from" => "tb_batch_course_has_account a",
            "join" => [
                "tb_batch_course b, a.id_batch_course = b.id, left",
                "app_module_setting c, a.status = c.value AND c.field = 'account_batch_status', left"
            ],
            "where" => ['a.id_account' => $id],
            "order_by" => "a.id, DESC"
        ];
        $get_course = Modules::run('database/get',$array_course)->result();

        $data_participant = Modules::run('database/find', 'tb_batch_course_has_account', ['id_account' => $id])->last_row();
        $get_data = Modules::run('database/find', 'tb_account', ['id' => $id])->row();

        if ($data_participant->status == 5) {
            $array_get = [
                "select" => "b.*, d.name as category_name",
                "from" => "tb_batch_course_has_account as a",
                "join"  => [
                    "tb_batch_course as b, a.id_batch_course = b.id",
                    'tb_course as c, b.id_course = c.id',
                    "tb_course_category d, c.id_category_course = d.id"
                ],
                "where" => ['a.id_account' => $id],
            ];
            
            $array_schedule = [
                "select" => "a.*, c.label, c.params",
                "from" => "tb_batch_course_has_schedule a",
                "join" => [
                    "tb_batch_course_schedule_has_attendance b, a.id = b.id_batch_course_schedule, left",
                    "app_module_setting c, b.status_attendance = c.value AND field = 'attendance', left"
                ],
                "where" => ['id_batch_course' => $data_participant->id_batch_course],
                "order_by" => "id, DESC"
            ];
            
            $this->app_data['last_schedule'] = Modules::run('database/get', $array_schedule)->row();
            $this->app_data['schedule'] = Modules::run('database/get', $array_schedule)->result();
            $this->app_data['course_active'] = Modules::run('database/get', $array_get)->last_row();
            $view_file = 'on_course';
        } else {
            $array_get = [
                "select" => "a.*, c.name as category_name",
                "from" => "tb_batch_course as a",
                "join"  => [
                    'tb_course as b, a.id_course = b.id',
                    "tb_course_category c, b.id_category_course = c.id"
                ],
                "where" => "ending_date > '" . date('Y-m-d') . "'",
                'order_by' => 'id,DESC'
            ];
            $this->app_data['course_active'] = Modules::run('database/get', $array_get)->result();
            $view_file = 'public';
        }

        $this->app_data['course']       = $get_course;
        $this->app_data['data_account'] = $get_data;
        $this->app_data['page_title']   = 'dashboard';
        $this->app_data['view_file']    = $view_file;
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }
}
