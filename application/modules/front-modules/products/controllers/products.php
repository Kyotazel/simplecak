<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends BackendController
{
    var $module_name        = 'products';
    var $module_directory   = 'products';
    var $module_js          = ['products'];
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
        $this->app_data['page_title'] = "Produk - Web Developer";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }
    public function website_custom()
    {
        $this->app_data['page_title'] = "web custom";
        $this->app_data['view_file'] = 'view_webcustom';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
    public function pointtech()
    {
        $this->app_data['page_title'] = "pointtech";
        $this->app_data['view_file'] = 'view_pointtech';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
    public function ngabsen()
    {
        $this->app_data['page_title'] = "ngabsen";
        $this->app_data['view_file'] = 'view_ngabsen';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
    public function sijapri()
    {
        $this->app_data['page_title'] = "sijapri";
        $this->app_data['view_file'] = 'view_sijapri';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
    public function grosales()
    {
        $this->app_data['page_title'] = "grosales";
        $this->app_data['view_file'] = 'view_grosales';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
    public function payroll()
    {
        $this->app_data['page_title'] = "payroll";
        $this->app_data['view_file'] = 'view_payroll';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
    public function ekspedisi()
    {
        $this->app_data['page_title'] = "Ekspedisi";
        $this->app_data['view_file'] = 'view_ekspedisi';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
    public function signage()
    {
        $this->app_data['page_title'] = "signage";
        $this->app_data['view_file'] = 'view_signage';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
    public function ecommerce()
    {
        $this->app_data['page_title'] = "Toko Online / E-commerce";
        $this->app_data['view_file'] = 'view_ecommerce';
        echo Modules::run('template/main_layout_dark', $this->app_data);
    }
}
