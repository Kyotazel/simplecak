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

        $count                      = Modules::run('database/get', $array_count)->row();
        
        $this->load->library('pagination');
        $config['base_url'] = base_url()."admin/package_question/question/index/$id/";
		$config['total_rows'] = $count->total;
		$config['per_page'] = 10;
        $config["uri_segment"] = 5;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['first_link']       = '<<';
        $config['last_link']        = '>>';
        $config['next_link']        = '>';
        $config['prev_link']        = '<';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination pagination-radius justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
 

		$this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $no_soal = $this->uri->segment('5') + 1;

        $this->app_data['answer']       = $this->db->get_where('tb_package_question_has_detail', ['id_parent' => $id], $config['per_page'], $data['page'])->result();
        $this->app_data['count']        = $count;
        $this->app_data['no_soal']      = $no_soal;
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

    public function list_data($id_parent, $id_question = 1)
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/find', 'tb_package_question_has_detail', ['id_parent' => $id_parent ,'id' => $id_question])->row();

        $all_json_answer = $get_all->json_answer;
        $all_answer      = json_decode($all_json_answer, true);

        $ouput = [
            "id"    => $get_all->id,
            "soal" => $get_all->text_question,
            "answer" => $get_all->answer,
            "all_answer" => $all_answer
        ];

        echo json_encode($ouput);
    }

    public function edit($id_question)
    {
        Modules::run('security/is_axist_data', ['method' => 'get', 'name' => 'data', 'encrypt' => true, "redirect" => Modules::run('helper/create_url', "/package_question/question")]);
        $id = $this->encrypt->decode($this->input->get("data"));
        $get_data                       = Modules::run('database/find', 'tb_package_question_has_detail', ['id' => $id])->row();
        $this->app_data['method']       = 'update';
        $this->app_data['id_parent']    = $id_question;
        $this->app_data['data_detail']  = $get_data;
        $this->app_data['answer']       = json_decode($get_data->json_answer, true);
        $this->app_data['page_title']   = 'Edit Soal';
        $this->app_data['view_file']    = 'question_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }


    public function save()
    {
        Modules::run("security/is_ajax"); 
        $id_parent          = $this->input->post('id_parent');
        $text_question      = $_POST['text_question'];
        $result_1           = $_POST['result_1'];
        $result_2           = $_POST['result_2'];
        $result_3           = $_POST['result_3'];
        $result_4           = $_POST['result_4'];
        $result_5           = $_POST['result_5'];
        $answer             = $this->input->post('answer');
        $solution           = $_POST['solution'];
        $get_package        = Modules::run('database/find', 'tb_package_question', ['id' => $id_parent])->row();
        $id_package         = $get_package->id_type_package;

        $result = [
            '1' => $result_1,
            '2' => $result_2,
            '3' => $result_3,
            '4' => $result_4,
            '5' => $result_5,
        ];

        header('Content-Type: application/json; charset=utf-8');
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

        $id_parent          = $this->input->post('id_parent');
        $text_question      = $_POST['text_question'];
        $result_1           = $_POST['result_1'];
        $result_2           = $_POST['result_2'];
        $result_3           = $_POST['result_3'];
        $result_4           = $_POST['result_4'];
        $result_5           = $_POST['result_5'];
        $answer             = $this->input->post('answer');
        $solution           = $_POST['solution'];
        $get_package        = Modules::run('database/find', 'tb_package_question', ['id' => $id_parent])->row();
        $id_package         = $get_package->id_type_package;

        $result = [
            '1' => $result_1,
            '2' => $result_2,
            '3' => $result_3,
            '4' => $result_4,
            '5' => $result_5,
        ];

        header('Content-Type: application/json; charset=utf-8');
        $json_answer = json_encode($result);

        $array_update = [
            'id_package'    => $id_package,
            'id_parent'     => $id_parent,
            'text_question' => $text_question,
            'answer'        => $answer,
            'solution'      => $solution,
            'json_answer'   => $json_answer,
            'created_by' => $this->session->userdata('us_id'),
            'created_date' => date('Y-m-d')
        ];

        Modules::run("database/update", "tb_package_question_has_detail", ['id' => $id], $array_update);

        $redirect = Modules::run('helper/create_url', "package_question/question/index/$id_parent");

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post("id"));

        Modules::run('database/delete', 'tb_package_question_has_detail', ['id' => $id]);
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