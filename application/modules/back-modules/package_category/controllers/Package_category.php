<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Package_category extends BackendController
{
    var $module_name = 'package_category';
    var $module_directory = 'package_category';
    var $module_js = ['package_category'];
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

        $this->app_data['page_title']    = "Daftar Kategori Paket Soal";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/get_all', 'tb_package_category')->result();
        $no = 0;
        $data = array();
        foreach ($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $btn_edit       = Modules::run('security/edit_access', ' <a href="' . Modules::run('helper/create_url', 'package_category/edit?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" data-id="' . $id_encrypt . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> </a>');
            $btn_delete     = Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> </a>');
            $btn_detail     = ' <a href="' . Modules::run('helper/create_url', 'package_category/detail?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" class="btn btn-sm btn-info"><i class="fa fa-tv"></i></a> ';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->name;
            $row[] = $btn_detail . $btn_edit . $btn_delete;
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        echo json_encode($ouput);
    }

    public function add()
    {
        $this->app_data['method']     = 'add';
        $this->app_data['page_title'] = "Tambah Kategori Paket Soal";
        $this->app_data['view_file']  = 'form_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function edit()
    {
        $id = $this->encrypt->decode($this->input->get('data'));

        $this->app_data['data_detail']   = Modules::run('database/find', 'tb_package_category', ['id' => $id])->row();
        $this->app_data['method']        = 'update';
        $this->app_data['page_title']    = 'Ubah Pelatihan';
        $this->app_data['view_file']     = 'form_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    private function validate_save()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');

        if ($this->input->post('name') == '') {
            $data['error_string'][] = 'Nama Pelatihan Harus Diisi';
            $data['inputerror'][] = 'name';
            $data['status'] = FALSE;
        }
        if ($this->input->post('description') == '') {
            $data['error_string'][] = 'Deskripsi Harus Diisi';
            $data['inputerror'][] = 'description';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save()
    {
        $this->validate_save();
        $name          = $this->input->post("name");
        $description   = $_POST["description"];

        $array_insert = [
            'name' => $name,
            'description' => $description,
            'created_by' => $this->session->userdata('us_id'),
            'created_date' => date('Y-m-d h:i:sa')
        ];
        Modules::run('database/insert', 'tb_package_category', $array_insert);

        $redirect = Modules::run('helper/create_url', 'package_category');

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }


    public function update()
    {
        Modules::run('security/is_ajax');
        $this->validate_save();

        $id            = $this->input->post('id');
        $name          = $this->input->post("name");
        $description   = $_POST["description"];

        $array_update = [
            'name' => $name,
            'description' => $description,
            'updated_by' => $this->session->userdata('us_id'),
            'updated_date' => date('Y-m-d h:i:sa')
        ];

        Modules::run('database/update', 'tb_package_category', ['id' => $id], $array_update);

        $redirect = Modules::run('helper/create_url', 'package_category');
        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function detail()
    {
        $id = $this->encrypt->decode($this->input->get('data'));
        $get_data = Modules::run('database/find', 'tb_package_category', ['id' => $id])->row();

        $this->app_data['data_detail'] = $get_data;
        $this->app_data['page_title'] = "Detail pelatihan";
        $this->app_data['view_file'] = 'view_detail';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post("id"));

        Modules::run('database/delete', 'tb_package_category', ['id' => $id]);
        echo json_encode(['status' => true]);
    }
}
