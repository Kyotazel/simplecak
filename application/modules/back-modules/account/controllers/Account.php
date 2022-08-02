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
        $get_all = Modules::run('database/get_all', 'tb_account')->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $btn_edit       = Modules::run('security/edit_access', ' <a href="' . Modules::run('helper/create_url', 'account/edit?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" data-id="' . $id_encrypt . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> </a>');
            $btn_delete     = Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> </a>');
            $btn_detail     = ' <a href="' . Modules::run('helper/create_url', 'account/detail?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" class="btn btn-sm btn-info"><i class="fa fa-tv"></i></a> ';
            
            $get_account_has_skill = Modules::run('database/find', 'tb_account_has_skill', ['id_account' => $data_table->id])->result();
            
            $skill = '';
            foreach($get_account_has_skill as $value) {
                $get_skill = Modules::run('database/find', "tb_skill", ["id" => $value->id_skill])->row();
                $skill .= "- $get_skill->name<br> ";
            }

            if ($data_table->status == 1) {
                $status = "<span class='badge badge-success'>Sudah Dikonfirmasi</span>";
            } else if ($data_table->status == 0) {
                $status = "<span class='badge badge-warning'>Belum Dikonfirmasi</span>
                        <br><a href=# data-id='$data_table->id' id='confirm_account'><span class='badge badge-primary'>Konfirmasi Akun</span></a>";
            }

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $data_table->name;
            $row[] = $data_table->email;
            $row[] = $skill;
            $row[] = Modules::run("helper/date_indo", $data_table->registration_date, "-");
            $row[] = $status;
            $row[] = $btn_detail . $btn_edit . $btn_delete;
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
        $this->app_data["religion"] = Modules::run("database/find", "app_module_setting", ["params" => "religion"])->result();
        $this->app_data["gender"] = Modules::run("database/find", "app_module_setting", ["params" => "gender"])->result();
        $this->app_data["married"] = Modules::run("database/find", "app_module_setting", ["params" => "married"])->result();
        $this->app_data['page_title'] = "Tambah Member";
        $this->app_data['view_file']  = 'form_add';
        $this->app_data["method"]  = 'add';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function edit() {
        Modules::run("security/is_axist_data", ['method' => 'get', 'name' => 'data', 'encrypt' => true]);
        $id = $this->encrypt->decode($this->input->get('data'));
        $get_skill = [
            "select" => "id_skill",
            "from" => "tb_account_has_skill",
            "where" => "id_account = $id"
        ];
        $get_skill  = Modules::run('database/get', $get_skill)->result();

        $data = [];
        foreach($get_skill as $value) {
            $data[] = $value->id_skill;
        }

        $this->app_data['data_detail']      = Modules::run('database/find', 'tb_account', ['id' => $id])->row();
        $this->app_data['detail_skill']     = $data;
        $this->app_data['get_skill']        = Modules::run('database/get_all', 'tb_skill')->result();
        $this->app_data["provinsi"]         = Modules::run("database/get_all", "provinces")->result();
        $this->app_data["last_education"]   = Modules::run("database/get_all", "tb_education")->result();
        $this->app_data["skill"]            = Modules::run("database/get_all", "tb_skill")->result();
        $this->app_data["religion"]         = Modules::run("database/find", "app_module_setting", ["params" => "religion"])->result();
        $this->app_data["gender"]           = Modules::run("database/find", "app_module_setting", ["params" => "gender"])->result();
        $this->app_data["married"]          = Modules::run("database/find", "app_module_setting", ["params" => "married"])->result();
        $this->app_data['page_title']       = "Edit Member";
        $this->app_data['view_file']        = 'form_add';
        $this->app_data["method"]           = 'update';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function detail() {
        $id = $this->encrypt->decode($this->input->get("data"));

        $get_account_has_skill = Modules::run('database/find', 'tb_account_has_skill', ['id_account' => $id])->result();
            
            $skill = '';
            foreach($get_account_has_skill as $value) {
                $get_skill = Modules::run('database/find', "tb_skill", ["id" => $value->id_skill])->row();
                $skill .= "- $get_skill->name<br> ";
            }

        $data_detail = Modules::run("database/find", "tb_account", ["id" => $id])->row();

        $this->app_data["data_detail"]      = $data_detail;
        $this->app_data["skill"]            = $skill;
        $this->app_data["education"]        = Modules::run("database/find", "tb_education", ["id" => $data_detail->id_last_education])->row();
        $this->app_data["gender"]           = Modules::run("database/find", "app_module_setting", ["params" => "gender", "value" => $data_detail->gender])->row();
        $this->app_data["religion"]         = Modules::run("database/find", "app_module_setting", ["params" => "religion", "value" => $data_detail->religion])->row();
        $this->app_data["province"]         = Modules::run("database/find", "provinces", ["id" => $data_detail->id_province])->row();
        $this->app_data["city"]             = Modules::run("database/find", "cities", ["id" => $data_detail->id_city])->row();
        $this->app_data["regency"]          = Modules::run("database/find", "regencies", ["id" => $data_detail->id_regency])->row();
        $this->app_data["village"]          = Modules::run("database/find", "villages", ["id" => $data_detail->id_village])->row();
        $this->app_data["province_current"] = Modules::run("database/find", "provinces", ["id" => $data_detail->id_province_current])->row();
        $this->app_data["city_current"]     = Modules::run("database/find", "cities", ["id" => $data_detail->id_city_current])->row();
        $this->app_data["regency_current"]  = Modules::run("database/find", "regencies", ["id" => $data_detail->id_regency_current])->row();
        $this->app_data["village_current"]  = Modules::run("database/find", "villages", ["id" => $data_detail->id_village_current])->row();
        $this->app_data['page_title']       = "Detail Member";
        $this->app_data["view_file"]        = "view_detail";
        echo Modules::run('template/main_layout', $this->app_data);
    }

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
        $image = ($image === '') ? 'default.png' : $image;

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

        foreach ($this->input->post("skill") as $skill) {
            $array_insert = [
                'id_skill' => $skill,
                'id_account' => $get_id_account->id
            ];
    
            Modules::run('database/insert', 'tb_account_has_skill', $array_insert);
        }

        $array_key = [
            'email' => $email
        ];

        $encrypt_key = $this->encrypt->encode(json_encode($array_key));

        Modules::run('emailing/confirm_email', $email, $encrypt_key, $username, $password);

        $redirect = Modules::run('helper/create_url', 'account');

        echo json_encode(["status" => true, "redirect" => $redirect]);
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
        ];

        // var_dump($array_update); return;

        $image = $this->upload_image();
        if ($image !== '') {
            $image = ["image" => $image];
            $array_update = array_merge($array_update, $image);
        }

        Modules::run("database/update", "tb_account", ["id" => $id], $array_update);

        Modules::run('database/delete', 'tb_account_has_skill', ['id_account' => $id]);

        foreach ($this->input->post("skill") as $skill) {
            $array_insert = [
                'id_skill' => $skill,
                'id_account' => $id
            ];
    
            Modules::run('database/insert', 'tb_account_has_skill', $array_insert);
        }

        $redirect = Modules::run('helper/create_url', 'account');

        echo json_encode(["status" => true, "redirect" => $redirect]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post("id"));

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
            return '';
        } else {
            $upload_data = $this->upload->data();
            $image_name = $upload_data['file_name'];
            return $image_name;
        }
    }
}
