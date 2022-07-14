<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kota extends BackendController
{
    var $module_name = 'kota';
    var $module_directory = 'kota';
    var $module_js = ['kota'];
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
        $this->app_data['page_title']     = "Master Kota / Kabupaten";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/get_all', 'cities')->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {

            $get_provinsi = Modules::run('database/find', 'provinces', ['id' => $data_table->province_id])->row();

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->name;
            $row[] = $get_provinsi->name;
            $row[] = '
                    <a href="javascript:void(0)" data-id="' . $data_table->id . '" class="btn btn-sm btn-info btn_edit"><i class="fas fa-pen"></i> Edit</a>
                    <a href="javascript:void(0)" data-id="' . $data_table->id . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> Hapus</a>
            ';
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        echo json_encode($ouput);
    }

    private function validate_save() {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');

        if ($this->input->post('name') == '') {
            $data['error_string'][] = 'Kota/Kabupaten Harus Diisi';
            $data['inputerror'][] = 'name';
            $data['status'] = FALSE;
        }
        if ($this->input->post('provinsi') == '') {
            $data['error_string'][] = 'Provinsi Harus Diisi';
            $data['inputerror'][] = 'provinsi';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save() {
        $this->validate_save();
        $name   = $this->input->post("name");
        $provinsi   = $this->input->post("provinsi");
        
        $array_insert = [
            'name' => $name,
            'province_id' => $provinsi

        ];
        Modules::run('database/insert', 'cities', $array_insert);

        echo json_encode(['status' => true]);

    }

    public function get_data() {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_data = Modules::run('database/find', 'cities', ['id' => $id])->row();

        echo json_encode(['data' => $get_data, 'status' => true]);
    }

    public function update() {
        Modules::run('security/is_ajax');
        $this->validate_save();

        $id     = $this->input->post('id');
        $name     = $this->input->post('name');
        $provinsi   = $this->input->post("provinsi");

        $array_update = [
            'name' => $name,
            'province_id' => $provinsi
        ];

        Modules::run('database/update', 'cities', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function delete_data() {
        Modules::run('security/is_ajax');
        $id = $this->input->post("id");

        Modules::run('database/delete', 'cities', ['id' => $id]);
        echo json_encode(['status' => true]);
    }
}