<?php
$session_image = $this->session->userdata('us_image');
$image = base_url('assets/themes/valex/img/faces/6.jpg');
if (!empty($session_image)) {
    $base_dir = str_replace(PREFIX_CREDENTIAL_DIRECTORY . '/', '', BASE_DIR);
    $dir = $base_dir . 'upload/user/' . $session_image;
    if (file_exists($dir)) {
        $image = base_url('upload/user/' . $session_image);
    }
}
?>

<ul class="nav">
    <?= $html_main_menu; ?>
</ul>