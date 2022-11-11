<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends ApiController
{
    public function alamat()
    {
        $response = [];
        $get_province = Modules::run('database/get_all', 'provinces')->result();
        $i = 0;
        $j = 0;
        $k = 0;
        $l = 0;
        foreach ($get_province as $value1) {
            $response['data'][$i]['id'] = $value1->id;
            $response['data'][$i]['province'] = $value1->name;
            $get_city = Modules::run('database/find', 'cities', ['province_id' => $value1->id])->result();

            foreach ($get_city as $value2) {
                $response['data'][$i]['data'][$j]['id'] = $value2->id;
                $response['data'][$i]['data'][$j]['name'] = $value2->name;
                $get_regency = Modules::run('database/find', 'regencies', ['city_id' => $value2->id])->result();

                foreach ($get_regency as $value3) {
                    $response['data'][$i]['data'][$j]['data'][$k]['id'] = $value3->id;
                    $response['data'][$i]['data'][$j]['data'][$k]['name'] = $value3->name;
                    $get_village = Modules::run('database/find', 'villages', ['regency_id' => $value3->id])->result();

                    foreach ($get_village as $value4) {
                        $response['data'][$i]['data'][$j]['data'][$k]['data'][$l]['id'] = $value4->id;
                        $response['data'][$i]['data'][$j]['data'][$k]['data'][$l]['name'] = $value4->name;

                        $l++;
                    }
                    $k++;
                }
                $j++;
            }
            $i++;
        }

        echo json_encode($response);
    }

    public function skill()
    {
        $response['error'] = FALSE;
        $skill = Modules::run('database/get_all', 'tb_skill',)->result();
        $i = 0;
        foreach($skill as $value) {
            $response['data'][$i]['id'] = $value->id;
            $response['data'][$i]['name'] = $value->name;

            $i++;
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
        $this->validate_update();
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
        $id_province            = $this->input->post('id_province');
        $id_city                = $this->input->post('id_city');
        $id_regency             = $this->input->post('id_regency');
        $id_village             = $this->input->post('id_village');
        $address                = $this->input->post('address');
        $id_province_current    = $this->input->post('id_province_current');
        $id_city_current        = $this->input->post('id_city_current');
        $id_regency_current     = $this->input->post('id_regency_current');
        $id_village_current     = $this->input->post('id_village_current');
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
            'id_province' => $id_province,
            'id_city' => $id_city,
            'id_regency' => $id_regency,
            'id_village' => $id_village,
            'address' => $address,
            'id_province_current' => $id_province_current,
            'id_city_current' => $id_city_current,
            'id_regency_current' => $id_regency_current,
            'id_village_current' => $id_village_current,
            'address_current' => $address_current,
            'updated_date' => date('Y-m-d h:i:sa'),
            'updated_by' => $this->session->userdata('us_id')
        ];

        // var_dump($array_update); return;

        $image = $this->upload_image();
        if ($image !== '') {
            $image = ["image" => $image];
            $array_update = array_merge($array_update, $image);
        }

        Modules::run("database/update", "tb_account", ["id" => $id], $array_update);

        Modules::run('database/delete', 'tb_account_has_skill', ['id_account' => $id]);

        if ($this->input->post("skill") !== NULL) {
            foreach ($this->input->post("skill") as $skill) {
                $array_insert = [
                    'id_skill' => $skill,
                    'id_account' => $id,
                ];

                Modules::run('database/insert', 'tb_account_has_skill', $array_insert);
            }
        }

        $data = Modules::run('database/find', 'tb_account', ['id' => $id])->row();

        $response = [
            "error" => FALSE,
            "data"  => $data,
        ];

        echo json_encode($response);
    }
}
