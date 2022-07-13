<?php
$company_description = Modules::run('database/find', 'app_setting', ['field' => 'company_description'])->row()->value;
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
<section style="margin-top: 100px;" class="mb-5">
    <div class="container mt-100 mt-60">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12">
                <div class="section-title ms-lg-4">
                    <?= $company_description; ?>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</section>
<!--end container-->
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4">Tim Kami</h4>
                    <!-- <p class="text-muted para-desc mx-auto mb-0">Start working with <span class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate awareness, drive traffic, connect.</p> -->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        <div class="row">
            <?php
            $get_all = Modules::run('database/find', 'tb_cms_team', ['isDeleted' => 'N'])->result();
            foreach ($get_all as $item_team) {
                echo '
                    <div class="col-lg-3 col-md-6 mt-4 pt-2">
                        <div class="card team text-center bg-transparent border-0">
                            <div class="card-body p-0">
                                <div class="position-relative">
                                    <img src="' . base_url('upload/team/' . $item_team->image) . '" class="img-fluid avatar avatar-ex-large rounded-circle" alt="">
                                </div>
                                <div class="content pt-3 pb-3">
                                    <h5 class="mb-0"><a href="javascript:void(0)" class="name text-dark">' . $item_team->name . '</a></h5>
                                    <small class="designation text-muted">' . $item_team->position . '</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
            }
            ?>

            <!--end col-->


        </div>
        <!--end row-->
    </div>
    <!--end container-->

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="section-title mb-4 pb-2 text-center">
                        <h4 class="title mb-4">Galeri Kami</h4>
                    </div>
                </div>
                <!--end col-->
            </div>
            <div class="row">
                <?php
                $get_all = Modules::run('database/find', 'tb_cms_banner', ['isDeleted' => 'N', 'type' => 1])->result();
                foreach ($get_all as $item_data) {
                    echo '
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="card border-0 work-container work-modern position-relative d-block overflow-hidden rounded">
                            <div class="portfolio-box-img position-relative overflow-hidden">
                                <img class="item-container img-fluid mx-auto" src="' . base_url('upload/banner/' . $item_data->image) . '" alt="1">
                                <div class="overlay-work bg-dark"></div>
                                <div class="content">
                                    <h5 class="mb-0"><a href="#" class="text-white title">' . $item_data->name . '</a></h5>
                                    <h6 class="text-light tag mb-0">' . $item_data->description . '</h6>
                                </div>
                                <div class="icons text-center">
                                    <a href="' . base_url('upload/banner/' . $item_data->image) . '" class="text-primary work-icon bg-white d-inline-block rounded-pill lightbox"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera fea icon-sm image-icon">
                                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                            <circle cx="12" cy="13" r="4"></circle>
                                        </svg></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
    </section>

</section>