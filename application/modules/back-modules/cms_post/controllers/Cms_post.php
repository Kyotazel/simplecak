<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms_post extends BackendController
{
    var $module_name        = 'cms_post';
    var $module_directory   = 'cms_post';
    var $module_js          = ['cms_post'];
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
        $this->app_data['page_title'] = "CMS SLIDER";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run('security/is_ajax');
        $get_all = Modules::run('database/get_all', 'tb_cms_page')->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);
            $btn_view       = ' <a href="' . Modules::run('helper/create_url', 'cms_post/detail?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" class="btn btn-sm btn-info"><i class="fa fa-tv"></i></a> ';
            $btn_delete     = Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" data-redirect="0" class="btn btn-sm btn-danger btn_delete"><i class="las la-trash"></i> </a>');
            $btn_edit       = Modules::run('security/edit_access', ' <a href="' . Modules::run('helper/create_url', 'cms_post/edit?data=' . urlencode($this->encrypt->encode($data_table->id))) . '" data-id="' . $id_encrypt . '" class="btn btn-sm btn-warning"><i class="las la-pen"></i> </a>');

            $no++;
            $row = array();
            $row[] = $no;

            $status = $data_table->status ? 'on' : '';
            $row[] = ' 
                        <label for="" class="tx-16 m-0">' . $data_table->title . '</label> 

                        <div class="p-1 border-dashed d-flex justify-content-left align-items-center">
                            <small><i class="fa fa-check-circle mr-2"></i>Tampilkan di menu : &nbsp;</small>
                            <div  data-id="' . $data_table->id . '" class="main-toggle main-toggle-dark change_status ' . $status . '"><span></span></div>
                        </div>

                        
                    ';
            $row[] = '
                <div class="p-3 shadow">
                    <label for="" class="m-0 d-block tx-18" style="color:#1A0DAB;">' . $data_table->title . '</label>
                    <a href="' . base_url('p/' . $data_table->slug) . '" target="_blank" style="color:#006621;">
                        ' . base_url('p/' . $data_table->slug) . '
                    </a>
                </div>
            ';
            $row[] =  $btn_view . $btn_edit . $btn_delete;
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );
        echo json_encode($ouput);
    }


    public function load_data()
    {
        Modules::run('security/is_ajax');
        $get_all = Modules::run('database/find', 'tb_cms_page', ['isDeleted' => 'N', 'type' => 2])->result();
        $html_respon = '';
        foreach ($get_all as $item_data) {
            $active = $item_data->status ? 'on' : '';
            $html_respon .= '
                <div class="row p-2 align-items-center border-dashed" style="width:100%;">
                    <div class="col-3 border-right">
                        <a href="#" class="image-popup" title="Screenshot-2"> 
                            <img style="height:100px;object-fit:cover;" src="' . base_url('upload/banner/' . $item_data->image) . '" class="thumb-img" alt="work-thumbnail"> 
                        </a>
                    </div>
                    <div class="col-6 align-items-center border-right">
                        <h4>' . $item_data->name . '</h4>
                        <p>' . nl2br($item_data->description) . '</p>
                    </div>
                    <div class="col-3 align-items-center">
                        <div class="text-center  d-flex justify-content-center col-12">
                            <a href="javascript:void(0)" data-id="' . $item_data->id . '" class="btn btn-sm btn-danger btn_delete ml-1 mr-1"><i class="fa fa-trash"></i> Hapus</a>
                            <a href="javascript:void(0)" data-id="' . $item_data->id . '" class="btn btn-sm btn-info  btn_edit ml-1 mr-1"><i class="fa fa-edit"></i> Update</a>
                            <div data-menu="horizontal" data-id="' . $item_data->id . '" class="main-toggle main-toggle-dark change_status ' . $active . '  ml-1 mr-1"><span></span></div>
                        </div>
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
                                    <small class="text-muted">Tidak ada team.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon]);
    }

    public function add()
    {
        $this->app_data['method'] = "add";
        $this->app_data['page_title'] = "Tambah Data";
        $this->app_data['view_file'] = 'form_add';
        echo Modules::run('template/main_layout', $this->app_data);
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


        if ($this->input->post('title') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'title';
            $data['status'] = FALSE;
        }

        if ($this->input->post('keyword') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'keyword';
            $data['status'] = FALSE;
        }

        if ($this->input->post('slug') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'slug';
            $data['status'] = FALSE;
        } else {
            $slug = $this->input->post('slug');
            $get_data = Modules::run('database/find', 'tb_cms_page', ['slug' => $slug])->row();
            if ($id) {
                if (!empty($get_data) && $get_data->id != $id) {
                    $data['error_string'][] = 'slug sudah dipakai';
                    $data['inputerror'][] = 'slug';
                    $data['status'] = FALSE;
                }
            } else {
                if (!empty($get_data)) {
                    $data['error_string'][] = 'slug sudah dipakai';
                    $data['inputerror'][] = 'slug';
                    $data['status'] = FALSE;
                }
            }
        }


        if ($this->input->post('content') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'content';
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
        $title    = $this->input->post('title');
        $keyword   = $this->input->post('keyword');
        $slug   = $this->input->post('slug');
        $image   = $this->input->post('image');
        $content   = $_POST['content'];

        $array_insert = [
            'title' => $title,
            'content' => $content,
            'keyword' => $keyword,
            'slug' => $slug,
            'status' => 1,
            'image' => $image
        ];
        Modules::run('database/insert', 'tb_cms_page', $array_insert);

        $get_data = $this->db->select('MAX(id) AS max_id')->get('tb_cms_page')->row();
        $redirect = Modules::run('helper/create_url', 'cms_post/detail?data=' . urlencode($this->encrypt->encode($get_data->max_id)));

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function upload_image()
    {
        Modules::run('security/is_ajax');
        $dir = $this->input->post('dir');
        $upload_data = $this->do_upload_image($dir);
        echo json_encode(['status' => TRUE, 'file_name' => $upload_data]);
    }

    private function do_upload_image($location)
    {

        $location_folder = 'upload/banner/' . $location;

        $config['upload_path']          = realpath(APPPATH . '../' . $location_folder);
        $config['allowed_types']        = '*';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('upload_file')) //upload and validate
        {
            $data['inputerror'][] = 'upload_file';
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

    public function delete_file()
    {
        Modules::run('security/is_ajax');
        $name = $this->input->post('name');
        $location = $this->input->post('location');
        $location_folder = 'upload/media/' . $location;

        $target = realpath(APPPATH . '../' . $location_folder . '/' . $name);
        if (file_exists($target)) {
            unlink($target);
        }
        echo json_encode(['status' => TRUE, 'name' => $name]);
    }

    public function detail()
    {
        $id = $this->encrypt->decode($this->input->get('data'));
        $get_data = Modules::run('database/find', 'tb_cms_page', ['id' => $id])->row();

        $this->app_data['data_detail'] = $get_data;
        $this->app_data['page_title'] = "Detail";
        $this->app_data['view_file'] = 'view_detail';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function edit()
    {
        $id = $this->encrypt->decode($this->input->get('data'));
        $get_data = Modules::run('database/find', 'tb_cms_page', ['id' => $id])->row();

        $this->app_data['data_detail'] = $get_data;
        $this->app_data['method'] = "edit";
        $this->app_data['page_title'] = "Detail";
        $this->app_data['view_file'] = 'form_add';
        echo Modules::run('template/main_layout', $this->app_data);
    }


    public function update()
    {
        Modules::run('security/is_ajax');
        $this->validate_save();

        $id     = $this->input->post('id');
        $title    = $this->input->post('title');
        $keyword   = $this->input->post('keyword');
        $slug   = $this->input->post('slug');
        $image   = $this->input->post('image');
        $content   = $this->input->post('content');

        $array_update = [
            'title' => $title,
            'content' => $content,
            'keyword' => $keyword,
            'slug' => $slug,
            'status' => 1
        ];

        if ($image != '') {
            $array_update['image'] = $image;
        }
        Modules::run('database/update', 'tb_cms_page', ['id' => $id], $array_update);
        $redirect = Modules::run('helper/create_url', 'cms_post/detail?data=' . urlencode($this->encrypt->encode($id)));

        echo json_encode(['status' => true, 'redirect' => $redirect]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $array_update = ['isDeleted' => 'Y'];
        Modules::run('database/delete', 'tb_cms_page', ['id' => $id]);
        echo json_encode(['status' => true]);
    }

    public function update_status()
    {
        Modules::run('security/is_ajax');
        $status = $this->input->post('status');
        $id     = $this->input->post('id');

        Modules::run('database/update', 'tb_cms_page', ['id' => $id], ['status' => $status]);
        echo json_encode(['status' => true]);
    }

    public function home_builder()
    {
        $this->app_data['page_title'] = "home Builder";
        $this->app_data['view_file'] = 'form_home_builder';
        echo Modules::run('template/main_layout', $this->app_data);
    }
}
