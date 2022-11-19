<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificate extends BackendController
{
    var $module_name = 'certificate';
    var $module_directory = 'certificate';
    var $module_js = ['certificate'];
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
        $this->app_data["provinsi"] = Modules::run("database/get_all", "provinces")->result();
        $this->app_data['page_title']     = "Sertifikat Pelatihan";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");
        $array_query = [
            "select" => "a.*",
            "from" => "tb_batch_course a",
            'order_by' => 'a.id, DESC'
        ];
        $get_all = Modules::run('database/get', $array_query)->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {

            $get_before = $this->db->query("SELECT COUNT(*) as total FROM tb_batch_course_has_account
             WHERE id_account NOT IN (SELECT id_account FROM tb_account_has_certificate) AND id_batch_course = $data_table->id")->row();

            $array_after = [
                "select" => "COUNT(*) as total",
                "from" => "tb_account_has_certificate",
                "where" => "id_batch_course = $data_table->id"
            ];
            $get_after = Modules::run('database/get', $array_after)->row();

            $url_before = Modules::run('helper/create_url', "certificate/detail_before/$data_table->id");
            $url_after = Modules::run('helper/create_url', "certificate/detail_after/$data_table->id");

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->title;
            $row[] = "<span class='text-info'><i class='fa fa-users'></i> $get_after->total Peserta </span> <a href='$url_after' class='btn btn-light btn-sm' data-id=$data_table->id style='background-color: white;'><i class='fa fa-arrow-right text-dark'></></a>";
            $row[] = "<span class='text-info'><i class='fa fa-users'></i> $get_before->total Peserta </span> <a href='$url_before' class='btn btn-light btn-sm' data-id=$data_table->id style='background-color: white;'><i class='fa fa-arrow-right text-dark'></></a>";
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        echo json_encode($ouput);
    }

    public function detail_before($id_batch_course)
    {
        $this->app_data['id_batch_course']     = $id_batch_course;
        $this->app_data['page_title']     = "Belum Sertifikat";
        $this->app_data['view_file']     = 'before_certificate';
        echo Modules::run('template/main_layout', $this->app_data);
    }
}
