<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Do_examination extends CommonController
{
    var $module_name = 'do_examination';
    var $module_directory = 'do_examination';
    var $module_js = ['do_examination'];
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
        $id_participant     = $this->session->userdata('session_examination_student');
        $array_participant  = [
            "select"    => "c.title as batch_name, e.creator_name as creator, d.name as title, d.processing_time, a.start_time, e.*",
            "from"      => "tb_participant_exam as a",
            "join"      => [
                "tb_account_exam_has_batch_course b, a.id_account_exam = b.id_account_exam",
                "tb_batch_course c, b.id_batch_course = c.id",
                "tb_account_examination d, a.id_account_exam = d.id",
                "tb_package_question e, a.id_package_question = e.id"
            ],
            "where"     => ["a.id" => $id_participant]
        ];

        $get_participant = Modules::run('database/get', $array_participant)->row();

        $this->app_data['time_exam'] = $this->count_time($get_participant->processing_time, $get_participant->start_time);
        $this->app_data['participant'] = $get_participant;
        $this->app_data['page_title'] = "Ujian Online";
        $this->app_data['view_file']  = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    private function count_time($processing_time, $time)
    {
        $selisih = time() - $time;
        // 120 --> hitungan menit
        $temp_waktu = ($processing_time * 60) - $selisih; //dijadikan detik dan dikurangi waktu yang berlalu
        $temp_menit = (int)($temp_waktu / 60);                //dijadikan menit lagi
        $temp_detik = $temp_waktu % 60;                       //sisa bagi untuk detik

        if ($temp_menit < 60) {
            /* Apabila $temp_menit yang kurang dari 60 meni */
            $jam    = 0;
            $menit  = $temp_menit;
            $detik  = $temp_detik;
        } else {
            /* Apabila $temp_menit lebih dari 60 menit */
            $jam    = (int)($temp_menit / 60);    //$temp_menit dijadikan jam dengan dibagi 60 dan dibulatkan menjadi integer 
            $menit  = $temp_menit % 60;           //$temp_menit diambil sisa bagi ($temp_menit%60) untuk menjadi menit
            $detik  = $temp_detik;
        }
        // return time
        $return_time = array(
            'hour' => $jam,
            'minute' => $menit,
            'second' => $detik
        );
        return json_encode($return_time);
    }

    public function get_question_examination($page_request)
    {
        $id_participant                 = $this->session->userdata('session_examination_student');
        $get_data_exam                  = Modules::run('database/find', 'tb_participant_exam', ['id' => $id_participant])->row();
        $line_question                  = json_decode($get_data_exam->detail_line_question);
        // get line
        $status = $page_request;
        $limit_each = 10;
        $start_key_array = ($status * $limit_each) - $limit_each;
        $counter = $start_key_array;
        // print_r($start_key_array);
        $data_html = '';
        for ($i = 0; $i < $limit_each; $i++) {
            $counter++;
            //filter
            if (!isset($line_question[$start_key_array])) {
                continue;
            }
            $id_question = $line_question[$start_key_array]->id;

            $array_question = [
                "select"    => "a.*, b.answer as axist_answer",
                "from"      => "tb_package_question_has_detail as a",
                "join"      => [
                    "tb_participant_exam_has_answer as b, ON a.id = b.id_question AND id_participant_exam = $id_participant, left"
                ],
                "where"     => "a.id = $id_question"
            ];

            $get_question = Modules::run('database/get', $array_question)->row();

            $get_answer = json_decode($get_question->json_answer, true);

            $answer_a  = $get_answer[1];
            $answer_b  = $get_answer[2];
            $answer_c  = $get_answer[3];
            $answer_d  = $get_answer[4];
            $answer_e  = $get_answer[5];

            // if axist answer
            $checked_a = '';
            $checked_b = '';
            $checked_c = '';
            $checked_d = '';
            $checked_e = '';
            //decided checked
            if ($get_question->axist_answer) {
                if ($get_question->axist_answer == 1) {
                    $checked_a = 'checked';
                } elseif ($get_question->axist_answer == 2) {
                    $checked_b = 'checked';
                } elseif ($get_question->axist_answer == 3) {
                    $checked_c = 'checked';
                } elseif ($get_question->axist_answer == 4) {
                    $checked_d = 'checked';
                } elseif ($get_question->axist_answer == 5) {
                    $checked_e = 'checked';
                }
            }

            $data_html .= '
            <div class="card my-3">
                <div class="card-header bg-primary text-light">
                    <h4 id="no_soal">Soal No. ' . $counter . '</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12" id="soal">
                                    ' . $get_question->text_question . '
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 ml-4">
                                    <label class="rdiobox mt-2">
                                        <input onchange=save_answer(' . "'" . $get_question->id . "','1'" . ') name="answer_' . $get_question->id . '" type="radio" ' . $checked_a . '>
                                        <span id="answer_1">
                                            ' . $answer_a . '
                                        </span>
                                    </label>
                                    <label class="rdiobox mt-2">
                                        <input onchange=save_answer(' . "'" . $get_question->id . "','2'" . ') name="answer_' . $get_question->id . '" type="radio" ' . $checked_b . '>
                                        <span id="answer_2">
                                            ' . $answer_b . '
                                        </span>
                                    </label>
                                    <label class="rdiobox mt-2">
                                        <input onchange=save_answer(' . "'" . $get_question->id . "','3'" . ') name="answer_' . $get_question->id . '" type="radio" ' . $checked_c . '>
                                        <span id="answer_3">
                                            ' . $answer_c . '
                                        </span>
                                    </label>
                                    <label class="rdiobox mt-2">
                                        <input onchange=save_answer(' . "'" . $get_question->id . "','4'" . ') name="answer_' . $get_question->id . '" type="radio" ' . $checked_d . '>
                                        <span id="answer_4">
                                            ' . $answer_d . '
                                        </span>
                                    </label>
                                    <label class="rdiobox mt-2">
                                        <input onchange=save_answer(' . "'" . $get_question->id . "','5'" . ') name="answer_' . $get_question->id . '" type="radio" ' . $checked_e . '>
                                        <span id="answer_5">
                                            ' . $answer_e . '
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
            $start_key_array++;
        }
        echo $data_html;
    }

    public function show_pagination()
    {
        $id_participant_exam = $this->session->userdata('session_examination_student');
        $get_data_exam          = $this->db->query("SELECT COUNT(b.id) AS count_question
											FROM tb_participant_exam a 
											LEFT JOIN tb_package_question_has_detail b ON a.id_package_question = b.id_parent
											WHERE a.id = '$id_participant_exam' ")->row_array();
        $count_question = $get_data_exam['count_question'];
        //make pagination
        $count_show_item = 10;
        $count_all_paging = ceil($count_question / $count_show_item);
        //print_r($count_all_paging);
        $html_li = '';
        $counter = 0;
        for ($i = 0; $i < $count_all_paging; $i++) {
            $counter++;
            $html_li .= '<li class="page-item" onclick="get_question_exam(' . $counter . ')" id="pagination_' . $counter . '"><a class="page-link" href="#">' . $counter . '</a></li>';
        }

        $data_html = '
						<input type="hidden" id="count_all_paging" value="' . $count_all_paging . '">
						 <nav class="mb-5">
						    <ul class="pagination">
						      <li class="page-item" onclick="control_page(0)"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>
						      ' . $html_li . '
						      <li class="page-item" onclick="control_page(1)"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>
						    </ul>
						  </nav>
					 ';
        echo $data_html;
    }

    public function save_answer_examination()
    {
        $id_participant_exam     = $this->session->userdata('session_examination_student');
        $id_question             = $this->input->post('id_question');
        $answer                 = $this->input->post('answer');

        // Get Data
        $get_data_answer    = Modules::run('database/find', 'tb_participant_exam_has_answer', ['id_participant_exam' => $id_participant_exam, 'id_question' => $id_question])->row();
        $get_data_question  = Modules::run('database/find', 'tb_package_question_has_detail', ['id' => $id_question])->row();

        //decide TRUE or FALSE answer
        if ($answer == $get_data_question->answer) {
            $answer_status = TRUE;
        } else {
            $answer_status = FALSE;
        }
        //save or update answer
        if (empty($get_data_answer)) {
            //save new answer
            $array_query = [
                'id_participant_exam' => $id_participant_exam,
                'id_question' => $id_question,
                'answer' => $answer,
                'answer_status' => $answer_status
            ];
            Modules::run('database/insert', 'tb_participant_exam_has_answer', $array_query);
        } else {

            $id_answer_axist = $get_data_answer->id;
            $array_query = [
                'answer' => $answer,
                'answer_status' => $answer_status
            ];
            Modules::run('database/update', 'tb_participant_exam_has_answer', ['id' => $id_answer_axist], $array_query);
        }

        $array_examination_account = [
            "select"=> "a.id, a.each_value_question, COUNT(b.id) as true_answer",
            "from"  => "tb_participant_exam a",
            "join"  => [
                "tb_participant_exam_has_answer b, a.id = b.id_participant_exam AND b.answer_status = 1, left"
            ],
            "where" => "a.id = $id_participant_exam",
            "group_by"  => "a.id"
        ];
        $get_examination_account = Modules::run('database/get', $array_examination_account)->row();
        //answer result_exam
        $result_value_exam      = $get_examination_account->true_answer * $get_examination_account->each_value_question;
        $array_update_result = [
            'result_value' => $result_value_exam
        ];
        Modules::run('database/update', 'tb_participant_exam', ['id' => $id_participant_exam], $array_update_result);
        echo json_encode(array('status' => TRUE));
    }

    public function list_resume_answer(){
		$id_account_exam 	= $this->session->userdata('session_examination_student');
		$get_line_question  = $this->db->query("SELECT detail_line_question FROM tb_participant_exam WHERE id = '$id_account_exam' ")->row_array();
		//get answer
		$array_line_question = json_decode($get_line_question['detail_line_question']);
		//create list
		$list_id_question = '';
		foreach ($array_line_question as $question_current) {
			$list_id_question .= $question_current->id.',';
		}
		$list_id_question = substr($list_id_question,0,strlen($list_id_question)-1);
		//get data answer
		$get_data_answer = $this->db->query("SELECT * FROM tb_participant_exam_has_answer WHERE id_participant_exam = '$id_account_exam' AND id_question IN($list_id_question) ")->result();
		//create array answer
		$array_answer_axist = array();
		foreach ($get_data_answer as $data_answer) {
			$array_answer_axist[$data_answer->id_question] = $data_answer->answer;
		}
		//create table
		$no = 0;
		$html_tr ='';
		foreach ($array_line_question as $data_table) {
			$no++;
			$label_number = '<label class="badge badge-pill badge-warning" style="width:100px;">'.$no.'</label>';
			if(isset($array_answer_axist[$data_table->id])){
				//decide answer
				if($array_answer_axist[$data_table->id]==1){
					$answer_letter = '<label style="font-size:20px;" class="btn btn-sm btn-outline-success">A</label>';
				}elseif ($array_answer_axist[$data_table->id]==2) {
					$answer_letter = '<label style="font-size:20px;" class="btn btn-sm btn-outline-success">B</label>';
				}elseif ($array_answer_axist[$data_table->id]==3) {
					$answer_letter = '<label style="font-size:20px;" class="btn btn-sm btn-outline-success">C</label>';
				}elseif ($array_answer_axist[$data_table->id]==4) {
					$answer_letter = '<label style="font-size:20px;" class="btn btn-sm btn-outline-success">D</label>';
				}elseif ($array_answer_axist[$data_table->id]==5) {
					$answer_letter = '<label style="font-size:20px;" class="btn btn-sm btn-outline-success">E</label>';
				}
			
			}else{
				$answer_letter= '<label class="badge badge-pill badge-danger">BELUM DIJAWAB</label>';
			}
			$html_tr.='
						<tr>
							<td>'.$label_number.'</td>
							<td>'.$answer_letter.'</td>
						</tr>
					  ';

		}
		$html_table_resume_answer = '
										 <table class="table table-hover" style="width:100%" id="table-resume-answer">
											<thead>
												<tr>
													<th  width="100px">Nomor Soal</th>
													<th>Jawaban</th>
												</tr>
											</thead>
											<tbody>'.$html_tr.'</tbody>
										</table>
									';
		echo $html_table_resume_answer;
	}

    public function timeout()
    {
        $id_participant_exam 	= $this->session->userdata('session_examination_student');
        $array_update = [
            "status" => 2
        ];

        Modules::run('database/update', 'tb_participant_exam', ['id' => $id_participant_exam], $array_update);
        $this->session->unset_userdata('session_examination_student');	
		echo json_encode(array('status'=>TRUE));
    }

    public function finish_examination()
    {
        $id_participant_exam 	= $this->session->userdata('session_examination_student');
        $array_update = [
            "status" => 2,
            "stop_timing" => date('Y-m-d H:i:s')
        ];

        Modules::run('database/update', 'tb_participant_exam', ['id' => $id_participant_exam], $array_update);
        $this->session->unset_userdata('session_examination_student');	
		echo json_encode(array('status'=>TRUE)); 
    }

    public function check_status_exam()
    {
        echo json_encode(['status' => FALSE]);
    }
}
