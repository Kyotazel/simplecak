<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Question extends BackendController
{
    var $module_name = 'package_question';
    var $module_directory = 'package_question';
    var $module_js = ['question'];
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

    public function index($id)
    {
        $package_question           = Modules::run('database/find', 'tb_package_question', ['id' => $id])->row();
        $type                       = Modules::run('database/find', 'tb_package_category', ['id' => $package_question->id_type_package])->row();
        $array_count = [
            "select"    => "count(*) as total",
            "from"      => "tb_package_question_has_detail",
            "where"     => "id_parent = $id"
        ];
        $this->app_data['count']        = Modules::run('database/get', $array_count)->row();
        $this->app_data['id']           = $id;
        $this->app_data['data_detail']  = $package_question;
        $this->app_data['type']         = $type->name;
        $this->app_data['page_title']   = $package_question->name;
        $this->app_data['view_file']    = 'question_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function add($id_question)
    {
        $this->app_data['id_parent']    = $id_question;
        $this->app_data['method']       = 'add';
        $this->app_data['page_title']   = 'Tambah Soal';
        $this->app_data['view_file']    = 'question_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data($id)
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/find', 'tb_package_question_has_detail', ['id_parent' => $id])->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $data_table->text_question;
            $row[] = "Tes";
            $data[] = $row;
        }

        $ouput = [
            "data" => $data
        ];

        echo json_encode($ouput);
    }

    public function edit($id_batch)
    {
        Modules::run('security/is_axist_data', ['method' => 'get', 'name' => 'data', 'encrypt' => true, "redirect" => Modules::run('helper/create_url', "/batch_course_schedule")]);
        $id = $this->encrypt->decode($this->input->get("data"));
        $this->app_data['batch_course'] = Modules::run('database/find', 'tb_batch_course', ['id' => $id_batch])->row();
        $this->app_data['method']       = 'update';
        $this->app_data['data_detail']  = Modules::run('database/find', 'tb_batch_course_has_schedule', ['id' => $id])->row();
        $this->app_data['media']        = Modules::run('database/find', 'app_module_setting', ['params' => 'media'])->result();
        $this->app_data['page_title']   = 'Edit Jadwal';
        $this->app_data['view_file']    = 'schedule_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }


    public function save()
    {
        Modules::run("security/is_ajax"); 
        $id_parent          = $this->input->post('id_parent');
        $text_question      = $_POST['text_question'];
        $result_a           = $_POST['result_a'];
        $result_b           = $_POST['result_b'];
        $result_c           = $_POST['result_c'];
        $result_d           = $_POST['result_d'];
        $result_e           = $_POST['result_e'];
        $answer             = $this->input->post('answer');
        $solution           = $_POST['solution'];
        $get_package        = Modules::run('database/find', 'tb_package_question', ['id' => $id_parent])->row();
        $id_package         = $get_package->id_type_package;

        $result = [
            'A' => $result_a,
            'B' => $result_b,
            'C' => $result_c,
            'D' => $result_d,
            'E' => $result_e,
        ];

        $json_answer = json_encode($result);

        $array_insert = [
            'id_package'    => $id_package,
            'id_parent'     => $id_parent,
            'text_question' => $text_question,
            'answer'        => $answer,
            'solution'      => $solution,
            'json_answer'   => $json_answer,
            'created_by' => $this->session->userdata('us_id'),
            'created_date' => date('Y-m-d')
        ];

        Modules::run("database/insert", "tb_package_question_has_detail", $array_insert);

        $redirect = Modules::run('helper/create_url', "package_question/question/index/$id_parent");

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function update()
    {
        Modules::run("security/is_ajax");
        $id = $this->input->post("id");

        $title              = $this->input->post('title');
        $id_batch_course    = $this->input->post('id_batch_course');
        $date               = $this->input->post('date');
        $starting_time      = $date . " " . $this->input->post('starting_time');
        $ending_type        = $date . " " . $this->input->post('ending_type');
        $description        = $_POST['description'];
        $media              = $this->input->post('media');

        $array_update = [
            'title'             => $title,
            'id_batch_course'   => $id_batch_course,
            'date'              => $date,
            'media'             => $media,
            'starting_time'     => $starting_time,
            'ending_type'       => $ending_type,
            'description'       => $description,
            'updated_by'        => $this->session->userdata('us_id'),
            'updated_date'       => date('Y-m-d')
        ];

        Modules::run("database/update", "tb_batch_course_has_schedule", ['id' => $id], $array_update);

        $redirect = Modules::run('helper/create_url', "batch_course/schedule/index/$id_batch_course");

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post("id"));

        Modules::run('database/delete', 'tb_batch_course_has_schedule', ['id' => $id]);
        echo json_encode(['status' => true]);
    }

    private function upload_image()
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/batch');
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image')) //upload and validate
        {
            return '';
        } else {
            $upload_data = $this->upload->data();
            $image_name = $upload_data['file_name'];
            return $image_name;
        }
    }
}