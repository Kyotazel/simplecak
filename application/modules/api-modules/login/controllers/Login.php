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
        $id_province        = $this->input->post('province_id');
        $id_city            = $this->input->post('city_id');
        $id_regency         = $this->input->post('regency_id');
        $id_village         = $this->input->post('village_id');
        $address            = $this->input->post('address');
        $id_province_current        = $this->input->post('province_id');
        $id_city_current            = $this->input->post('city_id');
        $id_regency_current         = $this->input->post('regency_id');
        $id_village_current         = $this->input->post('village_id');
        $address_current            = $this->input->post('address');
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
            'image' => $image
        ];

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
        // $this->_validate_forgot_password();
        $email = $this->input->post('email');
        $check_data = Modules::run('database/find', 'tb_account', ['email' => $email])->row();

        //update token
        $token      = time();
        Modules::run('database/update', 'tb_account', ['id' => $check_data->id], ['forgot_password' => $token]);
        //send email
        Modules::run('emailing/forgot_password_android', $email, $token);

        $response = [
            "error" => FALSE,
            "msg"   => [
                "Periksa email untuk konfirmasi reset password"
            ]
        ];
        echo json_encode($response);
    }

    public function check_token_password()
    {
        $token = $this->input->post('token');
        $email = $this->input->post('email');

        $get_data = Modules::run('database/find', 'tb_account', ['email' => $email])->row();

        if($get_data->forgot_password == $token) {
            echo json_encode([
                "error" => false,
                "msg" => "Token Sesuai"
            ]);
        } else {
            echo json_encode([
                "error" => true,
                "msg" => "Token tidak sesuai"
            ]);
        }
    }

    public function update_forgot_password()
    {
        $token = $this->input->post('token');
        $email = $this->input->post('email');
        $new_password = $this->input->post('password');
        $hash_password = hash('sha256', $new_password . config_item('encription_key'));

        Modules::run('database/update', 'tb_account', ['forgot_password' => $token, 'email' => $email], ['forgot_password' => null, "password" => $hash_password]);
        
        echo json_encode([
            "error" => false,
            "msg" => "Password berhasil diupdate"
        ]);
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

    public function logout()
    {
        $id  = $this->input->post('id');

        $data = Modules::run('database/find', 'tb_account', ['id' => $id])->row();
        Modules::run('database/update', 'tb_account', ['id' => $id], ['token' => '']);
        if ($data) {
            $response = [
                "error" => FALSE,
                "msg"   => [
                    "Logout Berhasil"
                ]
            ];
        } else {
            $response = [
                "error" => TRUE,
                "msg"   => [
                    "user tidak ditemukan"
                ]
            ];
        }
        echo json_encode($response);
    }
}
