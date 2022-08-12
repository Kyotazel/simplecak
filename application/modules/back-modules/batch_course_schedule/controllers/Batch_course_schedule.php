<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Batch_course_schedule extends BackendController
{
    var $module_name = 'batch_course_schedule';
    var $module_directory = 'batch_course_schedule';
    var $module_js = ['batch_course_schedule'];
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
        $this->app_data['page_title']     = "Penjadwalan Pertemuan";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data() {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/get_all', 'tb_batch_course_has_schedule')->result();
        $no = 0;
        $data = [];
        foreach($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $btn_edit       = Modules::run('security/edit_access', ' <a href="' . Modules::run('helper/create_url', 'batch_course_schedule/edit?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" data-id="' . $id_encrypt . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> </a>');
            $btn_delete     = Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> </a>');
            $btn_detail     = ' <a href="' . Modules::run('helper/create_url', 'batch_course_schedule/detail?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" class="btn btn-sm btn-info"><i class="fa fa-tv"></i></a> ';

            $get_batch_course = Modules::run("database/find", "tb_batch_course", ["id" => $data_table->id_batch_course])->row();
            
            $media = '';
            if($data_table->media == 1) {
                $media .= '<span class="badge badge-success">Online</span>';
            } else {
                $media .= '<span class="badge badge-primary">Tatap Muka</span>';
            }

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $get_batch_course->title;
            $row[] = $data_table->title;
            $row[] = $data_table->date;
            $row[] = $media;
            $row[] = $btn_detail . $btn_edit . $btn_delete;
            $data[] = $row;
        }

        $ouput = [
            "data" => $data
        ];

        echo json_encode($ouput);
    }

    public function add() {
        $this->app_data['batch_course'] = Modules::run('database/get_all', 'tb_batch_course')->result();
        $this->app_data['media']        = Modules::run('database/find', 'app_module_setting', ['params' => 'media'])->result();
        $this->app_data['method']       = 'add';
        $this->app_data['page_title']   = 'Tambah Jadwal';
        $this->app_data['view_file']   = 'form_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function edit() {
        $id = $this->encrypt->decode($this->input->get("data"));
        $this->app_data['batch_course'] = Modules::run('database/get_all', 'tb_batch_course')->result();
        $this->app_data['method']       = 'update';
        $this->app_data['data_detail']  = Modules::run('database/find', 'tb_batch_course_has_schedule', ['id' => $id])->row();
        $this->app_data['media']        = Modules::run('database/find', 'app_module_setting', ['params' => 'media'])->result();
        $this->app_data['page_title']   = 'Edit Jadwal';
        $this->app_data['view_file']    = 'form_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function detail() {
        $id = $this->encrypt->decode($this->input->get("data"));
        $batch_course_schedule  = Modules::run('database/find', 'tb_batch_course_has_schedule', ['id' => $id])->row();
        $batch_course           = Modules::run('database/find', 'tb_batch_course', ['id' => $batch_course_schedule->id_batch_course])->row();

        $start_query    = [
            'select'=> 'TIME(starting_time) as start',
            'from'  => 'tb_batch_course_has_schedule',
            'where' => "id = $id"
        ];

        $end_query    = [
            'select'=> 'TIME(ending_type) as end',
            'from'  => 'tb_batch_course_has_schedule',
            'where' => "id = $id"
        ];

        $query_profile = [
            'select' => '
                tb_account.*,
            ',
            'from' => 'tb_batch_course_has_account',
            'join' => [
                'tb_account, tb_batch_course_has_account.id_account = tb_account.id, left'
            ],
            'where' => "tb_batch_course_has_account.id_batch_course = $batch_course->id",
            'order_by' => 'tb_batch_course_has_account.id, DESC'
        ];

        $get_profile                    = Modules::run('database/get', $query_profile)->result();
        $starting_time                  = Modules::run('database/get', $start_query)->row();
        $ending_time                    = Modules::run('database/get', $end_query)->row();
        $this->app_data['data_profile'] = $get_profile;
        $this->app_data['data_detail']  = Modules::run('database/find', 'tb_batch_course_has_schedule', ['id' => $id])->row();
        $this->app_data['starting_time']= $starting_time->start;
        $this->app_data['ending_time']  = $ending_time->end;
        $this->app_data['module_js']  = ['absensi'];
        $this->app_data['page_title']   = "Detail Jadwal Pertemuan";
        $this->app_data['view_file']    = 'view_detail';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_peserta() {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_all  = Modules::run('database/find', 'tb_batch_course_has_schedule', ['id' => $id])->row();


        $get_batch_course = Modules::run("database/find", "tb_batch_course_has_account", ["id_batch_course" => $get_all->id_batch_course, "is_confirm" => 1])->result();

        $no = 0;
        $data = [];
        foreach($get_batch_course as $data_table) {
            $get_account = Modules::run("database/find", "tb_account", ["id" => $data_table->id_account])->row();

            $absensi    = '';
            $absensi    .= '<button class="btn btn-sm btn-danger mb-1">Belum Absensi</button><br><button class="btn btn-sm btn-primary" onclick="setAbsen('. "'$data_table->id', '$id'" .')">Klik Untuk Absensi</button>';

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $get_account->name;
            $row[] = $absensi;
            $data[] = $row;
        }

        $ouput = [
            "data" => $data
        ];

        echo json_encode($ouput);
    }

    public function validate_save() {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('id_batch_course') == '') {
            $data['error_string'][] = 'Tipe Gelombang Pelatihan Harus Diisi';
            $data['inputerror'][] = 'title';
            $data['status'] = FALSE;
        }
        if ($this->input->post('title') == '') {
            $data['error_string'][] = 'Judul Jadwal Harus Diisi';
            $data['inputerror'][] = 'title';
            $data['status'] = FALSE;
        }
        if ($this->input->post('date') == '') {
            $data['error_string'][] = 'Tanggal Jadwal Harus Dimasukkan';
            $data['inputerror'][] = 'date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('starting_time') == '') {
            $data['error_string'][] = 'Jadwal Mulai Harus Diisi';
            $data['inputerror'][] = 'starting_time';
            $data['status'] = FALSE;
        }
        if ($this->input->post('ending_type') == '') {
            $data['error_string'][] = 'Jadwal Selesai Harus Diisi';
            $data['inputerror'][] = 'ending_type';
            $data['status'] = FALSE;
        }
        if ($this->input->post('description') == '') {
            $data['error_string'][] = 'Deskripsi Harus Diisi';
            $data['inputerror'][] = 'description';
            $data['status'] = FALSE;
        }
        if ($this->input->post('media') == '') {
            $data['error_string'][] = 'Media Harus Diisi';
            $data['inputerror'][] = 'media';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save() {
        $this->validate_save();
        $title              = $this->input->post('title');
        $id_batch_course    = $this->input->post('id_batch_course');
        $date               = $this->input->post('date');
        $starting_time      = $this->input->post('starting_time');
        $ending_type        = $this->input->post('ending_type');
        $description        = $this->input->post('description');
        $media              = $this->input->post('media');

        $array_insert = [
            'title'     => $title,
            'id_batch_course'     => $id_batch_course,
            'date'     => $date,
            'starting_time'     => $starting_time,
            'ending_type'     => $ending_type,
            'description'     => $description,
            'media'     => $media,
            'created_by' => $this->session->userdata('us_id'),
            'crated_date' => date('Y-m-d')
        ];

        Modules::run("database/insert", "tb_batch_course_has_schedule", $array_insert);

        $redirect = Modules::run('helper/create_url', 'batch_course_schedule');

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function update() {
        Modules::run("security/is_ajax");
        $this->validate_save();
        $id = $this->input->post("id");

        $title              = $this->input->post('title');
        $id_batch_course    = $this->input->post('id_batch_course');
        $date               = $this->input->post('date');
        $starting_time      = $this->input->post('starting_time');
        $ending_type        = $this->input->post('ending_type');
        $description        = $this->input->post('description');
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

        Modules::run("database/update", "tb_batch_course_has_schedule", ['id' => $id] , $array_update);

        $redirect = Modules::run('helper/create_url', 'batch_course_schedule');

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function delete_data() {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post("id"));

        Modules::run('database/delete', 'tb_batch_course_has_schedule', ['id' => $id]);
        echo json_encode(['status' => true]);
    }

    private function upload_image()
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/schedule');
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