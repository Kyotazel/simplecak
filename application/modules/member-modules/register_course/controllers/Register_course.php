<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register_course extends CommonController
{
    var $module_name = 'register_course';
    var $module_directory = 'register_course';
    var $module_js = ['register_course'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        Modules::run('security/common_security');
        $this->_init();
    }

    private function _init()
    {
        $this->app_data['module_js']    = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }

    public function index() {

        // $get_batch_course = Modules::run('database/find', 'tb_batch_course', ['ending_date' > date('Y-m-d')])->result();

        $array_get = [
            "select" => "a.*, c.name as category_name",
            "from" => "tb_batch_course as a",
            "join"  => [
                'tb_course as b, a.id_course = b.id',
                "tb_course_category c, b.id_category_course = c.id"
            ],
            "where" => "ending_date > '" . date('Y-m-d') . "'",
            'order_by' => 'id,DESC'
        ];

        $get_batch_course = Modules::run('database/get', $array_get)->result();
        $this->app_data['batch_course'] = $get_batch_course;
        $this->app_data['page_title']   = "Pendaftaran Pelatihan";
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function detail()
    {
        $id = $this->encrypt->decode($this->input->get('data'));
        $id = str_replace(' ', '+', $id);
        $get_data = Modules::run('database/find', 'tb_batch_course', ['id' => $id])->row();

        $course    = Modules::run('database/find', 'tb_course', ["id" => $get_data->id_course])->row();
        $category_course = Modules::run("database/find", "tb_course_category", ["id" => $course->id_category_course])->row();

        $this->app_data['data_detail'] = $get_data;
        $this->app_data["category_course"]    = $category_course;
        $this->app_data["course"]    = $course;

        $this->app_data['page_title']   = "Pendaftaran Pelatihan";
        $this->app_data['view_file']    = 'detail';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    private function validate_register()
    {
        $id_account         = $this->session->userdata('member_id');
        $id_batch_course    = $this->input->post('id');

        $batch_course       = Modules::run('database/find', 'tb_batch_course', ['id' => $id_batch_course])->row();

        $terdaftar  = Modules::run('database/find', 'tb_batch_course_has_account', ['id_account' => $id_account, 'id_batch_course' => $id_batch_course])->row();
        $account    = Modules::run('database/find', 'tb_account', ['id' => $id_account])->row();
        $data = [];
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        if(isset($terdaftar)) {
            $data["title"]          = "Pendaftaran Gagal";
            $data["description"]    = "Anda Sudah Terdaftar Pada Course Ini";
            $data['status']         = FALSE;
        }

        if(
            $account->no_ktp == NULL ||
            $account->no_kk == NULL ||
            $account->phone_number == NULL ||
            $account->name == NULL ||
            $account->birth_place == NULL ||
            $account->birth_date == NULL ||
            $account->religion == NULL ||
            $account->married_status == NULL ||
            $account->gender == NULL ||
            $account->id_province == NULL ||
            $account->id_city == NULL ||
            $account->id_regency == NULL ||
            $account->id_village == NULL ||
            $account->address == NULL ||
            $account->id_province_current == NULL ||
            $account->id_city_current == NULL ||
            $account->id_regency_current == NULL ||
            $account->id_village_current == NULL ||
            $account->address_current == NULL ||
            $account->id_last_education == NULL ||
            $account->last_school == NULL
        ) {
            $data["title"]          = "Pendaftaran Gagal";
            $data["description"]    = "Lengkapi Profil Terlebih dahulu";
            $data['status']         = FALSE;
        }

        if ($batch_course->closing_registration_date < date('Y-m-d')) {
            $data["title"]          = "Pendaftaran Gagal";
            $data["description"]    = "Pendaftaran ini sudah ditutup";
            $data['status']         = FALSE;
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function register_batch()
    {
        $this->validate_register();
        $id_batch_course    = $this->input->post('id');
        $id_account         = $this->session->userdata('member_id');

        $array_insert = [
            'id_account' => $id_account,
            'id_batch_course' => $id_batch_course,
            'date' => date('Y-m-d'),
            'registration_code' => 'SC' . $id_batch_course . $id_account,
            'is_confirm' => 0,
            'crated_by' => $id_account,
            'created_date' => date('Y-m-d H:i:s'),
            'status' => 0
        ];

        Modules::run('database/insert', 'tb_batch_course_has_account', $array_insert);

        echo json_encode(['status' => TRUE]);

    }
}