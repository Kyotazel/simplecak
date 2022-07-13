<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $company_name; ?> | <?= $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Description" content="<?= $company_tagline; ?>">
    <meta name="Author" content="<?= $company_name; ?>">
    <meta name="Keywords" content="<?= $company_tagline; ?>" />
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/themes/landrik/'); ?>images/logo-icon.png">
    <!-- Bootstrap -->
    <link href="<?= base_url('assets/themes/landrik/'); ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- tobii css -->
    <link href="<?= base_url('assets/themes/landrik/'); ?>css/tobii.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="<?= base_url('assets/themes/landrik/'); ?>css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url('assets/themes/landrik/'); ?>css/line.css">
    <!-- Slider -->
    <link rel="stylesheet" href="<?= base_url('assets/themes/landrik/'); ?>css/tiny-slider.css" />
    <!-- Main Css -->
    <link href="<?= base_url('assets/themes/landrik/'); ?>css/style.min.css" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="<?= base_url('assets/themes/landrik/'); ?>css/colors/default.css" rel="stylesheet" id="color-opt">
    <link href="<?= base_url('assets/themes/landrik/'); ?>css/custom.css" rel="stylesheet" id="color-opt">

</head>
<script>
    //configuration
    var _controller = '<?= $this->router->fetch_class(); ?>';
</script>

<body>
    <!-- Loader -->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div> -->
    <!-- Loader -->

    <!-- Navbar STart -->
    <header id="topnav" class="defaultscroll sticky">
        <div class="container">
            <!-- Logo container-->
            <a class="logo" href="<?= base_url(); ?>">

                <img src="<?= base_url('assets/themes/landrik/'); ?>images/logo-dark5.png" style="width: 150px;" class="logo-light-mode" alt="">
                <img src="<?= base_url('assets/themes/landrik/'); ?>images/logo-light.png" class="logo-dark-mode" alt="">

                <img src="<?= base_url('assets/themes/landrik/'); ?>images/logo-light.png" height="24" class="logo-dark-mode" alt="">
            </a>

            <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>

            <!--Login button Start-->
            <ul class="buy-button list-inline mb-0">
                <li class="list-inline-item mb-0">
                    <div class="dropdown">
                        <button type="button" class="btn btn-link text-decoration-none dropdown-toggle p-0 pe-2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-search text-muted"></i>
                        </button>
                        <div class="dropdown-menu dd-menu dropdown-menu-end bg-white shadow rounded border-0 mt-3 py-0" style="width: 300px;">
                            <form>
                                <input type="text" id="text" name="name" class="form-control border bg-white" placeholder="Search...">
                            </form>
                        </div>
                    </div>
                </li>


                <li class="list-inline-item ps-1 mb-0">
                    <?php
                    if ($this->session->userdata('member_id')) {
                        echo '
                            <a href="' . base_url('member-area') . '" class="btn  btn-primary btn-pills" target="_blank">
                                <i data-feather="user" class="fea icon-sm"></i> Member Area
                            </a>
                            ';
                    } else {
                        echo '
                            <a href="' . base_url('member-area/login') . '" class="btn  btn-primary btn-pills" target="_blank">
                                <i data-feather="user" class="fea icon-sm"></i> Login
                            </a>
                            ';
                    }
                    ?>

                </li>
            </ul>
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <?php
                    $this->load->view('_partials/horizontal_main_menu');
                    ?>
                </ul>
            </div>

        </div>
        <!--end container-->
    </header>
    <!--end header-->
    <!-- Navbar End -->


    <?php
    $this->load->view($module_directory . '/' . $view_file);
    ?>

    <!-- Footer Start -->
    <footer class="footer">
        <?php $this->load->view('_partials/footer_menu'); ?>
    </footer>
    <!--end footer-->
    <!-- Footer End -->

    <?php $this->load->view('_partials/right_toggle_menu'); ?>
    <!-- Offcanvas End -->

    <?php $this->load->view('_partials/cookie'); ?>
    <!--Note: Cookies Js including in plugins.init.js (path like; js/plugins.init.js) and Cookies css including in _helper.scss (path like; scss/_helper.scss)-->
    <!-- Cookies End -->

    <!-- Back to top -->
    <a href="<?= base_url('assets/themes/landrik/'); ?>#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up" class="fea icon-sm icons align-middle"></i></a>
    <!-- Back to top -->

    <!-- javascript -->
    <script src="<?= base_url('assets/themes/landrik/'); ?>js/jquery.min.js"></script>
    <script src="<?= base_url('assets/themes/landrik/'); ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/themes/landrik/'); ?>js/shuffle.min.js"></script>
    <!-- SLIDER -->
    <script src="<?= base_url('assets/themes/landrik/'); ?>js/tiny-slider.js"></script>
    <!-- tobii js -->
    <script src="<?= base_url('assets/themes/landrik/'); ?>js/tobii.min.js"></script>
    <!-- Icons -->
    <script src="<?= base_url('assets/themes/landrik/'); ?>js/feather.min.js"></script>
    <!-- Switcher -->
    <script src="<?= base_url('assets/themes/landrik/'); ?>js/switcher.js"></script>
    <!-- Main Js -->
    <script src="<?= base_url('assets/themes/landrik/'); ?>js/plugins.init.js"></script>
    <!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
    <script src="<?= base_url('assets/themes/landrik/'); ?>js/app.js"></script>
    <!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->
    <?php
    echo '
        <script src="' . base_url('application/modules/front-modules/template/js/js-module-configuration.js') . '"></script>
    ';
    foreach ($module_js as $item_js) {
        echo '
                <script src="' . base_url('application/modules/front-modules/' . $module_directory . '/js/' . $item_js . '.js') . '"></script>
            ';
    }
    ?>
</body>

<!-- Mirrored from shreethemes.in/landrick/landing/index-it-solution-two.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 18 Dec 2021 02:37:06 GMT -->

</html>