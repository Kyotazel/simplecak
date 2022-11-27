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
        $this->app_data['company_name'] = Modules::run('database/find', 'app_setting', ['field' => 'company_name'])->row()->value;
        $this->app_data['company_tagline'] = Modules::run('database/find', 'app_setting', ['field' => 'company_tagline'])->row()->value;
        $this->app_data['company_email'] = Modules::run('database/find', 'app_setting', ['field' => 'company_email'])->row()->value;
        $this->app_data['company_number_phone'] = Modules::run('database/find', 'app_setting', ['field' => 'company_number_phone'])->row()->value;
        $this->app_data['company_website'] = Modules::run('database/find', 'app_setting', ['field' => 'company_website'])->row()->value;
        $this->app_data['company_address'] = Modules::run('database/find', 'app_setting', ['field' => 'company_address'])->row()->value;
        $this->app_data['company_link_video'] = Modules::run('database/find', 'app_setting', ['field' => 'company_link_video'])->row()->value;
        $this->app_data['company_schedule'] = Modules::run('database/find', 'app_setting', ['field' => 'company_schedule'])->row()->value;
        $this->app_data['company_description'] = Modules::run('database/find', 'app_setting', ['field' => 'company_description'])->row()->value;
        $this->app_data['company_short_description'] = Modules::run('database/find', 'app_setting', ['field' => 'company_short_description'])->row()->value;
        $this->app_data['company_front_banner'] = Modules::run('database/find', 'app_setting', ['field' => 'company_front_banner'])->row()->value;
        // print_r($this->app_data['company_front_banner']);
        // exit;

        $this->app_data['company_instagram'] = Modules::run('database/find', 'app_setting', ['field' => 'company_instagram'])->row()->value;
        $this->app_data['company_facebook'] = Modules::run('database/find', 'app_setting', ['field' => 'company_facebook'])->row()->value;
        $this->app_data['company_line'] = Modules::run('database/find', 'app_setting', ['field' => 'company_line'])->row()->value;
        $this->app_data['company_twitter'] = Modules::run('database/find', 'app_setting', ['field' => 'company_twitter'])->row()->value;
        $this->app_data['company_youtube'] = Modules::run('database/find', 'app_setting', ['field' => 'company_youtube'])->row()->value;

        $this->app_data['page_title']   = "Profil Perusahaan";
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function update_profile()
    {
        Modules::run('security/is_ajax');
        $name       = $this->input->post('name');
        $tagline    = $this->input->post('tagline');
        $number_phone = $this->input->post('number_phone');
        $email = $this->input->post('email');
        $website = $this->input->post('website');
        $address = $this->input->post('address');
        $link_profile = $this->input->post('link_profile');
        $array_schedule = $this->input->post('schedule');

        Modules::run('database/update', 'app_setting', ['field' => 'company_name'], ['value' => $name]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_tagline'], ['value' => $tagline]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_email'], ['value' => $email]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_number_phone'], ['value' => $number_phone]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_website'], ['value' => $website]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_address'], ['value' => $address]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_link_video'], ['value' => $link_profile]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_schedule'], ['value' => json_encode($array_schedule)]);
        echo json_encode(['status' => TRUE]);
    }

    public function update_sosmed()
    {
        Modules::run('security/is_ajax');
        $facebook    = $this->input->post('facebook');
        $instagram   = $this->input->post('instagram');
        $twitter     = $this->input->post('twitter');
        $line       = $this->input->post('line');
        $youtube    = $this->input->post('youtube');

        Modules::run('database/update', 'app_setting', ['field' => 'company_youtube'], ['value' => $youtube]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_twitter'], ['value' => $twitter]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_line'], ['value' => $line]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_facebook'], ['value' => $facebook]);
        Modules::run('database/update', 'app_setting', ['field' => 'company_instagram'], ['value' => $instagram]);
        echo json_encode(['status' => TRUE]);
    }

    public function save_service()
    {
        Modules::run('security/is_ajax');
        $image_name = $this->upload_image();
        $title = $this->input->post('title');
        $description = $this->input->post('description');


        $array_insert = [
            'type' => $this->service_company_type,
            'name' => $title,
            'description' => $description,
            'image' => $image_name
        ];
        Modules::run('database/insert', 'tb_service_company', $array_insert);
        echo json_encode(['status' => TRUE]);
    }

    public function list_service()
    {
        Modules::run('security/is_ajax');
        $get_all_data = Modules::run('database/find', 'tb_service_company', ['type' => $this->service_company_type])->result();
        $html_respon = '';
        foreach ($get_all_data as $item_data) {
            $html_respon .= '
                <tr>
                    <td>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-3">
                                <img src="' . base_url('upload/profile/' . $item_data->image) . '" alt="">
                            </div>
                            <div class="col-9">
                                <h2>' . $item_data->name . '</h2>
                                <p>' . $item_data->description . '</p>
                            </div>
                        </div>
                    </td>
                    <td style="vertical-align:middle;">
                        <a href="javascript:void(0)" data-id="' . $item_data->id . '" class="btn btn-warning-gradient btn-sm btn-rounded btn_edit_service"><i class="fa fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" data-id="' . $item_data->id . '"  class="btn btn-danger-gradient btn-sm btn-rounded btn_delete_service"><i class="fa fa-trash"></i> Hapus</a>
                    </td>
                </tr>
            ';
        }
        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon]);
    }

    public function get_data_service()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_data = Modules::run('database/find', 'tb_service_company', ['id' => $id])->row();
        $get_data->status = TRUE;

        echo json_encode($get_data);
    }

    public function update_service()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');

        $title = $this->input->post('title');
        $description = $this->input->post('description');

        $array_update = [
            'name' => $title,
            'description' => $description
        ];
        if (!empty($_FILES['media']['name'])) {
            $image_name = $this->upload_image();
            $array_update['image'] = $image_name;
        }
        Modules::run('database/update', 'tb_service_company', ['id' => $id], $array_update);
        echo json_encode(['status' => TRUE]);
    }

    public function delete_service()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        Modules::run('database/delete', 'tb_service_company', ['id' => $id]);
        echo json_encode(['status' => TRUE]);
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
