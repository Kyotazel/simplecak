<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms_page_builder extends BackendController
{
    var $module_name        = 'cms_page_builder';
    var $module_directory   = 'cms_page_builder';
    var $module_js          = ['cms_page_builder'];
    var $app_data           = [];


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
        $this->app_data['page_title'] = "CMS PAGE BUILDER";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function add()
    {
        $this->app_data['save_method'] = 'add';
        $this->app_data['page_title'] = "Input Data";
        $this->app_data['view_file'] = 'view_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function load_data()
    {
        Modules::run('security/is_ajax');
        $get_all = Modules::run('database/find', 'tb_cms_banner', ['isDeleted' => 'N', 'type' => 4])->result();
        $html_respon = '';
        $array_postion = [
            1 => 'left',
            2 => 'right',
            3 => 'center',
            4 => 'background-image'
        ];


        foreach ($get_all as $item_data) {
            $active = $item_data->status ? 'on' : '';
            $html_respon .= '
                <div class="col-12 shadow-3 row align-items-center p-2 mb-2" >
                    <div class="col-7 border-right">
                        <h4> ' . $item_data->name . '</h4>
                    </div>
                    <div class="col-2 border-right">
                        <small for="">Status :</small>
                        <div data-id="' . $item_data->id . '" class="main-toggle main-toggle-dark change_status ' . $active . '"><span></span></div>
                    </div>
                    <div class="col-3">
                        <a href="' . Modules::run('helper/create_url', 'cms_page_builder/detail?data=' . urlencode($this->encrypt->encode($item_data->id))) . '" class="btn btn-sm btn-info"><i class="fa fa-tv"></i></a>
                        <a href="' . Modules::run('helper/create_url', 'cms_page_builder/edit?data=' . urlencode($this->encrypt->encode($item_data->id))) . '" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" data-id="' . $item_data->id . '" class="btn btn-sm btn-danger btn_delete"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            ';
        }

        if (empty($get_all)) {
            $html_respon = '
                <div class="row justify-content-center align-items-center" >
                    <div class="col-12 text-center">
                        <div class="card">
                                <div class="card-body">
                                    <div class="plan-card text-center">
                                    <i class="fas fa-file plan-icon text-primary"></i>
                                    <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                    <small class="text-muted">Tidak ada Data.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon]);
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

        if ($this->input->post('content') == '') {
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
        $name    = $this->input->post('name');
        $description   = $_POST['content'];

        $array_insert = [
            'type' => 4,
            'name' => $name,
            'description' => $description,
            'status' => 0,
            'isDeleted' => 'N',
        ];

        Modules::run('database/insert', 'tb_cms_banner', $array_insert);
        echo json_encode(['status' => true]);
    }

    public function edit()
    {
        Modules::run('security/is_axist_data', ['name' => 'data', 'method' => 'GET', 'encrypt' => TRUE]);
        $id_page_builder = $this->encrypt->decode($this->input->get('data'));
        $this->app_data['data_page'] = Modules::run('database/find', 'tb_cms_banner', ['id' => $id_page_builder])->row();
        $this->app_data['save_method'] = 'edit';
        $this->app_data['page_title'] = "EDIT DATA";
        $this->app_data['view_file'] = 'view_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function update()
    {
        Modules::run('security/is_ajax');
        $id    = $this->input->post('id');
        $name    = $this->input->post('name');
        $description   = $_POST['content'];

        $array_update = [
            'name' => $name,
            'description' => $description
        ];
        Modules::run('database/update', 'tb_cms_banner', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $array_update = ['isDeleted' => 'Y'];
        Modules::run('database/update', 'tb_cms_banner', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function update_status()
    {
        Modules::run('security/is_ajax');
        $status = $this->input->post('status');
        $id     = $this->input->post('id');

        Modules::run('database/update', 'tb_cms_banner', ['status' => 1, 'type' => 4], ['status' => 0]);
        Modules::run('database/update', 'tb_cms_banner', ['id' => $id], ['status' => $status]);
        echo json_encode(['status' => true]);
    }

    public function detail()
    {
        Modules::run('security/is_axist_data', ['name' => 'data', 'method' => 'GET', 'encrypt' => TRUE]);
        $id_page_builder = $this->encrypt->decode($this->input->get('data'));
        $this->app_data['data_page'] = Modules::run('database/find', 'tb_cms_banner', ['id' => $id_page_builder])->row();

        $this->app_data['page_title'] = "DETAIL";
        $this->app_data['view_file'] = 'view_datail';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function login_admin()
    {
        $this->app_data['page_title'] = "UPDATE HALAMAN LOGIN PETUGAS";
        $this->app_data['view_file'] = 'view_admin_login';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function login_member()
    {
        $this->app_data['page_title'] = "UPDATE HALAMAN LOGIN MEMBER";
        $this->app_data['view_file'] = 'view_member_login';
        echo Modules::run('template/main_layout', $this->app_data);
    }
}
