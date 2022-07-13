<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_profile extends BackendController
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
        $id = $this->session->userdata('us_id');
        $array_query = [
            'select' => '
                st_user.*,
                app_credential.name AS credential_name
            ',
            'from' => 'st_user',
            'join' => [
                'app_credential, st_user.id_credential = app_credential.id, left'
            ],
            'where' => ['st_user.id' => $id]
        ];
        $get_data_user = Modules::run('database/get', $array_query)->row();
        $this->app_data['data_user']  = $get_data_user;
        $this->app_data['all_credential']   = Modules::run('database/get_all', 'app_credential')->result();

        $this->app_data['page_title'] = "Profile";
        $this->app_data['view_file']  = 'view_profile';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    private function validate_update_profile()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->input->post('name') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'name';
            $data['status'] = FALSE;
        } else {
            if (strlen($this->input->post('name')) < 5) {
                $data['error_string'][] = 'min 5 karakter';
                $data['inputerror'][] = 'name';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('email') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'email';
            $data['status'] = FALSE;
        } else {
            $email = $this->input->post('email');
            $get_data = Modules::run('database/find', 'st_user', ['email' => $email])->row();
            if (!empty($get_data) && $get_data->id != $id) {
                $data['error_string'][] = 'email sudah digunakan';
                $data['inputerror'][] = 'email';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('phone_number') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'phone_number';
            $data['status'] = FALSE;
        } else {
            if (strlen($this->input->post('name')) < 10 && strlen($this->input->post('name')) > 13) {
                $data['error_string'][] = 'format no.telp salah';
                $data['inputerror'][] = 'phone_number';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('address') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'address';
            $data['status'] = FALSE;
        }


        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }
    public function update_profile()
    {
        Modules::run('security/is_ajax');
        $this->validate_update_profile();
        $id = $this->input->post('id');
        $name     = $this->input->post('name');
        $email    = $this->input->post('email');
        $phone_number   = $this->input->post('phone_number');
        $address   = $this->input->post('address');

        $array_update = [
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number,
            'address' => $address,
        ];
        Modules::run('database/update', 'st_user', ['id' => $id], $array_update);
        $this->session->set_flashdata('success_message', '<strong>Sukses </strong>, data berhasil disimpan!');
        echo json_encode(['status' => true]);
    }

    private function validate_update_login()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');

        if ($this->input->post('username') != '') {
            $username = $this->input->post('username');
            $get_data = Modules::run('database/find', 'st_user', ['username' => $username])->row();
            if (!empty($get_data) && $get_data->id != $id) {
                $data['error_string'][] = 'username sudah digunakan';
                $data['inputerror'][] = 'username';
                $data['status'] = FALSE;
            }
        }

        // if ($this->input->post('credential') == '') {
        //     $data['error_string'][] = 'Harus Diisi';
        //     $data['inputerror'][] = 'credential';
        //     $data['status'] = FALSE;
        // }
        if ($this->input->post('password') != '') {
            if (strlen($this->input->post('password')) < 5) {
                $data['error_string'][] = 'min 5 karakter';
                $data['inputerror'][] = 'password';
                $data['status'] = FALSE;
            }

            if ($this->input->post('re_password') == '') {
                $data['error_string'][] = 'Harus Diisi';
                $data['inputerror'][] = 're_password';
                $data['status'] = FALSE;
            }
            if ($this->input->post('re_password') != '' && $this->input->post('password') != '') {
                if ($this->input->post('re_password') != $this->input->post('password')) {
                    $data['error_string'][] = 'password tidak sama';
                    $data['inputerror'][] = 're_password';
                    $data['status'] = FALSE;
                }
            }
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function update_login()
    {
        Modules::run('security/is_ajax');
        $this->validate_update_login();

        $id = $this->input->post('id');
        $credential   = $this->input->post('credential');
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');
        $hash_password = hash('sha512', $password . config_item('encryption_key'));

        $array_update = [];
        if (!empty($credential)) {
            $array_update['id_credential'] = $credential;
        }
        if (!empty($password)) {
            $array_update['password'] = $hash_password;
        }
        if (!empty($username)) {
            $array_update['username'] = $username;
        }

        Modules::run('database/update', 'st_user', ['id' => $id], $array_update);
        $this->session->set_flashdata('success_message', '<strong>Sukses </strong>, data berhasil disimpan!');
        echo json_encode(['status' => true]);
    }

    public function update_image()
    {
        Modules::run('security/is_ajax');
        $id = $this->session->userdata('us_id');
        $image_data = $this->upload_image();
        //update image
        if (!empty($_FILES['upload_profile']['name'])) {
            $array_update = ['image' => $image_data];
            Modules::run('database/update', 'st_user', ['id' => $id], $array_update);

            $this->session->set_userdata('us_image', $image_data);
        }
        echo json_encode(['status' => TRUE]);
    }

    private function upload_image()
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/user');
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('upload_profile')) //upload and validate
        {
            $data['inputerror'][] = 'upload_banner';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        } else {
            $upload_data = $this->upload->data();
            $image_name = $upload_data['file_name'];
            return $image_name;
        }
    }

    // public function delete_data()
    // {
    //     Modules::run('security/is_ajax');
    //     $id = $this->encrypt->decode($this->input->post('id'));
    //     $array_update = ['is_delete' => 1];
    //     Modules::run('database/update', 'st_user', ['id' => $id], $array_update);
    //     echo json_encode(['status' => true]);
    // }

    // public function update_status()
    // {
    //     Modules::run('security/is_ajax');
    //     $id       = $this->input->post('id');
    //     $status   = $this->input->post('status');
    //     $field    = $this->input->post('field');

    //     if ($field == 'status') {
    //         $array_update = ['status' => $status];
    //     }
    //     if ($field == 'create') {
    //         $array_update = ['access_create' => $status];
    //     }
    //     if ($field == 'update') {
    //         $array_update = ['access_update' => $status];
    //     }
    //     if ($field == 'delete') {
    //         $array_update = ['access_delete' => $status];
    //     }
    //     Modules::run('database/update', 'st_user', ['id' => $id], $array_update);
    //     echo json_encode(['status' => true]);
    // }

    // public function profile()
    // {
    //     $id = $this->session->userdata('us_id');
    //     $array_query = [
    //         'select' => '
    //             st_user.*,
    //             app_credential.name AS credential_name
    //         ',
    //         'from' => 'st_user',
    //         'join' => [
    //             'app_credential, st_user.id_credential = app_credential.id, left'
    //         ],
    //         'where' => ['st_user.id' => $id]
    //     ];
    //     $get_data_user = Modules::run('database/get', $array_query)->row();
    //     $this->app_data['data_user']  = $get_data_user;
    //     $this->app_data['all_credential']   = Modules::run('database/get_all', 'app_credential')->result();

    //     $this->app_data['page_title'] = "Profile";
    //     $this->app_data['view_file']  = 'view_profile';
    //     echo Modules::run('template/main_layout', $this->app_data);
    // }
}
