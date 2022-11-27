<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_certificate extends CommonController
{
    var $module_name = 'my_certificate';
    var $module_directory = 'my_certificate';
    var $module_js = ['my_certificate'];
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
            "where" => "d.id_account = $id AND d.status = 5",
            'order_by' => 'id,DESC'
        ];

        $get_batch_course = Modules::run('database/get', $array_get)->result();
        $this->app_data['batch_course'] = $get_batch_course;
        $this->app_data['page_title']   = "Sertifikat Ku";
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function check_certificate()
    {
        $id_account = $this->session->userdata('member_id');
        $id_batch_course = urldecode($this->encrypt->decode($this->input->post('id')));

        $get_data = Modules::run('database/find', 'tb_account_has_certificate', ['id_account' => $id_account, 'id_batch_course' => $id_batch_course])->row();

        if($get_data) {
            echo json_encode(['status' => true, 'redirect' => base_url('upload/certificate/' . $get_data->file)]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
}
