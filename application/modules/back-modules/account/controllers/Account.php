<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends BackendController
{
    var $module_name = 'account';
    var $module_directory = 'account';
    var $module_js = ['account'];
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
        $this->app_data["skill"] = Modules::run("database/get_all", "tb_skill")->result();
        $this->app_data['page_title']     = "Daftar Member";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/get_all', 'tb_account_has_skill')->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id_account);

            $get_account = Modules::run("database/find", "tb_account", ["id" => $data_table->id_account])->row();
            $get_skill = Modules::run("database/find", "tb_skill", ["id" => $data_table->id_skill])->row();

            if ($get_account->status == 1) {
                $status = "<span class='badge badge-success'>Sudah Dikonfirmasi</span>";
            } else if ($get_account->status == 0) {
                $status = "<span class='badge badge-warning'>Belum Dikonfirmasi</span>
                        <br><a href=# data-id='$get_account->id' id='confirm_account'><span class='badge badge-primary'>Konfirmasi Akun</span></a>";
            }

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $get_account->name;
            $row[] = $get_account->email;
            $row[] = $get_skill->name;
            $row[] = $status;
            $row[] = '
                    <a href="javascript:void(0)" data-id="' . $data_table->id_account . '" class="btn btn-sm btn-info btn_edit"><i class="fas fa-pen"></i> Edit</a>
                    <a href="javascript:void(0)" data-id="' . $data_table->id_account . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> Hapus</a>
            ';
            $data[] = $row;
        }

        $ouput = [
            "data" => $data
        ];

        echo json_encode($ouput);
    }

    public function add()
    {
        $this->app_data["provinsi"] = Modules::run("database/get_all", "provinces")->result();
        $this->app_data["last_education"] = Modules::run("database/get_all", "tb_education")->result();
        $this->app_data["skill"] = Modules::run("database/get_all", "tb_skill")->result();

        $this->app_data['page_title'] = "Tambah Member";
        $this->app_data['view_file']  = 'add';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    // public function edit()
    // {
    //     $id = $this->encrypt->decode($this->input->get('data'));

    //     $this->app_data["provinsi"] = Modules::run("database/get_all", "provinces")->result();
    //     $this->app_data["last_education"] = Modules::run("database/get_all", "tb_education")->result();
    //     $this->app_data["skill"] = Modules::run("database/get_all", "tb_skill")->result();
    //     $this->app_data['module_js']  = ["edit"];

    //     $account = Modules::run("database/find", "tb_account", ["id" => $id])->row();
    //     $this->app_data["get_account"] = $account;
    //     $this->app_data["get_skill"] = Modules::run("database/find", "tb_account_has_skill", ["id_account" => $id])->row();

    //     $this->app_data['page_title'] = "Update Member";
    //     $this->app_data['view_file']  = 'edit';
    //     echo Modules::run('template/main_layout', $this->app_data);
    // }

    // public function get_data()
    // {
    //     $id = $this->encrypt->decode($this->input->get('data'));
    //     var_dump($id);
    //     $account = Modules::run("database/find", "tb_account", ["id" => $id])->row();
    //     echo json_encode(["data" => $account]);
    // }

    public function update_confirm()
    {
        $id = $this->input->post("id");

        $array_update = [
            "status" => 1,
            "is_confirm" => 1
        ];

        Modules::run("database/update", "tb_account", ["id" => $id], $array_update);

        echo json_encode(["status" => true]);
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
        if ($this->input->post('id_skill') == '') {
            $data['error_string'][] = 'keahlian Harus Diisi';
            $data['inputerror'][] = 'id_skill';
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
        $id_skill                  = $this->input->post('id_skill');
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
        $username               = $email;
        $password               = bin2hex(random_bytes(8));
        $hash_password          = hash('sha256', $password . config_item('encription_key'));
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
            'password' => $hash_password,
            'status' => $status,
            'is_confirm' => $is_confirm,
            'image' => $image,
        ];

        Modules::run("database/insert", "tb_account", $array_insert);

        $get_id_account = Modules::run("database/find", "tb_account", ["no_ktp" => $no_ktp])->row();

        $array_insert = [
            "id_account" => $get_id_account->id,
            "id_skill" => $id_skill
        ];

        Modules::run("database/insert", "tb_account_has_skill", $array_insert);

        $array_key = [
            'email' => $email
        ];

        $encrypt_key = $this->encrypt->encode(json_encode($array_key));

        Modules::run('emailing/confirm_email', $email, $encrypt_key, $username, $password);

        echo json_encode(["status" => true]);
    }

    public function get_data() {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_data = Modules::run('database/find', 'tb_account', ['id' => $id])->row();
        $get_skill = Modules::run('database/find', 'tb_account_has_skill', ['id_account' => $id])->row();

        echo json_encode(['data' => $get_data, 'status' => true, 'skill' => $get_skill]);
    }


    public function update() {
        $this->validate_save();
        $id                     = $this->input->post("id");
        $no_ktp                 = $this->input->post('no_ktp');
        $no_kk                  = $this->input->post('no_kk');
        $id_skill                  = $this->input->post('id_skill');
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

        // $registration_date      = date("Y-m-d");
        // $username               = $email;
        // $password               = bin2hex(random_bytes(8));
        // $hash_password          = hash('sha256', $password . config_item('encription_key'));
        // $status = 0;
        // $is_confirm = 0;

        $image = $this->upload_image();
        $image = ($image == '') ? 'default.png' : $image;

        $array_update = [
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
            'image' => $image,
        ];

        Modules::run("database/update", "tb_account", ["id" => $id], $array_update);

        $get_id_account = Modules::run("database/find", "tb_account", ["no_ktp" => $no_ktp])->row();

        $array_update = [
            "id_account" => $get_id_account->id,
            "id_skill" => $id_skill
        ];

        Modules::run("database/update", "tb_account_has_skill", ["id_account" => $id], $array_update);

        echo json_encode(["status" => true]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post("id");

        Modules::run('database/delete', 'tb_account', ['id' => $id]);
        Modules::run('database/delete', 'tb_account_has_skill', ['id_account' => $id]);
        echo json_encode(['status' => true]);
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
