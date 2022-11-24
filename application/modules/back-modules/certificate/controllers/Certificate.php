<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificate extends BackendController
{
    var $module_name = 'certificate';
    var $module_directory = 'certificate';
    var $module_js = ['certificate'];
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
        $this->app_data['page_title']     = "Sertifikat Pelatihan";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");
        $array_query = [
            "select" => "a.*",
            "from" => "tb_batch_course a",
            'order_by' => 'a.id, DESC'
        ];
        $get_all = Modules::run('database/get', $array_query)->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {

            $get_before = $this->db->query("SELECT COUNT(*) as total FROM tb_batch_course_has_account
             WHERE id_account NOT IN (SELECT id_account FROM tb_account_has_certificate) AND id_batch_course = $data_table->id AND status=5")->row();

            $array_after = [
                "select" => "COUNT(*) as total",
                "from" => "tb_account_has_certificate",
                "where" => "id_batch_course = $data_table->id"
            ];
            $get_after = Modules::run('database/get', $array_after)->row();

            $url_before = Modules::run('helper/create_url', "certificate/detail_before/$data_table->id");
            $url_after = Modules::run('helper/create_url', "certificate/detail_after/$data_table->id");

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->title;
            $row[] = "<span class='text-info'><i class='fa fa-users'></i> $get_after->total Peserta </span> <a href='$url_after' class='btn btn-light btn-sm' data-id=$data_table->id style='background-color: white;'><i class='fa fa-arrow-right text-dark'></></a>";
            $row[] = "<span class='text-info'><i class='fa fa-users'></i> $get_before->total Peserta </span> <a href='$url_before' class='btn btn-light btn-sm' data-id=$data_table->id style='background-color: white;'><i class='fa fa-arrow-right text-dark'></></a>";
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        echo json_encode($ouput);
    }

    public function detail_before($id_batch_course)
    {
        $this->app_data['id_batch_course']     = $id_batch_course;
        $this->app_data['pelatihan']     = Modules::run('database/find', 'tb_batch_course', ['id' => $id_batch_course])->row()->title;
        $this->app_data['page_title']     = "Belum Sertifikat";
        $this->app_data['view_file']     = 'before_certificate';
        $this->app_data['module_js']  = ['before'];
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_before($id_batch_course)
    {
        Modules::run("security/is_ajax");
        $get_all = $this->db->query("SELECT a.*, b.name as name FROM tb_batch_course_has_account a
            LEFT JOIN tb_account b ON a.id_account = b.id
             WHERE id_account NOT IN (SELECT id_account FROM tb_account_has_certificate) AND a.id_batch_course = $id_batch_course AND a.status = 5")->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->name;
            $row[] = "<button class='btn btn-success btn-sm btn_generate' data-id=$data_table->id><i class='fa fa-gear'></i> Generate</button>";
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        echo json_encode($ouput);
    }

    public function detail_after($id_batch_course)
    {
        $this->app_data['id_batch_course']     = $id_batch_course;
        $this->app_data['pelatihan']     = Modules::run('database/find', 'tb_batch_course', ['id' => $id_batch_course])->row()->title;
        $this->app_data['page_title']     = "Belum Sertifikat";
        $this->app_data['view_file']     = 'after_certificate';
        $this->app_data['module_js']  = ['after'];
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_after($id_batch_course)
    {
        Modules::run("security/is_ajax");
        $get_all = Modules::run('database/find', 'tb_account_has_certificate', ['id_batch_course' => $id_batch_course])->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {

            $get_account = Modules::run('database/find', 'tb_account', ['id' => $data_table->id_account])->row();

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $get_account->name;
            $row[] = "<a href='" . base_url('upload/certificate/' . $data_table->file) . "' target='_blank' class='btn btn-success btn-sm' data-id=$data_table->id>Lihat Sertifikat <i class='fa fa-arrow-right'></i></a>";
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        echo json_encode($ouput);
    }

    private function _validate_generate()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');

        if ($this->input->post('no_peserta') == '') {
            $data['error_string'][] = 'No Peserta Harus Diisi';
            $data['inputerror'][] = 'no_peserta';
            $data['status'] = FALSE;
        }
        if ($this->input->post('no_sk') == '') {
            $data['error_string'][] = 'No Surat Keputusan Harus Diisi';
            $data['inputerror'][] = 'no_sk';
            $data['status'] = FALSE;
        }
        if ($this->input->post('jp') == '') {
            $data['error_string'][] = 'Jam Pelajaran Harus Diisi';
            $data['inputerror'][] = 'jp';
            $data['status'] = FALSE;
        }
        if ($this->input->post('certified_date') == '') {
            $data['error_string'][] = 'Tanggal Sertifikasi Harus Diisi';
            $data['inputerror'][] = 'certified_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('exp_date') == '') {
            $data['error_string'][] = 'Tanggal Expired Harus Diisi';
            $data['inputerror'][] = 'exp_date';
            $data['status'] = FALSE;
        }
        if ($this->input->post('sk_date') == '') {
            $data['error_string'][] = 'Tanggal Expired Harus Diisi';
            $data['inputerror'][] = 'sk_date';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function generate()
    {
        $this->_validate_generate();
        $id = $this->input->post('id');
        $no_peserta = $this->input->post('no_peserta');
        $no_sk = $this->input->post('no_sk');
        $jp = $this->input->post('jp');
        $certificate_date = $this->input->post('certified_date');
        $expired_date = $this->input->post('exp_date');
        $sk_date = $this->input->post('sk_date');
        $kompeten = $this->input->post('kompeten');

        $kompetensi = '';
        $kompetensi_en = '';
        if ($kompeten) {
            $kompetensi = 'dan dinyatakan KOMPETEN';
            $kompetensi_en = 'and Declared COMPETENT';
        }

        $array_query = [
            "select" => "b.*, c.*, d.name as course_name, c.image as photo, b.id as id_batch_course, c.id as id_account",
            "from" => "tb_batch_course_has_account a",
            "join" => [
                'tb_batch_course b, a.id_batch_course = b.id, left',
                'tb_account c, a.id_account = c.id, left',
                'tb_course d, b.id_course = d.id, left'
            ],
            "where" => ['a.id' => $id]
        ];
        $get_data = Modules::run('database/get', $array_query)->row();

        $array_key = [
            'id' => $get_data->id,
            'id_account' => $get_data->id_account,
            'id_batch_course' => $get_data->id_batch_course,
        ];

        $encrypted_url = base_url("certificate/check/");
        $encrypted_url .= urlencode(base64_encode(json_encode($array_key)));

        $qrcode = $this->create_qr_code($encrypted_url);

        $data['data'] = $get_data;
        $data['no_peserta'] = $no_peserta;
        $data['no_sk'] = $no_sk;
        $data['jp'] = $jp;
        $data['sk_date'] = $sk_date;
        $data['kompetensi'] = $kompetensi;
        $data['qrcode'] = $qrcode;
        $data['kompetensi_en'] = $kompetensi_en;
        $html = $this->load->view('print', $data, TRUE);
        // echo $this->load->view('print', $data, TRUE);
        $filename = time();
        $path = FCPATH . '../upload/certificate/';
        $pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'en', true, 'UTF-8', [10, 10, 10, 0]);
        $pdf->WriteHTML($html);
        $pdf->Output($path . $filename . '.pdf', 'F');

        $array_insert = [
            "id_account" => $get_data->id_account,
            "id_batch_course" => $get_data->id_batch_course,
            "file" => $filename . ".pdf",
            "certificate_date" => $certificate_date,
            "expired_date" => $expired_date,
        ];

        Modules::run('database/insert', 'tb_account_has_certificate', $array_insert);

        Modules::run('database/update', 'tb_account', ['id' => $get_data->id_account], ['is_alumni' => 1]);

        echo json_encode(['status' => true]);
    }

    private function create_qr_code($code)
    {
        error_reporting(0);
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = '../upload/'; //string, the default is application/cache/
        $config['errorlog']     = '../upload/'; //string, the default is application/logs/
        $config['imagedir']     = '../upload/barcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
        $image_name = time() . '.png'; //buat name dari qr code sesuai dengan nim
        $params['data'] = $code; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir']  . $image_name; //simpan image QR CODE ke folder assets/images/


        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        return $image_name;
    }
}
