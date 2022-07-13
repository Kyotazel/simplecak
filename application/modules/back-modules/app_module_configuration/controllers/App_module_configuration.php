<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_module_configuration extends BackendController
{
    var $module_name = 'app_module_configuration';
    var $module_directory = 'app_module_configuration';
    var $module_js = ['app_module_configuration'];
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
        $this->app_data['page_title']   = "Data Module Configuration";
        $this->app_data['view_file']    = 'main_view';
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
        if ($this->input->post('value') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'value';
            $data['status'] = FALSE;
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save()
    {
        $this->validate_save();

        $label     = $this->input->post('label');
        $params    = $this->input->post('params');
        $value   = $this->input->post('value');
        $field   = $this->input->post('field');
        $data_type = $this->input->post('data_type');

        $array_insert = [
            'field' => $field,
            'label' => $label,
            'params' => $params,
            'value' => $value,
            'data_type' => $data_type
        ];
        Modules::run('database/insert', 'app_module_setting', $array_insert);
        echo json_encode(['status' => true]);
    }


    public function update()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $label     = $this->input->post('label');
        $param    = $this->input->post('param');
        $value   = $this->input->post('value');

        $array_update = [
            'label' => $label,
            'params' => $param,
            'value' => $value
        ];
        Modules::run('database/update', 'app_module_setting', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        Modules::run('database/delete', 'app_module_setting', ['id' => $id]);
        echo json_encode(['status' => true]);
    }
}
