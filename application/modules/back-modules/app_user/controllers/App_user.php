<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_user extends BackendController
{
    var $module_name = 'app_user';
    var $module_directory = 'app_user';
    var $module_js = ['app_user'];
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
        $query_credential = [
            'select' => '
                app_credential.*,   
                app_menu.name AS app_menu_name
            ',
            'from' => 'app_credential',
            'join' => [
                'app_menu, app_credential.id_app_menu = app_menu.id, left'
            ],
            'order_by' => 'id, DESC'
        ];
        $this->app_data['all_credential'] = Modules::run('database/get', $query_credential)->result();

        $this->app_data['all_menu']     = Modules::run('database/find', 'app_menu', ['type' => 1, 'status' => 1])->result();
        $this->app_data['page_title']   = "app user";
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run('security/is_ajax');
        $type = $this->input->post('type');
        $array_module_type = Modules::run('helper/get_module_type');
        $array_query = [
            'select' => '
                st_user.*,
                app_credential.name AS credential_name
            ',
            'from' => 'st_user',
            'where' => ['is_delete' => 0, 'is_admin' => 0],
            'join' => [
                'app_credential, st_user.id_credential = app_credential.id, left'
            ],
            'order_by' => 'id, DESC'
        ];

        $get_data = Modules::run('database/get', $array_query)->result();
        $no = 0;
        $data = [];
        foreach ($get_data as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);
            $btn_delete     = Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="dropdown-item btn_delete"><i class="fa fa-trash"></i> Hapus</a>');

            $active = $data_table->status ? 'on' : '';
            $active_create = $data_table->access_create ? 'on' : '';
            $active_update = $data_table->access_update ? 'on' : '';
            $active_delete = $data_table->access_delete ? 'on' : '';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '
                    <h5 class="mb-0 text-capitalize">' . $data_table->name . '</h5>
                    <small class="text-muted"><i class="fa fa-map-marker"></i> Alamat :</small>
                    <small>' . $data_table->address . '</small>
            ';
            $row[] = ' <i class="fa fa-envelope"></i> ' . $data_table->email . '<br> <i class="fa fa-phone"></i> ' . $data_table->phone_number;
            $row[] = '<h5 class="text-info"><span class="badge badge-dark text-uppercase">' . $data_table->credential_name . '</span></h5>';
            $row[] = '<div data-status="status" data-id="' . $data_table->id . '" class="main-toggle main-toggle-dark change_status ' . $active . '"><span></span></div>';
            $row[] = '<div data-status="create" data-id="' . $data_table->id . '" class="main-toggle main-toggle-dark change_status ' . $active_create . '"><span></span></div>';
            $row[] = '<div data-status="update" data-id="' . $data_table->id . '" class="main-toggle main-toggle-dark change_status ' . $active_update . '"><span></span></div>';
            $row[] = '<div data-status="delete" data-id="' . $data_table->id . '" class="main-toggle main-toggle-dark change_status ' . $active_delete . '"><span></span></div>';
            $row[] = '
                        <div class=" mg-sm-t-0">
                            <button data-toggle="dropdown" class="btn btn-primary btn-block">Update <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                            <div class="dropdown-menu">
                                <a href="' . Modules::run('helper/create_url', 'app_user/detail?data=' . urlencode($id_encrypt)) . '" class="dropdown-item"><i class="fa fa-tv"></i> Detail</a>
                                ' . $btn_delete . '
                            </div><!-- dropdown-menu -->
                        </div>
            ';
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );
        echo json_encode($ouput);
    }

    public function add()
    {
        $this->app_data['all_credential']   = Modules::run('database/get_all', 'app_credential')->result();
        $this->app_data['page_title']       = "Tambah User";
        $this->app_data['view_file']        = 'form_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }


    private function validate_save()
    {
        Modules::run('security/is_ajax');
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
            if (!empty($get_data)) {
                $data['error_string'][] = 'email sudah digunakan';
                $data['inputerror'][] = 'email';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('username') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'username';
            $data['status'] = FALSE;
        } else {
            $username = $this->input->post('username');
            $get_data = Modules::run('database/find', 'st_user', ['username' => $username])->row();
            if (!empty($get_data)) {
                $data['error_string'][] = 'username sudah digunakan';
                $data['inputerror'][] = 'username';
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
        if ($this->input->post('credential') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'credential';
            $data['status'] = FALSE;
        }
        if ($this->input->post('password') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'password';
            $data['status'] = FALSE;
        } else {
            if (strlen($this->input->post('password')) < 5) {
                $data['error_string'][] = 'min 5 karakter';
                $data['inputerror'][] = 'password';
                $data['status'] = FALSE;
            }
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

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save()
    {
        $this->validate_save();

        $name     = $this->input->post('name');
        $email    = $this->input->post('email');
        $phone_number   = $this->input->post('phone_number');
        $credential   = $this->input->post('credential');
        $address   = $this->input->post('address');
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');
        $hash_password = hash('sha512', $password . config_item('encryption_key'));

        $array_insert = [
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number,
            'address' => $address,
            'username' => $username,
            'password' => $hash_password,
            'id_credential' => $credential,
            'status' => true,
            'access_create' => 1,
            'access_delete' => 1,
            'access_update' => 1
        ];
        Modules::run('database/insert', 'st_user', $array_insert);
        echo json_encode(['status' => true]);
    }

    public function detail()
    {
        Modules::run('security/is_axist_data', ['method' => 'get', 'name' => 'data', 'encrypt' => true]);
        $id = $this->encrypt->decode($this->input->get('data'));
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

        $this->app_data['page_title'] = "detail user";
        $this->app_data['view_file']  = 'view_detail';
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

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post('id'));
        $array_update = ['is_delete' => 1];
        Modules::run('database/update', 'st_user', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function update_status()
    {
        Modules::run('security/is_ajax');
        $id       = $this->input->post('id');
        $status   = $this->input->post('status');
        $field    = $this->input->post('field');

        if ($field == 'status') {
            $array_update = ['status' => $status];
        }
        if ($field == 'create') {
            $array_update = ['access_create' => $status];
        }
        if ($field == 'update') {
            $array_update = ['access_update' => $status];
        }
        if ($field == 'delete') {
            $array_update = ['access_delete' => $status];
        }
        Modules::run('database/update', 'st_user', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function profile()
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
}
