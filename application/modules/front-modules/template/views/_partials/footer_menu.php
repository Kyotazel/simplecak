<?php 
$setting = Modules::run('database/get_all', 'app_setting')->result_array();
 ?>
<div class="container py-3">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 order-lg-1 order-1 mb-lg-0 mb-4">
            <a class="d-inline-block mb-4" href="index.html">
                <img src="<?= base_url('assets/img/logo3.png'); ?>" width="130" alt="<?= $company_name; ?>">
            </a>
            <p class="mb-sm-4 mb-3 pb-lg-3 fs-xs text-light opacity-60"><?= $setting[2]['field'] == 'company_tagline' ? $setting[2]['value'] : '' ?></p>
            <a href="<?= $setting[6]['field'] == 'company_facebook' ? $setting[6]['value'] : '' ?>" class="btn-social me-1 mb-2 mt-md-0 mt-sm-1">
                <i class="ci-facebook"></i>
            </a>
            <a href="<?= $setting[17]['field'] == 'company_youtube' ? $setting[17]['value'] : '' ?>" class="btn-social me-1 mb-2 mt-md-0 mt-sm-1">
                <i class="ci-youtube"></i>
            </a>
            <a href="<?= $setting[5]['field'] == 'company_instagram' ? $setting[5]['value'] : '' ?>" class="btn-social me-1 mb-2 mt-md-0 mt-sm-1">
                <i class="ci-instagram"></i>
            </a>
            <a href="<?= $setting[4]['field'] == 'company_number_phone' ? $setting[4]['value'] : '' ?>" class="btn-social mb-1 mt-md-0 mt-sm-1">
                <i class="ci-ci-whatsapp"></i>
            </a>
        </div>
        <div class="col-lg-2 col-sm-12 col-6 order-lg-2 order-sm-4 order-1 mb-lg-0 mb-4">
            <h3 class="h6 mb-2 pb-1 text-uppercase text-light">Site map</h3>
            <ul class="nav nav-light flex-lg-column flex-sm-row flex-column">
                <?php 
                $array_query = [
                    'from' => 'app_menu',
                    'where' => ['id_menu' => '48', 'type' => 2, 'is_horizontal_menu' => 1],
                    'order_by' => 'sort'
                ];
                $get_menu = Modules::run('database/get', $array_query)->result();
                foreach ($get_menu as $value) : 
                if ($value->name == 'Home') {
                    continue;
                } ?>
                <li class="nav-item mb-2">
                    <a href="<?= base_url() . $value->link ?>" class="nav-link me-lg-0 me-sm-4 p-0 fw-normal"><?= $value->name ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-lg-2 col-sm-12 col-6 order-lg-3 order-sm-5 order-2 mb-lg-0 mb-4">
            <h3 class="h6 mb-2 pb-1 text-uppercase text-light">Courses</h3>
            <ul class="nav nav-light flex-lg-column flex-sm-row flex-column">
                <?php 
                $courses = Modules::run('database/get_all', 'tb_course')->result();
                $i = 0;
                foreach ($courses as $value) : ?>
                <li class="nav-item mb-2">
                    <a href="<?= base_url('kursus-pelatihan-kerja?data=') . $this->encrypt->encode($value->id) ?>" class="nav-link me-lg-0 me-sm-4 p-0 fw-normal"><?= $value->name ?></a>
                </li>
                <?php 
                if ($i == 4) {
                    break;
                }
                $i++;endforeach; ?>
            </ul>
        </div>
        <div class="col-lg-2 col-md-4 order-lg-4 order-sm-3 order-3 mb-md-0 mb-4">
            <h3 class="h6 mb-2 pb-1 text-uppercase text-light">Contact us</h3>
            <ul class="nav nav-light flex-md-column flex-sm-row flex-column">
                <li class="nav-item mb-2">
                    <a href="tel:(405)555-0128" class="nav-link me-md-0 me-sm-4 p-0 fw-normal text-nowrap">
                        <i class="ci-iphone me-2"></i>
                        <?= $setting[9]['field'] == 'company_fax' ? $setting[9]['value'] : '' ?>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="mailto:hello@example.com" class="nav-link me-md-0 me-sm-4 p-0 fw-normal text-nowrap">
                        <i class="ci-chat me-2"></i>
                        <?= $setting[3]['field'] == 'company_email' ? $setting[3]['value'] : '' ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 order-lg-5 order-sm-2 order-4 mb-sm-0 mb-4">
            <h3 class="h6 mb-2 pb-1 text-uppercase text-light">Sign up to our newsletter</h3>
            <form class="input-group needs-validation form_newsletter" novalidate>
                <div class="input-group input-group-light mb-2 pb-1">
                    <input class="form-control pe-5 rounded i_newsletter" name="email" type="email" placeholder="Email address*" required>
                    <i class="ci-arrow-right lead text-light position-absolute top-50 end-0 translate-middle-y mt-n1 me-3 zindex-5"></i>
                </div>
            </form>
        </div>
    </div>
</div>
<div style="background-color: #292C37;">
    <div class="container py-2">
        <div class="d-flex align-items-sm-center justify-content-between py-1">
            <div class="fs-xs text-light">
                <span class="d-sm-inline d-block mb-1">
                    <span class="fs-sm">&copy; </span>
                    All rights reserved.
                </span>
            </div>
            <div class="d-flex align-items-sm-center">
                <span class="d-sm-inline-block d-none text-light fs-sm me-3 mb-1 align-vertical">Back to top</span>
                <a class="btn-scroll-top position-static rounded" href="#top" data-scroll>
                    <i class="btn-scroll-top-icon ci-angle-up"></i>
                </a>
            </div>
        </div>
    </div>
</div>