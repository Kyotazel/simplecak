<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_module extends BackendController
{
    var $module_name = 'app_module';
    var $module_directory = 'app_module';
    var $module_js = ['app_module'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        Modules::run('security/common_security');
        $this->_init();
    }

    private function _init()
    {
        $this->app_data['module_js']  = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }

    public function index()
    {
        $query_count_data = [
            'select' => 'type, COUNT(id) AS total_module',
            'from' => 'app_module',
            'group_by' => 'type'
        ];
        $get_count_data = Modules::run('database/get', $query_count_data)->result();
        $array_count_data = [];
        $total_module = 0;
        foreach ($get_count_data as $item_count) {
            $array_count_data[$item_count->type] = $item_count->total_module;
            $total_module += $item_count->total_module;
        }

        $this->app_data['array_count'] = $array_count_data;
        $this->app_data['total_module'] = $total_module;
        $this->app_data['module_type'] = Modules::run('helper/get_module_type');
        $this->app_data['page_title']     = "app module";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run('security/is_ajax');
        $type = $this->input->post('type');
        $array_module_type = Modules::run('helper/get_module_type');
        $array_query = [
            'from' => 'app_module',
            'order_by' => 'id, DESC'
        ];

        if ($type != 'all' && $type != '' && !empty($type)) {
            $array_query['where'] = ['type' => $type];
        }

        $get_data = Modules::run('database/get', $array_query)->result();
        $no = 0;
        $data = [];
        foreach ($get_data as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);
            $module_type = isset($array_module_type[$data_table->type]) ? $array_module_type[$data_table->type] : '';
            $active = $data_table->status ? 'on' : '';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '
                    <h5 class="mb-0">' . $data_table->name . '</h5>
                    <small>' . $data_table->description . '</small>
            ';
            $row[] = ' <i class="bx bx-folder"></i> ' . $data_table->directory;
            $row[] = '<h5 class="text-info"><span class="badge badge-warning text-capitalize">' . $module_type . '</span></h5>';
            $row[] = '<div data-id="' . $data_table->id . '" class="main-toggle main-toggle-dark change_status ' . $active . '"><span></span></div>';
            $row[] = '
                        <a href="javascript:void(0)" data-id="' . $data_table->id . '" class="btn btn-sm btn-info btn_edit"><i class="las la-pen"></i></a>
                        <a href="javascript:void(0)" data-id="' . $data_table->id . '" class="btn btn-sm btn-danger btn_delete"><i class="las la-trash"></i></a>
            ';
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );
        echo json_encode($ouput);
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
        }
        if ($this->input->post('folder') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'folder';
            $data['status'] = FALSE;
        }
        if ($this->input->post('module_type') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'module_type';
            $data['status'] = FALSE;
        }
        if ($this->input->post('description') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'description';
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
        $name           = $this->input->post('name');
        $description    = $this->input->post('description');
        $folder    = $this->input->post('folder');
        $module_type = $this->input->post('module_type');

        $array_insert = [
            'name' => $name,
            'description' => $description,
            'directory' => $folder,
            'status' => true,
            'type' => $module_type
        ];
        Modules::run('database/insert', 'app_module', $array_insert);
        echo json_encode(['status' => true]);
    }

    public function get_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_data = Modules::run('database/find', 'app_module', ['id' => $id])->row();

        echo json_encode($get_data);
    }

    public function update()
    {
        $this->validate_save();
        $id             = $this->input->post('id');
        $name           = $this->input->post('name');
        $description    = $this->input->post('description');
        $folder    = $this->input->post('folder');
        $module_type = $this->input->post('module_type');

        $array_update = [
            'name' => $name,
            'description' => $description,
            'directory' => $folder,
            'status' => true,
            'type' => $module_type
        ];
        Modules::run('database/update', 'app_module', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');

        Modules::run('database/delete', 'app_module', ['id' => $id]);
        echo json_encode(['status' => true]);
    }

    public function update_status()
    {
        Modules::run('security/is_ajax');
        $id             = $this->input->post('id');
        $status           = $this->input->post('status');
        $array_update = [
            'status' => $status
        ];
        Modules::run('database/update', 'app_module', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }
}
