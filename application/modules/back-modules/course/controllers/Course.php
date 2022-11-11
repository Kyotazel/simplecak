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
        $get_course = Modules::run('database/get_all', 'tb_course')->result();
        $no = 0;
        $data = array();
        foreach ($get_course as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $btn_edit       = Modules::run('security/edit_access', ' <a href="' . Modules::run('helper/create_url', 'course/edit?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" data-id="' . $id_encrypt . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> </a>');
            $btn_delete     = Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> </a>');
            $btn_detail     = ' <a href="' . Modules::run('helper/create_url', 'course/detail?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" class="btn btn-sm btn-info"><i class="fa fa-tv"></i></a> ';

            $get_course_has_skill = Modules::run('database/find', 'tb_course_has_skill', ['id_course' => $data_table->id])->result();
            $get_category = Modules::run('database/find', 'tb_course_category', ['id' => $data_table->id_category_course])->row();

            $skill = '';
            foreach ($get_course_has_skill as $value) {
                $get_skill = Modules::run('database/find', "tb_skill", ["id" => $value->id_skill])->row();
                $skill .= "- $get_skill->name<br> ";
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->name;
            $row[] = $get_category->name;
            $row[] = $skill;
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
        $this->app_data['get_skill']     = Modules::run('database/get_all', 'tb_skill')->result();
        $this->app_data['get_course_category']     = Modules::run('database/get_all', 'tb_course_category')->result();
        $this->app_data['method']     = 'add';
        $this->app_data['page_title'] = "Tambah Pelatihan";
        $this->app_data['view_file']  = 'form_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function edit()
    {
        $id = $this->encrypt->decode($this->input->get('data'));
        $get_skill = [
            "select" => "id_skill",
            "from" => "tb_course_has_skill",
            "where" => "id_course = $id"
        ];
        $get_skill  = Modules::run('database/get', $get_skill)->result();

        $data = [];
        foreach ($get_skill as $value) {
            $data[] = $value->id_skill;
        }

        $this->app_data['data_detail']   = Modules::run('database/find', 'tb_course', ['id' => $id])->row();
        $this->app_data['detail_skill']  = $data;
        $this->app_data['get_skill']     = Modules::run('database/get_all', 'tb_skill')->result();
        $this->app_data['get_course_category'] = Modules::run('database/get_all', 'tb_course_category')->result();
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
        if ($this->input->post('skill') == '') {
            $data['error_string'][] = 'Skill Harus Diisi';
            $data['inputerror'][] = 'skill[]';
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

    public function save()
    {
        $this->validate_save();
        $name          = $this->input->post("name");
        $description   = $_POST["description"];
        $id_category_course         = $this->input->post("id_category_course");

        $array_insert = [
            'name' => $name,
            'description' => $description,
            'id_category_course' => $id_category_course,
            'created_by' => $this->session->userdata('us_id'),
            'created_date' => date('Y-m-d h:i:sa')
        ];
        Modules::run('database/insert', 'tb_course', $array_insert);

        $get_id_course = Modules::run('database/find', 'tb_course', ['name' => $name])->row();
        foreach ($this->input->post("skill") as $skill) {
            $array_insert = [
                'id_skill' => $skill,
                'id_course' => $get_id_course->id,
                'created_by' => $this->session->userdata('us_id'),
                'created_date' => date('Y-m-d h:i:sa')
            ];

            Modules::run('database/insert', 'tb_course_has_skill', $array_insert);
        }


        $redirect = Modules::run('helper/create_url', 'course');

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function get_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_skill = Modules::run('database/find', 'tb_course_has_skill', ['id_course' => $id])->row();

        $get_course = Modules::run('database/find', 'tb_course', ['id' => $id])->row();

        echo json_encode(['skill' => $get_skill, 'course' => $get_course, 'status' => true]);
    }

    public function update()
    {
        Modules::run('security/is_ajax');
        $this->validate_save();

        $id            = $this->input->post('id');
        $name          = $this->input->post("name");
        $description   = $_POST["description"];
        $id_category_course         = $this->input->post("id_category_course");

        $array_update_course = [
            'name' => $name,
            'description' => $description,
            'id_category_course' => $id_category_course,
            'updated_by' => $this->session->userdata('us_id'),
            'updated_date' => date('Y-m-d h:i:sa')
        ];

        Modules::run('database/update', 'tb_course', ['id' => $id], $array_update_course);

        Modules::run('database/delete', 'tb_course_has_skill', ['id_course' => $id]);

        foreach ($this->input->post("skill") as $skill) {
            $array_insert = [
                'id_skill' => $skill,
                'id_course' => $id,
                'updated_by' => $this->session->userdata('us_id'),
                'updated_date' => date('Y-m-d h:i:sa')
            ];

            Modules::run('database/insert', 'tb_course_has_skill', $array_insert);
        }

        $redirect = Modules::run('helper/create_url', 'course');
        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function detail()
    {
        $id = $this->encrypt->decode($this->input->get('data'));
        $get_data = Modules::run('database/find', 'tb_course', ['id' => $id])->row();
        $get_category = Modules::run('database/find', 'tb_course_category', ['id' => $get_data->id_category_course])->row();
        $get_course_has_skill = Modules::run('database/find', 'tb_course_has_skill', ['id_course' => $id])->result();

        $skill = '';
        foreach ($get_course_has_skill as $value) {
            $get_skill = Modules::run('database/find', "tb_skill", ["id" => $value->id_skill])->row();
            $skill .= "<h6>- $get_skill->name</h6> ";
        }

        $this->app_data['skill']       = $skill;
        $this->app_data['data_detail'] = $get_data;
        $this->app_data['category'] = $get_category;
        $this->app_data['page_title'] = "Detail pelatihan";
        $this->app_data['view_file'] = 'view_detail';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post("id"));

        Modules::run('database/delete', 'tb_course', ['id' => $id]);
        Modules::run('database/delete', 'tb_course_has_skill', ['id_course' => $id]);
        echo json_encode(['status' => true]);
    }
}
