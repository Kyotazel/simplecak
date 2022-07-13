<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends BackendController
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
            'from' => 'st_user',
            'where' => [
                'username' => $username,
                'is_delete' => 0,
                'status' => 1
            ],
            'or_where' => [
                'email' => $username
            ]
        ];

        $get_data_user = Modules::run('database/get', $array_query)->row();
        $hash_password = hash('sha512', $password . config_item('encryption_key'));

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
                Modules::run('database/update', 'st_user', ['id' => $get_data_user->id], ['token' => $token_id]);

                //create session
                $get_credential = Modules::run('database/find', 'app_credential', ['id' => $get_data_user->id_credential])->row();

                $array_query_credential_module = [
                    'select' => '
                        app_module.directory
                    ',
                    'from' => 'app_credential_access',
                    'join' => [
                        'app_module, app_credential_access.id_app_module = app_module.id, inner'
                    ],
                    'where' => [
                        'app_credential_access.id_credential' => $get_data_user->id_credential
                    ]
                ];
                $get_credential_module = Modules::run('database/get', $array_query_credential_module)->result();
                $array_app_module_access = [];
                foreach ($get_credential_module as $item_module) {
                    $array_app_module_access[] = strtolower($item_module->directory);
                }


                $session_data = [
                    'us_token_login'  => $token_id,
                    'us_credential'   => $get_data_user->id_credential,
                    'us_credetial_name' => isset($get_credential->name) ? $get_credential->name : '',
                    'us_credetial_module' => $array_app_module_access,
                    'us_credential_admin' => $get_data_user->is_admin,
                    'us_credential_menu' => isset($get_credential->id_app_menu) ? $get_credential->id_app_menu : '',
                    'us_credential_access' => ['create' => $get_data_user->access_create, 'update' => $get_data_user->access_update, 'delete' => $get_data_user->access_delete],
                    'us_id' => $get_data_user->id,
                    'us_name' => $get_data_user->name,
                    'us_email' => $get_data_user->email,
                    'last_check_admin' => time()
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
                        Username atau password salah!
                </div>
                ';
            $this->check_attempt();
            $status_login = FALSE;
        }
        echo json_encode(['status' => $status_login, 'token' => urlencode($token_id), 'attempt' => FALSE, 'error_login' => $html_respon, 'error_string' => [], 'inputerror' => []]);
    }

    private function check_attempt()
    {
        $limit_attempt = 4;

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
        Modules::run('security/token_validation');
        $token  = $this->input->get('token');
        $us_id  = $this->session->userdata('us_id');

        Modules::run('database/update', 'st_user', ['id' => $us_id], ['token' => '']);

        $session_data = [
            'us_token_login',
            'us_credential',
            'us_credetial_name',
            'us_credential_menu',
            'us_credential_access',
            'us_id',
            'us_name',
            'us_email',
            'last_check_admin'
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
            $check_data = Modules::run('database/find', 'st_user', ['email' => $email])->row();
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
        $check_data = Modules::run('database/find', 'st_user', ['email' => $email])->row();

        //update token
        $token      = time();
        Modules::run('database/update', 'st_user', ['id' => $check_data->id], ['forgot_password' => $token]);
        //send email
        $array_key = [
            'email' => $email,
            'token' => $token
        ];
        $encrypt_key = $this->encrypt->encode(json_encode($array_key));

        Modules::run('emailing/forgot_password', $email, $encrypt_key);

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

        $check_data = Modules::run('database/find', 'st_user', ['forgot_password' => $array_key['token']])->row();
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
        $hash_password = hash('sha512', $password . config_item('encryption_key'));

        $array_update = ['password' => $hash_password, 'forgot_password' => ''];
        Modules::run('database/update', 'st_user', ['id' => $id], $array_update);
        echo json_encode(['status' => TRUE]);
    }
}
