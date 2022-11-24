<?php
$company_short_description = Modules::run('database/find', 'app_setting', ['field' => 'company_short_description'])->row()->value;
$company_front_banner = Modules::run('database/find', 'app_setting', ['field' => 'company_front_banner'])->row()->value;

$company_link_video = Modules::run('database/find', 'app_setting', ['field' => 'company_link_video'])->row()->value;

$html_link = '';
if (!empty($company_link_video)) {
    $html_link = '
    <div class="play-icon">
        <a href="#!" data-type="youtube" data-id="' . $company_link_video . '" class="play-btn lightbox">
            <i class="mdi mdi-play text-primary rounded-circle bg-white shadow"></i>
        </a>
        </div>
    ';
}

?>
<div class="container mt-100 mt-60">
    <div class="row align-items-center">
        <div class="col-lg-5 col-md-5 mt-4 pt-2 mt-sm-0 pt-sm-0">
            <div class="position-relative">
                <img src="<?= base_url('upload/banner/' . $company_front_banner); ?>" class="rounded img-fluid mx-auto d-block" alt="">
                <?= $html_link; ?>
            </div>
        </div>
        <!--end col-->

        <div class="col-lg-7 col-md-7 mt-4 pt-2 mt-sm-0 pt-sm-0">
            <div class="section-title ms-lg-4">
                <?= $company_short_description; ?>
                <a href="<?= base_url('company') ?>" class="btn btn-primary mt-3">Lihat Detail <i class="uil uil-angle-right-b"></i></a>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
</div>
<!--end container-->