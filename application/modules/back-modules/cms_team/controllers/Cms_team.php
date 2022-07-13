<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms_team extends BackendController
{
    var $module_name        = 'cms_team';
    var $module_directory   = 'cms_team';
    var $module_js          = ['cms_team'];
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
        $this->app_data['page_title'] = "CMS TEAM";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function load_data()
    {
        Modules::run('security/is_ajax');
        $get_all = Modules::run('database/find', 'tb_cms_team', ['isDeleted' => 'N'])->result();
        $html_respon = '';
        foreach ($get_all as $item_data) {
            $active = $item_data->status ? 'on' : '';
            $html_respon .= '
                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                    <div class="card">
                        <div class="card-body text-center ">
                            <div class="main-img-user profile-user" style="width:150px;height:150px;">
                                <img alt="" src="' . base_url('upload/team/' . $item_data->image) . '">
                            </div>
                            <div class="d-flex justify-content-center mg-b-20">
                                <div>
                                    <h5 class="main-profile-name text-capitalize">' . $item_data->name . '</h5>
                                    <p class="main-profile-name-text">' . $item_data->position . '</p>
                                </div>
                            </div>
                            <div class="text-center d-flex justify-content-center">
                                <a href="javascript:void(0)" data-id="' . $item_data->id . '" class="btn btn-sm btn-danger btn_delete ml-1 mr-1"><i class="fa fa-trash"></i> Hapus</a>
                                <a href="javascript:void(0)" data-id="' . $item_data->id . '" class="btn btn-sm btn-info  btn_edit ml-1 mr-1"><i class="fa fa-edit"></i> Update</a>
                                <div data-menu="horizontal" data-id="' . $item_data->id . '" class="main-toggle main-toggle-dark change_status ' . $active . '  ml-1 mr-1"><span></span></div>
                            </div>
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


    private function validate_save()
    {
        Modules::run('security/is_ajax');
        $data = array();

        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->input->post('name') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'name';
            $data['status'] = FALSE;
        }

        if ($this->input->post('position') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'position';
            $data['status'] = FALSE;
        }
        if ($_FILES['media']['name'] == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'media';
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
        $name    = $this->input->post('name');
        $position   = $this->input->post('position');

        $array_insert = [
            'name' => $name,
            'position' => $position,
            'status' => 1,
            'isDeleted' => 'N',
        ];
        if (!empty($_FILES['media']['name'])) {
            $image_name = $this->upload_image();
            $array_insert['image'] = $image_name;
        }

        Modules::run('database/insert', 'tb_cms_team', $array_insert);
        echo json_encode(['status' => true]);
    }

    private function upload_image()
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/team');
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('media')) //upload and validate
        {
            $data['inputerror'][] = 'media';
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

    public function get_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_data = Modules::run('database/find', 'tb_cms_team', ['id' => $id])->row();
        echo json_encode($get_data);
    }

    public function update()
    {
        Modules::run('security/is_ajax');
        $this->validate_save();

        $id     = $this->input->post('id');
        $name    = $this->input->post('name');
        $position   = $this->input->post('position');


        $array_update = [
            'name' => $name,
            'position' => $position
        ];

        if (!empty($_FILES['media']['name'])) {
            $image_name = $this->upload_image();
            $array_update['image'] = $image_name;
        }
        Modules::run('database/update', 'tb_cms_team', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $array_update = ['isDeleted' => 'Y'];
        Modules::run('database/update', 'tb_cms_team', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function update_status()
    {
        Modules::run('security/is_ajax');
        $status = $this->input->post('status');
        $id     = $this->input->post('id');

        Modules::run('database/update', 'tb_cms_team', ['id' => $id], ['status' => $status]);
        echo json_encode(['status' => true]);
    }

    public function export_excel()
    {
        $array_query = [
            'select' => '
                mst_ship.*
            ',
            'from' => 'mst_ship',
            'where' => ['isDeleted' => 'N'],
            'order_by' => 'id, DESC'
        ];
        $get_data = Modules::run('database/get', $array_query)->result();
        error_reporting(0);
        $this->load->library("PHPExcel");
        //membuat objek
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet = $objPHPExcel->getActiveSheet();
        //set column 
        $sheet->getColumnDimension('A')->setWidth('5');
        $sheet->getColumnDimension('B')->setWidth('20');
        $sheet->getColumnDimension('C')->setWidth('50');
        $sheet->getColumnDimension('D')->setWidth('20');
        $sheet->getColumnDimension('E')->setWidth('20');
        $sheet->getColumnDimension('F')->setWidth('20');

        //bold style 
        $sheet->getStyle("A1:F2")->getFont()->setBold(true);
        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        //marge and center
        $sheet->mergeCells('A1:F2');
        $sheet->getStyle('A1:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:F2')->getFont()->setSize(18);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN DATA KAPAL');
        $sheet->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //sheet table resume 
        $from = "A3"; // or any value
        $to = "M3"; // or any value
        $objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'No');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'KODE KAPAL');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', 'KAPAL');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', 'BATAS TONASE (GT)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', 'BATAS KONTAINER');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', 'TANGGAL BELI');
        $sheet_number_resume = 3;
        $no = 0;

        $objPHPExcel->getActiveSheet()->getStyle('A' . $sheet_number_resume . ':F' . $sheet_number_resume)
            ->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle('A' . $sheet_number_resume . ':F' . $sheet_number_resume)->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '366092')
                ),
                'font'  => array(
                    'bold'  => true,
                    'color' => array('rgb' => 'FFFFFF'),
                    'size'  => 12
                )
            )
        );

        foreach ($get_data as $data_table) {
            $sheet_number_resume++;
            $no++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $sheet_number_resume, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $sheet_number_resume, $data_table->code);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $sheet_number_resume, strtoupper($data_table->name));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $sheet_number_resume, $data_table->tonase_limit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $sheet_number_resume, $data_table->container_slot);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $sheet_number_resume, Modules::run('helper/date_indo', $data_table->date_buy, '-'));
            $objPHPExcel->getActiveSheet()->getStyle('A' . $sheet_number_resume . ':F' . $sheet_number_resume)
                ->applyFromArray($styleThinBlackBorderOutline);
        }
        //Set Title
        $objPHPExcel->getActiveSheet()->setTitle('LAPORAN DATA KAPAL');
        //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //Header
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //Nama File
        header('Content-Disposition: attachment;filename="LAPORAN DATA KAPAL PER ' . date('d-m-Y') . '.xlsx"');
        //Download
        $objWriter->save("php://output");
    }

    public function export_pdf()
    {
        $array_query = [
            'select' => '
                mst_ship.*
            ',
            'from' => 'mst_ship',
            'where' => ['isDeleted' => 'N'],
            'order_by' => 'id, DESC'
        ];
        $get_data = Modules::run('database/get', $array_query)->result();

        error_reporting(0);
        ob_clean();
        $data['data_ship'] = $get_data;
        //print_r($data['data_profile']);
        //exit;
        ob_start();
        $this->load->view('pdf_ship', $data);
        //print_r($html);
        //exit;
        $html = ob_get_contents();
        ob_end_clean();
        require_once('../assets/plugin/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('P', 'A4', 'en');
        $pdf->WriteHTML($html);
        $pdf->Output('LAPORAN DATA KAPAL PER -' . date('d-m-Y') . '.pdf', 'D');
    }
}
