<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends ApiController
{
    public function validate_register()
    {
        $response = array();
        $response['error'] = FALSE;
        $response['msg'] = array();
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');

        $email = Modules::run('database/find', 'tb_account', ['email' => $this->input->post('email')])->row();
        if ($this->input->post('email') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Email Harus Diisi';
        }
        if ($this->input->post('nik') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'NIK Harus Diisi';
        }
        if ($this->input->post('no_kk') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'No KK Harus Diisi';
        }
        if ($this->input->post('name') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Nama Harus Diisi';
        }
        if ($this->input->post('birth_place') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Tempat Lahir Harus Diisi';
        }
        if ($this->input->post('birth_date') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Tanggal Lahir Harus Diisi';
        }
        if ($this->input->post('gender') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Jenis Kelamin Harus Diisi';
        }
        if ($this->input->post('religion') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Agama Harus Diisi';
        }
        if ($this->input->post('married_status') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Status Pernikahan Harus Diisi';
        }
        if ($this->input->post('id_last_education') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Pendidikan Terakhir Harus Diisi';
        }
        if ($this->input->post('last_school') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Sekolah Terakhir Harus Diisi';
        }
        if ($this->input->post('province_id') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Provinsi Asal Harus Diisi';
        }
        if ($this->input->post('city_id') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Kota Asal Harus Diisi';
        }
        if ($this->input->post('regency_id') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Kecamatan Asal Harus Diisi';
        }
        if ($this->input->post('village_id') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Desa Asal Harus Diisi';
        }
        if ($this->input->post('address') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Alamat Asal Harus Diisi';
        }
        if ($this->input->post('province_id_current') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Provinsi Sekarang Harus Diisi';
        }
        if ($this->input->post('city_id_current') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Kota Sekarang Harus Diisi';
        }
        if ($this->input->post('regency_id_current') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Kecamatan Sekarang Harus Diisi';
        }
        if ($this->input->post('village_id_current') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Desa Sekarang Harus Diisi';
        }
        if ($this->input->post('address_current') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Alamat Sekarang Harus Diisi';
        }
        if ($this->input->post('password') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Kata Sandi Harus Diisi';
        }
        if (!empty($email)) {
            $response['error'] = TRUE;
            $response['msg'][] = 'Email Sudah Terdaftar';
        }
        
        
        if ($response['error'] == TRUE) {
            echo json_encode($response);
            exit();
        }
    }

    public function do_register()
    {
        $this->validate_register();
        $nik                = $this->input->post('nik');
        $no_kk              = $this->input->post('no_kk');
        $name               = $this->input->post('name');
        $birth_place        = $this->input->post('birth_place');
        $birth_date         = $this->input->post('birth_date');
        $gender             = $this->input->post('gender');
        $religion           = $this->input->post('religion');
        $married_status     = $this->input->post('married_status');
        $id_last_education  = $this->input->post('id_last_education');
        $last_school        = $this->input->post('last_school');
        $id_province        = $this->input->post('id_province');
        $id_city            = $this->input->post('id_city');
        $id_regency         = $this->input->post('id_regency');
        $id_village         = $this->input->post('id_village');
        $address            = $this->input->post('address');
        $id_province_current        = $this->input->post('id_province_current');
        $id_city_current            = $this->input->post('id_city_current');
        $id_regency_current         = $this->input->post('id_regency_current');
        $id_village_current         = $this->input->post('id_village_current');
        $address_current            = $this->input->post('address_current');
        $email              = $this->input->post('email');
        $registration_date  = date("Y-m-d");
        $username           = $email;
        $password           = $this->input->post('password');
        $hash_password      = hash('sha256', $password . config_item('encription_key'));
        $status             = 0;
        $is_confirm         = 0;

        $image = $this->upload_image();
        
        $array_insert = [
            'no_ktp' =>  $nik,
            'no_kk' =>  $no_kk,
            'name' =>  $name,
            'birth_place' =>  $birth_place,
            'birth_date' =>  $birth_date,
            'gender' =>  $gender,
            'religion' =>  $religion,
            'married_status' =>  $married_status,
            'id_last_education' =>  $id_last_education,
            'last_school' =>  $last_school,
            'id_province' =>  $id_province,
            'id_city' =>  $id_city,
            'id_regency' =>  $id_regency,
            'id_village' =>  $id_village,
            'address' =>  $address,
            'id_province_current' =>  $id_province_current,
            'id_city_current' =>  $id_city_current,
            'id_regency_current' =>  $id_regency_current,
            'id_village_current' =>  $id_village_current,
            'address_current' =>  $address_current,
            'email' => $email,
            'registration_date' => $registration_date,
            'username' => $username,
            'password' => $hash_password,
            'status' => $status,
            'is_confirm' => $is_confirm,
        ];

        if ($image !== '') {
            $image = ["image" => $image];
            $array_insert = array_merge($array_insert, $image);
        }

        Modules::run("database/insert", "tb_account", $array_insert);

        $array_key = [
            'email' => $email
        ];

        $encrypt_key = $this->encrypt->encode(json_encode($array_key));

        Modules::run('emailing/confirm_email', $email, $encrypt_key, $username, $password);

        $response = [
            "error" => FALSE,
            "msg"   => [
                "Email Berhasil didaftarkan"
            ]
        ];

        echo json_encode($response);
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

    public function _validate()
    {
        $response = array();
        $response['error'] = FALSE;
        $response['msg'] = array();
        if ($this->input->post('username') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Username harus diisi';
        }
        if ($this->input->post('password') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Password harus diisi';
        }

        if ($response['error'] == TRUE) {
            echo json_encode($response);
            exit();
        }
    }

    public function do_login()
    {
        $this->_validate();
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $array_query = [
            'select' => '*',
            'from' => 'tb_account',
            'where' => [
                'username' => $username,
            ],
        ];

        $get_data_user          = Modules::run('database/get', $array_query)->row();
        $hash_password          = hash('sha256', $password . config_item('encription_key'));

        $response = [];
        if (!empty($get_data_user)) {
            if ($get_data_user->status == 1) {
                if ($get_data_user->password == $hash_password) {
                    $token_id = time();
                    Modules::run('database/update', 'tb_account', ['id' => $get_data_user->id], ['token' => $token_id]);
                    $response = [
                        "error" => FALSE,
                        "data"  => $get_data_user
                    ];
                } else {
                    $response = [
                        "error" => TRUE,
                        "msg"   => [
                            "Password anda salah"
                        ]
                    ];
                }
            } else {
                $response = [
                    "error" => TRUE,
                    "msg"   => [
                        "Akun anda terkonfirmasi tidak aktif"
                    ]
                ];
            }
        } else {
            $response = [
                "error" => TRUE,
                "msg"   => [
                    "Email / Username tidak ditemukan"
                ]
            ];
        }

        echo json_encode($response);
    }

    public function _validate_forgot_password()
    {
        $response = array();
        $response['error'] = FALSE;
        $response['msg'] = array();

        if ($this->input->post('email') == '') {
            $response['error'] = TRUE;
            $response['msg'][] = 'Email harus diisi';
        } else {
            $email = $this->input->post('email');
            $check_data = Modules::run('database/find', 'tb_account', ['email' => $email])->row();
            if (empty($check_data)) {
                $response['error'] = TRUE;
                $response['msg'][] = 'email tidak terdaftar';
            }
        }

        if ($response['error'] == TRUE) {
            echo json_encode($response);
            exit();
        }
    }

    public function forgot_password()
    {
        $this->_validate_forgot_password();
        $email = $this->input->post('email');
        $check_data = Modules::run('database/find', 'tb_account', ['email' => $email])->row();

        //update token
        $token      = time();
        Modules::run('database/update', 'tb_account', ['id' => $check_data->id], ['forgot_password' => $token]);
        //send email
        $array_key = [
            'email' => $email,
            'token' => $token
        ];
        $encrypt_key = $this->encrypt->encode(json_encode($array_key));

        Modules::run('emailing/forgot_password', $email, $encrypt_key, "member-area");

        $response = [
            "error" => FALSE,
            "msg"   => [
                "Periksa email untuk konfirmasi reset password"
            ]
        ];
        echo json_encode($response);
    }

    public function validate_update_password()
    {
        $data = array();
        $data['error'] = FALSE;
        $data['msg'] = array();
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        $get_data = Modules::run('database/find', 'tb_account', ['id' => $id])->row();

        if ($this->input->post('old_password') == '') {
            $data['error'] = TRUE;
            $data['msg'][] = 'Password Lama Harus Diisi';
        }
        if ($this->input->post('new_password') == '') {
            $data['error'] = TRUE;
            $data['msg'][] = 'Password Baru Harus Diisi';
        }
        if ($this->input->post('confirm_password') == '') {
            $data['error'] = TRUE;
            $data['msg'][] = 'Konfirmasi Password Harus Diisi';
        }
        if (strlen($this->input->post('new_password')) < 6) {
            $data['error'] = TRUE;
            $data['msg'][] = 'Password Minimal 6 Karakter';
        }
        if ($this->input->post('confirm_password') != $this->input->post('new_password')) {
            $data['error'] = TRUE;
            $data['msg'][] = 'Konfirmasi Password Tidak Sama';
        }
        if (hash('sha256', $this->input->post('old_password') . config_item('encription_key')) !== $get_data->password) {
            $data['error'] = TRUE;
            $data['msg'][] = 'Password Tidak Sesuai';
        }
        if ($data['error'] == TRUE) {
            echo json_encode($data);
            exit();
        }
    }

    public function update_password()
    {
        $this->validate_update_password();
        $id = $this->input->post('id');
        $new_password = $this->input->post('new_password');
        $hash_password = hash('sha256', $new_password . config_item('encription_key'));

        $array_update_password = [
            "password" => $hash_password
        ];

        Modules::run('database/update', 'tb_account', ['id' => $id], $array_update_password);

        $response = [
            "error" => FALSE,
            "msg"   => [
                "Password Berhasil Diubah"
            ]
        ];

        echo json_encode($response);
    }
}
