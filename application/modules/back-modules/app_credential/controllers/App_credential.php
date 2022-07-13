
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_credential extends BackendController
{
    var $module_name = 'app_credential';
    var $module_directory = 'app_credential';
    var $module_js = ['app_credential'];
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

        $this->app_data['all_menu']  = Modules::run('database/find', 'app_menu', ['type' => 1, 'status' => 1])->result();
        $this->app_data['page_title']     = "app credential";
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
        if ($this->input->post('description') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'description';
            $data['status'] = FALSE;
        }

        if ($this->input->post('id_menu') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'id_menu';
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
        $view_file    = $this->input->post('view_file');
        $id_menu        = $this->input->post('id_menu');

        $array_insert = [
            'name' => $name,
            'description' => $description,
            'id_app_menu' => $id_menu,
            'view_file' => $view_file
        ];
        Modules::run('database/insert', 'app_credential', $array_insert);
        echo json_encode(['status' => true]);
    }

    public function get_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_data = Modules::run('database/find', 'app_credential', ['id' => $id])->row();

        echo json_encode($get_data);
    }

    public function update()
    {
        $this->validate_save();

        $id             = $this->input->post('id');
        $name           = $this->input->post('name');
        $description    = $this->input->post('description');
        $id_menu        = $this->input->post('id_menu');
        $view_file    = $this->input->post('view_file');

        $array_update = [
            'name' => $name,
            'description' => $description,
            'view_file' => $view_file,
            'id_app_menu' => $id_menu
        ];
        Modules::run('database/update', 'app_credential', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        Modules::run('database/delete', 'app_credential', ['id' => $id]);
        Modules::run('database/delete', 'app_credential_access', ['id_credential' => $id]);
        echo json_encode(['status' => true]);
    }

    public function show_credential()
    {
        $array_get_credential = [
            'select' => '
                type,
                GROUP_CONCAT(id,"-",name,"-",directory,"-",status) AS list_module
            ',
            'from' => 'app_module',
            'order_by' => 'type',
            'group_by' => 'type'
        ];
        $get_module = Modules::run('database/get', $array_get_credential)->result();
        $data['data_module'] = $get_module;
        $data['module_type'] = Modules::run('helper/get_module_type');

        //get list module 
        $id_credential = $this->input->post('id_credential');
        $get_credential_access = Modules::run('database/get', ['select' => 'GROUP_CONCAT(id_app_module) AS list_access', 'from' => 'app_credential_access', 'where' => ['id_credential' => $id_credential]])->row();
        $data['array_access'] = explode(',', $get_credential_access->list_access);

        $html_respon = $this->load->view('view_list_module', $data, TRUE);

        $array_respon = ['status' => TRUE, 'html_respon' => $html_respon];
        echo json_encode($array_respon);
    }

    public function update_status_module()
    {
        Modules::run('security/is_ajax');

        $id_credential       = $this->input->post('id_credential');
        $id_module       = $this->input->post('id_module');
        $status           = $this->input->post('status');

        if ($status) {
            $array_insert = [
                'id_credential' => $id_credential,
                'id_app_module' => $id_module
            ];
            Modules::run('database/insert', 'app_credential_access', $array_insert);
        } else {
            Modules::run('database/delete', 'app_credential_access', ['id_credential' => $id_credential, 'id_app_module' => $id_module]);
        }
        echo json_encode(['status' => true]);
    }

    public function update_status_all()
    {
        Modules::run('security/is_ajax');

        $id_credential    = $this->input->post('id_credential');
        $array_module       = $this->input->post('array_module');
        $status          = $this->input->post('status');

        if ($status) {
            foreach ($array_module as $id_module) {

                $check = Modules::run('database/find', 'app_credential_access', ['id_app_module' => $id_module, 'id_credential' => $id_credential])->row();
                if (empty($check)) {
                    $array_insert = [
                        'id_credential' => $id_credential,
                        'id_app_module' => $id_module
                    ];
                    Modules::run('database/insert', 'app_credential_access', $array_insert);
                }
            }
        } else {
            foreach ($array_module as $id_module) {
                Modules::run('database/delete', 'app_credential_access', ['id_credential' => $id_credential, 'id_app_module' => $id_module]);
            }
        }
        echo json_encode(['status' => true]);
    }
}
