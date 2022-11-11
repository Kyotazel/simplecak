<?php
$session_image = $this->session->userdata('member_image');
$image = base_url('assets/themes/valex/img/faces/6.jpg');
if (!empty($session_image)) {
    $base_dir = str_replace(PREFIX_CREDENTIAL_DIRECTORY . '/', '', BASE_DIR);
    $dir = $base_dir . 'upload/member/' . $session_image;
    if (file_exists($dir)) {
        $image = base_url('upload/member/' . $session_image);
    }
}
?>

<ul class="nav" style="padding-bottom:150px;">
    <?= $html_main_menu; ?>
</ul>