<?php
$session_image = $this->session->userdata('member_image');
$image = base_url('assets/themes/valex/img/faces/6.jpg');
if (!empty($session_image)) {
    $base_dir = str_replace(PREFIX_CREDENTIAL_DIRECTORY . '/', '', BASE_DIR);
    $dir = $base_dir . 'upload/customer/' . $session_image;
    if (file_exists($dir)) {
        $image = base_url('upload/customer/' . $session_image);
    }
}
?>
<div class="dropdown main-profile-menu nav nav-item nav-link">
    <a class="profile-user d-flex" href=""><img alt="" src="<?= $image; ?>"></a>
    <div class="dropdown-menu">
        <div class="main-header-profile bg-primary p-3">
            <div class="d-flex wd-100p">
                <div class="main-img-user"><img alt="" src="<?= $image; ?>" class=""></div>
                <div class="ml-3 my-auto">
                    <h6 class="text-capitalize"><?= $this->session->userdata('member_name'); ?></h6>
                    <!-- <span class="text-capitalize"><?= $this->session->userdata('us_credetial_name'); ?></span> -->
                </div>
            </div>
        </div>
        <a class="dropdown-item" href="<?= Modules::run('helper/create_url', 'app_profile'); ?>"><i class="bx bx-user-circle"></i>Profile Saya</a>
        <!-- <a class="dropdown-item" href=""><i class="bx bx-cog"></i> Edit Profil</a> -->
        <!-- <a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>Inbox</a>
        <a class="dropdown-item" href=""><i class="bx bx-envelope"></i>Messages</a> -->
        <a class="dropdown-item" href="<?= Modules::run('helper/create_url', 'login/logout') ?>"><i class="bx bx-log-out"></i> Keluar</a>
    </div>
</div>