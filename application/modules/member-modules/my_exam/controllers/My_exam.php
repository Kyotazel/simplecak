<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_exam extends CommonController
{
    var $module_name = 'my_exam';
    var $module_directory = 'my_exam';
    var $module_js = ['my_exam'];
    var $app_data = [];

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
        $id_account      = $this->session->userdata('member_id');

        $array_get_exam = [
            "select"    => "c.*, e.name as course_name, e.creator_name as creator_name",
            "from"      => "tb_batch_course_has_account as a",
            "join"      => [
                "tb_account_exam_has_batch_course as b, a.id_batch_course = b.id_batch_course",
                "tb_account_examination as c, b.id_account_exam = c.id",
                "tb_account_exam_has_package as d, c.id = d.id_account_exam",
                "tb_package_question as e, d.id_package_question = e.id"
            ],
            "where"     => "a.id_account = $id_account AND c.status = 1 AND a.status = 2"
        ];

        $get_exam = Modules::run('database/get', $array_get_exam)->result();

        $this->app_data['examination']  = $get_exam;
        $this->app_data['page_title']   = "Ujian Ku";
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function get_exam()
    {
        $id = $this->input->post('id');
        $id_account     = $this->session->userdata('member_id');

        $array_get_exam = [
            "select"    => "a.*, e.name as course_name, e.creator_name as creator_name",
            "from"      => "tb_account_examination as a",
            "join"      => [
                "tb_account_exam_has_package as b, a.id = b.id_account_exam",
                "tb_package_question as e, b.id_package_question = e.id"
            ],
            "where"     => "a.id = $id"
        ];
        
        $get_exam = Modules::run('database/get', $array_get_exam)->row();
        
        $random = '';
        if ($get_exam->random_status == 0) {
            $random = "Soal Tidak Diacak";
        } else {
            $random = "Soal Diacak";
        }
        
        $get_exam_current = Modules::run('database/find', 'tb_participant_exam', ['id_account_exam' => $id, 'id_account' => $id_account])->row();

        if(empty($get_exam_current)) {
            $button = "<button type='button' onclick='join_exam($get_exam->id)' class='btn btn-lg btn-primary' style='width:300px;'><i class='fa fa-check'></i> Ikuti Ujian</button>";
        } else {
            if($get_exam_current->stop_timing > date('Y-m-d H:i:s')) {
                $button = "<button type='button' onclick='join_exam($get_exam->id)' class='btn btn-lg btn-warning' style='width: 300px'><i class='fa fa-clock'></i> Lanjutkan Ujian</button>";
            } else {
                $button = "<button type='button' class='btn btn-lg btn-info' style='width: 300px' disabled><i class='fa fa-times'></i> Telah Selesai Diikuti</button>";
            }
        }

        $html = "
            <div class='row'>
                <div class='col-md-12 text-center'>
                    <h3 class='text-uppercase'>Persiapan Pelaksanaan Ujian</h3>
                    <p>Bacalah petunjuk pelaksanaan ujian dengan teliti, Jika Belum Mengerti Silahkan Bertanya Kepada <b>PENGAWAS UJIAN.</b></p>
                    <hr>
                </div>
            </div>
            <div class='container'>
                <div class='col-md-12'>
                    <h5 align='center'>PETUNJUK UMUM PELAKSANAAN UJIAN</h5>
                    <div>
                    <table  class='table'>
                        <tr>
                        <td>1.</td>
                        <td style='line-height:20px;'>Sebelum Mengerjakan Soal Silahkan Teliti Paket Yang anda pilih memang sesuai dengan ujian yang diadakan oleh pengawas ujian.</td>
                        </tr>
                        <tr>
                        <td>2.</td>
                        <td style='line-height:20px;'>pada tiap-tiap soal ujian terdapat 5 pilihan ganda yang dapat dipilih oleh peserta ujian, <b>Pilih Jawaban dengan Teliti</b></td>
                        </tr>
                        <tr>
                        <td>3.</td>
                        <td style='line-height:20px;'>Dilarang menggunakan alat bantu hitung elektronik.</td>
                        </tr>
                        <tr>
                        <td>4.</td>
                        <td style='line-height:20px;'>Perhatikanlah 'waktu yang berjalan' yang terdapat pada halaman ujian anda.</td>
                        </tr>
                        <tr>
                        <td>5.</td>
                        <td style='line-height:20px;'>Waktu Pelaksanaan Ujian akan bergantung pada waktu ujian pada masing-masing acara ujian.</td>
                        </tr>
                        <tr>
                        <td>6.</td>
                        <td style='line-height:20px;'>Sistem akan secara otomatis  menyimpan hasil ujian anda jika waktu pengerjaan ujian telah habis.</td>
                        </tr>
                    </table>
                    </div>
                    <hr>
                </div>
                <div class='col-md-12'>
                    <div class='col-md-12' align='center'>
                        <h3 align='center'><i class='mdi mdi-check-all icon-sm text-primary align-self-center'></i> $get_exam->name </h3>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-md-4' style='font-size:14px;' align='center'>
                        <i class='icon-check text-primary'></i> Mata Pelajaran :<br> <label style='font-size:15px;' class='badge badge-info text-light'>$get_exam->course_name</label>
                        </div> 
                        <div class='col-md-4' style='font-size:14px;' align='center'>
                            <i class='icon-check text-primary'></i> status Acak Soal :<br> <label style='font-size:15px;' class='badge badge-info text-light'>$random</label>
                        </div> 
                        <div class='col-md-4' style='font-size:14px;' align='center'>
                        <i class='icon-check text-primary'></i> Waktu :<br> <label style='font-size:20px;' class='badge badge-info text-light'>$get_exam->processing_time Menit</label>
                        </div> 
                    </div>  
                    <hr>
                    <div class='col-md-12' align='center'>
                        <p>Klik <b>Ikuti Ujian</b> Dibawah untuk mengikuti ujian.</p>
                        $button
                    </div>
                </div>
            </div>
        ";

        $data = [
            "html"  => $html,
            "title" => "Tes Judul"
        ];

        echo json_encode($data);
    }

    public function save_exam_participant()
    {
        $id_account     = $this->session->userdata('member_id');
        $id_exam        = $this->input->post('id');
        $get_package    = Modules::run('database/find', 'tb_account_exam_has_package', ['id_account_exam' => $id_exam])->row();
        $id_package     = $get_package->id_package_question;
        $time           = time();

        $get_data_account_exam_program = Modules::run('database/find', 'tb_account_examination', ['id' => $id_exam])->row();

        $array_get_package = [
            "select"    => "id",
            "from"      => "tb_package_question_has_detail",
            "where"     => "id_parent = $id_package"
        ];

        if ($get_data_account_exam_program->random_status == 1) {
            $array_get_package = array_merge($array_get_package, ["order_by" => "RAND()"]);
        }

        $processing_time = $get_data_account_exam_program->processing_time;

        $stop_timing = strtotime("+$processing_time minutes");
        $stop_timing = date('Y-m-d H:i:s', $stop_timing);

        $get_random_package = Modules::run('database/get', $array_get_package);

        $detail_line_question = json_encode($get_random_package->result());
        if ($get_random_package->num_rows() == 0) {
            $each_value_question =  100;
        } else {
            $each_value_question =  100 / $get_random_package->num_rows();
        }
        //insert data
        $array_insert = [
            'id_account_exam' => $id_exam,
            'id_account' => $id_account,
            'id_package_question' => $id_package,
            'detail_line_question' => $detail_line_question,
            'each_value_question' => $each_value_question,
            'start_time' => $time,
            'stop_timing' => $stop_timing,
            'status' => 1,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id_account
        ];

        $get_exam_current = Modules::run('database/find', 'tb_participant_exam', ['id_account_exam' => $id_exam, 'id_account' => $id_account])->row();

        if (empty($get_exam_current)) {
            Modules::run('database/insert', 'tb_participant_exam', $array_insert);
            $get_exam_current = Modules::run('database/find', 'tb_participant_exam', ['id_account_exam' => $id_exam, 'id_account' => $id_account])->row();
            // create session
            $this->session->set_userdata('session_examination_student', $get_exam_current->id);
        }
        //create account data
        echo json_encode(array('status' => TRUE));
    }
}
