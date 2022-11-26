<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Schedule extends ApiController
{
    public function get_schedule()
    {
        $id_batch_course = $this->input->post('id_batch_course');

        $get_batch_course = Modules::run('database/find', 'tb_batch_course_has_schedule', ['id_batch_course' => $id_batch_course])->result();

        if ($get_batch_course) {
            $response = [
                "error" => FALSE,
                "data" => $get_batch_course
            ];
        } else {
            $response = [
                "error" => TRUE,
                "msg" => "Jadwal tidak ditemukan"
            ];
        }
        

        echo json_encode($response);

    }

    public function attendance()
    {
        $id_account = $this->input->post('id_account');
        $id_batch_course = $this->input->post('id_batch_course');
        $id_schedule = $this->input->post('id_schedule');

        $array_get_account = Modules::run('database/find', 'tb_batch_course_has_account', ['id_batch_course' => $id_batch_course, 'id_account' => $id_account])->row();

        $array_insert = [
            'id_batch_course_schedule' => $id_schedule, 
            'id_batch_course_account' => $array_get_account->id, 
            'status_attendance' => 1,
            'created_by' => $id_account,
            'crated_date' => date('Y-m-d H:i:s')
        ];
        $check_attendance = Modules::run('database/find', 'tb_batch_course_schedule_has_attendance', ['id_batch_course_schedule' => $id_schedule, 'id_batch_course_account' => $array_get_account->id, ])->row();

        if ($check_attendance) {
            $response = [
                "error" => TRUE,
                "msg" => "Anda sudah pernah absensi"
            ];
        } else {
            Modules::run('database/insert', 'tb_batch_course_schedule_has_attendance', $array_insert);
            $response = [
                "error" => FALSE,
                "msg" => "Absensi berhasil dilakukan"
            ];
        }

        echo json_encode($response);

    }

}
