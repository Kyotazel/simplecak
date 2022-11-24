<?php
$q_short_desc = [
    'select' => '*',
    'from' => 'app_setting',
    'where' => [
        'field' => 'company_short_description',
    ]
];
$q_long_desc = [
    'select' => '*',
    'from' => 'app_setting',
    'where' => [
        'field' => 'company_description'
    ]
];
if (!$this->uri->segment(1) == 'about-us') {
    $short_desc = Modules::run('database/get', $q_short_desc)->row();
    echo $short_desc->value;
} else {
    $long_desc = Modules::run('database/get', $q_long_desc)->row();
    echo $long_desc->value;
    $this->load->view('instructor.php');
} ?>