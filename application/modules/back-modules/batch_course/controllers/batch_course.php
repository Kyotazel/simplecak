<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Batch_course extends BackendController
{
    var $module_name = 'batch_course';
    var $module_directory = 'batch_course';
    var $module_js = ['batch_course'];
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
        $this->app_data['page_title']     = "Gelombang Pelatihan";
        $this->app_data['view_file']     = 'main_view';
        $this->app_data["course"]       = Modules::run("database/get_all", "tb_course")->result();
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data() {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/get_all', 'tb_batch_course')->result();
        $no = 0;
        $data = [];
        foreach($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $btn_edit       = Modules::run('security/edit_access', ' <a href="' . Modules::run('helper/create_url', 'batch_course/edit?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" data-id="' . $id_encrypt . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> </a>');
            $btn_delete     = Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> </a>');
            $btn_detail     = ' <a href="' . Modules::run('helper/create_url', 'batch_course/detail?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" class="btn btn-sm btn-info"><i class="fa fa-tv"></i></a> ';

            $get_course = Modules::run("database/find", "tb_course", ["id" => $data_table->id_course])->row();
            $array_query = [
                "select" => "count(*) as total",
                "from" => "tb_batch_course_has_account",
                "where" => "id_batch_course = $data_table->id"
            ];
            $get_count  = Modules::run("database/get", $array_query)->row();

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $data_table->title;
            $row[] = "$get_course->name";
            $row[] = '<button class="btn btn-outline-info btn-light btn-sm" onclick="modal_tambah(' . "'$data_table->id'" . ')"><i class="fa fa-plus text-info"></i></button> ' . 
            '<a href="javascript:void(0)" onclick="modal_peserta(' . "'$data_table->id'" . ')">' . $get_count->total . " / " . $data_table->target_registrant . " peserta</a>";
            $row[] = "<p style='color: gray; margin-top: 4px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;'><i class='fa fa-calendar-alt'> Tanggal Dimulai</i></p><b>"
             . Modules::run("helper/date_indo", $data_table->starting_date, "-") . "</b>" . 
             "<p style='color: gray; margin-top: 4px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;'><i class='fa fa-calendar-alt'> Tanggal Selesai</i></p><b>"
             . Modules::run("helper/date_indo", $data_table->ending_date, "-") . "</b>";
            $row[] = $btn_detail . $btn_edit . $btn_delete;
            $data[] = $row;
        }

        $ouput = [
            "data" => $data
        ];

        echo json_encode($ouput);
    }

    public function add() {
        $this->app_data["course"]       = Modules::run("database/get_all", "tb_course")->result();
        $this->app_data["method"]       = "add";
        $this->app_data["page_title"] = "Tambah Gelombang Pelatihan";
        $this->app_data["view_file"] = "form_add";
        echo Modules::run("template/main_layout", $this->app_data);
    }

    public function get_data() {
        Modules::run("security/is_ajax");
        $id = $this->input->post("id");
        $get_data = Modules::run("database/find", "tb_batch_course", ["id" => $id])->row();
        echo json_encode(["data" => $get_data, "status" => true]);
    }

    public function get_add() {
        Modules::run("security/is_ajax");
        $id_batch_course = $this->input->post("id_batch_course");

        $get_all = Modules::run("database/get_all", "tb_account")->result();
        $no = 0;
        $data = [];
        foreach($get_all as $data_table) {
            $get_account_has_skill = Modules::run('database/find', 'tb_account_has_skill', ['id_account' => $data_table->id])->result();
            
            $skill = '';
            foreach($get_account_has_skill as $value) {
                $get_skill = Modules::run('database/find', "tb_skill", ["id" => $value->id_skill])->row();
                $skill .= "- $get_skill->name<br> ";
            }

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $data_table->name;
            $row[] = $skill;
            $row[] = '<button class="btn btn-primary" onclick="add_to_batch('. "'$data_table->id'," . "'$id_batch_course'" .')"><i class="fa fa-check"></i> Pilih</button>';
            $data[] = $row;
        }

        $ouput = [
            "data" => $data
        ];

        echo json_encode($ouput);

    }

    public function get_peserta() {
        Modules::run("security/is_ajax");
        $id_batch_course = $this->input->post("id_batch_course");

        $get_all = Modules::run("database/find", "tb_batch_course_has_account", ["id_batch_course" => $id_batch_course, "is_confirm" => 1])->result();

        $no = 0;
        $data = [];
        foreach($get_all as $data_table) {
            $get_account = Modules::run("database/find", "tb_account", ["id" => $data_table->id_account])->row();
            $get_account_skill = Modules::run("database/find", "tb_account_has_skill", ["id_account" => $data_table->id_account])->result();
            $skill = '';
            foreach($get_account_skill as $value) {
                $get_skill = Modules::run('database/find', "tb_skill", ["id" => $value->id_skill])->row();
                $skill .= "- $get_skill->name<br> ";
            }

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $get_account->name;
            $row[] = $skill;
            $row[] = "<button class='btn btn-danger btn-sm btn_delete_peserta' data-id=$data_table->id><i class='fa fa-trash'></i> Hapus</button>";
            $data[] = $row;
        }

        $ouput = [
            "data" => $data
        ];

        echo json_encode($ouput);
    }

    public function add_account_batch() {
        $id_account = $this->input->post("id_account");
        $id_batch = $this->input->post("id_batch");

        $target = Modules::run("database/find", "tb_batch_course", ["id" => $id_batch])->row();

        $array_query = [
            "select" => "count(*) as total",
            "from" => "tb_batch_course_has_account",
            "where" => "id_batch_course = $id_batch"
        ];
        $get_count  = Modules::run("database/get", $array_query)->row();

        $code_reg = "SC" . $id_batch . $id_account;

        $array_insert = [
            "id_account" => $id_account,
            "id_batch_course" => $id_batch,
            "date" => date("Y-m-d"),
            "registration_code" => $code_reg,
            "is_confirm" => 1,
            'confirm_by' => $this->session->userdata('us_id'),
            'crated_by' => $this->session->userdata('us_id')
        ];

        if ($get_count->total >= $target->target_registrant) {
            echo json_encode(["status" => false, "kesalahan" => "Tidak Bisa Melebihi Total"]);
            exit();
        }

        Modules::run("database/insert", "tb_batch_course_has_account", $array_insert);

        echo json_encode(["status" => true]);
    }

    public function delete_peserta() {
        $id = $this->input->post("id");

        Modules::run("database/delete", "tb_batch_course_has_account", ["id" => $id]);

        echo json_encode(["status" => true]);
    }

    public function edit() {
        $id = $this->encrypt->decode($this->input->get("data"));
        $this->app_data["method"]       = "update";
        $this->app_data['data_detail']  = Modules::run('database/find', 'tb_batch_course', ['id' => $id])->row();
        $this->app_data['page_title']   = "Edit Gelombang Pelatihan";
        $this->app_data['view_file']    = 'form_add';
        $this->app_data["course"]       = Modules::run("database/get_all", "tb_course")->result();
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function validate_save()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('title') == '') {
            $data['error_string'][] = 'Judul Pelatihan Harus Diisi';
            $data['inputerror'][] = 'title';
            $data['status'] = FALSE;
        }
        if ($this->input->post('description') == '') {
            $data['error_string'][] = 'Deskripsi Pelatihan Harus Diisi';
            $data['inputerror'][] = 'description';
            $data['status'] = FALSE;
        }
        if ($this->input->post('target_registrant') == '') {
            $data['error_string'][] = 'Kuota Peserta Harus Diisi';
            $data['inputerror'][] = 'target_registrant';
            $data['status'] = FALSE;
        }
        if ($this->input->post('opening_registration_date') == '') {
            $data['error_string'][] = 'Awal Pendaftaran Harus Diisi';
            $data['inputerror'][] = 'opening_registration_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('closing_registration_date') == '') {
            $data['error_string'][] = 'Akhir Pendaftaran Harus Diisi';
            $data['inputerror'][] = 'closing_registration_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('starting_date') == '') {
            $data['error_string'][] = 'Awal Pelatihan Harus Diisi';
            $data['inputerror'][] = 'starting_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('ending_date') == '') {
            $data['error_string'][] = 'Akhir Pelatihan Harus Diisi';
            $data['inputerror'][] = 'ending_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_course') == '') {
            $data['error_string'][] = 'Tipe Pelatihan Harus Diisi';
            $data['inputerror'][] = 'id_course';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save() 
    {
        Modules::run("security/is_ajax");
        $this->validate_save();
        
        $title                      = $this->input->post("title");
        $id_course                  = $this->input->post("id_course");
        $description                = $this->input->post("description");
        $target_registrant          = $this->input->post("target_registrant");
        $opening_registration_date  = $this->input->post("opening_registration_date");
        $closing_registration_date  = $this->input->post("closing_registration_date");
        $starting_date              = $this->input->post("starting_date");
        $ending_date                = $this->input->post("ending_date");
        echo $opening_registration_date; return;

        $image = $this->upload_image();
        $image = ($image === '') ? 'default.png' : $image;

        $array_insert = [
            "id_course" => $id_course,
            "title" => $title,
            "description" => $description,
            "target_registrant" => $target_registrant,
            "opening_registration_date" => $opening_registration_date,
            "closing_registration_date" => $closing_registration_date,
            "starting_date" => $starting_date,
            "ending_date" => $ending_date,
            "image" => $image,
            'created_by' => $this->session->userdata('us_id'),
            'created_date' => date('Y-m-d')
        ];

        Modules::run("database/insert", "tb_batch_course", $array_insert);

        $redirect = Modules::run('helper/create_url', 'batch_course');

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function update() 
    {
        Modules::run("security/is_ajax");
        $this->validate_save();
        $id = $this->input->post("id");
        
        $title                      = $this->input->post("title");
        $id_course                  = $this->input->post("id_course");
        $description                = $this->input->post("description");
        $target_registrant          = $this->input->post("target_registrant");
        $opening_registration_date  = $this->input->post("opening_registration_date");
        $closing_registration_date  = $this->input->post("closing_registration_date");
        $starting_date              = $this->input->post("starting_date");
        $ending_date                = $this->input->post("ending_date");

        $array_update = [
            "id_course" => $id_course,
            "title" => $title,
            "description" => $description,
            "target_registrant" => $target_registrant,
            "opening_registration_date" => $opening_registration_date,
            "closing_registration_date" => $closing_registration_date,
            "starting_date" => $starting_date,
            "ending_date" => $ending_date,
            'updated_by' => $this->session->userdata('us_id'),
            'updated_date' => date('Y-m-d')
        ];

        $image = $this->upload_image();
        if ($image !== '') {
            $image = ["image" => $image];
            $array_update = array_merge($array_update, $image);
        }
        // var_dump($array_update); die;

        Modules::run('database/update', 'tb_batch_course', ['id' => $id], $array_update);

        $redirect = Modules::run('helper/create_url', 'batch_course');

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function detail()
    {
        $id = $this->encrypt->decode($this->input->get('data'));
        $get_data = Modules::run('database/find', 'tb_batch_course', ['id' => $id])->row();

        $array_query = [
            "select" => "count(*) as total",
            "from" => "tb_batch_course_has_account",
            "where" => "id_batch_course = $id"
        ];
        $count = Modules::run("database/get", $array_query)->row();
        $course    = Modules::run('database/find', 'tb_course', ["id" => $get_data->id_course])->row();
        $category_course = Modules::run("database/find", "tb_course_category", ["id" => $course->id_category_course])->row();

        $query_profile = [
            'select' => '
                tb_account.*,
            ',
            'from' => 'tb_batch_course_has_account',
            'join' => [
                'tb_account, tb_batch_course_has_account.id_account = tb_account.id, left'
            ],
            'where' => "tb_batch_course_has_account.id_batch_course = $id",
            'order_by' => 'tb_batch_course_has_account.id, DESC'
        ];
        $get_profile = Modules::run('database/get', $query_profile)->result();

        $this->app_data['data_profile'] = $get_profile;
        $this->app_data['data_detail'] = $get_data;
        $this->app_data["count"]       = $count;
        $this->app_data["category_course"]    = $category_course;
        $this->app_data["course"]    = $course;
        $this->app_data['page_title'] = "Detail Gelombang Pelatihan";
        $this->app_data['view_file'] = 'view_detail';
        echo Modules::run('template/main_layout', $this->app_data);
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

    public function delete_data() {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post("id"));

        Modules::run('database/delete', 'tb_batch_course', ['id' => $id]);
        echo json_encode(['status' => true]);
    }
    
}