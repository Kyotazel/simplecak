<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends ApiController
{
    public function alamat()
    {
        $id = $this->input->post('id');
        $province_id = $this->input->post('province_id');
        $city_id = $this->input->post('city_id');
        $regency_id = $this->input->post('regency_id');
        $village_id = $this->input->post('village_id');
        $province_id_current = $this->input->post('province_id_current');
        $city_id_current = $this->input->post('city_id_current');
        $regency_id_current = $this->input->post('regency_id_current');
        $village_id_current = $this->input->post('village_id_current');

        $array_update = [
            'id_province' => $province_id,
            'id_city' => $city_id,
            'id_regency' => $regency_id,
            'id_village' => $village_id,
            'id_province_current' => $province_id_current,
            'id_city_current' => $city_id_current,
            'id_regency_current' => $regency_id_current,
            'id_village_current' => $village_id_current,
        ];

        Modules::run('database/update', 'tb_account', ['id' => $id], $array_update);

        $data = Modules::run('database/find', 'tb_account', ['id' => $id])->row();
        $response = [
            "error" => FALSE,
            "msg" => "Alamat berhasil di update",
            "data"  => $data,
        ];

        echo json_encode($response);
    }

    public function validate_update()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if (strlen($this->input->post('no_ktp')) < 16) {
            $data['error_string'][] = 'NIK harus 16 digit';
            $data['inputerror'][] = 'no_ktp';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function update()
    {
        $id                     = $this->input->post('id');
        $no_ktp                 = $this->input->post('no_ktp');
        $no_kk                  = $this->input->post('no_kk');
        $name                   = $this->input->post('name');
        $id_last_education      = $this->input->post('id_last_education');
        $last_school            = $this->input->post('last_school');
        $email                  = $this->input->post('email');
        $phone_number           = $this->input->post('phone_number');
        $birth_place            = $this->input->post('birth_place');
        $birth_date             = $this->input->post('birth_date');
        $gender                 = $this->input->post('gender');
        $religion               = $this->input->post('religion');
        $married_status         = $this->input->post('married_status');
        $address                = $this->input->post('address');
        $address_current        = $this->input->post('address_current');

        if (strpos(substr($phone_number, 0, 3), '08') !== false) {
            $awal = str_replace("08", "628", substr($phone_number, 0, 3));
            $phone_number = $awal . substr($phone_number, 3);
        }

        $array_update = [
            'no_ktp' => $no_ktp,
            'no_kk' => $no_kk,
            'name' => $name,
            'id_last_education' => $id_last_education,
            'last_school' => $last_school,
            'email' => $email,
            'phone_number' => $phone_number,
            'birth_place' => $birth_place,
            'birth_date' => $birth_date,
            'gender' => $gender,
            'religion' => $religion,
            'married_status' => $married_status,
            'address' => $address,
            'address_current' => $address_current,
            'updated_date' => date('Y-m-d h:i:sa'),
            'updated_by' => $this->session->userdata('us_id')
        ];

        Modules::run("database/update", "tb_account", ["id" => $id], $array_update);

        $data = Modules::run('database/find', 'tb_account', ['id' => $id])->row();

        $response = [
            "error" => FALSE,
            "msg" => "Profil berhasil di update",
            "data"  => $data,
        ];

        echo json_encode($response);
    }

    public function update_image()
    {
        $id = $this->input->post('id');

        $image = $this->upload_image();

        
        if ($image != '') {
            Modules::run('database/update', 'tb_account', ['id' => $id], ['image' => $image]);
            $response = [
                "error" => FALSE,
                "msg" => "Foto Profil Berhasil di Update",
                "data" => [
                    "image" => $image
                ]
            ];
        } else {
            $response = [
                "error" => TRUE,
                "msg" => "Foto Gagal di Update",
                "data" => [
                    "image" => $image
                ]
            ];
        }


        echo json_encode($response);
    }

    private function upload_image()
    {
        $config['upload_path']          = realpath(APPPATH . '../upload/member');
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image')) //upload and validate
        {
            return '';
        } else {
            $upload_data = $this->upload->data();
            $image_name = $upload_data['file_name'];
            return $image_name;
        }
    }

    public function update_skill()
    {
        $id = $this->input->post('id');
        Modules::run('database/delete', 'tb_account_has_skill', ['id_account' => $id]);

        foreach ($this->input->post("skill") as $skill) {
            $array_insert = [
                'id_skill' => $skill,
                'id_account' => $id,
                'created_by' => $this->session->userdata('us_id')
            ];

            Modules::run('database/insert', 'tb_account_has_skill', $array_insert);
        }

        echo json_encode([
            "error" => FALSE,
            "msg" => "Skill Berhasil ditambahkan"
        ]);
    }
}
