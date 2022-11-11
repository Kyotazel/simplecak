<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CommonController
{
    var $module_name        = 'login';
    var $module_directory   = 'login';
    var $module_js          = ['login'];
    var $app_data           = [];

    public function __construct()
    {
        parent::__construct();
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

        Modules::run('security/is_logged');
        $this->app_data['page_title'] = "Login";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/login_layout', $this->app_data);
    }

    public function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('username') == '') {
            $data['error_string'][] = 'harus diisi';
            $data['inputerror'][] = 'username';
            $data['status'] = FALSE;
        }
        if ($this->input->post('password') == '') {
            $data['error_string'][] = 'harus diisi';
            $data['inputerror'][] = 'password';
            $data['status'] = FALSE;
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
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
                'status' => 1,
            ],
        ];

        $get_data_user          = Modules::run('database/get', $array_query)->row();
        $hash_password          = hash('sha256', $password . config_item('encription_key'));

        // echo json_encode($hash_password); return;

        $status_login = TRUE;
        $html_respon = '';
        $token_id = '';
        if (!empty($get_data_user)) {
            //super admin
            if ($get_data_user->password == $hash_password) {
                //clear attempts
                $this->clear_attempt();

                // create token
                $token_id = time();
                Modules::run('database/update', 'tb_account', ['id' => $get_data_user->id], ['token' => $token_id]);

                //create session
                $get_group_menu = Modules::run('database/find', 'app_menu', ['is_member_menu' => 1])->row();
                $session_data = [
                    'member_data' => $get_data_user,
                    'member_credential_menu' => !empty($get_group_menu) ? $get_group_menu->id : 0,
                    'member_token_login'  => $token_id,
                    'member_id' => $get_data_user->id,
                    'member_image' => $get_data_user->image,
                    'member_name' => $get_data_user->name,
                    'member_email' => $get_data_user->email,
                    'member_last_check_admin' => time()
                ];
                $this->session->set_userdata($session_data);
                $status_login = TRUE;
                $token_id = $this->encrypt->encode($token_id);
            } else {
                //check temp
                $html_respon = '
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Login Gagal, Username atau password salah!
                    </div>
                ';
                $this->check_attempt();
                $status_login = FALSE;
            }
        } else {
            $html_respon = '
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Username tidak ditemukan
                </div>
                ';
            $this->check_attempt();
            $status_login = FALSE;
        }
        echo json_encode(['status' => $status_login, 'token' => urlencode($token_id), 'attempt' => FALSE, 'error_login' => $html_respon, 'error_string' => [], 'inputerror' => []]);
    }

    private function check_attempt()
    {
        $limit_attempt = 10;

        $ip_address = $this->input->ip_address();
        $check_attemp = Modules::run('database/find', 'st_log_login', ['ip_address' => $ip_address])->num_rows();
        if ($check_attemp >= $limit_attempt) {
            echo json_encode(['status' => FALSE, 'status_forgot_password' => TRUE]);
            die;
        } else {
            //insert data to attempt
            $array_insert = [
                'ip_address' => $ip_address
            ];
            Modules::run('database/insert', 'st_log_login', $array_insert);
            $this->session->set_flashdata('error_login', 'Username & password salah');
        }
    }

    private function clear_attempt()
    {
        $username = $this->input->post('username');
        $ip_address = $this->input->ip_address();
        Modules::run('database/delete', 'st_log_login', ['ip_address' => $ip_address]);
    }

    public function logout()
    {
        Modules::run('security/login_validation');
        // Modules::run('security/token_validation');
        $token  = $this->input->get('token');
        $us_id  = $this->session->userdata('member_id');

        Modules::run('database/update', 'tb_account', ['id' => $us_id], ['token' => '']);

        $session_data = [
            'member_token_login',
            'member_credential',
            'member_credetial_name',
            'member_credential_menu',
            'member_credential_access',
            'member_id',
            'member_image',
            'member_name',
            'member_email',
            'member_last_check_admin'
        ];

        //update data log 
        // Modules::run('database/update', 'log_admin', ['id' => $id_log], $array_update_log);
        $this->session->unset_userdata($session_data);
        redirect(Modules::run('helper/create_url', 'login'));
    }

    public function forgot_password()
    {
        $this->app_data['page_title'] = "Forget Password";
        $this->app_data['view_file'] = 'view_forgot_password';
        echo Modules::run('template/login_layout', $this->app_data);
    }


    public function _validate_send_email()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('email') == '') {
            $data['error_string'][] = 'harus diisi';
            $data['inputerror'][] = 'email';
            $data['status'] = FALSE;
        } else {
            $email = $this->input->post('email');
            $check_data = Modules::run('database/find', 'tb_account', ['email' => $email])->row();
            if (empty($check_data)) {
                $data['error_string'][] = 'email tidak terdaftar';
                $data['inputerror'][] = 'email';
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function send_email()
    {
        Modules::run('security/is_ajax');
        $this->_validate_send_email();
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

        $html_respon = '
            <div class="col-12 text-center">
                <div class="plan-card text-center">
                    <i class="fas fa-envelope plan-icon text-primary"></i>
                    <h6 class="text-drak text-uppercase mt-2">silahkan verifikasi link yang kami kirim ke email anda untuk reset password.</h6>
                </div>
            </div>
        ';
        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon]);
    }

    public function reset_password()
    {
        $key = $this->encrypt->decode($this->input->get('key'));
        $array_key = json_decode($key, TRUE);

        $check_data = Modules::run('database/find', 'tb_account', ['forgot_password' => $array_key['token']])->row();
        if (empty($check_data)) { //expired on 30 minute
            redirect(Modules::run('helper/create_url', 'login'));
        }

        $diff = time() - $array_key['token'];
        $diff = floor($diff / (60));
        if ($diff > 30) { //expired on 30 minute
            redirect(Modules::run('helper/create_url', 'login'));
        }
        $this->app_data['data_user'] = $check_data;
        $this->app_data['page_title'] = "Reset Password";
        $this->app_data['view_file'] = 'view_reset_password';
        echo Modules::run('template/login_layout', $this->app_data);
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

    public function do_reset_password()
    {
        Modules::run('security/is_ajax');
        $this->_validate_do_reset_password();
        $password = $this->input->post('password');
        $id = $this->encrypt->decode($this->input->post('id'));
        $hash_password = hash('sha256', $password . config_item('encription_key'));

        $array_update = ['password' => $hash_password, 'forgot_password' => ''];
        Modules::run('database/update', 'tb_account', ['id' => $id], $array_update);
        echo json_encode(['status' => TRUE]);
    }

    public function update_image()
    {
        Modules::run('security/is_ajax');
        if (isset($_FILES['upload_background']) && !empty($_FILES['upload_background']['name'])) {
            $image_name = $this->upload_image('upload_background');
            $array_update = ['value' => $image_name];
            Modules::run('database/update', 'app_setting', ['field' => 'member_login_background'], $array_update);
        }

        if (isset($_FILES['upload_image']) && !empty($_FILES['upload_image']['name'])) {
            $image_name = $this->upload_image('upload_image');
            $array_update = ['value' => $image_name];
            Modules::run('database/update', 'app_setting', ['field' => 'member_login_image'], $array_update);
        }

        echo json_encode(['status' => true]);
    }

    private function upload_image($name)
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/banner');
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($name)) //upload and validate
        {
            $data['inputerror'][] = 'media';
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

    public function delete_image()
    {
        Modules::run('security/is_ajax');
        $type = $this->input->post('type');
        if ($type == 'background') {
            $get_image = Modules::run('database/find', 'app_setting', ['field' => 'member_login_background'])->row()->value;
            $dir = realpath(APPPATH . '../upload/banner');
            if (file_exists($dir . '/' . $get_image)) {
                unlink($dir . '/' . $get_image);
            }

            Modules::run('database/update', 'app_setting', ['field' => 'member_login_background'], ['value' => '']);
        }
        if ($type == 'image') {
            $get_image = Modules::run('database/find', 'app_setting', ['field' => 'member_login_image'])->row()->value;
            $dir = realpath(APPPATH . '../upload/banner');
            if (file_exists($dir . '/' . $get_image)) {
                unlink($dir . '/' . $get_image);
            }
            Modules::run('database/update', 'app_setting', ['field' => 'member_login_image'], ['value' => '']);
        }
        echo json_encode(['status' => true]);
    }

    public function register()
    {
        $this->app_data['page_title'] = "Tambah Member";
        $this->app_data['view_file']  = 'register';
        $this->app_data["method"]  = 'add';
        echo Modules::run('template/login_layout', $this->app_data);
    }

    public function validate_register()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');

        $email = Modules::run('database/find', 'tb_account', ['email' => $this->input->post('email')])->row();

        if ($this->input->post('email') == '') {
            $data['error_string'][] = 'Email Harus Diisi';
            $data['inputerror'][] = 'email';
            $data['status'] = FALSE;
        }
        if (!empty($email)) {
            $data['error_string'][] = 'Email Sudah Terdaftar';
            $data['inputerror'][] = 'email';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function do_register()
    {
        $this->validate_register();
        $email                  = $this->input->post('email');
        $registration_date      = date("Y-m-d");
        $username               = $email;
        $password               = bin2hex(random_bytes(8));
        $hash_password          = hash('sha256', $password . config_item('encription_key'));
        $status                 = 0;
        $is_confirm             = 0;

        $array_insert = [
            'email' => $email,
            'registration_date' => $registration_date,
            'username' => $username,
            'password' => $hash_password,
            'status' => $status,
            'is_confirm' => $is_confirm,
        ];

        Modules::run("database/insert", "tb_account", $array_insert);

        $array_key = [
            'email' => $email
        ];

        $encrypt_key = $this->encrypt->encode(json_encode($array_key));

        Modules::run('emailing/confirm_email', $email, $encrypt_key, $username, $password);

        // var_dump($tes); return;

        echo json_encode(["status" => true]);
    }

    public function confirm_email() {
        $this->app_data['module_js']  = ["confirm"];
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
        $this->app_data['view_file'] = 'view_confirm';
        echo Modules::run('template/login_layout', $this->app_data);
    }

}
