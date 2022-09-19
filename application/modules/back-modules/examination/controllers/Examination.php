<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Examination extends BackendController
{
    var $module_name = 'examination';
    var $module_directory = 'examination';
    var $module_js = ['examination'];
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
        $array_active_batch_registration   = [
            "select"    => "*",
            "from"      => "tb_batch_course",
            "where"     => "opening_registration_date < '" . date('Y-m-d') . "' AND closing_registration_date > '" . date('Y-m-d') . "'"
        ];

        $this->app_data['batch_registration'] = Modules::run('database/get', $array_active_batch_registration)->result();
        $this->app_data['package_category'] = Modules::run('database/get_all', 'tb_package_category')->result();
        $this->app_data['page_title']    = "Data Ujian Online";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run("security/is_ajax");

        $array_get_all = [
            "select"    => "a.*, b.name as type_question_name",
            "from"      => "tb_account_examination as a",
            "join"      => [
                "tb_package_category as b, a.id_type_question = b.id"
            ],
            "where"     => "a.status = 0",
            "order"     => 'a.id, DESC'
        ];

        $get_all_data = Modules::run('database/get', $array_get_all)->result();

		$data = array();
		$no = 0;
		foreach ($get_all_data as $data_table) {
			//label status
			if($data_table->status==0){
				$label_status = '<div class="btn btn-sm btn-outline-primary">Belum Dibuka</div>';
			}elseif ($data_table->status==1) {
				$label_status = '<div class="btn btn-sm btn-outline-warning">Sedang Berlangsung</div>';
			}elseif ($data_table->status==2) {
				$label_status = '<div class="btn btn-sm btn-outline-success">Selesai</div>';
			}else{
				$label_status = '<div class="btn btn-sm btn-outline-danger">Dibatalkan</div>';
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[]= $data_table->name;
			$row[]= $data_table->type_question_name;
			$row[]= $label_status;
			$row[] = '<a class="btn btn-outline-primary" href="javascript:void(0)" title="Detail" onclick="get_detail('."'".$data_table->id."'".')"> <i class="fa fa-list"></i></a>';
			$data[] = $row;
		}
		$ouput = array(
						"data"=>$data
					);
		echo json_encode($ouput);
    }

    public function list_data_canceled()
    {
        Modules::run("security/is_ajax");

        $array_get_all = [
            "select"    => "a.*, b.name as type_question_name",
            "from"      => "tb_account_examination as a",
            "join"      => [
                "tb_package_category as b, a.id_type_question = b.id"
            ],
            "where"     => "a.status = 3",
            "order"     => 'a.id, DESC'
        ];

        $get_all_data = Modules::run('database/get', $array_get_all)->result();

		$data = array();
		$no = 0;
		foreach ($get_all_data as $data_table) {
			//label status
			if($data_table->status==0){
				$label_status = '<div class="btn btn-sm btn-outline-primary">Belum Dibuka</div>';
			}elseif ($data_table->status==1) {
				$label_status = '<div class="btn btn-sm btn-outline-warning">Sedang Berlangsung</div>';
			}elseif ($data_table->status==2) {
				$label_status = '<div class="btn btn-sm btn-outline-success">Selesai</div>';
			}else{
				$label_status = '<div class="btn btn-sm btn-outline-danger">Dibatalkan</div>';
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_table->date_close;
			$row[]= $data_table->name;
			$row[]= $data_table->type_question_name;
			$row[]= $label_status;
			$row[] = '<a class="btn btn-outline-primary" href="javascript:void(0)" title="Detail" onclick="get_detail('."'".$data_table->id."'".')"> <i class="fa fa-list"></i></a>';
			$data[] = $row;
		}
		$ouput = array(
						"data"=>$data
					);
		echo json_encode($ouput);
    }

    public function list_data_finished()
    {
        Modules::run("security/is_ajax");

        $array_get_all = [
            "select"    => "a.*, b.name as type_question_name",
            "from"      => "tb_account_examination as a",
            "join"      => [
                "tb_package_category as b, a.id_type_question = b.id"
            ],
            "where"     => "a.status = 2",
            "order"     => 'a.id, DESC'
        ];

        $get_all_data = Modules::run('database/get', $array_get_all)->result();

		$data = array();
		$no = 0;
		foreach ($get_all_data as $data_table) {
			//label status
			if($data_table->status==0){
				$label_status = '<div class="btn btn-sm btn-outline-primary">Belum Dibuka</div>';
			}elseif ($data_table->status==1) {
				$label_status = '<div class="btn btn-sm btn-outline-warning">Sedang Berlangsung</div>';
			}elseif ($data_table->status==2) {
				$label_status = '<div class="btn btn-sm btn-outline-success">Selesai</div>';
			}else{
				$label_status = '<div class="btn btn-sm btn-outline-danger">Dibatalkan</div>';
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_table->date_close;
			$row[]= $data_table->name;
			$row[]= $data_table->type_question_name;
			$row[]= $label_status;
			$row[] = '<a class="btn btn-outline-primary" href="javascript:void(0)" title="Detail" onclick="get_detail('."'".$data_table->id."'".')"> <i class="fa fa-list"></i></a>';
			$data[] = $row;
		}
		$ouput = array(
						"data"=>$data
					);
		echo json_encode($ouput);
    }

    public function validate_save() {
        $id = $this->input->post('id');
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('name')==''){
			$data['error_string'][] = 'nama harus diisi';
			$data['inputerror'][] = 'name';
			$data['status'] = FALSE;
		}

		if(empty($_POST['id_package'])){
			$data['error_string'][] = 'paket belum dipilih';
			$data['inputerror'][] = 'id_package';
			$data['status'] = FALSE;	
		}

		// if($this->input->post('id_type_question')==''){
		// 	$data['error_string'][] = 'jenis ujian harus diisi';
		// 	$data['inputerror'][] = 'id_type_question';
		// 	$data['status'] = FALSE;	
		// }
		if($this->input->post('time_processing')==''){
			$data['error_string'][] = 'waktu pengerjaan harus diisi';
			$data['inputerror'][] = 'time_processing';
			$data['status'] = FALSE;	
		}

		if($data['status']==FALSE){
			echo json_encode($data);
			exit();
		}
    }

    public function save() {
        $id_session = $this->session->userdata('us_id');
		$this->validate_save();
		$name 				= $this->input->post('name');
        $id_type_package    = $this->input->post('id_type_package');
		$time_processing 	= $this->input->post('time_processing');
		$random_status 		= $this->input->post('random_status');
		$show_value_status 	= $this->input->post('show_value');
		$status 			= 0;

        $array_insert_exam = [
            'id_type_question' => $id_type_package,
            'name' => $name,
            'date' => date('Y-m-d'),
            'processing_time' => $time_processing,
            'status' => $status,
            'random_status' => $random_status,
            'show_value_status' => $show_value_status,
            'created_date'  => date('Y-m-d'),
            'created_by'    => $id_session
        ];

        Modules::run('database/insert', 'tb_account_examination', $array_insert_exam);

        $array_data_current = [
            "select" => "MAX(id) as id",
            "from" => "tb_account_examination",
            "where" => "created_by = $id_session"
        ];

        $get_data_current = Modules::run('database/get', $array_data_current)->row_array();
        $id_current = $get_data_current['id'];

        foreach ($_POST['id_batch_course'] as $key_id_class => $id_batch_course) {
            $array_insert_class = array(
                                        'id_account_exam'=>$id_current,
                                        'id_batch_course'=>$id_batch_course,
                                        'created_by'=>$this->session->userdata('us_id'),
                                        'created_date'=>date('Y-m-d H:i:s')
                                        );
            Modules::run('database/insert','tb_account_exam_has_batch_course',$array_insert_class);
        }

        foreach ($_POST['id_package'] as $key_id_package => $value_id_package) {
            $array_insert_package = array(
                                        'id_account_exam'=>$id_current,
                                        'id_package_question'=>$value_id_package,
                                        'created_by'=>$this->session->userdata('us_id'),
                                        'created_date'=>date('Y-m-d H:i:s')
                                        );
            Modules::run('database/insert','tb_account_exam_has_package',$array_insert_package);
        }
       echo json_encode(array('status'=>TRUE));

    }

    public function get_list_package(){

        $id_type_package     = $this->input->post('id_type_package');

        $array_get_package = [
            "select"    => "*",
            "from"      => "tb_package_question",
            "where"     => "id_type_package = $id_type_package"
        ];

        $get_data_package = Modules::run('database/get', $array_get_package)->result();

		$html_tr = '';
		$no=0;
		foreach ($get_data_package as $data_package) {
			$no++;
			$html_tr .= '
						<tr>
		                    <td>'.$no.'</td>
		                    <td>'.$data_package->code.'</td>
		                    <td>'.strtoupper($data_package->name).'</td>
		                    <td>'.$data_package->min_value_graduation.'</td>
		                    <td><input type="radio"  name="id_package[]" value="'.$data_package->id.'"></td>
		                  </tr>
						';
		}
		$data_html='
					<label>PAKET TERSEDIA:</label>
	                <table class="table  table-hover table_package">
	                  <tr>
	                    <th>No</th>
	                    <th>Kode</th>
	                    <th>Nama Paket</th>
	                    <th>nilai min.lulus</th>
	                    <th>Pilih</th>
	                  </tr>
	                  '.$html_tr.'
	                </table>
	                <div class="is-invalid"></div>
					';
		$html_error = '<label>PAKET TERSEDIA:</label><h1>TIDAK ADA PAKET TERSEDIA</h1><div class="is-invalid"></div>';
		if(!empty($get_data_package)){
			echo $data_html;
		}else{
			echo $html_error;
		}
		
	}

    public function get_detail_account($id) {
        $data_exam["data_current"]  = Modules::run('database/find', 'tb_account_examination', ['id' => $id])->row();
        $data_exam['type']          = Modules::run('database/find', 'tb_package_category', ['id' => $data_exam["data_current"]->id_type_question])->row()->name;
        $array_batch = [
            "select"=> "a.*, b.title as title",
            "from"  => "tb_account_exam_has_batch_course as a",
            "join"  => [
                "tb_batch_course as b, a.id_batch_course = b.id"
            ],
            "where" => "a.id_account_exam = $id"
        ];
        $array_package = [
            "select"=> "a.*, b.name as package_name",
            "from"  => "tb_account_exam_has_package as a",
            "join"  => [
                "tb_package_question as b, a.id_package_question = b.id"
            ],
            "where" => "a.id_account_exam = $id"
        ];
        $data_exam["batch"]         = Modules::run('database/get', $array_batch)->result();
        $data_exam["package"]       = Modules::run('database/get', $array_package)->result();

        echo $this->load->view("detail_account", $data_exam);
    }

    public function validate_confirm_account(){

		$password = $this->input->post('password');


		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$id = $this->session->userdata('us_id');
		$array_query = [
            'select' => '*',
            'from' => 'st_user',
            'where' => [
                'id' => $id,
                'is_delete' => 0,
                'status' => 1
            ]
        ];

        $get_data_user = Modules::run('database/get', $array_query)->row();
        $hash_password = hash('sha512', $password . config_item('encryption_key'));

		if($get_data_user->password != $hash_password){
			$data['error_string'][] = 'password salah / tidak valid';
			$data['inputerror'][] = 'confirm_password';
			$data['status'] = FALSE;
		}

		if($data['status']==FALSE){
			echo json_encode($data);
			exit();
		}
	}

    public function confirm_exam() {
        $id = $this->input->post('id');
        $this->validate_confirm_account();

        $array_update_status = [
	        'date_open'=>date('Y-m-d H:i:s'),
			'status'=>1
        ];

        Modules::run('database/update', 'tb_account_examination', ['id' => $id], $array_update_status);
        echo json_encode(array('status'=>TRUE));
    }
    
    public function cancel_exam($id) {

        $array_update = [
            "date_close" => date('Y-m-d H:i:s'),
            'status'     => 3
        ];

        Modules::run('database/update', 'tb_account_examination', ['id' => $id], $array_update);
		echo json_encode(array('status'=>TRUE));
    }

    public function get_active_exam() {
        $array_active_exam = [
            "select"=> "a.*",
            "from"  => "tb_account_examination as a",
            "where" => "a.status = 1"
        ];

        $get_active_exam = Modules::run('database/get', $array_active_exam)->result();

        $html_empty_data = '
                    <div class="col-md-12">
					    <h3>TIDAK ADA UJIAN BERLANGSUNG</h3>
					</div>
        ';

        $data_html='';
		foreach ($get_active_exam as $data_exam) {		
            $data_html .= '
            <div class="col-md-4 grid-margin my-1">
                <div class="card item-hover-blue bg-dark text-light">
                    <div class="card-body">
                        <h6 class="card-title mb-0" style="height:30px;" align="center">'. strtoupper($data_exam->name) .'</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-inline-block">
                                <div class="d-lg-flex">
                                    <div class="d-flex align-items-center ml-lg-2">
                                        <i class="mdi mdi-clock text-muted"></i>
                                        <small class="ml-1 mb-0">Dibuka : '. date($data_exam->date_open) .' </small>
                                    </div>
                                </div>
                                <small>Status : <label class="btn btn-sm btn-warning">Berlangsung</label><br></small>
                                <small>Dibuat : &nbsp; <label class="btn btn-sm btn-info">SuperAdmin</label></small> <br>
                            </div>
                            <div class="d-inline-block">
                                <div class="" style="padding:0;" align="center">
                                    <i style="font-size: 32px;" class="fa fa-laptop icon-lg mb-2"></i>
                                    <br>
                                    <button type="button" onclick="validate_event('.$data_exam->id.')" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-right"></i> Monitoring</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }

        if(empty($get_active_exam)){
			echo $html_empty_data;
		}else{
			echo $data_html;	
		}

    }

    public function validate_monitoring(){
		$id_user 			= $this->session->userdata('us_id');
		$password 			= $this->input->post('password');
        $hash_password      = hash('sha512', $password . config_item('encryption_key'));
        // echo $hash_password; return;
		$id_account_exam 	= $this->input->post('id_account_exam');
		//gget data
		$get_data = Modules::run('database/find', 'st_user', ['id' => $id_user, 'password' => $hash_password])->row();
		if(empty($get_data)){
			echo json_encode(array('status'=>FALSE));
		}else{
			$this->session->set_userdata('session_monitoring_exam',$id_account_exam);
			echo json_encode(array('status'=>TRUE));
		}
    }

    public function monitoring(){
		if($this->session->userdata('session_monitoring_exam')==FALSE){
			redirect(base_url($this->index()));
		}
		$id_account_exam = $this->session->userdata('session_monitoring_exam');

        $get_data_exam = Modules::run('database/find', 'tb_account_examination', ['id' => $id_account_exam])->row_array();
        $get_package_category = Modules::run('database/find', 'tb_package_category', ['id' => $get_data_exam['id_type_question']])->row_array();

        $array_batch_course = [
            "select"    => "b.*",
            "from"      => "tb_account_exam_has_batch_course as a",
            "join"      => [
                "tb_batch_course as b, a.id_batch_course = b.id"
            ],
            "where"     => "a.id_account_exam = $id_account_exam"
        ];

        $get_batch_course = Modules::run('database/get', $array_batch_course)->result();


        $this->app_data['data_exam']    = $get_data_exam;
        $this->app_data['batch_course'] = $get_batch_course;
        $this->app_data['category']     = $get_package_category;
		$this->app_data['page_title']   = "Data Ujian Online";
        $this->app_data['view_file']    = 'view_monitoring_exam';
        echo Modules::run('template/main_layout', $this->app_data);

	}

    public function validate_close_monitoring() {
        $id_user 			= $this->session->userdata('us_id');
		$password 			= $this->input->post('password');
        $hash_password      = hash('sha512', $password . config_item('encryption_key'));
		$id_account_exam    = $this->session->userdata('session_monitoring_exam');

		$get_data = Modules::run('database/find', 'st_user', ['id' => $id_user, 'password' => $hash_password])->row();
		
        if(empty($get_data)){
			echo json_encode(array('status'=>FALSE));
		}else{
            $array_update_status = [
                'date_close'=>date('Y-m-d H:i:s'),
                'status'=>2
            ];
    
            Modules::run('database/update', 'tb_account_examination', ['id' => $id_account_exam], $array_update_status);
			$this->session->unset_userdata('session_monitoring_exam');	
			echo json_encode(array('status'=>TRUE));
		}
    }

    public function list_data_recap()
    {
        Modules::run("security/is_ajax");
        $id_batch_course = $this->input->post('id');
        $id_account_exam = $this->session->userdata('session_monitoring_exam');

        $array_get_all = [
            "select"    => "a.id, b.name as account_name, d.title as batch_course_name, a.date_start, a.status, a.result_value",
            "from"      => "tb_participant_exam as a",
            "join"      => [
                "tb_account b, a.id_account = b.id, left",
                "tb_account_exam_has_batch_course c, a.id_account_exam = c.id_account_exam, left",
                "tb_batch_course d, c.id_batch_course = d.id, left",
                "tb_account_examination e, a.id_account_exam = e.id"
            ],
            "where"     => "a.id_account_exam = $id_account_exam AND c.id_batch_course = $id_batch_course"
        ];

        $get_all_data = Modules::run('database/get', $array_get_all)->result();

		$data = array();
		$no = 0;
		foreach ($get_all_data as $data_table) {
			//label status
			if($data_table->status==0){
				$label_status = '<div class="btn btn-sm btn-outline-primary">Belum Dibuka</div>';
			}elseif ($data_table->status==1) {
				$label_status = '<div class="btn btn-sm btn-outline-warning text-warning">Sedang Berlangsung</div>';
			}elseif ($data_table->status==2) {
				$label_status = '<div class="btn btn-sm btn-outline-success">Selesai</div>';
			}else{
				$label_status = '<div class="btn btn-sm btn-outline-danger">Diblokir</div>';
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_table->account_name;
			$row[] = $data_table->batch_course_name;
			$row[]= $data_table->date_start;
			$row[]= $label_status;
			$row[]= $data_table->result_value;
			$row[] = '<a class="btn btn-outline-primary" href="javascript:void(0)" title="Detail" onclick="get_detail('."'".$data_table->id."'".')"> <i class="fa fa-list"></i></a>';
			$data[] = $row;
		}
		$ouput = array(
						"data"=>$data
					);
		echo json_encode($ouput);
    }
}
