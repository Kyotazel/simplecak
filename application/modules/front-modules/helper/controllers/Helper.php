<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helper extends CommonController
{
    var  $module = 'helper';
    public function __construct()
    {
        parent::__construct();
        Modules::run('security/banned_url', $this->module);
    }

    public function get_module_type()
    {
        $get_data = Modules::run('database/find', 'app_setting', ['field' => 'app_module_type'])->row();
        $array_type = json_decode($get_data->value, TRUE);
        return $array_type;
    }

    public function get_setting($field, $param = 0)
    {
        $get_data = Modules::run('database/get', 'app_setting', ['field' => $field])->row();
        if (!empty($get_data)) {
            return $get_data;
        } else {
            return false;
        }
    }

    public function create_url($method)
    {
        // check for current url
        if (filter_var($method, FILTER_VALIDATE_URL)) {
            return $method;
        }
        //for #
        if ($method == '#') {
            return $method;
        }

        $prefix_page = PREFIX_CREDENTIAL_DIRECTORY;
        $token          = $this->session->userdata('us_token_login');
        $encrypt_token  = $this->encrypt->encode($token);
        $clear_method = substr($method, -1) == '/' ? substr($method, 0, strlen($method) - 1) : $method;
        if (substr($clear_method, 0, 1) != '/') {
            $clear_method = '/' . $clear_method;
        }
        //check if query url axist
        $explode_url = explode('?', $clear_method);
        $query_url = count($explode_url) > 1 ?   $clear_method . '&token=' . urlencode($encrypt_token) :  $clear_method . '?token=' . urlencode($encrypt_token);
        $url = base_url($prefix_page . $query_url);
        return $url;
    }
}
