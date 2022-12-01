<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Batch_course extends ApiController
{
    public function list_batch_course()
    {
        $array_get = [
            "select" => "*",
            "from" => "tb_batch_course",
            "where" => "starting_date > '" . date('Y-m-d') . "'" 
        ];
        $get_all = Modules::run('database/get', $array_get)->result();

        if($get_all) {
            $response = [
                "error" => false,
                "msg" => "Success",
                "data" => $get_all
            ];
        } else {
            $response = [
                "error" => true,
                "msg" => "Not Found",
                "data" => "Data Tidak Ditemukan"
            ];
        }

        echo json_encode($response);
    }

    private function _validate_register()
    {
        $response = array();
        $response['error'] = FALSE;

        $id_account = $this->input->post('id_account');
        $id_batch_course = $this->input->post('id_batch_course');

        $get_data = Modules::run('database/find', 'tb_batch_course_has_account', ['id_account' => $id_account, 'id_batch_course' => $id_batch_course])->row();

        if($get_data) {
            $response['msg'][] = 'Akun ini pernah mendaftar di pelatihan ini';
            $response['error'] = TRUE;
        }

        if ($response['error'] == TRUE) {
            echo json_encode($response);
            exit();
        }

    }

    public function registration_batch_course()
    {
        $this->_validate_register();
        $id_account = $this->input->post('id_account');
        $id_batch_course = $this->input->post('id_batch_course');

        $array_insert = [
            'id_account' => $id_account,
            'id_batch_course' => $id_batch_course,
            'date' => date('Y-m-d'),
            'registration_code' => 'SC' . $id_batch_course . $id_account,
            'is_confirm' => 0,
            'crated_by' => $id_account,
            'created_date' => date('Y-m-d H:i:s'),
            'status' => 0
        ];

        Modules::run('database/insert', 'tb_batch_course_has_account', $array_insert);

        $response = [
            "error" => false,
            "msg" => "Sukses mendaftarkan pelatihan",
        ];

        echo json_encode($response);
    }

    public function account_course()
    {

        $id = $this->input->post('id_account');
        $array_query = [
            "select" => "",
            "from" => "tb_batch_course_has_account a",
            "join" => [
                "tb_batch_course b, a.id_batch_course = b.id" 
            ],
            "where" => "a.id_account = $id"
        ];

        $get_data = Modules::run('database/get', $array_query)->result();

        if($get_data)
        {
            $response = [
                "error" => false,
                "msg" => "Success",
                "data" => $get_data
            ];
        } else {
            $response = [
                "error" => true,
                "msg" => "Data Not Found",
            ];
        }

        echo json_encode($response);

    }

    public function status_course()
    {
        $id_account = $this->input->post('id_account');
        $id_batch_course = $this->input->post('id_batch_course');

        $status = Modules::run('database/find', 'tb_batch_course_has_account', ['id_account' => $id_account, 'id_batch_course' => $id_batch_course])->row();

        if($status) {
            $response = [
                "error" => false,
                "msg" => "Data Ditemukan",
                "data" => $status
            ];
        } else {
            $response = [
                "error" => true,
                "msg" => "Data Tidak Ditemukan",
            ];
        }

        echo json_encode($response);
    }

    public function certificate()
    {
        $id = $this->input->post('id_account');
        $get_certificate = Modules::run('database/find', 'tb_account_has_certificate', ['id_account' => $id])->result();

        if($get_certificate) {
            $response = [
                "error" => False,
                "data" => $get_certificate
            ];
        } else {
            $response = [
                "error" => True,
                "msg" => "Data tidak ditemukan",
            ];
        }

        echo json_encode($response);

    }
}
