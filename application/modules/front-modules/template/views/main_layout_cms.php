<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from createx.createx.studio/online-courses/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 10 Jul 2022 01:50:09 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <title><?= $page_title; ?></title>

    <!-- SEO Meta Tags-->
    <meta name="description" content="Createx - Multipurpose Bootstrap Template">
    <meta name="keywords" content="bootstrap, business, creative agency, construction, services, e-commerce, mobile app showcase, multipurpose, shop, ui kit, marketing, seo, landing, html5, css3, javascript, gallery, slider, touch, creative">
    <meta name="author" content="Createx Studio">

    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/'); ?>img/logo3-color.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/'); ?>img/logo3-color.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/'); ?>img/logo3-color.png">
    <link rel="manifest" href="https://createx.createx.studio/assets/img/site.webmanifest">
    <link rel="mask-icon" color="#5bbad5" href="https://createx.createx.studio/assets/img/safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#766df4">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendor Styles-->
    <link rel="stylesheet" media="screen" href="<?= base_url('assets/themes/createx/'); ?>vendor/lightgallery.js/dist/css/lightgallery.min.css" />
    <link rel="stylesheet" media="screen" href="<?= base_url('assets/themes/createx/'); ?>vendor/simplebar/dist/simplebar.min.css" />
    <link rel="stylesheet" media="screen" href="<?= base_url('assets/themes/createx/'); ?>vendor/tiny-slider/dist/tiny-slider.css" />
    <!-- Select2 css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/select2/css/select2.min.css" rel="stylesheet">
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e0e2f7;
        border: 1px solid #e0e2f7;
        color: #1d212f;
    }
</style>
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="<?= base_url('assets/themes/createx/'); ?>css/demo/online-courses/theme.min.css">

    <!-- Page loading styles-->
    <style>
        .page-loading {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            -webkit-transition: all .4s .2s ease-in-out;
            transition: all .4s .2s ease-in-out;
            background-color: #fff;
            opacity: 0;
            visibility: hidden;
            z-index: 9999;
        }

        .page-loading.active {
            opacity: 1;
            visibility: visible;
        }

        .page-loading-inner {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            text-align: center;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            -webkit-transition: opacity .2s ease-in-out;
            transition: opacity .2s ease-in-out;
            opacity: 0;
        }

        .page-loading.active>.page-loading-inner {
            opacity: 1;
        }

        .page-loading-inner>span {
            display: block;
            font-size: 1rem;
            font-weight: normal;
            color: #787a80;
        }

        .page-spinner {
            display: inline-block;
            width: 2.75rem;
            height: 2.75rem;
            margin-bottom: .75rem;
            vertical-align: text-bottom;
            background-color: #cfcfd1;
            border-radius: 50%;
            opacity: 0;
            -webkit-animation: spinner .75s linear infinite;
            animation: spinner .75s linear infinite;
        }

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }

            50% {
                opacity: 1;
                -webkit-transform: none;
                transform: none;
            }
        }

        @keyframes spinner {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }

            50% {
                opacity: 1;
                -webkit-transform: none;
                transform: none;
            }
        }
    </style>

    <!-- Page loading scripts-->
    <script>
        (function() {
            window.onload = function() {
                var preloader = document.querySelector('.page-loading');
                preloader.classList.remove('active');
                setTimeout(function() {
                    preloader.remove();
                }, 2000);
            };
        })();
    </script>

    <!-- Demo switcher offcanvas toggle styles -->
    <style>
        .demo-switcher {
            position: fixed;
            display: block;
            top: 50%;
            right: 1rem;
            z-index: 100;
        }

        .demo-switcher-inner {
            width: 3rem;
            height: 3rem;
            border: 1px solid #e5e8ed;
            border-radius: 50%;
            background-color: #fff;
            color: #1e212c;
            font-size: 1.25rem;
            line-height: 3rem;
            text-align: center;
            text-decoration: none;
            box-shadow: 0px 10px 15px 0px rgba(30, 33, 44, 0.10);
        }
    </style>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                '../../www.googletagmanager.com/gtm5445.html?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WKV3GT5');
    </script>
</head>


<!-- Body-->

