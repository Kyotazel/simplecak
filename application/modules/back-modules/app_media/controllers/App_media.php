<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_media extends BackendController
{
    var $module_name        = 'app_media';
    var $module_directory   = 'app_media';
    var $module_js          = ['app_media'];
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
        $ckeditor_access = isset($_GET['CKEditor']) ? true : false;
        $this->app_data['ckeditor_status'] = $ckeditor_access;
        $this->app_data['vendor_stuff'] = Modules::run('database/find', 'mst_vendor_stuff', ['isDeleted' => 'N'])->result();
        $this->app_data['page_title'] = "Media";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function load_image()
    {
        Modules::run('security/is_ajax');
        $base_dir = str_replace(PREFIX_CREDENTIAL_DIRECTORY . '/', '', BASE_DIR);

        $dir_request = $this->input->post('dir');
        // print_r($dir_request);
        // exit;
        $dir = $base_dir . 'upload/media/' . $dir_request;
        $location = 'upload/media/' . $dir_request;
        $html_breadcrumb = '
            <li class="breadcrumb-item tx-20">
                <a href="#">MEDIA</a>
            </li>
            ';


        if ($dir_request != '') {

            $explode_dir = explode('/', $dir_request);
            $html_breadcrumb = '
                <li class="breadcrumb-item tx-20 ">
                    <a href="javascript:void(0)" class="item-folder" data-location="">MEDIA</a>
                </li>
            ';

            $counter  = 0;
            $text_arrange_folder  = '';
            $location_current = '';
            foreach ($explode_dir as $item_dir) {
                $counter++;
                $location_current .= $item_dir . '/';
                if ($counter == count($explode_dir)) {
                    $html_breadcrumb  .= '
                        <li class="breadcrumb-item tx-20 active current_folder" data-location="' .  substr($location_current, 0, strlen($location_current) - 1) . '">' . $item_dir . '</li>
                    ';
                } else {
                    $html_breadcrumb  .= '
                        <li class="breadcrumb-item tx-20 " >
                            <a href="javascript:void(0)" class="item-folder"  data-location="' . substr($location_current, 0, strlen($location_current) - 1) . '">' . $item_dir . '</a>
                        </li>
                    ';
                }
            }
        } else {
            $html_breadcrumb = '
                <li class="breadcrumb-item tx-20 active current_folder" data-location="">Media</li>
            ';
        }


        $ignored = array('.', '..', '.svn', '.htaccess');
        $all_files = scandir($dir, 1);
        $file_show = [];
        $folder_show = [];
        foreach ($all_files as $item_file) {
            if (in_array($item_file, $ignored)) {
                continue;
            }
            if (is_dir($dir . '/' . $item_file)) {
                $folder_show[] = $item_file;
            } else {
                $file_show[] = $item_file;
            }
        }


        $html_respon = '';

        if (empty($file_show) && empty($folder_show)) {
            $html_respon = '
                <div class="row justify-content-center align-items-center" style="min-height: 500px;">
                    <div class="col-12 text-center">
                        <div class="plan-card text-center">
                            <i class="fas fa-file plan-icon text-primary"></i>
                            <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                            <small class="text-muted">Tidak ada item media.</small>
                        </div>
                    </div>
                </div>
            ';
        }

        $html_item_folder = '';
        foreach ($folder_show as $folder) {

            $dir_current = $dir_request == '' ? $folder : $dir_request . '/' . $folder;

            $html_item_folder .= '
                <div class="col-md-2 col-sm-4 col-6 pos-relative item-file">
                    <a href="javascript:void(0)" data-type="folder" data-location="' . $dir_current . '"  class="btn-delete-file"><i class="fa fa-trash"></i></a>
                    <label for="" class="m-0 p-2 border rounded-5 item-folder d-block" data-location="' . $dir_current . '">
                        <i class="fa fa-folder"></i> &nbsp;&nbsp; ' . $folder . '
                    </label>
                </div>
            ';
        }

        if (!empty($folder_show)) {
            $html_respon .= '
                <div class="row mt-2">
                    <div class="col-12 mb-2">
                        <label for="" class="m-0">Folder</label>
                    </div>
                    ' . $html_item_folder . '
                </div>
            ';
        }

        $html_item_file = '';
        foreach ($file_show as $file) {
            $path = $dir . '/' . $file;
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $image_ext = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($ext), $image_ext)) {
                //image
                $html_item_file .= '
                    <div class="col-md-2 col-sm-4 col-6 mb-3 item-file">
                        <div class="item-image border p-2 rounded-5 pos-relative text-center" data-src="' . base_url($location . '/' . $file) . '"  style="aspect-ratio:3/2;">
                            <a href="javacript:void(0)" data-type="file" data-location="' . $location . '/' . $file . '" class="btn-delete-file"><i class="fa fa-trash"></i></a>
                            <img src="' . base_url($location . '/' . $file) . '" alt="" style="height:100%;">
                            <label for="" class="m-0 p-2 pos-absolute bg-white" style="
                            bottom: 0;
                            left: 0;
                            right: 0;
                            width: 100%;"><i class="fa fa-image"></i> &nbsp;&nbsp;' . $file . '</label>
                        </div>
                    </div>
                ';
            } else {
                //file
                $html_item_file .= '
                    <div class="col-md-2 col-sm-4 col-6 mb-3 item-file" >
                        <div class="item-image border p-2 rounded-5 pos-relative text-center d-flex justify-content-center align-items-center" data-src="' . base_url($location . '/' . $file) . '" style="aspect-ratio:3/2;">
                            <a href="javacript:void(0)" class="btn-delete-file" data-type="file" data-location="' . $location . '/' . $file . '"><i class="fa fa-trash"></i></a>
                            <i class="fa fa-file tx-50"></i>
                            <label for="" class="m-0 p-2 pos-absolute bg-white" style="
                            bottom: 0;
                            left: 0;
                            right: 0;
                            width: 100%;"><i class="fa fa-image"></i> &nbsp;&nbsp;' . $file . '</label>
                        </div>
                    </div>
                ';
            }
        }

        if (!empty($file_show)) {
            $html_respon .= '
            <div class="row mt-3">
                <div class="col-12 mb-2">
                    <label for="" class="m-0">File</label>
                </div>
                ' . $html_item_file . '
            </div>
        ';
        }


        $html_respon = '
            <div class="col-12">
                <nav aria-label="breadcrumb" data-dir="' . $dir . '" data-location="' . $dir_request . '" class="location_directory border-top border-bottom pt-2 pb-2">
                    <ol class="breadcrumb breadcrumb-style2 m-0">
                        ' . $html_breadcrumb . '
                    </ol>
                </nav>
            </div>
        ' . $html_respon;



        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon]);
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

        $location_folder = 'upload/media/' . $location;

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

    public function create_folder()
    {
        Modules::run('security/is_ajax');
        $folder_name = $this->input->post('folder_name');
        $location = $this->input->post('location');

        $base_dir = str_replace(PREFIX_CREDENTIAL_DIRECTORY . '/', '', BASE_DIR);
        $dir = $base_dir . 'upload/media/' . $location;
        if (!file_exists($dir . '/' . $folder_name)) {
            mkdir($dir . '/' . $folder_name, 0755, true);
            echo json_encode(['status' => TRUE]);
        } else {
            echo json_encode(['status' => false, 'message' => 'nama folder telah tersedia']);
        }
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $type       = $this->input->post('type');
        $location   = $this->input->post('location');

        if ($type == 'file') {
            $location = $this->input->post('location');
            $target = realpath(APPPATH . '../' . $location);
            if (file_exists($target)) {
                unlink($target);
            }
        } else {
            $this->rrmdir(($location));
        }

        echo json_encode(['status' => true]);
    }

    private function rrmdir($dir_remove)
    {
        $base_dir = str_replace(PREFIX_CREDENTIAL_DIRECTORY . '/', '', BASE_DIR);
        $dir = $base_dir . 'upload/media/' . $dir_remove;
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        $this->rrmdir($dir . "/" . $object);
                    else unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
