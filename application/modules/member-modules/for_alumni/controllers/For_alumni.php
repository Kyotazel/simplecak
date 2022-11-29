<?php

use Spipu\Html2Pdf\Html2Pdf;

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
    
    public function about_me_edit()
    {
        $id = $this->session->userdata('member_id');
        $about_me = $_POST['description'];

        Modules::run('database/update', 'tb_cv_intern', ['id_account' => $id], ['about_me' => $about_me]);

        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');

        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);
    }

    private function _validate_experience()
    {

        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('company_name') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'company_name';
            $data['status'] = FALSE;
        }
        if ($this->input->post('position') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'position';
            $data['status'] = FALSE;
        }
        if ($this->input->post('start_month') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'start_month';
            $data['status'] = FALSE;
        }
        if ($this->input->post('start_year') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'start_year';
            $data['status'] = FALSE;
        }
        if ($this->input->post('end_month') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'end_month';
            $data['status'] = FALSE;
        }
        if ($this->input->post('end_year') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'end_year';
            $data['status'] = FALSE;
        }


        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function experience_save()
    {
        $this->_validate_experience();
        $id = $this->session->userdata('member_id');
        $company_name = $this->input->post('company_name');
        $position = $this->input->post('position');
        $start_month = $this->input->post('start_month');
        $start_year = $this->input->post('start_year');
        $end_month = $this->input->post('end_month');
        $end_year = $this->input->post('end_year');
        $description = $_POST['description'];

        $cv_intern = Modules::run('database/find', 'tb_cv_intern', ['id_account' => $id])->row();

        $array_insert = [
            'id_cv_intern' => $cv_intern->id,
            'company_name' => $company_name,
            'position' => $position,
            'description' => $description,
            'started_date' => $start_year . "-" . $start_month . "-01",
            'end_date' => $end_year . "-" . $end_month . "-01",
            "created_by" => $id,
            "created_date" => date('Y-m-d h:i:sa')
        ];

        Modules::run('database/insert', 'tb_cv_intern_has_experience', $array_insert);

        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');

        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);
    }

    public function delete_experience()
    {

        $id = $this->input->post('id');

        Modules::run('database/delete', 'tb_cv_intern_has_experience', ['id' => $id]);

        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');
        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);
    }

    public function get_data_experience()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');

        $data = Modules::run('database/find', 'tb_cv_intern_has_experience', ['id' => $id])->row();

        echo json_encode(['status' => TRUE, 'data' => $data]);

    }

    public function experience_update()
    {
        $id = $this->input->post('id');
        $this->_validate_experience();
        $id_account = $this->session->userdata('member_id');
        $company_name = $this->input->post('company_name');
        $position = $this->input->post('position');
        $start_month = $this->input->post('start_month');
        $start_year = $this->input->post('start_year');
        $end_month = $this->input->post('end_month');
        $end_year = $this->input->post('end_year');
        $description = $_POST['description'];

        $array_update = [
            'company_name' => $company_name,
            'position' => $position,
            'description' => $description,
            'started_date' => $start_year . "-" . $start_month . "-01",
            'end_date' => $end_year . "-" . $end_month . "-01",
            "updated_by" => $id_account,
            "updated_date" => date('Y-m-d h:i:sa')
        ];

        Modules::run('database/update', 'tb_cv_intern_has_experience', ['id' => $id], $array_update);

        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');
        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);

    }

    private function _validate_education()
    {

        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('school_name') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'school_name';
            $data['status'] = FALSE;
        }
        if ($this->input->post('study_program') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'study_program';
            $data['status'] = FALSE;
        }
        if ($this->input->post('start_year') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'start_year';
            $data['status'] = FALSE;
        }
        if ($this->input->post('end_year') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'end_year';
            $data['status'] = FALSE;
        }


        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function education_save()
    {
        $this->_validate_education();
        $id = $this->session->userdata('member_id');
        $school_name = $this->input->post('school_name');
        $study_program = $this->input->post('study_program');
        $start_year = $this->input->post('start_year');
        $end_year = $this->input->post('end_year');
        $description = $_POST['description'];

        $cv_intern = Modules::run('database/find', 'tb_cv_intern', ['id_account' => $id])->row();

        $array_insert = [
            'id_cv_intern' => $cv_intern->id,
            'school_name' => $school_name,
            'study_program' => $study_program,
            'description' => $description,
            'started_date' => $start_year,
            'end_date' => $end_year,
            "created_by" => $id,
            "created_date" => date('Y-m-d h:i:sa')
        ];

        Modules::run('database/insert', 'tb_cv_intern_has_education', $array_insert);

        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');

        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);
    }

    public function delete_education()
    {
        $id = $this->input->post('id');
        Modules::run('database/delete', 'tb_cv_intern_has_education', ['id' => $id]);
        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');
        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);
    }

    public function get_data_education()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');

        $data = Modules::run('database/find', 'tb_cv_intern_has_education', ['id' => $id])->row();

        echo json_encode(['status' => TRUE, 'data' => $data]);

    }

    public function education_update()
    {
        $id = $this->input->post('id');
        $this->_validate_education();
        $id_account = $this->session->userdata('member_id');
        $school_name = $this->input->post('school_name');
        $study_program = $this->input->post('study_program');
        $start_year = $this->input->post('start_year');
        $end_year = $this->input->post('end_year');
        $description = $_POST['description'];

        $array_update = [
            'school_name' => $school_name,
            'study_program' => $study_program,
            'description' => $description,
            'started_date' => $start_year,
            'end_date' => $end_year,
            "updated_by" => $id_account,
            "updated_date" => date('Y-m-d h:i:sa')
        ];

        Modules::run('database/update', 'tb_cv_intern_has_education', ['id' => $id], $array_update);

        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');
        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);

    }

    private function _validate_skill()
    {

        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('skill') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'skill';
            $data['status'] = FALSE;
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function skill_save()
    {
        $this->_validate_skill();
        $id = $this->session->userdata('member_id');
        $skill = $this->input->post('skill');

        $cv_intern = Modules::run('database/find', 'tb_cv_intern', ['id_account' => $id])->row();

        $array_insert = [
            'id_cv_intern' => $cv_intern->id,
            'skill' => $skill,
            "created_by" => $id,
            "created_date" => date('Y-m-d h:i:sa')
        ];

        Modules::run('database/insert', 'tb_cv_intern_has_skill', $array_insert);

        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');

        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);
    }

    public function delete_skill()
    {
        $id = $this->input->post('id');
        Modules::run('database/delete', 'tb_cv_intern_has_skill', ['id' => $id]);
        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');
        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);
    }

    public function get_data_skill()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');

        $data = Modules::run('database/find', 'tb_cv_intern_has_skill', ['id' => $id])->row();

        echo json_encode(['status' => TRUE, 'data' => $data]);

    }

    public function skill_update()
    {
        $id = $this->input->post('id');
        $this->_validate_skill();
        $id_account = $this->session->userdata('member_id');
        $skill = $this->input->post('skill');

        $array_update = [
            'skill' => $skill,
            "updated_by" => $id_account,
            "updated_date" => date('Y-m-d h:i:sa')
        ];

        Modules::run('database/update', 'tb_cv_intern_has_skill', ['id' => $id], $array_update);

        $redirect = Modules::run('helper/create_url', 'for_alumni/make_cv');
        echo json_encode(['status' => TRUE, 'redirect' => $redirect]);

    }

    public function print_cv()
    {
        $id = $this->session->userdata('member_id');
        $account = Modules::run('database/find', 'tb_account', ['id' => $id])->row();
        $intern_cv = Modules::run('database/find', 'tb_cv_intern', ['id_account' => $id])->row();

        $data['account'] = $account;
        $data['intern_cv'] = $intern_cv;
        $html = $this->load->view('print_cv', $data, TRUE);
        $pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en', true, 'UTF-8', [16,16,16,16]);
        $pdf->WriteHTML($html);
        $pdf->Output('contoh_cv.pdf', 'I');
    }

}