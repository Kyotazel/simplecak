<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Schedule extends BackendController
{
    var $module_name = 'batch_course';
    var $module_directory = 'batch_course';
    var $module_js = ['schedule'];
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
        $batch_course               = Modules::run('database/find', 'tb_batch_course', ['id' => $id])->row();
        $this->app_data['id']       = $id;
        $this->app_data['name']     = $batch_course->title;
        $this->app_data['page_title']     = "Jadwal Pertemuan";
        $this->app_data['view_file']     = 'schedule_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data($id)
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/find', 'tb_batch_course_has_schedule', ['id_batch_course' => $id])->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $btn_edit       = Modules::run('security/edit_access', ' <a href="' . Modules::run('helper/create_url', "batch_course/schedule/edit/$id?data=" . urlencode($this->encrypt->encode($data_table->id))) . '" data-id="' . $id_encrypt . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> </a>');
            $btn_delete     = Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> </a>');
            $btn_detail     = ' <a href="' . Modules::run('helper/create_url', 'batch_course/schedule/detail?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" class="btn btn-sm btn-info"><i class="fa fa-tv"></i></a> ';

            $media = '';
            if ($data_table->media == 1) {
                $media .= '<span class="badge badge-success">Online</span>';
            } else {
                $media .= '<span class="badge badge-primary">Tatap Muka</span>';
            }

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $data_table->title;
            $row[] = "<i class='fa fa-calendar-alt mb-2'></i> <b>" . Modules::run('helper/date_indo', $data_table->date, '-') . "</b><br><b>"
            . date('H:i:s', strtotime($data_table->starting_time)) . "</b>" . 
            "<p style='color: gray; margin-top: 0px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;'><i class='fa fa-clock'> S/D</i></p><b>"
            . date('H:i:s', strtotime($data_table->ending_type)) . "</b>";
            $row[] = $media;
            $row[] =
            '<img src="' . base_url("upload/barcode/$data_table->id" . ".png") . '" style="width: 55%;" class="img-fluid popupqrcode">';
            $row[] = $btn_detail . $btn_edit . $btn_delete;
            $data[] = $row;
        }

        $ouput = [
            "data" => $data
        ];

        echo json_encode($ouput);
    }

    public function add($id_batch)
    {
        $this->app_data['batch_course'] = Modules::run('database/find', 'tb_batch_course', ['id' => $id_batch])->row();   
        $this->app_data['media']        = Modules::run('database/find', 'app_module_setting', ['params' => 'media'])->result();
        $this->app_data['method']       = 'add';
        $this->app_data['page_title']   = 'Tambah Jadwal';
        $this->app_data['view_file']   = 'schedule_add';
        echo Modules::run('template/main_layout', $this->app_data);
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

    public function detail()
    {
        Modules::run('security/is_axist_data', ['method' => 'get', 'name' => 'data', 'encrypt' => true, "redirect" => Modules::run('helper/create_url', "/batch_course_schedule")]);
        $id = $this->encrypt->decode($this->input->get("data"));
        $batch_course_schedule  = Modules::run('database/find', 'tb_batch_course_has_schedule', ['id' => $id])->row();
        $batch_course           = Modules::run('database/find', 'tb_batch_course', ['id' => $batch_course_schedule->id_batch_course])->row();

        $count_query    = [
            "select"    => "count(*) as total",
            "from"      => "tb_batch_course_schedule_has_attendance",
            "where"     => "id_batch_course_schedule = $id"
        ];

        $count_batch = [
            "select" => "count(*) as total",
            "from" => "tb_batch_course_has_account",
            "where" => "id_batch_course = $batch_course->id"
        ];

        $start_query    = [
            'select' => 'TIME(starting_time) as start',
            'from'  => 'tb_batch_course_has_schedule',
            'where' => "id = $id"
        ];

        $end_query    = [
            'select' => 'TIME(ending_type) as end',
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
        $this->app_data["count"]        = Modules::run('database/get', $count_query)->row();
        $this->app_data["count_batch"]  = Modules::run("database/get", $count_batch)->row();
        $this->app_data['data_profile'] = $get_profile;
        $this->app_data['attendance']   = Modules::run('database/find', 'app_module_setting', ['field' => 'attendance'])->result();
        $this->app_data["batch_course"] = $batch_course;
        $this->app_data['data_detail']  = $batch_course_schedule;
        $this->app_data['starting_time'] = $starting_time->start;
        $this->app_data['ending_time']  = $ending_time->end;
        $this->app_data['module_js']  = ['absensi'];
        $this->app_data['page_title']   = "Detail Jadwal Pertemuan";
        $this->app_data['view_file']    = 'schedule_detail';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_peserta()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_all  = Modules::run('database/find', 'tb_batch_course_has_schedule', ['id' => $id])->row();


        $get_batch_course = Modules::run("database/find", "tb_batch_course_has_account", ["id_batch_course" => $get_all->id_batch_course, "is_confirm" => 1])->result();

        $no = 0;
        $data = [];
        foreach ($get_batch_course as $data_table) {
            $get_account = Modules::run("database/find", "tb_account", ["id" => $data_table->id_account])->row();

            $status     = Modules::run('database/find', 'tb_batch_course_schedule_has_attendance', ['id_batch_course_schedule' => $id, 'id_batch_course_account' => $data_table->id])->row();

            $absensi    = '';
            if (isset($status)) {
                $status_absensi = '';
                if ($status->status_attendance == 0) {
                    $status_absensi .= "Tidak Hadir";
                } else if ($status->status_attendance == 1) {
                    $status_absensi .= "Hadir";
                } else if ($status->status_attendance == 2) {
                    $status_absensi .= "Izin";
                } else if ($status->status_attendance == 3) {
                    $status_absensi .= "Sakit";
                }
                $absensi    .= '<button class="btn btn-sm btn-success">Sudah Absensi</button> <button class="btn btn-warning btn-sm">' . $status_absensi . '</button> <button class="btn btn-danger btn-sm btn_delete_absensi" data-idSchedule=' . $id . ' data-idAccount=' . $data_table->id . '><i class="fa fa-trash"></i></button>';
            } else {
                $absensi    .= '<button class="btn btn-sm btn-danger mb-1">Belum Absensi</button><br><button class="btn btn-sm btn-primary btn_absensi" data-idSchedule=' . $id . ' data-idAccount=' . $data_table->id . '>Klik Untuk Absensi</button>';
            }

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

    public function validate_save()
    {
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

    public function save()
    {
        $this->validate_save();
        $title              = $this->input->post('title');
        $id_batch_course    = $this->input->post('id_batch_course');
        $date               = $this->input->post('date');
        $starting_time      = $date . " " . $this->input->post('starting_time');
        $ending_type        = $date . " " . $this->input->post('ending_type');
        $description        = $_POST['description'];
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

        $array_get_id = [
            "select" => "*",
            "from" => "tb_batch_course_has_schedule",
            "order_by" => "id, DESC",
            "limit" => "1"
        ];

        $get_id = Modules::run('database/get', $array_get_id)->row();

        $qrcode = $this->create_qr_code($get_id->id);

        $redirect = Modules::run('helper/create_url', "batch_course/schedule/index/$id_batch_course");

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function update()
    {
        Modules::run("security/is_ajax");
        $this->validate_save();
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

    public function add_attendance()
    {
        $id_batch_course_account = $this->input->post("id_batch_course_account");
        $id_batch_course_schedule = $this->input->post("id_batch_course_schedule");
        $status = $this->input->post('status');

        $array_insert = [
            'id_batch_course_account'   => $id_batch_course_account,
            'id_batch_course_schedule'  => $id_batch_course_schedule,
            'status_attendance'         => $status,
            'created_by'                => $this->session->userdata('us_id'),
            'crated_date'              => date('Y-m-d')
        ];

        Modules::run('database/insert', 'tb_batch_course_schedule_has_attendance', $array_insert);
        echo json_encode(['status' => true]);
    }

    public function delete_data_absensi()
    {
        $id_batch_course_account = $this->input->post("id_batch_course_account");
        $id_batch_course_schedule = $this->input->post("id_batch_course_schedule");

        Modules::run('database/delete', 'tb_batch_course_schedule_has_attendance', ['id_batch_course_account' => $id_batch_course_account, 'id_batch_course_schedule' => $id_batch_course_schedule]);
        echo json_encode(['status' => true]);
    }

    private function create_qr_code($code)
    {
        error_reporting(0);
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = '../upload/'; //string, the default is application/cache/
        $config['errorlog']     = '../upload/'; //string, the default is application/logs/
        $config['imagedir']     = '../upload/barcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
        $image_name = $code . '.png'; //buat name dari qr code sesuai dengan nim
        $params['data'] = $code; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir']  . $image_name; //simpan image QR CODE ke folder assets/images/


        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        return $image_name;
    }
}