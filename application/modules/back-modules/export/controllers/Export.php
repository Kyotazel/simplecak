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
        $data['user'] = Modules::run('database/find', 'tb_account', ['id' => 28])->row();
        $html = $this->load->view('print', $data, TRUE);
        $pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'en', true, 'UTF-8', [10,10,10,0]);
        $pdf->WriteHTML($html);
        $pdf->Output('laporan_dosen_mengajar.pdf', 'I');
    }

    public function print_cv()
    {
        $data['tes'] = "tes";
        $html = $this->load->view('cv', $data, TRUE);
        $pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en', true, 'UTF-8', [16,16,16,16]);
        $pdf->WriteHTML($html);
        $pdf->Output('contoh_cv.pdf', 'I');
    }

    public function check_cv()
    {
        echo $this->load->view('cv');
    }

}
