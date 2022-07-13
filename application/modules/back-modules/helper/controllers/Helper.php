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
        $get_data = Modules::run('database/find', 'app_module_setting', ['field' => $field])->row();
        if (!empty($get_data)) {
            return $get_data;
        } else {
            return false;
        }
    }

    public function get_config($field, $param = false)
    {
        $get_data = Modules::run('database/find', 'app_module_setting', ['field' => $field])->result();
        $array_return = [];
        $array_return_complete = [];
        foreach ($get_data as $item_data) {
            $array_return[$item_data->value] = $item_data->label;
            $array_return_complete[] = [
                'label' => $item_data->label,
                'params' => $item_data->params,
                'value' => $item_data->value
            ];
        }


        if ($param) {
            return $array_return_complete;
        } else {
            return $array_return;
        }
    }


    public function get_single_config($field, $param)
    {
        $param['field'] = $field;
        $get_data = Modules::run('database/find', 'app_module_setting', $param)->row();

        $array_return = [];
        if (!empty($get_data)) {
            $array_return = [
                'label' => $get_data->label,
                'param' => $get_data->params,
                'value' => $get_data->value
            ];
        }

        return $array_return;
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

    public function change_date($date, $delimiter)
    {
        if (empty($date)) {
            return '';
        } else {
            $explode_date = explode($delimiter, $date);
            $date_return = $explode_date[2] . '-' . $explode_date[1] . '-' . $explode_date[0];
            return $date_return;
        }
    }

    public function date_indo($date, $delimiter)
    {
        $array_month = [
            '01' => 'januari', '02' => 'februari', '03' => 'maret', '04' => 'april', '05' => 'mei', '06' => 'juni', '07' => 'juli', '08' => 'agustus', '09' => 'september', '10' => 'oktober', '11' => 'november', '12' => 'december'
        ];
        $explode_date = explode($delimiter, $date);
        $date_return = $explode_date[2] . ' ' . ucfirst($array_month[$explode_date[1]]) . ' ' . $explode_date[0];
        return $date_return;
    }

    public function datetime_indo($datetime)
    {
        $explode_datetime = explode(' ', $datetime);
        $time = $explode_datetime[1];
        $date = $explode_datetime[0];

        $array_month = [
            '01' => 'januari', '02' => 'februari', '03' => 'maret', '04' => 'april', '05' => 'mei', '06' => 'juni', '07' => 'juli', '08' => 'agustus', '09' => 'september', '10' => 'oktober', '11' => 'november', '12' => 'december'
        ];
        $explode_date = explode('-', $date);
        $date_return = $explode_date[2] . ' ' . ucfirst($array_month[$explode_date[1]]) . ' ' . $explode_date[0];

        $explode_time = explode(':', $time);
        $date_return .= '&nbsp;&nbsp; ' . $explode_time[0] . ':' . $explode_time[1];
        return $date_return;
    }

    public function interval_date($date1, $date2)
    {
        $tgl1 = new DateTime($date1);
        $tgl2 = new DateTime($date2);
        $jarak = $tgl2->diff($tgl1);
        return $jarak;
    }
}
