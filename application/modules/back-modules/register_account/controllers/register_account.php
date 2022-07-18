<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register_account extends BackendController
{
    var $module_name = 'register_account';
    var $module_directory = 'register_account';
    var $module_js = ['register_account'];
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
        $this->app_data["provinsi"] = Modules::run("database/get_all", "provinces")->result();
        $this->app_data['page_title']     = "Pendaftaran Akun";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function get_kota() {
        Modules::run("security/is_ajax");
        $provinsi = $this->input->post("provinsi");
        // $provinsi = 13;

        $array_kota = [
            "select" => "*",
            "from" => "cities",
            "where" => "province_id = $provinsi"
        ];
        $get_kota = Modules::run("database/get", $array_kota)->result();

        echo json_encode($get_kota);
    }

    public function get_kecamatan() {
        Modules::run("security/is_ajax");
        $kota = $this->input->post("kota");

        $array_kota = [
            "select" => "*",
            "from" => "regencies",
            "where" => "city_id = $kota"
        ];
        $get_kecamatan = Modules::run("database/get", $array_kota)->result();

        echo json_encode($get_kecamatan);
    }

    public function get_desa() {
        Modules::run("security/is_akax");
        $kecamatan = $this->input->post("kecamatan");

        $array_kecamatan = [
            "select" => "*",
            "from" => "villages",
            "where" => "regency_id = $kecamatan"
        ];
        $get_desa = Modules::run("database/get", $array_kecamatan)->result();

        echo json_encode($get_desa);
    }
    
}