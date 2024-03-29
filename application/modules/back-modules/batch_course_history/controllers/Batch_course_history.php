<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Batch_course_history extends BackendController
{
    var $module_name = 'batch_course_history';
    var $module_directory = 'batch_course_history';
    var $module_js = ['batch_course_history'];
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
        $this->app_data['page_title'] = 'Pelatihan Telah Selesai';
        $this->app_data['view_file']     = 'main_view';
        $this->app_data["course"]       = Modules::run("database/get_all", "tb_course")->result();
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data() {
        Modules::run("security/is_ajax");
        $array_get = [
            "select" => "*",
            "from" => "tb_batch_course",
            "where" => "ending_date < '" . date('Y-m-d') . "'" 
        ];
        $get_all = Modules::run('database/get', $array_get)->result();
        $no = 0;
        $data = [];
        foreach($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $btn_edit       = Modules::run('security/edit_access', ' <a href="' . Modules::run('helper/create_url', 'batch_course_history/edit?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" data-id="' . $id_encrypt . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> </a>');
            $btn_delete     = Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> </a>');
            $btn_detail     = ' <a href="' . Modules::run('helper/create_url', 'batch_course_history/detail?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" class="btn btn-sm btn-info"><i class="fa fa-tv"></i></a> ';
            $btn_schedule   = " <a href='" . Modules::run('helper/create_url', 'batch_course_history/schedule/index/'. $data_table->id) . "' class='btn btn-sm btn-outline-info text-info'><i class='fa fa-info-circle'></i> Detail</a>";

            $array_peserta = [
                "select" => "count(*) as total",
                "from" => "tb_batch_course_has_account",
                "where" => "id_batch_course = $data_table->id AND status = 5"
            ];

            $array_belum = [
                "select" => "count(*) as total",
                "from"  => "tb_batch_course_has_schedule",
                "where" => "starting_time > '" . date('Y-m-d H:i:s') . "' AND id_batch_course = $data_table->id"
            ];

            $array_sudah = [
                "select" => "count(*) as total",
                "from"  => "tb_batch_course_has_schedule",
                "where" => "ending_type < '" . date('Y-m-d H:i:s') . "' AND id_batch_course = $data_table->id"
            ];

            $array_berlangsung = [
                "select" => "count(*) as total",
                "from"  => "tb_batch_course_has_schedule",
                "where" => "starting_time < '" . date('Y-m-d H:i:s') . "' AND ending_type > '" . date('Y-m-d H:i:s') . "' AND id_batch_course = $data_table->id"
            ];

            $count_peserta      = Modules::run("database/get", $array_peserta)->row();
            $count_belum        = Modules::run('database/get', $array_belum)->row();
            $count_sudah        = Modules::run('database/get', $array_sudah)->row();
            $count_berlangsung  = Modules::run('database/get', $array_berlangsung)->row();

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $data_table->title;
            $row[] = "
            <div class='row'>
                <div class='col-md-6'>
                    <span class='badge badge-primary'>Belum : $count_belum->total</span> <br> <span class='badge badge-warning text-light'>Berlangsung : $count_berlangsung->total</span> <br> <span class='badge badge-success'>Selesai : $count_sudah->total</span>
                </div>
                <div class='col-md-6 mt-3'>
                    $btn_schedule
                </div>
            </div>
            ";
            // $row[] = $data_table->target_registrant . ' Peserta';
            $row[] = '<a href="javascript:void(0)" class="btn btn-outline-info" onclick="modal_peserta(' . "'$data_table->id'" . ')"> <i class="fa fa-user"></i> ' . $count_peserta->total . " / " . $data_table->target_registrant . " peserta</a>";
            $row[] = "
            <div class='row'>
                <div class='col-md-6'>
                    <p style='color: gray; margin-top: 4px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;'><i class='fa fa-calendar-alt'> Pendaftaran Mulai</i></p><b>"
                    . Modules::run("helper/date_indo", $data_table->opening_registration_date, "-") . "</b>" . 
                    "<p style='color: gray; margin-top: 4px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;'><i class='fa fa-calendar-alt'> Pendaftaran Akhir</i></p><b>"
                    . Modules::run("helper/date_indo", $data_table->closing_registration_date, "-") . "</b>
                </div>
                <div class='col-md-6'>
                    <p style='color: gray; margin-top: 4px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;'><i class='fa fa-calendar-alt'> Pelatihan Dimulai</i></p><b>"
                    . Modules::run("helper/date_indo", $data_table->starting_date, "-") . "</b>" . 
                    "<p style='color: gray; margin-top: 4px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;'><i class='fa fa-calendar-alt'> Pelatihan Selesai</i></p><b>"
                    . Modules::run("helper/date_indo", $data_table->ending_date, "-") . "</b>
                </div>
            </div>";
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

    public function get_peserta() {
        Modules::run("security/is_ajax");
        $id_batch_course = $this->input->post("id_batch_course");

        $get_all = Modules::run("database/find", "tb_batch_course_has_account", ["id_batch_course" => $id_batch_course, 'status' => 5])->result();

        $no = 0;
        $data = [];
        foreach($get_all as $data_table) {
            $get_account = Modules::run("database/find", "tb_account", ["id" => $data_table->id_account])->row();

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $get_account->name;
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
            "is_confirm" => 0,
            'crated_by' => $this->session->userdata('us_id')
        ];

        if ($get_count->total >= $target->target_registrant) {
            echo json_encode(["status" => false, "kesalahan" => "Tidak Bisa Melebihi Total"]);
            exit();
        }

        Modules::run("database/insert", "tb_batch_course_has_account", $array_insert);

        echo json_encode(["status" => true]);
    }

    public function update_confirm()
    {
        $id = $this->input->post("id");

        $array_update = [
            "is_confirm" => 1,
            "confirm_by" => $this->session->userData('us_id'),
            "status" => 1,
        ];

        Modules::run("database/update", "tb_batch_course_has_account", ["id" => $id], $array_update);

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
        if ($this->input->post('opening_registration_date') > date('Y-m-d')) {
            $data['error_string'][] = 'Tanggal Tidak Valid';
            $data['inputerror'][] = 'opening_registration_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('closing_registration_date') > date('Y-m-d')) {
            $data['error_string'][] = 'Tanggal Tidak Valid';
            $data['inputerror'][] = 'closing_registration_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('starting_date') > date('Y-m-d')) {
            $data['error_string'][] = 'Tanggal Tidak Valid';
            $data['inputerror'][] = 'starting_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('ending_date') > date('Y-m-d')) {
            $data['error_string'][] = 'Tanggal Tidak Valid';
            $data['inputerror'][] = 'ending_date';
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
        $description                = $_POST["description"];
        $target_registrant          = $this->input->post("target_registrant");
        $opening_registration_date  = $this->input->post("opening_registration_date");
        $closing_registration_date  = $this->input->post("closing_registration_date");
        $starting_date              = $this->input->post("starting_date");
        $ending_date                = $this->input->post("ending_date");
        // echo $opening_registration_date; return;

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

        $redirect = Modules::run('helper/create_url', 'batch_course_history');

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function update() 
    {
        Modules::run("security/is_ajax");
        $this->validate_save();
        $id = $this->input->post("id");
        
        $title                      = $this->input->post("title");
        $id_course                  = $this->input->post("id_course");
        $description                = $_POST["description"];
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

        $redirect = Modules::run('helper/create_url', 'batch_course_history');

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function detail()
    {
        $id = $this->encrypt->decode($this->input->get('data'));
        $get_data = Modules::run('database/find', 'tb_batch_course', ['id' => $id])->row();

        $array_query = [
            "select" => "count(*) as total",
            "from" => "tb_batch_course_has_account",
            "where" => "id_batch_course = $id AND status = 5"
        ];
        $count = Modules::run("database/get", $array_query)->row();
        $course    = Modules::run('database/find', 'tb_course', ["id" => $get_data->id_course])->row();
        $category_course = Modules::run("database/find", "tb_course_category", ["id" => $course->id_category_course])->row();

        $query_profile = [
            'select' => '
                tb_account.*, a.is_confirm as confirm_batch, a.id as batch_account_id
            ',
            'from' => 'tb_batch_course_has_account as a',
            'join' => [
                'tb_account, a.id_account = tb_account.id, left'
            ],
            'where' => "a.id_batch_course = $id AND a.status = 5",
            'order_by' => 'a.id, DESC'
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