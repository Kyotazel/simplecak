<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course extends BackendController
{
    var $module_name = 'course';
    var $module_directory = 'course';
    var $module_js = ['course'];
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

        $this->app_data['get_skill']     = Modules::run('database/get_all', 'tb_skill')->result();
        $this->app_data['get_course_category']     = Modules::run('database/get_all', 'tb_course_category')->result();
        $this->app_data['page_title']    = "Daftar Pelatihan";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/get_all', 'tb_course_has_skill')->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {

            $get_course = Modules::run('database/find', 'tb_course', ['id' => $data_table->id_course])->row();
            $get_skill = Modules::run('database/find', 'tb_skill', ['id' => $data_table->id_skill])->row();
            $get_category = Modules::run('database/find', 'tb_course_category', ['id' => $get_course->id_category_course])->row();

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $get_course->name;
            $row[] = $get_category->name;
            $row[] = $get_skill->name;
            $row[] = '
                    <a href="javascript:void(0)" data-id="' . $data_table->id_course . '" class="btn btn-sm btn-info btn_edit"><i class="fas fa-pen"></i> Edit</a>
                    <a href="javascript:void(0)" data-id="' . $data_table->id_course . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> Hapus</a>
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
            $data['error_string'][] = 'Nama Pelatihan Harus Diisi';
            $data['inputerror'][] = 'name';
            $data['status'] = FALSE;
        }
        if ($this->input->post('description') == '') {
            $data['error_string'][] = 'Deskripsi Harus Diisi';
            $data['inputerror'][] = 'description';
            $data['status'] = FALSE;
        }
        if ($this->input->post('skill') == '') {
            $data['error_string'][] = 'Skill Harus Diisi';
            $data['inputerror'][] = 'skill';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_category_course') == '') {
            $data['error_string'][] = 'Kategori Keahlian Harus Diisi';
            $data['inputerror'][] = 'id_category_course';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save() {
        $this->validate_save();
        $name          = $this->input->post("name");
        $description   = $this->input->post("description");
        $skill         = $this->input->post("skill");
        $id_category_course         = $this->input->post("id_category_course");
        
        $array_insert = [
            'name' => $name,
            'description' => $description,
            'id_category_course' => $id_category_course
        ];
        Modules::run('database/insert', 'tb_course', $array_insert);

        $get_id_course = Modules::run('database/find', 'tb_course', ['name' => $name])->row();

        $array_insert = [
            'id_skill' => $skill,
            'id_course' => $get_id_course->id
        ];

        Modules::run('database/insert', 'tb_course_has_skill', $array_insert);

        echo json_encode(['status' => true]);

    }

    public function get_data() {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_skill = Modules::run('database/find', 'tb_course_has_skill', ['id_course' => $id])->row();

        $get_course = Modules::run('database/find', 'tb_course', ['id' => $id])->row();

        echo json_encode(['skill' => $get_skill, 'course' => $get_course, 'status' => true]);
    }

    public function update() {
        Modules::run('security/is_ajax');
        $this->validate_save();

        $id            = $this->input->post('id');
        $name          = $this->input->post("name");
        $description   = $this->input->post("description");
        $skill         = $this->input->post("skill");
        $id_category_course         = $this->input->post("id_category_course");

        $array_update_course = [
            'name' => $name,
            'description' => $description,
            'id_category_course' => $id_category_course
        ];

        $array_update_skill = [
            'id_skill' => $skill
        ];

        Modules::run('database/update', 'tb_course', ['id' => $id], $array_update_course);
        Modules::run('database/update', 'tb_course_has_skill', ['id_course' => $id], $array_update_skill);
        echo json_encode(['status' => true]);
    }

    public function delete_data() {
        Modules::run('security/is_ajax');
        $id = $this->input->post("id");

        Modules::run('database/delete', 'tb_course', ['id' => $id]);
        Modules::run('database/delete', 'tb_course_has_skill', ['id_course' => $id]);
        echo json_encode(['status' => true]);
    }
}