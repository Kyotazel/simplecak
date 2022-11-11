<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends ApiController
{

    public function provinces()
    {
        $response = Modules::run('database/get_all', 'provinces')->result();
        echo json_encode($response);
    }

    public function cities()
    {
        $province_id = $this->input->post('province_id');
        $response = Modules::run('database/find', 'cities', ['province_id' => $province_id])->result();
        echo json_encode($response);
    }

    public function regencies()
    {
        $city_id = $this->input->post('city_id');
        $response = Modules::run('database/find', 'regencies', ['city_id' => $city_id])->result();
        echo json_encode($response);
    }

    public function villages()
    {
        $regency_id = $this->input->post('regency_id');
        $response = Modules::run('database/find', 'villages', ['regency_id' => $regency_id])->result();
        echo json_encode($response);
    }

    public function gender()
    {
        $response = Modules::run("database/find", "app_module_setting", ["params" => "gender"])->result();
        echo json_encode($response);
    }

    public function religion()
    {
        $response = Modules::run("database/find", "app_module_setting", ["params" => "religion"])->result();
        echo json_encode($response);
    }

    public function married()
    {
        $response = Modules::run("database/find", "app_module_setting", ["params" => "married"])->result();
        echo json_encode($response);
    }

    public function last_education()
    {
        $response = Modules::run("database/get_all", "tb_education")->result();
        echo json_encode($response);
    }
}
