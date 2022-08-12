<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course_category extends BackendController
{
    var $module_name = 'course_category';
    var $module_directory = 'course_category';
    var $module_js = ['course_category'];
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
        $this->app_data['page_title']     = "Kategori Pelatihan";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/get_all', 'tb_course_category')->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->name;
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
            $data['error_string'][] = 'Kategori Pelatihan Harus Diisi';
            $data['inputerror'][] = 'name';
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
        
        $array_insert = [
            'name' => $name,
            'created_by' => $this->session->userdata('us_id'),
            'created_date' => date('Y-m-d h:i:sa')
        ];
        Modules::run('database/insert', 'tb_course_category', $array_insert);

        echo json_encode(['status' => true]);

    }

    public function get_data() {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_data = Modules::run('database/find', 'tb_course_category', ['id' => $id])->row();

        echo json_encode(['data' => $get_data, 'status' => true]);
    }

    public function update() {
        Modules::run('security/is_ajax');
        $this->validate_save();

        $id     = $this->input->post('id');
        $name     = $this->input->post('name');

        $array_update = [
            'name' => $name,
            'updated_by' => $this->session->userdata('us_id'),
            'updated_date' => date('Y-m-d h:i:sa')
        ];

        Modules::run('database/update', 'tb_course_category', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function delete_data() {
        Modules::run('security/is_ajax');
        $id = $this->input->post("id");

        Modules::run('database/delete', 'tb_course_category', ['id' => $id]);
        echo json_encode(['status' => true]);
    }

    public function export_pdf() {
        $html = "<h1 style='text-align: center;'>Data Dosen Mengajar</h1><br><br>";
    }
}