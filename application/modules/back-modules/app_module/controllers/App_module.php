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

        $this->app_data['list_unregistered_modul'] = $this->unregistered_module();

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

            $get_routing = Modules::run('database/find', 'app_module_has_route', ['id_module' => $data_table->id])->result();

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
                        <a href="javascript:void(0)" data-id="' . $data_table->id . '" class="btn btn-sm btn-warning-gradient btn-rounded btn_add_routing" title="routing">( ' . count($get_routing) . ' ) <i class="las la-tv"></i></a>
                        <a href="javascript:void(0)" data-id="' . $data_table->id . '" class="btn btn-sm btn-info btn_edit btn-rounded" title="edit"><i class="las la-pen"></i></a>
                        <a href="javascript:void(0)" data-id="' . $data_table->id . '" class="btn btn-sm btn-danger btn_delete btn-rounded" title="hapus"><i class="las la-trash"></i></a>
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
        } else {
            $folder_name = $this->input->post('folder');
            $check = Modules::run('database/find', 'app_module', ['directory' => $folder_name])->row();
            if (!empty($check) && $check->id != $id) {
                $data['error_string'][] = 'folder sudah ada';
                $data['inputerror'][] = 'folder';
                $data['status'] = FALSE;
            }
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

        //Create folder
        $this->create_folder_module($folder, $name, $description, $module_type);
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

    public function detail_route()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');

        $data['credential_access'] = [
            0 => 'public',
            1 => 'create',
            2 => 'edit / update',
            3 => 'delete'
        ];

        //get module
        $getModule = Modules::run('database/find', 'app_module', ['id' => $id])->row();
        $getRoute = Modules::run('database/find', 'app_module_has_route', ['id_module' => $id])->result();

        $data['data_module'] = $getModule;
        $data['data_route'] = $getRoute;
        $html_view = $this->load->view('view_route', $data, TRUE);
        echo json_encode(['status' => TRUE, 'html_respon' => $html_view]);
    }

    private function validate_save_routing()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->input->post('route') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'route';
            $data['status'] = FALSE;
        } else {
            $route = $this->input->post('route');
            $id = $this->input->post('id_module');

            //get route
            $get_route = Modules::run('database/find', 'app_module_has_route', ['id_module' => $id, 'route' => $route])->row();
            if (!empty($get_route)) {
                $data['error_string'][] = 'end point telah digunakan';
                $data['inputerror'][] = 'route';
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save_routing()
    {
        Modules::run('security/is_ajax');
        $this->validate_save_routing();
        $route = $this->input->post('route');
        $id_module = $this->input->post('id_module');
        $credential_access = $this->input->post('credential_access');

        $array_insert = [
            'id_module' => $id_module,
            'route' => $route,
            'credential_access_type' => $credential_access
        ];
        Modules::run('database/insert', 'app_module_has_route', $array_insert);
        echo json_encode(['status' => TRUE, 'id' => $id_module]);
    }

    public function update_routing()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $route = $this->input->post('route');
        $credential_access = $this->input->post('credential_access');
        $array_update = [
            'route' => $route,
            'credential_access_type' => $credential_access
        ];
        Modules::run('database/update', 'app_module_has_route', ['id' => $id], $array_update);
        //get module
        $getModule = Modules::run('database/find', 'app_module_has_route', ['id' => $id])->row();

        echo json_encode(['status' => TRUE, 'id' => $getModule->id_module]);
    }

    public function delete_routing()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $getModule = Modules::run('database/find', 'app_module_has_route', ['id' => $id])->row();
        Modules::run('database/delete', 'app_module_has_route', ['id' => $id]);
        echo json_encode(['status' => TRUE, 'id' => $getModule->id_module]);
    }

    /**
     * create config file
     */

    private function create_config_file($folder_name, $module_name, $module_description = '', $module_type = '')
    {
        /**
         * create config.php
         */
        $base_app_dir = array_key_first($this->config->item('modules_locations'));
        $module_dir = $base_app_dir . '/' . strtolower($folder_name);
        $text_file = "
                <?php
                return [
                    /*
                     |--------------------------------------------------------------------------
                     | General settings
                     |--------------------------------------------------------------------------
                     |
                     | General settings for configuring the PageBuilder.
                     | If you install phpb with Composer, general.assets_url line must be:
                     | 'assets_url' => '/vendor/hansschouten/phpagebuilder/dist',
                     |  type :
                     | (1 = Master data), (2 = Transaksi), (3 = Laporan), (4 = CMS), (5 = Setting & Configuration) 
                     */
                    'general' => [
                        'name' => '$module_name',
                        'description' => '$module_description',
                        'type'=>" . ($module_type ? $module_type : '0') . "
                    ],
                
                    /*
                     |--------------------------------------------------------------------------
                     | Routing Credential settings
                     |--------------------------------------------------------------------------
                     |
                     | We have 4 kind of credential for each route
                     | 1. public = everyone can see
                     | 2. create = for create access
                     | 3. edit = for edit access
                     | 4. delete = for delete access 
                     |
                     */
                    'routes' => [
                        'index' => 'public',
                    ]
                ];
                    
            ";
        $text_file = str_replace('                ', '', $text_file); // remove tabs
        $fp = fopen($module_dir . '/config.php', 'w');
        fwrite($fp, $text_file);
        fclose($fp);
    }

    /**
     * Create directory for module
     */
    private function create_folder_module($folder_name, $module_name, $module_description = '', $module_type = '')
    {
        $base_app_dir = array_key_first($this->config->item('modules_locations'));
        $module_dir = $base_app_dir . '/' . strtolower($folder_name);

        if (!file_exists($module_dir)) {
            mkdir($module_dir, 0755, true);
            mkdir($module_dir . '/controllers', 0755, true);
            mkdir($module_dir . '/views', 0755, true);
            mkdir($module_dir . '/views/print', 0755, true);
            mkdir($module_dir . '/js', 0755, true);

            //preparin data
            $controller_name = ucfirst($folder_name);
            $controller_name_small = $folder_name;

            /**
             * create controller main
             */
            $file_src =  $base_app_dir . '/' . $this->module_directory . '/views/master_data/controller.text';
            $file_data = fopen($file_src, "r");
            $text_file = fread($file_data, filesize($file_src));
            //replacing data
            $text_file = str_replace('{controller_name}', $controller_name, $text_file);
            $text_file = str_replace('{controller_name_small}', $controller_name_small, $text_file);
            $text_file = str_replace('{module_name}', $module_name, $text_file);

            $fp = fopen($module_dir . '/controllers/' . ucfirst($folder_name) . '.php', 'w');
            fwrite($fp, $text_file);
            fclose($fp);

            /**
             * create print controller
             */
            $file_src =  $base_app_dir . '/' . $this->module_directory . '/views/master_data/controller-print.text';
            $file_data = fopen($file_src, "r");
            $text_file = fread($file_data, filesize($file_src));
            //replacing data
            $text_file = str_replace('{controller_name}', $controller_name, $text_file);
            $text_file = str_replace('{controller_name_small}', $controller_name_small, $text_file);
            $text_file = str_replace('{module_name}', $module_name, $text_file);

            $fp = fopen($module_dir . '/controllers/Print_data.php', 'w');
            fwrite($fp, $text_file);
            fclose($fp);

            // create config file
            $this->create_config_file($folder_name, $module_name, $module_description, $module_type);

            /**
             * Create view/main_view.php
             */
            $file_src =  $base_app_dir . '/' . $this->module_directory . '/views/master_data/view-main.text';
            $file_data = fopen($file_src, "r");
            $text_file = fread($file_data, filesize($file_src));
            //replacing data
            $text_file = str_replace('{controller_name}', $controller_name, $text_file);
            $text_file = str_replace('{controller_name_small}', $controller_name_small, $text_file);
            $text_file = str_replace('{module_name}', $module_name, $text_file);

            $fp = fopen($module_dir . '/views/main_view.php', 'w');
            fwrite($fp, $text_file);
            fclose($fp);

            /**
             * Create view/pdf_data.php
             */
            $file_src =  $base_app_dir . '/' . $this->module_directory . '/views/master_data/view-print-pdf.text';
            $file_data = fopen($file_src, "r");
            $text_file = fread($file_data, filesize($file_src));
            //replacing data
            $text_file = str_replace('{controller_name}', $controller_name, $text_file);
            $text_file = str_replace('{controller_name_small}', $controller_name_small, $text_file);
            $text_file = str_replace('{module_name}', $module_name, $text_file);

            $fp = fopen($module_dir . '/views/print/pdf_data.php', 'w');
            fwrite($fp, $text_file);
            fclose($fp);

            /**
             * Create js/main_js
             */
            $file_src =  $base_app_dir . '/' . $this->module_directory . '/views/master_data/js-main.text';
            $file_data = fopen($file_src, "r");
            $text_file = fread($file_data, filesize($file_src));
            $fp = fopen($module_dir . '/js/' . strtolower($folder_name) . '.js', 'w');
            fwrite($fp, $text_file);
            fclose($fp);

            /**
             * Create js/print.js
             */
            $file_src =  $base_app_dir . '/' . $this->module_directory . '/views/master_data/js-print.text';
            $file_data = fopen($file_src, "r");
            $text_file = fread($file_data, filesize($file_src));
            $fp = fopen($module_dir . '/js/print.js', 'w');
            fwrite($fp, $text_file);
            fclose($fp);
        }
    }

    private function unregistered_module()
    {
        $get_all_module = Modules::run('database/get_all', 'app_module')->result();
        $array_directory = [];
        foreach ($get_all_module as $item_modul) {
            $array_directory[] = $item_modul->directory;
        }
        //read to folder modules
        $base_app_dir = array_key_first($this->config->item('modules_locations'));
        $all_dir = $this->scan_dir($base_app_dir, $array_directory);
        return $all_dir;
    }

    private function scan_dir($dir, $available_modul)
    {
        $exception_module = [];
        $common_module = $this->config->item('common_module');
        $exception_module = $common_module;
        $admin_module = $this->config->item('app_admin_module');
        foreach ($admin_module as $key => $item_admin) {
            $exception_module[] = $key;
        }

        $dirs = array_filter(glob($dir . '*'), 'is_dir');
        $unregistered_modul = [];
        foreach ($dirs as $item_dir) {
            $explode_module = explode('/', $item_dir);
            $folder_module_name = end($explode_module);
            if (in_array($folder_module_name, $exception_module)) {
                continue;
            }
            if (in_array($folder_module_name, $available_modul)) {
                continue;
            }
            if (strpos($folder_module_name, '-old') != '') {
                continue;
            }
            $unregistered_modul[] = $folder_module_name;
        }
        return $unregistered_modul;
    }

    public function create_config()
    {
        Modules::run('security/is_ajax');
        $exception_module = [];
        $common_module = $this->config->item('common_module');
        $exception_module = $common_module;
        $admin_module = $this->config->item('app_admin_module');
        foreach ($admin_module as $key => $item_admin) {
            $exception_module[] = $key;
        }

        $base_app_dir = array_key_first($this->config->item('modules_locations'));
        $dirs = array_filter(glob($base_app_dir . '*'), 'is_dir');
        $counter = 0;
        foreach ($dirs as $item_dir) {
            $explode_module = explode('/', $item_dir);
            $folder_module_name = end($explode_module);
            if (in_array($folder_module_name, $exception_module)) {
                continue;
            }
            if (strpos($folder_module_name, '-old') != '') {
                continue;
            }
            $search_file_config = $item_dir . '/config.php';
            if (!file_exists($search_file_config)) {
                $counter++;
                $check_db = Modules::run('database/find', 'app_module', ['directory' => $folder_module_name])->row();
                // create config file
                if (!empty($check_db)) {
                    $module_name = $check_db->name;
                    $module_description = $check_db->description;
                    $module_type = $check_db->type;
                } else {
                    $module_name = str_replace('_', ' ', $folder_module_name);
                    $module_description = 'No description';
                    $module_type = '';
                }

                $this->create_config_file($folder_module_name, $module_name, $module_description, $module_type);
            }
        }

        $array_response = ['status' => TRUE, 'count_data' => $counter];
        echo json_encode($array_response);
    }

    public function sync_config()
    {
        Modules::run('security/is_ajax');
        //array config credentials
        $config_credential = [
            'public' => 0,
            'create' => 1,
            'edit' => 2,
            'delete' => 3
        ];

        $exception_module = [];
        $common_module = $this->config->item('common_module');
        $exception_module = $common_module;
        $admin_module = $this->config->item('app_admin_module');
        foreach ($admin_module as $key => $item_admin) {
            $exception_module[] = $key;
        }

        $base_app_dir = array_key_first($this->config->item('modules_locations'));
        $dirs = array_filter(glob($base_app_dir . '*'), 'is_dir');
        $counter = 0;
        foreach ($dirs as $item_dir) {
            $explode_module = explode('/', $item_dir);
            $folder_module_name = end($explode_module);
            if (in_array($folder_module_name, $exception_module)) {
                continue;
            }
            if (strpos($folder_module_name, '-old') != '') {
                continue;
            }
            $search_file_config = $item_dir . '/config.php';
            if (file_exists($search_file_config)) {
                $counter++;
                $check_db = Modules::run('database/find', 'app_module', ['directory' => $folder_module_name])->row();
                // create config file
                if (empty($check_db)) {
                    $config = require $search_file_config;
                    //insert data
                    $array_insert = [
                        'name' => $config['general']['name'],
                        'description' => $config['general']['description'],
                        'directory' => $folder_module_name,
                        'status' => true,
                        'type' => $config['general']['type']
                    ];
                    Modules::run('database/insert', 'app_module', $array_insert);
                    $get_module = Modules::run('database/find', 'app_module', ['directory' => $folder_module_name])->row();
                    //insert routing
                    foreach ($config['routes'] as $method => $access) {
                        $access_code = isset($config_credential[$access]) ? $config_credential[$access] : 0; //set to public
                        $array_insert = [
                            'id_module' => $get_module->id,
                            'route' => $method,
                            'credential_access_type' => $access_code
                        ];
                        Modules::run('database/insert', 'app_module_has_route', $array_insert);
                    }
                }
            }
        }

        $array_response = ['status' => TRUE, 'count_data' => $counter];
        echo json_encode($array_response);
    }

    public function sync_config_module()
    {
        Modules::run('security/is_ajax');
        $config_credential = [
            'public' => 0,
            'create' => 1,
            'edit' => 2,
            'delete' => 3
        ];

        $id = $this->input->post('id');
        $get_module = Modules::run('database/find', 'app_module', ['id' => $id])->row();
        $base_app_dir = array_key_first($this->config->item('modules_locations'));
        $search_file_config = $base_app_dir . '/' . $get_module->directory . '/config.php';

        $config = require $search_file_config;
        //update data
        $array_update = [
            'name' => $config['general']['name'],
            'description' => $config['general']['description'],
            'status' => true,
            'type' => $config['general']['type']
        ];
        Modules::run('database/update', 'app_module', ['id' => $id], $array_update);
        //delete old routing
        Modules::run('database/delete', 'app_module_has_route', ['id_module' => $id]);
        foreach ($config['routes'] as $method => $access) {
            $access_code = isset($config_credential[$access]) ? $config_credential[$access] : 0; //set to public
            $array_insert = [
                'id_module' => $get_module->id,
                'route' => $method,
                'credential_access_type' => $access_code
            ];
            Modules::run('database/insert', 'app_module_has_route', $array_insert);
        }

        echo json_encode(['status' => true, 'id' => $id]);
    }
}
