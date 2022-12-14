<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company_profile extends BackendController
{
    var $module_name = 'company_profile';
    var $module_directory = 'company_profile';
    var $module_js = ['company_profile'];
    var $app_data = [];

    var $service_company_type = 1;

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
        $data = [
            'select' => 'a.*, a.name company, b.name sector_name',
            'from' => 'tb_industry a',
            'join' => [
                'tb_industry_sector b, b.id = a.sector, left'
            ],
            'where' => [
                'a.id' => $this->session->userdata('industry_id')
            ]
        ];
        $this->app_data['company_profile'] = Modules::run('database/get', $data)->row();
        $this->app_data['company_vacancy'] = Modules::run('database/find', 'tb_job_vacancy', ['id_industry' => $this->session->userdata('industry_id')])->result();
        $this->app_data['page_title']   = "Profil Perusahaan";
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function edit () {
        $this->app_data['company_profile'] = Modules::run('database/find', 'tb_industry', ['id' => $this->session->userdata('industry_id')])->row();
        $this->app_data['company_vacancy'] = Modules::run('database/find', 'tb_job_vacancy', ['id_industry' => $this->session->userdata('industry_id')])->result();
        $this->app_data['sector']          = Modules::run('database/get_all', 'tb_industry_sector')->result();
        $this->app_data['page_title']      = "Edit Profil Perusahaan";
        $this->app_data['view_file']       = 'view_detail';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    private function validate_profile()
    {
        Modules::run('security/is_ajax');
        $data = array();

        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->input->post('company_name') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'company_name';
            $data['status'] = FALSE;
        }
        if ($this->input->post('sector') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'sector';
            $data['status'] = FALSE;
        }
        if ($this->input->post('description') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'description';
            $data['status'] = FALSE;
        }
        if ($this->input->post('email') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'email';
            $data['status'] = FALSE;
        }
        if ($this->input->post('phone') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'phone';
            $data['status'] = FALSE;
        }
        if ($this->input->post('email') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'email';
            $data['status'] = FALSE;
        }
        if ($this->input->post('website') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'website';
            $data['status'] = FALSE;
        }
        if ($this->input->post('company_address') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'company_address';
            $data['status'] = FALSE;
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function update () {
        Modules::run("security/is_ajax");
        $this->validate_profile();

        $id = $this->session->userdata('industry_id');
        $cover = $this->upload_img('company_cover', 'cover', time());
        $logo = $this->upload_img('company_logo', 'company', time());
        $company_name = $this->input->post('company_name');
        $sector = $this->input->post('sector');
        $description = $this->input->post('description');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $website = $this->input->post('website');
        $testimony = $this->input->post('testimony');
        $company_address = $this->input->post('company_address');
        
        $array_update = [
            'name' => $company_name,
            'cover' => $cover,
            'image' => $logo,
            'sector' => $sector,
            'description' => str_replace("[removed]", '', $description),
            'email' => $email,
            'phone_number' => $phone,
            'website' => $website,
            'address' => $company_address,
            'testimony' => $testimony
        ];

        Modules::run("database/update", "tb_industry", ['id' => $id], $array_update);        
        $redirect = Modules::run('helper/create_url', "company_profile/");
        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    private function upload_img($name, $folder, $file_name)
    {
        if (isset($_FILES[$name]["name"])) {
            $config['upload_path'] = '../upload/' . $folder . "/";
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['overwrite'] = TRUE;
            $config['file_name'] = $file_name; //just milisecond timestamp fot unique name
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if (!$this->upload->do_upload($name)) {
                echo $this->upload->display_errors();
                return "";
            } else {
                $data = $this->upload->data();

                $file_name = $data['file_name'];
                return $file_name;
            }
        } 
        return '';
    }
}
