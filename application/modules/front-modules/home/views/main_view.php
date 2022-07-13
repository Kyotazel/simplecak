<?php
$this->load->view('_partials/slider');
$this->load->view('_partials/company_client');
// $this->load->view('_partials/profile_company');
// $this->load->view('_partials/banners');

$id_page_builder = $this->encrypt->decode($this->input->get('id_page_builder'));

if ($id_page_builder) {
    $get_content = Modules::run('database/find', 'tb_cms_banner', ['id' => $id_page_builder])->row();
} else {
    $get_content = Modules::run('database/find', 'tb_cms_banner', ['type' => 4, 'status' => 1])->row();
}

echo $get_content->description;
$this->load->view('_partials/service_category');
