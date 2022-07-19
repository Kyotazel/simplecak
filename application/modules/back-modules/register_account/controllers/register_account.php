<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register_account extends BackendController
{
    var $module_name = 'register_account';
    var $module_directory = 'register_account';
    var $module_js = ['register_account'];
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
        $this->app_data["provinsi"] = Modules::run("database/get_all", "provinces")->result();
        $this->app_data["last_education"] = Modules::run("database/get_all", "tb_education")->result();
        $this->app_data['page_title']     = "Pendaftaran Akun";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function validate_save()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');

        if ($this->input->post('no_ktp') == '') {
            $data['error_string'][] = 'NIK Harus Diisi';
            $data['inputerror'][] = 'no_ktp';
            $data['status'] = FALSE;
        }
        if (strlen($this->input->post('no_ktp')) < 16) {
            $data['error_string'][] = 'NIK harus 16 digit';
            $data['inputerror'][] = 'no_ktp';
            $data['status'] = FALSE;
        }
        if ($this->input->post('no_kk') == '') {
            $data['error_string'][] = 'No. KK Harus Diisi';
            $data['inputerror'][] = 'no_kk';
            $data['status'] = FALSE;
        }
        if ($this->input->post('name') == '') {
            $data['error_string'][] = 'Nama Lengkap Harus Diisi';
            $data['inputerror'][] = 'name';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_last_education') == '') {
            $data['error_string'][] = 'Pendidikan Terakhir Harus Diisi';
            $data['inputerror'][] = 'id_last_education';
            $data['status'] = FALSE;
        }
        if ($this->input->post('last_school') == '') {
            $data['error_string'][] = 'Asal Sekolah Harus Diisi';
            $data['inputerror'][] = 'last_school';
            $data['status'] = FALSE;
        }
        if ($this->input->post('email') == '') {
            $data['error_string'][] = 'Email Harus Diisi';
            $data['inputerror'][] = 'email';
            $data['status'] = FALSE;
        }
        if ($this->input->post('birth_place') == '') {
            $data['error_string'][] = 'Tempat Lahir Harus Diisi';
            $data['inputerror'][] = 'birth_place';
            $data['status'] = FALSE;
        }
        if ($this->input->post('birth_date') == '') {
            $data['error_string'][] = 'Tanggal Lahir Harus Diisi';
            $data['inputerror'][] = 'birth_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('gender') == '') {
            $data['error_string'][] = 'Jenis Kelamin Harus Diisi';
            $data['inputerror'][] = 'gender';
            $data['status'] = FALSE;
        }
        if ($this->input->post('religion') == '') {
            $data['error_string'][] = 'Agama Harus Diisi';
            $data['inputerror'][] = 'religion';
            $data['status'] = FALSE;
        }
        if ($this->input->post('married_status') == '') {
            $data['error_string'][] = 'Status Menikah Harus Diisi';
            $data['inputerror'][] = 'married_status';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_province') == '') {
            $data['error_string'][] = 'Provinsi asal Harus Diisi';
            $data['inputerror'][] = 'id_province';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_city') == '') {
            $data['error_string'][] = 'Kota Asal Harus Diisi';
            $data['inputerror'][] = 'id_city';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_regency') == '') {
            $data['error_string'][] = 'Kecamatan Asal Harus Diisi';
            $data['inputerror'][] = 'id_regency';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_village') == '') {
            $data['error_string'][] = 'Desa Asal Harus Diisi';
            $data['inputerror'][] = 'id_village';
            $data['status'] = FALSE;
        }
        if ($this->input->post('address') == '') {
            $data['error_string'][] = 'Alamat Lengkap Harus Diisi';
            $data['inputerror'][] = 'address';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_province_current') == '') {
            $data['error_string'][] = 'Provinsi asal Harus Diisi';
            $data['inputerror'][] = 'id_province_current';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_city_current') == '') {
            $data['error_string'][] = 'Kota Asal Harus Diisi';
            $data['inputerror'][] = 'id_city_current';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_regency_current') == '') {
            $data['error_string'][] = 'Kecamatan Asal Harus Diisi';
            $data['inputerror'][] = 'id_regency_current';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_village_current') == '') {
            $data['error_string'][] = 'Desa Asal Harus Diisi';
            $data['inputerror'][] = 'id_village_current';
            $data['status'] = FALSE;
        }
        if ($this->input->post('address_current') == '') {
            $data['error_string'][] = 'Alamat Lengkap Harus Diisi';
            $data['inputerror'][] = 'address_current';
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
        $no_ktp                 = $this->input->post('no_ktp');
        $no_kk                  = $this->input->post('no_kk');
        $name                   = $this->input->post('name');
        $id_last_education      = $this->input->post('id_last_education');
        $last_school            = $this->input->post('last_school');
        $email                  = $this->input->post('email');
        $birth_place            = $this->input->post('birth_place');
        $birth_date             = $this->input->post('birth_date');
        $gender                 = $this->input->post('gender');
        $religion               = $this->input->post('religion');
        $married_status         = $this->input->post('married_status');
        $id_province            = $this->input->post('id_province');
        $id_city                = $this->input->post('id_city');
        $id_regency             = $this->input->post('id_regency');
        $id_village             = $this->input->post('id_village');
        $address                = $this->input->post('address');
        $id_province_current    = $this->input->post('id_province_current');
        $id_city_current        = $this->input->post('id_city_current');
        $id_regency_current     = $this->input->post('id_regency_current');
        $id_village_current     = $this->input->post('id_village_current');
        $address_current        = $this->input->post('address_current');

        $registration_date      = date("Y-m-d");
        $username               = $no_ktp;
        $password               = hash('sha256', $no_kk.config_item('encription_key'));
        $status = 0;
        $is_confirm = 0;

        $image = $this->upload_image();
        $image = ($image == '') ? 'default.png' : $image;

        $array_insert = [
            'no_ktp' => $no_ktp,
            'no_kk' => $no_kk,
            'name' => $name,
            'id_last_education' => $id_last_education,
            'last_school' => $last_school,
            'email' => $email,
            'birth_place' => $birth_place,
            'birth_date' => $birth_date,
            'gender' => $gender,
            'religion' => $religion,
            'married_status' => $married_status,
            'id_province' => $id_province,
            'id_city' => $id_city,
            'id_regency' => $id_regency,
            'id_village' => $id_village,
            'address' => $address,
            'id_province_current' => $id_province_current,
            'id_city_current' => $id_city_current,
            'id_regency_current' => $id_regency_current,
            'id_village_current' => $id_village_current,
            'address_current' => $address_current,
            'registration_date' => $registration_date,
            'username' => $username,
            'password' => $password,
            'status' => $status,
            'is_confirm' => $is_confirm,
            'image' => $image,
        ];

        Modules::run("database/insert", "tb_account", $array_insert);

        $array_key = [
            'email' => $email
        ];

        $encrypt_key = $this->encrypt->encode(json_encode($array_key));

        Modules::run('emailing/confirm_email', $email, $encrypt_key, $username, $no_kk);

        echo json_encode(["status" => true]);
    }

    public function confirm_email() {
        $key = $this->encrypt->decode($this->input->get('key'));
        $array_key = json_decode($key, TRUE);

        $check_data = Modules::run('database/find', 'tb_account', ['email' => $array_key['email']])->row();

        if (empty($check_data)) { //expired on 30 minute
            redirect(Modules::run('helper/create_url', 'login'));
        }

        $array_update = [
            "status" => 1,
            "is_confirm" => 1
        ];

        Modules::run('database/update', 'tb_account', ['email' => $array_key["email"]], $array_update);

        $this->app_data['data_user'] = $check_data;
        $this->app_data['page_title'] = "Reset Password";
        $this->app_data['view_file'] = 'view_reset_password';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function _validate_do_reset_password()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('password') == '') {
            $data['error_string'][] = 'harus diisi';
            $data['inputerror'][] = 'password';
            $data['status'] = FALSE;
        }
        if ($this->input->post('re_password') == '') {
            $data['error_string'][] = 'harus diisi';
            $data['inputerror'][] = 're_password';
            $data['status'] = FALSE;
        }


        if ($data['status']) {
            if ($this->input->post('re_password') != $this->input->post('password')) {
                $data['error_string'][] = 'password tidak sama';
                $data['inputerror'][] = 're_password';
                $data['status'] = FALSE;
            }
        }


        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function do_reset_password() {
        Modules::run('security/is_ajax');
        $this->_validate_do_reset_password();
        $password = $this->input->post('password');
        $id = $this->encrypt->decode($this->input->post('id'));
        $hash_password = hash('sha512', $password . config_item('encryption_key'));

        $array_update = ['password' => $hash_password];
        Modules::run('database/update', 'tb_account', ['id' => $id], $array_update);
        echo json_encode(['status' => TRUE]);
    }

    public function get_kota()
    {
        Modules::run("security/is_ajax");
        $provinsi = $this->input->post("provinsi");
        // $provinsi = 13;

        $array_kota = [
            "select" => "*",
            "from" => "cities",
            "where" => "province_id = $provinsi"
        ];
        $get_kota = Modules::run("database/get", $array_kota)->result();

        echo json_encode($get_kota);
    }

    public function get_kecamatan()
    {
        Modules::run("security/is_ajax");
        $kota = $this->input->post("kota");

        $array_kota = [
            "select" => "*",
            "from" => "regencies",
            "where" => "city_id = $kota"
        ];
        $get_kecamatan = Modules::run("database/get", $array_kota)->result();

        echo json_encode($get_kecamatan);
    }

    public function get_desa()
    {
        Modules::run("security/is_akax");
        $kecamatan = $this->input->post("kecamatan");

        $array_kecamatan = [
            "select" => "*",
            "from" => "villages",
            "where" => "regency_id = $kecamatan"
        ];
        $get_desa = Modules::run("database/get", $array_kecamatan)->result();

        echo json_encode($get_desa);
    }

    private function upload_image()
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/member');
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image')) //upload and validate
        {
            // $data['inputerror'][] = 'image';
            // $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            // $data['status'] = FALSE;
            // echo json_encode($data);
            // exit();
        } else {
        }
        $upload_data = $this->upload->data();
        $image_name = $upload_data['file_name'];
        return $image_name;
    }
}
