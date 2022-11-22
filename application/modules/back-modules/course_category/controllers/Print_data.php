
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Print_data extends BackendController
{
    var $module_name        = 'course_category';
    var $module_directory   = 'course_category';
    var $module_js          = ['course_category','print'];
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

    public function print_data()
    {
        $data_print = $this->input->post('data');
        $document   = $this->input->post('document');

        $url_pdf    = Modules::run('helper/create_url', $this->module_name . '/print_data/export_pdf_data');
        $url_excel  = Modules::run('helper/create_url', $this->module_name . '/print_data/export_excel_data');
        $html_iframe = '
            <div class=col-12 p-0>
                <iframe name="iframe1" style="width: 100%;min-height:900px;border-style: none" src="' . $url_pdf . '"></iframe>
            </div>
        ';
        echo json_encode(["status" => TRUE, "html_respon" => $html_iframe, "url" => $url_excel]);
    }

    public function export_pdf_data()
    {
        error_reporting(0);
        ob_clean();
        $data_print =  json_decode($this->encrypt->decode($this->session->userdata("print_data")), TRUE);
        $data['company'] = [
            'name' => Modules::run('database/find', 'app_setting', ['field' => 'company_name'])->row()->value,
            'company_tagline' => Modules::run('database/find', 'app_setting', ['field' => 'company_tagline'])->row()->value,
            'company_email' => Modules::run('database/find', 'app_setting', ['field' => 'company_email'])->row()->value,
            'company_number_phone' => Modules::run('database/find', 'app_setting', ['field' => 'company_number_phone'])->row()->value,
            'company_address' => Modules::run('database/find', 'app_setting', ['field' => 'company_address'])->row()->value,
            'company_logo' => Modules::run('database/find', 'app_setting', ['field' => 'company_logo'])->row()->value
        ];

        $data_print     =  json_decode($this->encrypt->decode($this->session->userdata("print_data")), TRUE);
        $get_data_print = []; // set your query here
        $filter_data    = $data_print["filter"];

        $data["get_data_print"] = $get_data_print;
        $data["filter_data"] = $filter_data;
        ob_start();
        $this->load->view("print/pdf_data", $data);
        $html = ob_get_contents();
        ob_end_clean();
        require_once("../assets/plugin/html2pdf/html2pdf.class.php");
        $pdf = new HTML2PDF("P", "A4", "en", true, "UTF-8", array(2, 2, 2, 2));
        $pdf->setTestTdInOnePage(false);
        $pdf->WriteHTML($html);
        $pdf->Output("LAPORAN test.pdf", "R");
    }

    public function export_excel_data()
    {

        $data_print     =  json_decode($this->encrypt->decode($this->session->userdata('print_data')), TRUE);
        // $get_data_print = Modules::run('database/get', $data_print['query'])->result();
        $get_data_print = [];
        $filter_data    = isset($data_print['filter']) ? $data_print['filter'] : [];

        $company = [
            'name' => Modules::run('database/find', 'app_setting', ['field' => 'company_name'])->row()->value,
            'company_tagline' => Modules::run('database/find', 'app_setting', ['field' => 'company_tagline'])->row()->value,
            'company_email' => Modules::run('database/find', 'app_setting', ['field' => 'company_email'])->row()->value,
            'company_number_phone' => Modules::run('database/find', 'app_setting', ['field' => 'company_number_phone'])->row()->value,
            'company_address' => Modules::run('database/find', 'app_setting', ['field' => 'company_address'])->row()->value,
            'company_logo' => Modules::run('database/find', 'app_setting', ['field' => 'company_logo'])->row()->value
        ];

        error_reporting(0);
        $this->load->library("PHPExcel");
        //membuat objek
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet = $objPHPExcel->getActiveSheet();
        //set column 
        $sheet->getColumnDimension('A')->setWidth('5');
        $sheet->getColumnDimension('B')->setWidth('15');
        $sheet->getColumnDimension('C')->setWidth('60');
        $sheet->getColumnDimension('D')->setWidth('30');
        $sheet->getColumnDimension('E')->setWidth('20');

        $start_column = 'A';
        $end_column = 'E';
        // //bold style 
        $sheet->getStyle($start_column . '1:' . $end_column . '2')->getFont()->setBold(true);
        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $sheet_number_resume = 0;
        //create Header report
        $sheet_number_resume++;
        $sheet->mergeCells($start_column . $sheet_number_resume . ':' . $end_column . $sheet_number_resume);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($start_column . $sheet_number_resume, $company['name']);
        $sheet->getStyle($start_column . $sheet_number_resume . ':' . $end_column . $sheet_number_resume)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $sheet_number_resume++;
        $sheet->mergeCells($start_column . $sheet_number_resume . ':' . $end_column . $sheet_number_resume);
        $sheet->getStyle($start_column . '1:' . $end_column . ($sheet_number_resume + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($start_column . '1:' . $end_column . ($sheet_number_resume + 1))->getFont()->setSize(12);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $sheet_number_resume, 'LAPORAN DATA');

        //create filter
        $sheet_number_resume++;
        $sheet->mergeCells($start_column . $sheet_number_resume . ':B' . $sheet_number_resume);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $sheet_number_resume, 'Filter Data:');
        foreach ($filter_data as $item_filter) {
            $sheet_number_resume++;
            $sheet->mergeCells($start_column . $sheet_number_resume . ':B' . $sheet_number_resume);
            $sheet->mergeCells('C' . $sheet_number_resume . ':' . $end_column . $sheet_number_resume);
            $sheet->getStyle("C" . $sheet_number_resume . ':C' . $sheet_number_resume)->getFont()->setBold(true);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $sheet_number_resume, $item_filter['label']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $sheet_number_resume, ': ' . $item_filter['value']);
        }
        // create header table
        $sheet_number_resume++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $sheet_number_resume, 'NO');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $sheet_number_resume, 'TANGGAL');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $sheet_number_resume, 'KETERANGAN');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $sheet_number_resume, 'NOMINAL');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $sheet_number_resume, 'TGL INPUT');

        $objPHPExcel->getActiveSheet()->getStyle($start_column . $sheet_number_resume . ':' . $end_column . $sheet_number_resume)
            ->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle($start_column . $sheet_number_resume . ':' . $end_column . $sheet_number_resume)
            ->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle($start_column . $sheet_number_resume . ':' . $end_column . $sheet_number_resume)->applyFromArray(
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

        // create content
        $counter = 0;
        foreach ($get_data_print as $item_data) {
            $counter++;
            $sheet_number_resume++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $sheet_number_resume, $counter);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $sheet_number_resume, $item_data->date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $sheet_number_resume, $item_data->description);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $sheet_number_resume, $item_data->price);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $sheet_number_resume, $item_data->created_date);

            $objPHPExcel->getActiveSheet()->getStyle($start_column . $sheet_number_resume . ':' . $end_column . $sheet_number_resume)
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
        header('Content-Disposition: attachment;filename="LAPORAN DATA.xlsx"');
        //Download
        $objWriter->save("php://output");
    }
}
