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
<div class="main-sidemenu">
    <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
            <div class="">
                <img alt="user-img" style="object-fit:cover;" class="avatar avatar-xl brround" src="<?= $image; ?>"><span class="avatar-status profile-status bg-green"></span>
            </div>
            <div class="user-info">
                <h4 class="font-weight-semibold mt-3 mb-0 text-capitalize"><?= $this->session->userdata('member_name'); ?></h4>
                <span class="mb-0 text-muted text-capitalize">Customer</span>
            </div>
        </div>
    </div>
    <ul class="side-menu" style="padding-bottom:150px;">
        <?= $html_main_menu; ?>
    </ul>
</div>