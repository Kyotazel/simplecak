<?php
// $this->load->view('_partials/company_client');
// $this->load->view('_partials/profile_company');
// $this->load->view('_partials/banners');
$id_page_builder = $this->encrypt->decode($this->input->get('id_page_builder'));

if ($id_page_builder) {
    $get_content = Modules::run('database/find', 'tb_cms_banner', ['id' => $id_page_builder])->row();
} else {
    $get_content = Modules::run('database/find', 'tb_cms_banner', ['type' => 4, 'status' => 1])->row();
}
// var_dump($get_content);die;
echo $get_content->description;
$this->load->view('_partials/courses.php');
$this->load->view('_partials/batch_course.php');
$this->load->view('_partials/certificate.php');
$this->load->view('_partials/structure.php');
// $this->load->view('_partials/service_category');
