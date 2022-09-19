<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Confirm_register extends BackendController
{
    var $module_name = 'confirm_register';
    var $module_directory = 'confirm_register';
    var $module_js = ['confirm_register'];
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
        $this->app_data['page_title']   = 'Konfirmasi Pendaftaran';
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");
        $array_get = [
            "select" => "*",
            "from" => "tb_batch_course",
            "where" => "ending_date > '" . date('Y-m-d') . "'"
        ];
        $get_all = Modules::run('database/get', $array_get)->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $array_peserta = [
                "select" => "count(*) as total",
                "from" => "tb_batch_course_has_account",
                "where" => "id_batch_course = $data_table->id AND status = 0"
            ];
            $count_peserta      = Modules::run("database/get", $array_peserta)->row();

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $data_table->title;
            $row[] =
                '<a href="javascript:void(0)" onclick="modal_peserta(' . "'$data_table->id'" . ')"><i class="fa fa-user"></i> ' . $count_peserta->total . ' peserta</a>';
            $row[] = "<p style='color: gray; margin-top: 4px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;'><i class='fa fa-calendar-alt'> Tanggal Dimulai</i></p><b>"
                . Modules::run("helper/date_indo", $data_table->opening_registration_date, "-") . "</b>" .
                "<p style='color: gray; margin-top: 4px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;'><i class='fa fa-calendar-alt'> Tanggal Selesai</i></p><b>"
                . Modules::run("helper/date_indo", $data_table->closing_registration_date, "-") . "</b>";
            $data[] = $row;
        }

        $ouput = [
            "data" => $data
        ];

        echo json_encode($ouput);
    }

    public function get_peserta()
    {
        Modules::run("security/is_ajax");
        $id_batch_course = $this->input->post("id_batch_course");

        $get_all = Modules::run("database/find", "tb_batch_course_has_account", ["id_batch_course" => $id_batch_course, 'status' => 0])->result();

        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {
            $get_account = Modules::run("database/find", "tb_account", ["id" => $data_table->id_account])->row();

            $confirm = "<a href='#' data-id='$data_table->id' id='confirm_account' class='text-light btn btn-sm btn-success'>Klik Untuk Konfirmasi</a>";

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = '<a href="javascript:void(0)" onclick="modal_detail(' . $get_account->id . ')" >' . $get_account->name . '</a>';
            $row[] = $confirm;
            $row[] = "<button class='btn btn-danger btn-sm btn_delete_peserta' data-id=$data_table->id>Tolak Peserta</button>";
            $data[] = $row;
        }

        $ouput = [
            "data" => $data
        ];

        echo json_encode($ouput);
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

    public function delete_peserta()
    {
        $id = $this->input->post("id");

        $array_update = [
            "is_confirm" => 1,
            "confirm_by" => $this->session->userData('us_id'),
            "status" => 10,
        ];

        Modules::run("database/update", "tb_batch_course_has_account", ["id" => $id], $array_update);

        echo json_encode(["status" => true]);
    }

    public function detail_peserta()
    {

        $id = $this->input->post('id');

        $get_content = Modules::run('database/find', 'tb_account', ['id' => $id])->row();

        $education        = Modules::run("database/find", "tb_education", ["id" => $get_content->id_last_education])->row();
        $gender           = Modules::run("database/find", "app_module_setting", ["params" => "gender", "value" => $get_content->gender])->row();
        $religion         = Modules::run("database/find", "app_module_setting", ["params" => "religion", "value" => $get_content->religion])->row();
        $province_current = Modules::run("database/find", "provinces", ["id" => $get_content->id_province_current])->row();
        $city_current     = Modules::run("database/find", "cities", ["id" => $get_content->id_city_current])->row();
        $regency_current  = Modules::run("database/find", "regencies", ["id" => $get_content->id_regency_current])->row();
        $village_current  = Modules::run("database/find", "villages", ["id" => $get_content->id_village_current])->row();

        $html_content = "
        <h4 class='text-center'>$get_content->name</h4>
        <p class='text-center text-muted'>$get_content->email</p>
        <div class='text-center'>
            <img src='asd.png' alt='' class='align-item-center' style='height: 160px; width: 120px'>
        </div>
        <div class='content mt-4'>
            <div class='row'>
                <div class='col-md-6'>No Ktp</div>
                <div class='col-md-6'>: $get_content->no_ktp</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>No KK</div>
                <div class='col-md-6'>: $get_content->no_kk</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>No Hp</div>
                <div class='col-md-6'>: $get_content->phone_number</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>Tempat, Tanggal Lahir</div>
                <div class='col-md-6'>: $get_content->birth_place, " . Modules::run('helper/date_indo', $get_content->birth_date, '-') ."</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>Agama</div>
                <div class='col-md-6'>: $religion->label</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>Jenis Kelamin : </div>
                <div class='col-md-6'>: $gender->label</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>Provinsi Sekarang</div>
                <div class='col-md-6'>: $province_current->name</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>Kota Sekarang</div>
                <div class='col-md-6'>: $city_current->name</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>Kecamatan Sekarang</div>
                <div class='col-md-6'>: $regency_current->name</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>Desa Sekarang</div>
                <div class='col-md-6'>: $village_current->name</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>Alamat Sekarang</div>
                <div class='col-md-6'>: $get_content->address_current</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>Pendidikan Terakhir</div>
                <div class='col-md-6'>: $education->name</div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>Sekolah Terakhir</div>
                <div class='col-md-6'>: $get_content->last_school</div>
            </div>
            <hr>
        </div>";
        echo $html_content;
    }
}
