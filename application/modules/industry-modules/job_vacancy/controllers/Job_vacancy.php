<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job_vacancy extends BackendController
{
    var $module_name = 'job_vacancy';
    var $module_directory = 'job_vacancy';
    var $module_js = ['job_vacancy'];
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
        $vacancy = Modules::run('database/get_all', 'tb_job_vacancy')->result();
        $this->app_data['vacancy'] = $vacancy;
        $this->app_data['page_title']   = "Lowongan Kerja";
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function create () {
        $this->app_data['page_title']   = "Buat Lowongan Kerja";
        $this->app_data['view_file']    = 'create_job';
        $this->app_data['method']       = 'add';
        $this->app_data['work_field'] = Modules::run('database/get_all', 'tb_work_field')->result();
        $this->app_data['education'] = Modules::run('database/get_all', 'tb_education')->result();
        $this->app_data['skill'] = Modules::run('database/get_all', 'tb_skill')->result();
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    private function validate_vacancy()
    {
        Modules::run('security/is_ajax');
        $data = array();

        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->input->post('job_name') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'job_name';
            $data['status'] = FALSE;
        }
        if ($this->input->post('end_vacancy') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'end_vacancy';
            $data['status'] = FALSE;
        } else {
            if ($this->input->post('end_vacancy') < date('Y-m-d')) {
                $data['error_string'][] = 'Tanggal penutupan tidak boleh tanggal kemarin';
                $data['inputerror'][] = 'end_vacancy';
                $data['status'] = FALSE;
            }
        }
        if ($this->input->post('min_salary') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'min_salary';
            $data['status'] = FALSE;
        }
        if ($this->input->post('max_salary') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'max_salary';
            $data['status'] = FALSE;
        } elseif ($this->input->post('max_salary') < $this->input->post('min_salary')) {
            $data['error_string'][] = 'Gaji maximum tidak boleh kurang dari gaji minimum';
            $data['inputerror'][] = 'max_salary';
            $data['status'] = FALSE;
        }
        if ($this->input->post('job_position') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'job_position';
            $data['status'] = FALSE;
        }
        if ($this->input->post('education') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'education';
            $data['status'] = FALSE;
        }
        if ($this->input->post('work_field') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'work_field';
            $data['status'] = FALSE;
        }
        if ($this->input->post('job_skill') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'job_skill';
            $data['status'] = FALSE;
        }
        if ($this->input->post('employment_status') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'employment_status';
            $data['status'] = FALSE;
        }
        if ($this->input->post('experience') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'experience';
            $data['status'] = FALSE;
        }
        if ($this->input->post('applicant_gender') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'applicant_gender';
            $data['status'] = FALSE;
        }
        if ($this->input->post('job_address') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'job_address';
            $data['status'] = FALSE;
        }
        if ($this->input->post('job_desc') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'job_desc';
            $data['status'] = FALSE;
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save () {
        Modules::run("security/is_ajax");
        $this->validate_vacancy();

        $industry_id = $this->session->userdata('industry_id');
        $job_name = $this->input->post('job_name');
        $end_vacancy = $this->input->post('end_vacancy');
        $min_salary = $this->input->post('min_salary');
        $max_salary = $this->input->post('max_salary');
        $job_position = $this->input->post('job_position');
        $education = $this->input->post('education');
        $work_field = $this->input->post('work_field');
        $job_skill = $this->input->post('job_skill');
        $employment_status = $this->input->post('employment_status');
        $experience = $this->input->post('experience');
        $applicant_gender = $this->input->post('applicant_gender');
        $job_address = $this->input->post('job_address');
        $job_desc = $this->input->post('job_desc');

        $array_insert = [
            'id_industry' => $industry_id,
            'job_name' => $job_name,
            'end_vacancy' => $end_vacancy,
            'minimum_salary' => $min_salary,
            'maximum_salary' => $max_salary,
            'position' => $job_position,
            'work_field' => $work_field,
            'employment_status' => $employment_status,
            'experience' => $experience,
            'applicant_gender' => $applicant_gender,
            'job_address' => $job_address,
            'job_desc' => str_replace("[removed]", '', $job_desc),
        ];

        Modules::run("database/insert", "tb_job_vacancy", $array_insert);
        $job_id = $this->db->insert_id();
        foreach ($education as $value) {
            Modules::run('database/insert', 'tb_job_vacancy_has_education', [
                'id_job_vacancy' => $job_id,
                'education' => $value
            ]);
        }
        foreach ($job_skill as $value) {
            Modules::run('database/insert', 'tb_job_vacancy_has_skill', [
                'id_job_vacancy' => $job_id,
                'skill' => $value
            ]);
        }
        $job_id = $this->encrypt->encode($job_id);
        $redirect = Modules::run('helper/create_url', "job_vacancy/detail?data=$job_id");
        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function detail () {
        $vacancy_id = $this->input->get('data');
        $vacancy_id = str_replace(' ', '+', $vacancy_id);
        $vacancy_id = $this->encrypt->decode($vacancy_id);
        $this->app_data['detail_vacancy'] = Modules::run('database/find', 'tb_job_vacancy', ['id' => $vacancy_id])->row();
        $detail_vacancy = $this->app_data['detail_vacancy'];
        $this->app_data['page_title']   = "Detail Lowongan Kerja";
        $this->app_data['view_file']    = 'detail_job';
        $this->app_data['company'] = Modules::run('database/find', 'tb_industry', ['id' => $detail_vacancy->id_industry])->row();
        $this->app_data['education'] = Modules::run('database/find', 'tb_job_vacancy_has_education', ['id_job_vacancy' => $detail_vacancy->id])->result();
        $this->app_data['skill'] = Modules::run('database/find', 'tb_job_vacancy_has_skill', ['id_job_vacancy' => $detail_vacancy->id])->result();
        $date = date_create($detail_vacancy->end_vacancy);
        $date = date_format($date, 'Y-m-d');
        $this->app_data['disabled'] = '';
        $this->app_data['end_vacancy'] = $date;
        if (date('Y-m-d') > $date) {
            $this->app_data['disabled'] = 'disabled';
            Modules::run('database/update', 'tb_job_vacancy', ['id' => $detail_vacancy->id], ['vacancy_status' => 0]);
            $this->app_data['detail_vacancy'] = Modules::run('database/find', 'tb_job_vacancy', ['id' => $vacancy_id])->row();
            $detail_vacancy = $this->app_data['detail_vacancy'];
        }
        // var_dump($detail_vacancy->vacancy_status);die;
        switch ($detail_vacancy->employment_status) {
            case '0':
                $this->app_data['employment'] = 'Fulltime';
                break;
            case '1':
                $this->app_data['employment'] = 'Parttime';
                break;
            case '2':
                $this->app_data['employment'] = 'Kontrak';
                break;
            case '3':
                $this->app_data['employment'] = 'Magang';
                break;
            default:
                
                break;
        }
        switch ($detail_vacancy->applicant_gender) {
            case '0':
                $this->app_data['gender'] = 'Perempuan';
                break;
            case '1':
                $this->app_data['gender'] = 'Laki-Laki';
                break;        
            case '2':
                $this->app_data['gender'] = 'Laki-Laki & Perempuan';
                break;    
            default:
                # code...
                break;
        }
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function edit () {
        $vacancy_id = $this->input->get('data');
        $vacancy_id = str_replace(' ', '+', $vacancy_id);
        $vacancy_id = $this->encrypt->decode($vacancy_id);
        $this->app_data['page_title'] = "Edit Lowongan Kerja";
        $this->app_data['view_file'] = 'edit_job';
        $this->app_data['method'] = 'edit';
        $this->app_data['work_field'] = Modules::run('database/get_all', 'tb_work_field')->result();
        $this->app_data['education'] = Modules::run('database/get_all', 'tb_education')->result();
        $has_education = [];
        foreach (Modules::run('database/find', 'tb_job_vacancy_has_education', ['id_job_vacancy' => $vacancy_id])->result() as $value) {
            $has_education []= $value->education;
        }
        $this->app_data['has_education'] = $has_education;
        $has_skill = [];
        foreach (Modules::run('database/find', 'tb_job_vacancy_has_skill', ['id_job_vacancy' => $vacancy_id])->result() as $value) {
            $has_skill []= $value->skill;
        }
        $this->app_data['skill'] = Modules::run('database/get_all', 'tb_skill')->result();
        $this->app_data['has_skill'] = $has_skill;
        $this->app_data['employment_status'] = (object) [
            ['id' => '0',
            'name' => 'Fulltime'], [
            'id' => '1', 
            'name' => 'Parttime'], [
            'id' => '2',
            'name' => 'Kontrak'], [
            'id' => '3', 
            'name' => 'Magang']
        ];
        $this->app_data['applicant_gender'] = (object) [
            ['id' => '0',
            'name' => 'Perempuan'], 
            ['id' => '1', 
            'name' => 'Laki - Laki'], [
            'id' => '2', 
            'name' => 'Semua Gender']
        ];
        $this->app_data['data_detail'] = Modules::run('database/find', 'tb_job_vacancy', ['id' => $vacancy_id])->row();
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function update () {
        Modules::run("security/is_ajax");
        $this->validate_vacancy();
        $vacancy_id = $this->input->post('id');
        $vacancy_id = $this->encrypt->decode($vacancy_id);
        $job_name = $this->input->post('job_name');
        $end_vacancy = $this->input->post('end_vacancy');
        $min_salary = $this->input->post('min_salary');
        $max_salary = $this->input->post('max_salary');
        $job_position = $this->input->post('job_position');
        $education = $this->input->post('education');
        $work_field = $this->input->post('work_field');
        $job_skill = $this->input->post('job_skill');
        $employment_status = $this->input->post('employment_status');
        $experience = $this->input->post('experience');
        $applicant_gender = $this->input->post('applicant_gender');
        $job_address = $this->input->post('job_address');
        $job_desc = $this->input->post('job_desc');

        $array_update = [
            'job_name' => $job_name,
            'end_vacancy' => $end_vacancy,
            'minimum_salary' => $min_salary,
            'maximum_salary' => $max_salary,
            'position' => $job_position,
            'work_field' => $work_field,
            'employment_status' => $employment_status,
            'experience' => $experience,
            'applicant_gender' => $applicant_gender,
            'job_address' => $job_address,
            'job_desc' => str_replace("[removed]", '', $job_desc)
        ];

        Modules::run("database/update", "tb_job_vacancy", ['id' => $vacancy_id], $array_update);
        $job_id = $vacancy_id;
        $check_education = Modules::run('database/find', 'tb_job_vacancy_has_education', ['id_job_vacancy' => $job_id])->result();
        if (!empty($check_education)) {
            $duplicate = [];
            $temp_education = [];
            $i = 0;
            // Get the duplicate value
            foreach ($check_education as $value1) {
                foreach ($education as $value2) {
                    if ($value1->education == $value2) {
                        $duplicate []= $value2; 
                        break;
                    }
                }
                $temp_education []= $value1->education;
                $i++;
            }
            // Delete the left side
            foreach(array_diff($temp_education, $duplicate) as $val) {
                // delete data
                Modules::run('database/delete', 'tb_job_vacancy_has_education', [
                    'id_job_vacancy' => $job_id,
                    'education' => $val
                ]);
            }
            // Insert the right side
            foreach (array_diff($education, $duplicate) as $val) {
                // insert data
                Modules::run('database/insert', 'tb_job_vacancy_has_education', [
                    'id_job_vacancy' => $job_id,
                    'education' => $val
                ]);
            }
        } else {
            foreach ($education as $value) {
                Modules::run('database/insert', 'tb_job_vacancy_has_education', [
                    'id_job_vacancy' => $job_id,
                    'education' => $value
                ]);
            }
        }
        $check_skill = Modules::run('database/find', 'tb_job_vacancy_has_skill', ['id_job_vacancy' => $job_id])->result();
        if (!empty($check_skill)) {
            $duplicate = [];
            $temp_job_skill = [];
            $i = 0;
            // Get the duplicate value
            foreach ($check_skill as $value1) {
                foreach ($job_skill as $value2) {
                    if ($value1->skill == $value2) {
                        $duplicate []= $value2; 
                        break;
                    }
                }
                $temp_job_skill []= $value1->skill;
                $i++;
            }
            // Delete the left side
            foreach(array_diff($temp_job_skill, $duplicate) as $val) {
                // delete data
                Modules::run('database/delete', 'tb_job_vacancy_has_skill', [
                    'id_job_vacancy' => $job_id,
                    'skill' => $val
                ]);
            }
            // Insert the right side
            foreach (array_diff($job_skill, $duplicate) as $val) {
                // insert data
                Modules::run('database/insert', 'tb_job_vacancy_has_skill', [
                    'id_job_vacancy' => $job_id,
                    'skill' => $val
                ]);
            }
        } else {
            foreach ($job_skill as $value) {
                Modules::run('database/insert', 'tb_job_vacancy_has_skill', [
                    'id_job_vacancy' => $job_id,
                    'skill' => $value
                ]);
            }
        }
        $job_id = $this->encrypt->encode($job_id);
        $redirect = Modules::run('helper/create_url', "job_vacancy/detail?data=$job_id");
        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function update_status()
    {
        Modules::run('security/is_ajax');
        $id       = $this->encrypt->decode($this->input->post('id'));
        $status   = $this->input->post('status');
        $field    = $this->input->post('field');

        if ($field == 'status') {
            $array_update = ['vacancy_status' => $status];
        }
        if ($field == 'create') {
            $array_update = ['access_create' => $status];
        }
        if ($field == 'update') {
            $array_update = ['access_update' => $status];
        }
        if ($field == 'delete') {
            $array_update = ['access_delete' => $status];
        }
        Modules::run('database/update', 'tb_job_vacancy', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function delete () {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post("id"));

        Modules::run('database/delete', 'tb_job_vacancy', ['id' => $id]);
        Modules::run('database/delete', 'tb_job_vacancy_has_skill', ['id_job_vacancy' => $id]);
        Modules::run('database/delete', 'tb_job_vacancy_has_education', ['id_job_vacancy' => $id]);
        echo json_encode(['status' => true]);
    }

    private function upload_image()
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/profile');
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('media')) //upload and validate
        {
            $data['inputerror'][] = 'upload_banner';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        } else {
            $upload_data = $this->upload->data();
            $image_name = $upload_data['file_name'];
            return $image_name;
        }
    }

    public function update_description()
    {
        Modules::run('security/is_ajax');

        $content = $_POST['content'];
        $content_short = $_POST['content_short'];
        Modules::run('database/update', 'app_setting', ['field' => 'company_description'], ['value' => $content]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_short_description'], ['value' => $content_short]);
        echo json_encode(['status' => TRUE]);
    }

    public function update_image()
    {
        Modules::run('security/is_ajax');
        $id = $this->session->userdata('us_id');
        $image_data = $this->upload_image_banner();
        //update image
        Modules::run('database/update', 'app_setting', ['field' => 'company_front_banner'], ['value' => $image_data]);
        echo json_encode(['status' => TRUE]);
    }

    private function upload_image_banner()
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/banner');
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('upload_profile')) //upload and validate
        {
            $data['inputerror'][] = 'upload_banner';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        } else {
            $upload_data = $this->upload->data();
            $image_name = $upload_data['file_name'];
            return $image_name;
        }
    }
}
