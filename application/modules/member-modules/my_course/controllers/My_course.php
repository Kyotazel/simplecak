<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_course extends CommonController
{
    var $module_name = 'my_course';
    var $module_directory = 'my_course';
    var $module_js = ['my_course'];
    var $app_data = [];

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

        $array_get = [
            "select" => "a.*, c.name as category_name, d.status as course_status",
            "from" => "tb_batch_course as a",
            "join"  => [
                'tb_course as b, a.id_course = b.id',
                "tb_course_category c, b.id_category_course = c.id",
                "tb_batch_course_has_account as d, a.id = d.id_batch_course"
            ],
            "where" => ["d.id_account" => $id],
            'order_by' => 'id,DESC'
        ];

        $get_batch_course = Modules::run('database/get', $array_get)->result();
        $this->app_data['batch_course'] = $get_batch_course;
        $this->app_data['page_title']   = "Pelatihan Ku";
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function detail()
    {
        $id_batch_course = $this->encrypt->decode($this->input->get('data'));
        $id_account      = $this->session->userdata('member_id');

        $get_data = Modules::run('database/find', 'tb_batch_course', ['id' => $id_batch_course])->row();
        $course    = Modules::run('database/find', 'tb_course', ["id" => $get_data->id_course])->row();
        $category_course = Modules::run("database/find", "tb_course_category", ["id" => $course->id_category_course])->row();
        $account = Modules::run('database/find', 'tb_batch_course_has_account', ['id_account' => $id_account, 'id_batch_course' => $id_batch_course])->row();

        $array_examination = [
            "select" => "a.*,",
            "from" => "tb_account_examination as a",
            "join" => [
                "tb_account_exam_has_batch_course as b, a.id = b.id_account_exam"
            ],
            "where" => "b.id_batch_course = $id_batch_course AND a.status = 1"
        ];

        $get_examination = Modules::run('database/get', $array_examination)->row();

        $this->app_data['examination']  = $get_examination;
        $this->app_data['data_detail'] = $get_data;
        $this->app_data["category_course"]    = $category_course;
        $this->app_data["course"]    = $course;
        $this->app_data["account"]    = $account;

        $this->app_data['page_title']   = "Detail Pelatihan";
        $this->app_data['view_file']    = 'detail';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }
}
