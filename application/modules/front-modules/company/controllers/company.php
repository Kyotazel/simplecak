<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company extends FrontendController
{
    var $module_name        = 'company';
    var $module_directory   = 'company';
    var $module_js          = ['company'];
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
        $this->app_data['page_title'] = "Tentang kami - Web Developer";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }

    public function contact()
    {
        $this->app_data['page_title'] = "Hubungi kami";
        $this->app_data['view_file'] = 'view_contact';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }

    private function validate_save_message()
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
        if ($this->input->post('email') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'email';
            $data['status'] = FALSE;
        }
        if ($this->input->post('number_phone') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'number_phone';
            $data['status'] = FALSE;
        }
        if ($this->input->post('comments') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'comments';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save_message()
    {
        $this->validate_save_message();

        $name   = $this->input->post('name');
        $email  = $this->input->post('email');
        $number_phone = $this->input->post('number_phone');
        $company    = $this->input->post('company');
        $address    = $this->input->post('address');
        $comments   =  $this->input->post('comments');

        $array_insert = [
            'name' => $name,
            'email' => $email,
            'number_phone' => $number_phone,
            'company' => $company,
            'address' => $address,
            'comments' => $comments,
            'type' => 1,
            'status' => 0
        ];
        Modules::run('database/insert', 'mst_message', $array_insert);
        $this->session->set_flashdata('success_message', true);
        echo json_encode(['status' => true]);
    }

    public function thanks()
    {
        if (!$this->session->flashdata('success_message')) {
            redirect(base_url());
        }
        $this->app_data['page_title'] = "Terima Kasih";
        $this->app_data['view_file'] = 'view_thanks';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
}
