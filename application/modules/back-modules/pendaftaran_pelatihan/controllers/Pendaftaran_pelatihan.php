<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendaftaran_pelatihan extends BackendController
{
    var $module_name = 'pendaftaran_pelatihan';
    var $module_directory = 'pendaftaran_pelatihan';
    var $module_js = ['pendaftaran_pelatihan'];
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
        $this->app_data["course"]       = Modules::run("database/get_all", "tb_course")->result();
        $this->app_data['page_title']     = "Pendaftaran Batch Pelatihan";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function validate_save()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('title') == '') {
            $data['error_string'][] = 'Judul Pelatihan Harus Diisi';
            $data['inputerror'][] = 'title';
            $data['status'] = FALSE;
        }
        if ($this->input->post('description') == '') {
            $data['error_string'][] = 'Deskripsi Pelatihan Harus Diisi';
            $data['inputerror'][] = 'description';
            $data['status'] = FALSE;
        }
        if ($this->input->post('target_registrant') == '') {
            $data['error_string'][] = 'Kuota Peserta Harus Diisi';
            $data['inputerror'][] = 'target_registrant';
            $data['status'] = FALSE;
        }
        if ($this->input->post('opening_registration_date') == '') {
            $data['error_string'][] = 'Awal Pendaftaran Harus Diisi';
            $data['inputerror'][] = 'opening_registration_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('closing_registration_date') == '') {
            $data['error_string'][] = 'Akhir Pendaftaran Harus Diisi';
            $data['inputerror'][] = 'closing_registration_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('starting_date') == '') {
            $data['error_string'][] = 'Awal Pelatihan Harus Diisi';
            $data['inputerror'][] = 'starting_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('ending_date') == '') {
            $data['error_string'][] = 'Akhir Pelatihan Harus Diisi';
            $data['inputerror'][] = 'ending_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('id_course') == '') {
            $data['error_string'][] = 'Tipe Pelatihan Harus Diisi';
            $data['inputerror'][] = 'id_course';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save() 
    {
        Modules::run("security/is_ajax");
        $this->validate_save();
        
        $title                      = $this->input->post("title");
        $id_course                      = $this->input->post("id_course");
        $description                = $this->input->post("description");
        $target_registrant          = $this->input->post("target_registrant");
        $opening_registration_date  = $this->input->post("opening_registration_date");
        $closing_registration_date  = $this->input->post("closing_registration_date");
        $starting_date               = $this->input->post("starting_date");
        $ending_date                = $this->input->post("ending_date");

        $image = $this->upload_image();
        $image = ($image == '') ? 'default.png' : $image;

        $array_insert = [
            "id_course" => $id_course,
            "title" => $title,
            "description" => $description,
            "target_registrant" => $target_registrant,
            "opening_registration_date" => $opening_registration_date,
            "closing_registration_date" => $closing_registration_date,
            "starting_date" => $starting_date,
            "ending_date" => $ending_date,
            "image" => $image
        ];

        Modules::run("database/insert", "tb_batch_course", $array_insert);

        echo json_encode(["status" => true]);
    }

    private function upload_image()
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/batch');
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $file_name                      = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $config['file_name']            = $file_name; //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image')) //upload and validate
        {
            // $data['inputerror'][] = 'image';
            // $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            // $data['status'] = FALSE;
            // echo json_encode($data);
            // exit();
        } else {
        }
        // $upload_data = $this->upload->data();
        $image_name = $file_name;
        return $image_name;
    }
}