<body>

    <!-- Google Tag Manager (noscript)-->
    <noscript>
        <iframe src="http://www.googletagmanager.com/ns.html?id=GTM-WKV3GT5" height="0" width="0" style="display: none; visibility: hidden;"></iframe>
    </noscript>

    <!-- Page loading spinner-->
    <div class="page-loading active">
        <div class="page-loading-inner">
            <div class="page-spinner"></div><span>Loading...</span>
        </div>
    </div>

    <!-- Main content-->
    <!-- Wraps everything except footer to push footer to the bottom of the page if there is little content -->
    <main class="page-wrapper position-relative">

        <!-- Navbar -->
        <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page -->
        <header class="header navbar navbar-expand-lg navbar-light navbar-sticky navbar-floating">
            <div class="container px-0 px-xl-3">
                <a class="navbar-brand order-lg-1 me-lg-5 me-0 pe-lg-2" href="<?= Modules::run('helper/create_url', ''); ?>">
                    <img src="<?= base_url('assets/img/logo3-color.png'); ?>" alt="Createx Logo" width="130">
                </a>
                <div class="d-flex align-items-center order-lg-3">
                    <a class="btn btn-gradient btn-hover-shadow d-sm-inline-block d-none ms-4" href="<?= base_url('member-area/login/register') ?>">Daftar Sekarang</a>
                    <a href="<?= base_url('member-area/login') ?>" class="btn-link d-lg-inline-block d-none ms-4 text-decoration-none text-nowrap">
                        <i class="ci-profile mt-n1 me-2 lead align-middle"></i>
                        Masuk
                    </a>
                    <button class="navbar-toggler ms-1 me-n3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse1" aria-expanded="false">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <?php
                $this->load->view('_partials/horizontal_main_menu');
                ?>
            </div>
        </header>
        <!-- Page content-->
        <!-- Hero-->
        <?php 
            $this->load->view($module_directory.'/'.$view_file);
        ?>


        <!-- About -->


        <!-- Courses -->

        <!-- Events -->


        <!-- Certificate -->
        


        <!-- Parallax wrapper -->
        


        <!-- Blog -->


        <!-- Subscribe -->
        <section class="py-lg-6 py-5 bg-faded-primary bg-repeat-0 bg-position-center-bottom bg-size-cover" style="background-image: url(<?= base_url('assets/themes/createx/'); ?>img/online-courses/subscribe-bg.png);">
            <div class="container pt-md-4 pt-3 pb-md-5 pb-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <h3 class="h6 mb-2 text-uppercase text-center">Jangan sampai ketinggalan</h3>
                        <h2 class="h1 mb-lg-5 pb-md-2 text-center">Gabung bersama kami yuk dan kurangi angka pengangguran.</h2>
                    </div>
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <form class="input-group needs-validation form_newsletter" novalidate>
                            <input class="form-control rounded bg-light" type="email" name="email" placeholder="ketik emailmu..." required>
                            <button class="btn btn-gradient btn-hover-shadow ms-md-4 ms-sm-3 ms-2 rounded" type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <!-- Footer -->
    <footer class="footer pt-sm-5 pt-4 bg-dark">
        <?= $this->load->view('_partials/footer_menu'); ?>
    </footer>

    <!-- Vendor scripts: js libraries and plugins-->
    <script src="<?= base_url('assets/themes/createx/'); ?>vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/themes/createx/'); ?>vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="<?= base_url('assets/themes/createx/'); ?>vendor/lightgallery.js/dist/js/lightgallery.min.js"></script>
    <script src="<?= base_url('assets/themes/createx/'); ?>vendor/lg-video.js/dist/lg-video.min.js"></script>
    <script src="<?= base_url('assets/themes/createx/'); ?>vendor/jarallax/dist/jarallax.min.js"></script>
    <script src="<?= base_url('assets/themes/createx/'); ?>vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="<?= base_url('assets/themes/createx/'); ?>vendor/tiny-slider/dist/min/tiny-slider.js"></script>
     <!-- Jquery js-->
     <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- Select2 js-->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/select2/js/select2.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>js/select2.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Main theme script-->
    <script src="<?= base_url('assets/themes/createx/'); ?>js/theme.min.js"></script>

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

<!-- Mirrored from createx.createx.studio/online-courses/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 10 Jul 2022 01:50:26 GMT -->

</html>