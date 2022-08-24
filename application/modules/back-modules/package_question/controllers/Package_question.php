<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Package_question extends BackendController
{
    var $module_name = 'package_question';
    var $module_directory = 'package_question';
    var $module_js = ['package_question'];
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

        $this->app_data['page_title']    = "Bank Soal";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/get_all', 'tb_package_question')->result();
        $no = 0;
        $data = array();
        foreach ($get_all as $data_table) {
            
            $btn_soal       = " <a href='" . Modules::run('helper/create_url', 'package_question/question/index/'. $data_table->id) . "' class='btn btn-sm btn-info text-light'><i class='fa fa-laptop'></i> Buat Soal</a>";;

            $category       = Modules::run('database/find', 'tb_package_category', ['id' => $data_table->id_type_package])->row();
            
            $array_count = [
                "select"    => "count(*) as total",
                "from"      => "tb_package_question_has_detail",
                "where"     => "id_parent = $data_table->id"
            ];

            $get_count      = Modules::run('database/get', $array_count)->row();
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->code;
            $row[] = $data_table->name;
            $row[] = $category->name;
            $row[] = $data_table->creator_name;
            $row[] = $get_count->total . " Soal";
            $row[] = $data_table->min_value_graduation;
            $row[] = $btn_soal;
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        echo json_encode($ouput);
    }

    public function add()
    {
        $this->app_data['type_package'] = Modules::run('database/get_all', 'tb_package_category')->result();
        $this->app_data['method']       = 'add';
        $this->app_data['page_title']   = "Tambah Bank Soal";
        $this->app_data['view_file']    = 'form_add';
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
        if ($this->input->post('creator_name') == '') {
            $data['error_string'][] = 'Pembuat Soal Harus Diisi';
            $data['inputerror'][] = 'creator_name';
            $data['status'] = FALSE;
        }
        if ($this->input->post('min_value_graduation') == '') {
            $data['error_string'][] = 'Nilai Minimal Kelulusan Harus Diisi';
            $data['inputerror'][] = 'min_value_graduation';
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

        $code                   = $this->input->post('code');
        $id_type_package        = $this->input->post('id_type_package');
        $creator_name           = $this->input->post('creator_name');
        $name                   = $this->input->post("name")    ;
        $min_value_graduation   = $this->input->post('min_value_graduation');

        $array_insert = [
            'code'                  => $code,
            'id_type_package'       => $id_type_package,
            'creator_name'          => $creator_name,
            'name'                  => $name,
            'min_value_graduation'  => $min_value_graduation,
            'created_by'            => $this->session->userdata('us_id'),
            'created_date'          => date('Y-m-d h:i:sa'),
            'updated_by'            => $this->session->userdata('us_id'),
            'updated_date'          => date('Y-m-d h:i:sa')
        ];
        Modules::run('database/insert', 'tb_package_question', $array_insert);

        $redirect = Modules::run('helper/create_url', 'package_question');

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

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post("id"));

        Modules::run('database/delete', 'tb_package_category', ['id' => $id]);
        echo json_encode(['status' => true]);
    }
}
