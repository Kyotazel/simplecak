<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Skill extends ApiController {
    public function list_data()
    {
        // Modules::run("security/is_ajax");
        $get_all = Modules::run('database/get_all', 'tb_skill')->result();
        $no = 0;
        $data = [];
        foreach ($get_all as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->name;
            $row[] = '
                    <a href="javascript:void(0)" data-id="' . $data_table->id . '" class="btn btn-sm btn-info btn_edit"><i class="fas fa-pen"></i> Edit</a>
                    <a href="javascript:void(0)" data-id="' . $data_table->id . '" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash"></i> Hapus</a>
            ';
            $data[] = $row;
        }

        $response = array(
            "data" => $data,
            "status" => TRUE
        );

        header("Content-Type: application/json");
        echo json_encode($response);
    }
}