<?php
$session_image = $this->session->userdata('member_image');
$image = base_url('assets/themes/spruhha/img/users/6.jpg');
if (!empty($session_image)) {
    $base_dir = str_replace(PREFIX_CREDENTIAL_DIRECTORY . '/', '', BASE_DIR);
    $dir = $base_dir . 'upload/member/' . $session_image;
    // $image = $dir;
    if (file_exists($dir)) {
        $image = base_url('upload/member/' . $session_image);
    }
}
?>


<div class="dropdown main-profile-menu">
    <a class="d-flex" href="#">
        <span class="main-img-user"><img alt="avatar" src="<?= $image; ?>"></span>
    </a>
    <div class="dropdown-menu">
        <div class="header-navheading">
            <h6 class="main-notification-title"><?= $this->session->userdata('member_name'); ?></h6>
            <p class="main-notification-text"><?= $this->session->userdata('member_credetial_name'); ?></p>
        </div>
        <a class="dropdown-item border-top" href="<?= Modules::run('helper/create_url', 'app_profile'); ?>">
            <i class="fe fe-user"></i> Profil Saya
        </a>
        <a class="dropdown-item" href="<?= Modules::run('helper/create_url', 'login/logout') ?>">
            <i class="fe fe-power"></i> Keluar
        </a>
    </div>
</div>