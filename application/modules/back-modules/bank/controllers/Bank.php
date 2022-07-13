<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank extends BackendController
{
    var $module_name        = 'bank';
    var $module_directory   = 'bank';
    var $module_js          = ['bank'];
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
        $this->app_data['page_title'] = "Master Bank";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run('security/is_ajax');
        $array_query = [
            'select' => '
                mst_bank.*
            ',
            'from' => 'mst_bank',
            'where' => ['isDeleted' => 'N'],
            'order_by' => 'id, DESC'
        ];

        $get_data = Modules::run('database/get', $array_query)->result();
        $no = 0;
        $data = [];
        foreach ($get_data as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);
            $btn_delete     = Modules::run('security/delete_access', ' 
                <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-danger btn_delete"><i class="las la-trash"></i> </a>
            ');

            $btn_edit     = Modules::run('security/edit_access', ' 
            <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-info btn_edit"><i class="las la-pen"></i> </a>
            ');

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ' <img style="width:100px;" src="' . base_url('upload/bank/' . $data_table->image) . '" alt=""> ';
            $row[] = $data_table->name;
            $row[] = $data_table->account_owner;
            $row[] = $data_table->account_number;
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
        }

        if ($this->input->post('account_number') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'account_number';
            $data['status'] = FALSE;
        }

        if ($this->input->post('account_name') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'account_name';
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
        $account_number   = $this->input->post('account_number');
        $account_name   = $this->input->post('account_name');


        $array_insert = [
            'name' => $name,
            'account_number' => $account_number,
            'account_owner' => $account_name,
            'isDeleted' => 'N',
        ];
        if (!empty($_FILES['media']['name'])) {
            $image_name = $this->upload_image();
            $array_insert['image'] = $image_name;
        }

        Modules::run('database/insert', 'mst_bank', $array_insert);
        echo json_encode(['status' => true]);
    }

    private function upload_image()
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/bank');
        $config['allowed_types']        = 'gif|jpg|png';
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

    public function get_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post('id'));
        $get_data = Modules::run('database/find', '	mst_bank', ['id' => $id])->row();
        echo json_encode($get_data);
    }

    public function update()
    {
        Modules::run('security/is_ajax');
        $this->validate_save();

        $id     = $this->input->post('id');
        $name    = $this->input->post('name');
        $account_number   = $this->input->post('account_number');
        $account_name   = $this->input->post('account_name');

        $array_update = [
            'name' => $name,
            'account_number' => $account_number,
            'account_owner' => $account_name
        ];

        if (!empty($_FILES['media']['name'])) {
            $image_name = $this->upload_image();
            $array_update['image'] = $image_name;
        }
        Modules::run('database/update', 'mst_bank', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function delete_data()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post('id'));
        $array_update = ['isDeleted' => 'Y'];
        Modules::run('database/update', 'mst_bank', ['id' => $id], $array_update);
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
