<?php
defined('BASEPATH') or exit('No direct script access allowed');

class For_alumni extends CommonController
{
    var $module_name = 'for_alumni';
    var $module_directory = 'for_alumni';
    var $module_js = ['for_alumni'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        Modules::run('security/common_security');
        $this->_init();
    }

    private function _init()
    {
        $id = $this->session->userdata('member_id');

        $get_alumni = Modules::run('database/find', 'tb_account', ['id' => $id])->row();

        if($get_alumni->is_alumni == 0) {
            echo Modules::run('template/forbidden_module', 'Hanya menu untuk alumni');
        }

        $this->app_data['module_js']    = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }

    public function index()
    {

        $id = $this->session->userdata('member_id');

        $get_extern = Modules::run('database/find', 'tb_cv_extern', ['id_account' => $id])->row();

        $this->app_data['extern_cv']    = $get_extern;
        $this->app_data['page_title']   = "Menu Khusus Alumni";
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function save_cv()
    {
        $id = $this->session->userdata('member_id');
        $test = $this->upload_cv();

        $array_insert = [
            "id_account" => $id,
            "file" => $test,
            "created_by" => $id,
            "updated_date" => date('Y-m-d h:i:sa')
        ];

        Modules::run('database/insert', 'tb_cv_extern', $array_insert);

        $redirect = Modules::run('helper/create_url', '/for_alumni');

        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);

    }

    public function delete_data()
    {
        $id = $this->input->post('id');

        $data = Modules::run('database/find', 'tb_cv_extern', ['id' => $id])->row();
        unlink("../upload/extern_cv/$data->file");

        Modules::run('database/delete', 'tb_cv_extern', ['id' => $id]);

        $redirect = Modules::run('helper/create_url', '/for_alumni');
        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);
    }

    private function upload_cv()
    {

        $id = $this->session->userdata('member_id');
        $get_data = Modules::run('database/find', 'tb_account', ['id' => $id])->row();
        $name = str_replace(' ', '_', $get_data->name);

        $config['upload_path']          = realpath(APPPATH . '../upload/extern_cv');
        $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
        $config['file_name']            = $name . "_extern_" . round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('extern_cv')) //upload and validate
        {
            $data['error_string'] = '*) Harus diisi';
            $data['inputerror'] = 'extern_cv';
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        } else {
            $upload_data = $this->upload->data();
            $image_name = $upload_data['file_name'];
            return $image_name;
        }
    }

    public function make_cv()
    {
        $id = $this->session->userdata('member_id');
        $account = Modules::run('database/find', 'tb_account', ['id' => $id])->row();
        $get_intern = Modules::run('database/find', 'tb_cv_intern', ['id_account' => $id])->row();
        if(!$get_intern) {
            Modules::run('database/insert', 'tb_cv_intern', ['id_account' => $id]);
        }
        $intern_cv = Modules::run('database/find', 'tb_cv_intern', ['id_account' => $id])->row();
        
        
        $this->app_data['data_account'] = $account;
        $this->app_data['intern_cv']    = $intern_cv;
        $this->app_data['page_title']   = "Informasi Tambahan";
        $this->app_data['view_file']    = 'make_cv';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function salary_edit()
    {
        $id = $this->session->userdata('member_id');
        $expected_salary = $this->input->post('expected_salary');
        $link_portfolio = $this->input->post('link_portfolio');

        Modules::run('database/update', 'tb_cv_intern', ['id_account' => $id], ['expected_salary' => $expected_salary, 'link_portfolio' => $link_portfolio]);

        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');

        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);
    }

}
