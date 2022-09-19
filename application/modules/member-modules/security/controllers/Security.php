<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Security extends CommonController
{
    var  $module = 'security';

    public function __construct()
    {
        parent::__construct();
        Modules::run('security/banned_url', $this->module);
    }

    public function common_security()
    {
        $this->login_validation();
        // $this->token_validation();

        // $controller_name    = $this->router->fetch_class();
        // $this->module_access_validation(strtolower($controller_name));
        // $this->admin_access_validation(strtolower($controller_name));
    }

    public function login_validation()
    {
        $token      = $this->session->userdata('member_token_login');
        $id_user    = $this->session->userdata('member_id');
        $get_data   = Modules::run('database/find', 'tb_account', ['id' => $id_user])->row();

        if ($token == '' || !isset($get_data->token) || $get_data->token == '') {
            //create url
            $url = Modules::run('helper/create_url', '/login');
            redirect($url);
        }
    }
    public function token_validation()
    {
        $token      = $this->session->userdata('member_token_login');
        $token_query = $this->encrypt->decode($this->input->get('token'));
        $id_user    = $this->session->userdata('member_id');
        $get_data   = Modules::run('database/find', 'st_user', ['id' => $id_user])->row();

        if ($this->uri->segment(1) == '' && $this->input->get('token') == '') {
            redirect(Modules::run('helper/create_url', '/'));
        }

        if ($token != $get_data->token || $token_query != $token) {
            //create url
            $data['token'] = $token;
            echo die(Modules::run('template/error_token', $data));
        }
    }

    public function module_access_validation($controller)
    {

        $array_module_access = $this->session->userdata('member_credetial_module');
        $common_module = $this->config->item('common_module');
        $admin_module = $this->config->item('app_admin_module');
        if (!in_array($controller, $array_module_access) && !in_array($controller, $common_module) && !isset($admin_module[$controller]) && !$this->session->userdata('member_credential_admin')) {
            $data['controllers'] = $controller;
            echo die(Modules::run('template/forbidden_module', $data));
        }
    }

    public function admin_access_validation($controller)
    {
        $admin_module = $this->config->item('app_admin_module');
        $admin_access = $this->session->userdata('member_credential_admin');
        if (isset($admin_module[$controller]) && !$admin_access) {
            $data['controllers'] = '';
            echo die(Modules::run('template/forbidden_module', $data));
        }
    }

    public function is_logged()
    {
        $token      = $this->session->userdata('member_token_login');
        $id_user    = $this->session->userdata('member_id');
        $get_data   = Modules::run('database/find', 'st_user', ['id' => $id_user])->row();
        if (!empty($get_data) && $token == $get_data->token) {
            //create url
            $url = Modules::run('helper/create_url', '/');
            redirect($url);
        }
    }

    public function banned_url($controller, $redirect = false)
    {
        $uri_1 = $this->uri->segment(1);

        if (strtolower($uri_1) == strtolower($controller)) {
            if ($redirect) {
                redirect($redirect);
            } else {
                $this->is_logged();
            }
        }
    }

    public function is_ajax()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url('auth/logout'));
        }
    }

    public function is_axist_data($data)
    {
        $error_log = '';
        $status_process = TRUE;

        //get data
        if (isset($data['method']) && isset($data['name'])) {
            $method = strtolower($data['method']);
            if ($method == 'post') {
                $data_search = $this->input->post($data['name']);
            } elseif ($method == 'get') {
                $data_search = $this->input->get($data['name']);
            } else {
                $data_search = '';
                $status_process = FALSE;
            }
        } else {
            $data_search = '';
            $status_process = FALSE;
        }



        //do encrypt
        if (isset($data['encrypt'])) {
            if ($data['encrypt']) {
                $data_search = $this->encrypt->decode($data_search);
            }
        }

        //check to db
        $status_data = TRUE;
        if (isset($data['table_name'])) {
            if (!empty($data_search)) {

                if (isset($data['where_table'])) {
                    $array_where['id'] = $data_search;
                    foreach ($data['where_table'] as $key_where => $item_where) {
                        $array_where[$key_where] = $item_where;
                    }
                } else {
                    $array_where['id'] = $data_search;
                }
                $get_data = modules::run('database/find', $data['table_name'], $array_where)->num_rows();
                if ($get_data == 0) {
                    $status_data = FALSE;
                }
            }
        }

        if ($status_process) {
            //check axist data
            if (empty($data_search) || $status_data == FALSE) {

                if (isset($data['return'])) {
                    if ($data['return']) {
                        //return value true
                        return TRUE;
                    } else {
                        //return value false
                        if (isset($data['redirect'])) {
                            redirect($data['redirect']);
                        } else {
                            redirect(Modules::run('helper/create_url', '/'));
                        }
                    }
                } else {
                    //not return
                    if (isset($data['redirect'])) {
                        redirect($data['redirect']);
                    } else {
                        redirect(Modules::run('helper/create_url', '/'));
                    }
                }
            }
        } else {
            print_r('Error Process, your object data is false');
            exit;
        }
    }

    public function create_access($html)
    {
        $credential_access = $this->session->userdata('member_credential_access');
        $html_return = isset($credential_access['create']) && $credential_access['create'] ? $html : '';
        return $html_return;
    }

    public function edit_access($html)
    {

        $credential_access = $this->session->userdata('member_credential_access');
        $html_return = isset($credential_access['update']) && $credential_access['update'] ? $html : '';
        return $html_return;
    }

    public function delete_access($html)
    {
        $credential_access = $this->session->userdata('member_credential_access');
        $html_return = isset($credential_access['delete']) && $credential_access['delete'] ? $html : '';
        return $html_return;
    }
}
