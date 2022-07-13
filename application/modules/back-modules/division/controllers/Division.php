<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Division extends BackendController
{
    var $module_name        = 'division';
    var $module_directory   = 'division';
    var $module_js          = ['division'];
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
        $this->app_data['page_title'] = "Devisi Pegawai";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run('security/is_ajax');
        $array_query = [
            'select' => '
                mst_employee_division.*
            ',
            'from' => 'mst_employee_division',
            'where' => ['isDeleted' => 'N'],
            'order_by' => 'id, DESC'
        ];

        $get_data = Modules::run('database/get', $array_query)->result();
        $no = 0;
        $data = [];
        foreach ($get_data as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);
            $btn_delete     = Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-danger btn_delete"><i class="las la-trash"></i> </a>');
            $btn_edit     = Modules::run('security/edit_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-info btn_edit"><i class="las la-pen"></i> </a>');

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->name;
            $row[] = $btn_edit . $btn_delete;
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );
        echo json_encode($ouput);
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
        } else {
            if (strlen($this->input->post('name')) < 5) {
                $data['error_string'][] = 'min 5 karakter';
                $data['inputerror'][] = 'name';
                $data['status'] = FALSE;
            }
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

        $array_insert = [
            'name' => $name,
            'created_by' => $this->session->userdata('us_id'),
            'created_date' => date('Y-m-d H:i:s'),
            'isDeleted' => 'N'
        ];

        Modules::run('database/insert', 'mst_employee_division', $array_insert);
        echo json_encode(['status' => true]);
    }

    public function get_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post('id'));
        $get_data = Modules::run('database/find', 'mst_employee_division', ['id' => $id])->row();
        echo json_encode($get_data);
    }

    public function update()
    {
        Modules::run('security/is_ajax');
        $this->validate_save();

        $id     = $this->input->post('id');
        $name    = $this->input->post('name');

        $array_update = [
            'name' => $name,
            'updated_by' => $this->session->userdata('us_id')
        ];

        Modules::run('database/update', 'mst_employee_division', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post('id'));
        $array_update = ['isDeleted' => 'Y'];
        Modules::run('database/update', 'mst_employee_division', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function print()
    {
        $array_query = [
            'select' => '
            mst_employee_division.*
        ',
            'from' => 'mst_employee_division',
            'where' => ['isDeleted' => 'N'],
            'order_by' => 'id, DESC'
        ];

        $get_data = Modules::run('database/get', $array_query)->result();

        if ($this->input->post('print_excel')) {
            $this->export_excel($get_data);
        }
        if ($this->input->post('print_pdf')) {
            $this->export_pdf($get_data);
        }
    }

    public function export_excel($data)
    {
        error_reporting(0);
        $this->load->library("PHPExcel");
        //membuat objek
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet = $objPHPExcel->getActiveSheet();
        //set column 
        $sheet->getColumnDimension('A')->setWidth('5');
        $sheet->getColumnDimension('B')->setWidth('80');

        //bold style 
        $sheet->getStyle("A1:C2")->getFont()->setBold(true);
        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        // //marge and center
        $sheet->mergeCells('A1:B2');
        $sheet->getStyle('A1:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:B2')->getFont()->setSize(18);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN DAFTAR DEVISI');
        $sheet->getStyle('A3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //sheet table resume 
        $from = "A3"; // or any value
        $to = "B3"; // or any value
        $objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'No');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'NAMA DEVISI');
        $sheet_number_resume = 3;
        $no = 0;

        $objPHPExcel->getActiveSheet()->getStyle('A' . $sheet_number_resume . ':B' . $sheet_number_resume)
            ->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle('A' . $sheet_number_resume . ':B' . $sheet_number_resume)->applyFromArray(
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

        foreach ($data as $data_table) {

            $sheet_number_resume++;
            $no++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $sheet_number_resume, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $sheet_number_resume, $data_table->name);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $sheet_number_resume . ':B' . $sheet_number_resume)
                ->applyFromArray($styleThinBlackBorderOutline);
        }
        //Set Title
        $objPHPExcel->getActiveSheet()->setTitle('LAPORAN DATA');
        //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //Header
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //Nama File
        header('Content-Disposition: attachment;filename="LAPORAN DAFTAR DEVISI PER ' . date('d-m-Y') . '.xlsx"');
        //Download
        $objWriter->save("php://output");
    }

    public function export_pdf($list_data)
    {
        error_reporting(0);
        ob_clean();
        $data['data_position'] = $list_data;
        ob_start();
        $this->load->view('pdf_division', $data);
        $html = ob_get_contents();
        ob_end_clean();
        require_once('../assets/plugin/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 5));
        $pdf->WriteHTML($html);
        $pdf->Output('LAPORAN DAFTAR DEVISI PER -' . date('d-m-Y') . '.pdf', 'D');
    }
}
