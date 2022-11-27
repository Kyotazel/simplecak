<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Generate_query extends ApiController
{
    public function api()
    {
        Modules::run('database/delete', 'tb_batch_course_has_account', ['id_account' => 60]);

        echo "oke";
    }
}
