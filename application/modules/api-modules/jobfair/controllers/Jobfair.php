<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jobfair extends ApiController
{
    public function list_jobfair()
    {
        $array_jobfair = [
            "select" => "a.*, b.name as industry_name, b.image as industry_image",
            "from" => "tb_job_vacancy a",
            "join" => [
                "tb_industry b, a.id_industry = b.id, left"
            ],
            "where" => ['vacancy_status' => 1],
            "order_by" => "a.id,desc"
        ];

        $jobfair = Modules::run('database/get', $array_jobfair)->result();

        if($jobfair) {
            $response = [
                "error" => false,
                "msg" => "List pekerjaan ditemukan",
                "data" => $jobfair
            ];
        } else {
            $response = [
                "error" => true,
                "msg" => "Data Not Found",
            ];
        }
        echo json_encode($response);
    }
}