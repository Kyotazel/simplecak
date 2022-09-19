<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_profile extends CommonController
{
    var $module_name = 'app_profile';
    var $module_directory = 'app_profile';
    var $module_js = ['app_profile'];
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

    public function index()
    {
        $id = $this->session->userdata('member_id');

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

        $this->app_data['page_title'] = "Profile";
        $this->app_data['view_file']  = 'view_profile';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function update_profile()
    {
        $id = $this->session->userdata('member_id');
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
        $detail = Modules::run('database/find', 'tb_account', ['id' => $id])->row();

        $this->app_data['data_detail']      = $detail;
        $this->app_data['detail_skill']     = $data;
        $this->app_data['get_skill']        = Modules::run('database/get_all', 'tb_skill')->result();
        $this->app_data["provinsi"]         = Modules::run("database/get_all", "provinces")->result();
        $this->app_data["kota"]             = Modules::run("database/get_all", "cities")->result();
        $this->app_data["kecamatan"]        = Modules::run("database/find", "regencies", ["id" => $detail->id_regency])->result();
        $this->app_data["desa"]             = Modules::run("database/find", "villages", ["id" => $detail->id_village])->result();
        $this->app_data["last_education"]   = Modules::run("database/get_all", "tb_education")->result();
        $this->app_data["skill"]            = Modules::run("database/get_all", "tb_skill")->result();
        $this->app_data["religion"]         = Modules::run("database/find", "app_module_setting", ["params" => "religion"])->result();
        $this->app_data["gender"]           = Modules::run("database/find", "app_module_setting", ["params" => "gender"])->result();
        $this->app_data["married"]          = Modules::run("database/find", "app_module_setting", ["params" => "married"])->result();
        $this->app_data['page_title']       = "Update Profile";
        $this->app_data['view_file']        = 'form_add';
        $this->app_data["method"]           = 'update';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function reset_password()
    {
        $id = $this->session->userdata('member_id');

        $this->app_data['page_title']       = "Update Password";
        $this->app_data['view_file']        = 'update_password';
        echo Modules::run('template/horizontal_layout', $this->app_data);

    }

    public function validate_update_password()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->session->userdata('member_id');
        $get_data = Modules::run('database/find', 'tb_account', ['id' => $id])->row();

        if ($this->input->post('old_password') == '') {
            $data['error_string'][] = 'Password Lama Harus Diisi';
            $data['inputerror'][] = 'old_password';
            $data['status'] = FALSE;
        }
        if ($this->input->post('new_password') == '') {
            $data['error_string'][] = 'Password Baru Harus Diisi';
            $data['inputerror'][] = 'new_password';
            $data['status'] = FALSE;
        }
        if ($this->input->post('confirm_password') == '') {
            $data['error_string'][] = 'Konfirmasi Password Harus Diisi';
            $data['inputerror'][] = 'confirm_password';
            $data['status'] = FALSE;
        }
        if (strlen($this->input->post('new_password')) < 6) {
            $data['error_string'][] = 'Password Minimal 6 Karakter';
            $data['inputerror'][] = 'new_password';
            $data['status'] = FALSE;
        }
        if ($this->input->post('confirm_password') != $this->input->post('new_password')) {
            $data['error_string'][] = 'Konfirmasi Password Tidak Sama';
            $data['inputerror'][] = 'confirm_password';
            $data['status'] = FALSE;
        }
        if(hash('sha256', $this->input->post('old_password') . config_item('encription_key')) !== $get_data->password)
        {
            $data['error_string'][] = 'Password Tidak Sesuai';
            $data['inputerror'][] = 'old_password';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function update_password()
    {
        $id = $this->session->userdata('member_id');
        $this->validate_update_password();
        $new_password = $this->input->post('new_password');
        $hash_password = hash('sha256', $new_password . config_item('encription_key'));

        $array_update_password = [
            "password" => $hash_password
        ];

        Modules::run('database/update', 'tb_account', ['id' => $id], $array_update_password);

        $redirect = Modules::run('helper/create_url', 'account');

        echo json_encode(["status" => true, "redirect" => $redirect]);
    }

    public function update_image()
    {
        Modules::run('security/is_ajax');
        $id = $this->session->userdata('member_id');
        $image_data = $this->upload_image();
        //update image
        if (!empty($_FILES['upload_profile']['name'])) {
            $array_update = ['image' => $image_data];
            Modules::run('database/update', 'tb_account', ['id' => $id], $array_update);

            $this->session->set_userdata('member_image', $image_data);
        }
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
            return '';
        } else {
            $upload_data = $this->upload->data();
            $image_name = $upload_data['file_name'];
            return $image_name;
        }
    }

    public function update() {
        $id                     = $this->session->userdata('member_id');
        $no_ktp                 = $this->input->post('no_ktp');
        $no_kk                  = $this->input->post('no_kk');
        $name                   = $this->input->post('name');
        $id_last_education      = $this->input->post('id_last_education');
        $last_school            = $this->input->post('last_school');
        $email                  = $this->input->post('email');
        $phone_number           = $this->input->post('phone_number');
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

        if(strpos(substr($phone_number,0,3), '08') !== false){
        	$awal = str_replace("08", "628", substr($phone_number,0,3));
        	$phone_number = $awal. substr($phone_number,3);
        }

        $array_update = [
            'no_ktp' => $no_ktp,
            'no_kk' => $no_kk,
            'name' => $name,
            'id_last_education' => $id_last_education,
            'last_school' => $last_school,
            'email' => $email,
            'phone_number' => $phone_number,
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
            'updated_date' => date('Y-m-d h:i:sa'),
            'updated_by' => $this->session->userdata('us_id')
        ];

        // var_dump($array_update); return;

        $image = $this->upload_image();
        if ($image !== '') {
            $image = ["image" => $image];
            $array_update = array_merge($array_update, $image);
        }

        Modules::run("database/update", "tb_account", ["id" => $id], $array_update);

        Modules::run('database/delete', 'tb_account_has_skill', ['id_account' => $id]);

        if($this->input->post("skill") !== NULL) {
            foreach ($this->input->post("skill") as $skill) {
                $array_insert = [
                    'id_skill' => $skill,
                    'id_account' => $id,
                    'created_by' => $this->session->userdata('us_id')
                ];
        
                Modules::run('database/insert', 'tb_account_has_skill', $array_insert);
            }
        }

        $redirect = Modules::run('helper/create_url', 'account');

        echo json_encode(["status" => true, "redirect" => $redirect]);
    }

}
