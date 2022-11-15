<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Spipu\Html2Pdf\Html2Pdf;

class Export extends BackendController
{
    var $module_name        = 'export';
    var $module_directory   = 'export';
    var $module_js          = ['export'];
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
        $this->app_data['page_title']   = 'dashboard';
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function print_pdf()
    {
        $data = [];
        $html = $this->load->view('print', $data, TRUE);
        $pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'en', true, 'UTF-8', [10,10,10,0]);
        $pdf->WriteHTML($html);
        $pdf->Output('laporan_dosen_mengajar.pdf', 'I');
    }

    public function check_pdf()
    {
        echo $this->load->view('print');
    }

}
