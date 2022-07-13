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


        <!-- Sign in modal-->
        <div class="modal fade" id="modal-signin" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0">

                    <!-- Sign in form -->
                    <div class="view show" id="modal-signin-view">
                        <div class="modal-header border-0 pb-0 px-md-5 px-4 d-block position-relative">
                            <h3 class="modal-title mt-4 mb-0 text-center">Sign in</h3>
                            <button type="button" class="btn-close position-absolute" style="top: 1.5rem; right: 1.5rem;" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-md-5 px-4">
                            <p class="fs-sm text-muted text-center">Sign in to your account using email and password provided during registration.</p>
                            <form class="needs-validation" novalidate>
                                <div class="mb-4">
                                    <label for="signin-email" class="form-label-lg">Email</label>
                                    <input type="email" class="form-control" id="signin-email" placeholder="Your email address" required>
                                </div>
                                <div class="mb-4">
                                    <label for="signin-password" class="form-label-lg">Password</label>
                                    <div class="password-toggle">
                                        <input class="form-control" type="password" id="signin-password" value="hidden@password">
                                        <label class="password-toggle-btn" aria-label="Show/hide password">
                                            <input class="password-toggle-check" type="checkbox">
                                            <span class="password-toggle-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember-me" checked>
                                        <label for="remember-me" class="form-check-label fs-base">Remember me</label>
                                    </div>
                                    <a href="#" class="fs-sm text-decoration-none">Forgot password?</a>
                                </div>
                                <button type="submit" class="btn btn-primary btn-hover-shadow d-block w-100">Sign in</button>
                                <p class="fs-sm pt-4 mb-0">
                                    Don't have an account?
                                    <a href="#" class="fw-bold text-decoration-none" data-view="#modal-signup-view">Sign up</a>
                                </p>
                            </form>
                        </div>
                    </div>

                    <!-- Sign up form -->
                    <div class="view" id="modal-signup-view">
                        <div class="modal-header border-0 pb-0 px-md-5 px-4 d-block position-relative">
                            <h3 class="modal-title mt-4 mb-0 text-center">Sign up</h3>
                            <button type="button" class="btn-close position-absolute" style="top: 1.5rem; right: 1.5rem;" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-md-5 px-4">
                            <p class="fs-sm text-muted text-center">Sign in to your account using email and password provided during registration.</p>
                            <form class="needs-validation" novalidate>
                                <div class="mb-4">
                                    <label for="signup-name" class="form-label-lg">Full name</label>
                                    <input type="text" class="form-control" id="signup-name" placeholder="Your full name" required>
                                </div>
                                <div class="mb-4">
                                    <label for="signup-email" class="form-label-lg">Email</label>
                                    <input type="email" class="form-control" id="signup-email" placeholder="Your email address" required>
                                </div>
                                <div class="mb-4">
                                    <label for="signup-password" class="form-label-lg">Password</label>
                                    <div class="password-toggle">
                                        <input class="form-control" type="password" id="signup-password" required>
                                        <label class="password-toggle-btn" aria-label="Show/hide password">
                                            <input class="password-toggle-check" type="checkbox">
                                            <span class="password-toggle-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="signup-confirm-password" class="form-label-lg">Confirm password</label>
                                    <div class="password-toggle">
                                        <input class="form-control" type="password" id="signup-confirm-password" required>
                                        <label class="password-toggle-btn" aria-label="Show/hide password">
                                            <input class="password-toggle-check" type="checkbox">
                                            <span class="password-toggle-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-hover-shadow d-block w-100" type="submit">Sign up</button>
                                <p class="fs-sm pt-4 mb-0">Already have an account?
                                    <a href="#" class="fw-bold text-decoration-none" data-view="#modal-signin-view">Sign in</a>
                                </p>
                            </form>
                        </div>
                    </div>
                    <div class="modal-body text-center px-0 pt-2 pb-4">
                        <hr class="my-0">
                        <p class="fs-sm text-heading mb-3 pt-4">Or sign in with</p>
                        <a href="#" class="btn-social mx-1 mb-2" data-bs-toggle="tooltip" title="Facebook">
                            <i class="ci-facebook"></i>
                        </a>
                        <a href="#" class="btn-social mx-1 mb-2" data-bs-toggle="tooltip" title="Google">
                            <i class="ci-google"></i>
                        </a>
                        <a href="#" class="btn-social mx-1 mb-2" data-bs-toggle="tooltip" title="Twitter">
                            <i class="ci-twitter"></i>
                        </a>
                        <a href="#" class="btn-social mx-1 mb-2" data-bs-toggle="tooltip" title="LinkedIn">
                            <i class="ci-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Navbar -->
        <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page -->
        <header class="header navbar navbar-expand-lg navbar-light navbar-sticky navbar-floating">
            <div class="container px-0 px-xl-3">
                <a class="navbar-brand order-lg-1 me-lg-5 me-0 pe-lg-2" href="<?= Modules::run('helper/create_url', ''); ?>">
                    <img src="<?= base_url('assets/img/logo3-color.png'); ?>" alt="Createx Logo" width="130">
                </a>
                <div class="d-flex align-items-center order-lg-3">
                    <a class="btn btn-gradient btn-hover-shadow d-sm-inline-block d-none ms-4" href="contacts.html">Daftar Sekarang</a>
                    <a href="#modal-signin" data-bs-toggle="modal" data-view="#modal-signin-view" class="btn-link d-lg-inline-block d-none ms-4 text-decoration-none text-nowrap">
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
        <section class="d-flex min-vh-100 mb-lg-6 mb-5 pt-lg-6 pt-5 jarallax" data-jarallax data-speed="0.8" style="background-color: #f9dcd4;">
            <div class="container d-flex flex-column justify-content-between">
                <div class="row align-items-center h-100">
                    <div class="col-xl-5 col-md-6 order-md-1 order-2 me-xl-auto text-md-start text-center">
                        <div class="mb-4">
                            <a href="https://www.youtube.com/watch?v=MDNtJr_gEh0&amp;ab_channel=LibertyUniversity" class="btn-video me-3" data-gallery-video></a>
                            <span class="fs-sm fw-bold text-dark">Play Showreel</span>
                        </div>
                        <h1 class="display-2 mb-md-5 mb-3 pb-3">Balai Latihan Kerja Pemerintah Jawa Timur.</h1>
                        <a href="about.html" class="btn btn-lg btn-outline-primary btn-hover-shadow mb-3 me-sm-4 me-2 px-md-5 px-4">Tentang Kami</a>
                        <a href="courses.html" class="btn btn-lg btn-gradient btn-hover-shadow mb-3 px-md-5 px-4">Ikuti Pelatihan</a>
                    </div>
                    <div class="col-md-6 col-sm-10 order-md-2 order-1 mx-md-0 mx-auto mb-md-0 mb-5">
                        <img src="https://createx.createx.studio/assets/img/online-courses/home/hero/illustration.svg" alt="Illustration">
                    </div>
                </div>
                <div class="mb-md-5 py-4">
                    <ul class="d-md-flex d-none align-items-center justify-content-between flex-md-nowrap flex-wrap list-unstyled">
                        <li class="d-flex flex-lg-row flex-column align-items-center mb-md-0 mb-4 text-dark text-nowrap">
                            <span class="h1 mb-lg-0 mb-1 me-lg-2">1200</span>
                            Alumni
                        </li>
                        <li class="d-md-block d-none fs-sm text-primary">&bull;</li>
                        <li class="d-flex flex-lg-row flex-column align-items-center mb-md-0 mb-4 text-dark text-nowrap">
                            <span class="h1 mb-lg-0 mb-1 me-lg-2">84</span>
                            Pelatihan
                        </li>
                        <li class="d-md-block d-none fs-sm text-primary">&bull;</li>
                        <li class="d-flex flex-lg-row flex-column align-items-center mb-md-0 mb-4 text-dark text-nowrap">
                            <span class="h1 mb-lg-0 mb-1 me-lg-2">16</span>
                            Perusahaan
                        </li>
                        <li class="d-md-block d-none fs-sm text-primary">&bull;</li>
                        <li class="d-flex flex-lg-row flex-column align-items-center mb-md-0 mb-4 text-dark text-nowrap">
                            <span class="h1 mb-lg-0 mb-1 me-lg-2">5</span>
                            Tahun Berpengalaman
                        </li>
                    </ul>
                </div>
            </div>
            <div class="jarallax-img" style="background-image: url(<?= base_url('assets/themes/createx/'); ?>img/online-courses/home/hero/bg.png);"></div>
        </section>


        <!-- About -->
        <section class="pt-lg-5 pt-4 pb-lg-6 pb-5 bg-repeat-0 bg-position-center bg-size-contain" style="background-image: url(https://createx.createx.studio/assets/img/online-courses/home/shapes/01-about.svg);">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 me-auto mb-md-0 mb-4 pb-md-0 pb-3">
                        <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/home/about.jpg" alt="About" class="rounded">
                    </div>
                    <div class="col-lg-4 col-md-5">
                        <h3 class="h6 mb-2 text-uppercase">Tentang kami</h3>
                        <h2 class="h1 mb-4 pb-lg-3">Mengapa harus kami?</h2>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex mb-2 pb-1">
                                <i class="ci-check mt-1 me-3 text-primary"></i>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry
                            </li>
                            <li class="d-flex mb-2 pb-1">
                                <i class="ci-check mt-1 me-3 text-primary"></i>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry
                            </li>
                            <li class="d-flex mb-2 pb-1">
                                <i class="ci-check mt-1 me-3 text-primary"></i>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry
                            </li>
                            <li class="d-flex mb-2 pb-1">
                                <i class="ci-check mt-1 me-3 text-primary"></i>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry
                            </li>
                            <li class="d-flex mb-2 pb-1">
                                <i class="ci-check mt-1 me-3 text-primary"></i>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry
                            </li>
                            <li class="d-flex mb-2 pb-1">
                                <i class="ci-check mt-1 me-3 text-primary"></i>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry
                            </li>
                        </ul>
                        <a href="about.html" class="btn btn-gradient btn-hover-shadow mt-lg-5 mt-4">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </section>


        <!-- Courses -->
        <section class="container pt-lg-5 pt-4 pb-5">
            <h3 class="h6 mb-2 text-uppercase">Siap untuk belajar?</h3>
            <div class="d-flex align-items-center justify-content-between mb-lg-5 mb-4 pb-md-2">
                <h2 class="h1 mb-0">Kategori Pelatihan</h2>
                <div class="d-sm-block d-none">
                    <a href="courses.html" class="btn btn-lg btn-outline-primary btn-hover-shadow">View all courses</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-grid-gutter">
                    <a href="course-single.html" class="card card-horizontal card-hover shadow heading-highlight">
                        <div class="card-img-top bg-position-center-top" style="background-image: url(<?= base_url('assets/themes/createx/'); ?>img/online-courses/courses/curator/01.jpg);"></div>
                        <div class="card-body">
                            <span class="badge bg-success mb-3 fs-sm">Marketing</span>
                            <h5 class="card-title mb-3 py-1">The Ultimate Google Ads Training Course</h5>
                            <div class="text-muted">
                                <span class="fw-bold text-primary">$100</span>
                                <span class="text-border px-1">|</span>
                                by Jerome Bell
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-grid-gutter">
                    <a href="course-single.html" class="card card-horizontal card-hover shadow heading-highlight">
                        <div class="card-img-top bg-position-center-top" style="background-image: url(<?= base_url('assets/themes/createx/'); ?>img/online-courses/courses/curator/02.jpg);"></div>
                        <div class="card-body">
                            <span class="badge bg-info mb-3 fs-sm">Management</span>
                            <h5 class="card-title mb-3 py-1">Product Management Fundamentals</h5>
                            <div class="text-muted">
                                <span class="fw-bold text-primary">$480</span>
                                <span class="text-border px-1">|</span>
                                by Jerome Bell
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-grid-gutter">
                    <a href="course-single.html" class="card card-horizontal card-hover shadow heading-highlight">
                        <div class="card-img-top bg-position-center-top" style="background-image: url(<?= base_url('assets/themes/createx/'); ?>img/online-courses/courses/curator/03.jpg);"></div>
                        <div class="card-body">
                            <span class="badge bg-warning mb-3 fs-sm">HR &amp; Recruting</span>
                            <h5 class="card-title mb-3 py-1">HR Management and Analytics</h5>
                            <div class="text-muted">
                                <span class="fw-bold text-primary">$200</span>
                                <span class="text-border px-1">|</span>
                                by Jerome Bell
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-grid-gutter">
                    <a href="course-single.html" class="card card-horizontal card-hover shadow heading-highlight">
                        <div class="card-img-top bg-position-center-top" style="background-image: url(<?= base_url('assets/themes/createx/'); ?>img/online-courses/courses/curator/04.jpg);"></div>
                        <div class="card-body">
                            <span class="badge bg-success mb-3 fs-sm">Marketing</span>
                            <h5 class="card-title mb-3 py-1">Brand Management & PR Communications</h5>
                            <div class="text-muted">
                                <span class="fw-bold text-primary">$530</span>
                                <span class="text-border px-1">|</span>
                                by Jerome Bell
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-grid-gutter">
                    <a href="course-single.html" class="card card-horizontal card-hover shadow heading-highlight">
                        <div class="card-img-top bg-position-center-top" style="background-image: url(<?= base_url('assets/themes/createx/'); ?>img/online-courses/courses/curator/05.jpg);"></div>
                        <div class="card-body">
                            <span class="badge bg-info mb-3 fs-sm">Management</span>
                            <h5 class="card-title mb-3 py-1">Business Development Management</h5>
                            <div class="text-muted">
                                <span class="fw-bold text-primary">$400</span>
                                <span class="text-border px-1">|</span>
                                by Jerome Bell
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-grid-gutter">
                    <a href="course-single.html" class="card card-horizontal card-hover shadow heading-highlight">
                        <div class="card-img-top bg-position-center-top" style="background-image: url(<?= base_url('assets/themes/createx/'); ?>img/online-courses/courses/curator/06.jpg);"></div>
                        <div class="card-body">
                            <span class="badge mb-3 fs-sm text-light" style="background-color: #F52F6E;">Design</span>
                            <h5 class="card-title mb-3 py-1">Graphic Design Basic</h5>
                            <div class="text-muted">
                                <span class="fw-bold text-primary">$500</span>
                                <span class="text-border px-1">|</span>
                                by Jerome Bell
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="d-sm-none d-block py-3 text-center">
                <a href="courses.html" class="btn btn-lg btn-outline-primary">View all courses</a>
            </div>
        </section>





        <!-- Events -->
        <section class="py-lg-5 py-4 bg-faded-primary jarallax" data-jarallax data-speed="0.8">
            <div class="jarallax-img" style="background-image: url(https://createx.createx.studio/assets/img/online-courses/home/shapes/02-events.svg);"></div>
            <div class="container py-4">
                <h3 class="h6 mb-2 text-uppercase text-sm-center">Pembukaan Pendaftaran Pelatihan</h3>
                <h2 class="h1 mb-lg-5 pb-md-2 text-sm-center">Kursus &amp; Praktikum</h2>

                <!-- Card horizontal -->
                <div class="card card-horizontal border-0 mb-4 px-sm-5 py-sm-0 py-3">
                    <div class="card-header flex-shrink-0 my-sm-4 ms-sm-n2 py-sm-2 px-sm-0 border-0">
                        <div class="d-flex">
                            <span class="display-4 mb-0 text-primary" style="font-size: 3rem;">05</span>
                            <div class="ms-3 ps-1">
                                <h6 class="h5 mb-1">August</h6>
                                <span class="text-muted">11:00 – 14:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body m-sm-4 py-sm-2 py-0 px-sm-3">
                        <h3 class="h5 mb-sm-1 mb-2">
                            <a href="event-single.html" class="nav-link">Formation of the organizational structure of the company in the face of uncertainty.</a>
                        </h3>
                        <span class="text-muted">Online master-class</span>
                    </div>
                    <div class="card-footer flex-shrink-0 my-sm-4 mt-5 me-sm-n2 py-sm-2 px-sm-0 border-0">
                        <a href="event-single.html" class="btn btn-outline-primary btn-hover-shadow d-sm-inline-block d-block">View more</a>
                    </div>
                </div>

                <!-- Card horizontal -->
                <div class="card card-horizontal border-0 mb-4 px-sm-5 py-sm-0 py-3">
                    <div class="card-header flex-shrink-0 my-sm-4 ms-sm-n2 py-sm-2 px-sm-0 border-0">
                        <div class="d-flex">
                            <span class="display-4 mb-0 text-primary" style="font-size: 3rem;">24</span>
                            <div class="ms-3 ps-1">
                                <h6 class="h5 mb-sm-1 mb-2">July</h6>
                                <span class="text-muted">11:00 – 12:30</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body m-sm-4 py-sm-2 py-0 px-sm-3">
                        <h3 class="h5 mb-1">
                            <a href="event-single.html" class="nav-link">Building a customer service department. Best Practices.</a>
                        </h3>
                        <span class="text-muted">Online lecture</span>
                    </div>
                    <div class="card-footer flex-shrink-0 my-sm-4 mt-5 me-sm-n2 py-sm-2 px-sm-0 border-0">
                        <a href="event-single.html" class="btn btn-outline-primary btn-hover-shadow d-sm-inline-block d-block">View more</a>
                    </div>
                </div>

                <!-- Card horizontal -->
                <div class="card card-horizontal border-0 mb-4 px-sm-5 py-sm-0 py-3">
                    <div class="card-header flex-shrink-0 my-sm-4 ms-sm-n2 py-sm-2 px-sm-0 border-0">
                        <div class="d-flex">
                            <span class="display-4 mb-0 text-primary" style="font-size: 3rem;">16</span>
                            <div class="ms-3 ps-1">
                                <h6 class="h5 mb-sm-1 mb-2">July</h6>
                                <span class="text-muted">10:00 – 13:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body m-sm-4 py-sm-2 py-0 px-sm-3">
                        <h3 class="h5 mb-1">
                            <a href="event-single.html" class="nav-link">How to apply methods of speculative design in practice. Worldbuilding prototyping.</a>
                        </h3>
                        <span class="text-muted">Online workshop</span>
                    </div>
                    <div class="card-footer flex-shrink-0 my-sm-4 mt-5 me-sm-n2 py-sm-2 px-sm-0 border-0">
                        <a href="event-single.html" class="btn btn-outline-primary btn-hover-shadow d-sm-inline-block d-block">View more</a>
                    </div>
                </div>
                <h4 class="h3 pt-sm-4 pt-3 mb-0 text-center">
                    Do you want more?
                    <a href="events-list.html" class="btn btn-lg btn-gradient btn-hover-shadow d-sm-inline-block d-block mt-sm-0 mt-4 ms-sm-4">Explore all events</a>
                </h4>
            </div>
        </section>


        <!-- Certificate -->
        <section class="container pt-lg-6 pt-5">
            <div class="row pt-3 pb-4 py-lg-0">
                <div class="col-md-5 col-sm-6 me-auto">
                    <div class="col-lg-9 px-0">
                        <h3 class="h6 mb-2 text-uppercase">Sertifikat Pelatihan</h3>
                        <h2 class="h1 mb-lg-5">Keahlian Anda akan dikonfirmasi</h2>
                        <p>Kami Menerbitkan Sertifikat Legal yang dapat digunakan dalam membangun karir mu.</p>
                    </div>
                    <ul class="list-unstyled d-flex flex-sm-nowrap flex-wrap">
                        <li class="mb-lg-0 mb-3 me-4 pe-3">
                            <img src="https://createx.createx.studio/assets/img/online-courses/logo/eu-business-school.svg" alt="EU Business School">
                        </li>
                        <li class="mb-lg-0 mb-3 me-4 pe-3">
                            <img src="https://createx.createx.studio/assets/img/online-courses/logo/mcgill-university.svg" alt="Mcgill University">
                        </li>
                        <li class="mb-lg-0 mb-3 me-4 pe-3">
                            <img src="https://createx.createx.studio/assets/img/online-courses/logo/incae-business-school.svg" alt="Incae Business School">
                        </li>
                    </ul>
                </div>
                <div class="col-md-7 col-sm-6">
                    <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/courses/certificate.jpg" alt="Certificate" class="mb-md-n5 mb-sm-0 mb-n4 rounded shadow-lg position-relative" style="z-index: 5;">
                </div>
            </div>
        </section>


        <!-- Parallax wrapper -->
        <div class="pt-5 bg-secondary jarallax" data-jarallax data-speed="0.8">


            <!-- Parallax image -->
            <div class="jarallax-img" style="background-image: url(https://createx.createx.studio/assets/img/online-courses/home/shapes/03-team-testimonials.svg);"></div>


            <!-- Team -->
            <section class="container pt-lg-6 pt-5 pb-lg-5 pb-4">
                <h3 class="h6 mb-2 text-uppercase">Tutor terbaik kami</h3>
                <div class="mb-lg-5 mb-4 pb-md-2 d-flex justify-content-between">
                    <h2 class="h1 mb-0">kenalan dengan tim kami yuk</h2>
                    <div class="tns-custom-controls tns-controls-inverse mb-md-n4" id="tns-team-controls" tabindex="0">
                        <button type="button" data-controls="prev" tabindex="-1">
                            <i class="ci-arrow-left"></i>
                        </button>
                        <button type="button" data-controls="next" tabindex="-1">
                            <i class="ci-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Carousel component -->
                <div class="tns-carousel-wrapper">
                    <div class="tns-carousel-inner" data-carousel-options='{
              "gutter": 30,
              "nav": false,
              "controlsContainer": "#tns-team-controls",
              "responsive": {
                "0": {
                  "items": 1
                },
                "576": {
                  "items": 2
                },
                "768": {
                  "items": 3
                },
                "992": {
                  "items": 4
                }
              }
            }'>
                        <div class="card team bg-transparent">
                            <div class="card-img">
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/about/team/01.jpg" alt="Team member" />
                                <div class="card-floating-links text-end">
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-facebook"></i>
                                    </a>
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-instagram"></i>
                                    </a>
                                    <a class="btn-social bs-light" href="#">
                                        <i class="ci-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body py-3 text-center">
                                <h4 class="card-title h5 mb-1">Dianne Russell</h4>
                                <p class="card-text text-muted">Founder and CEO</p>
                            </div>
                        </div>
                        <div class="card team bg-transparent">
                            <div class="card-img">
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/about/team/02.jpg" alt="Team member" />
                                <div class="card-floating-links text-end">
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-facebook"></i>
                                    </a>
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-instagram"></i>
                                    </a>
                                    <a class="btn-social bs-light" href="#">
                                        <i class="ci-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body py-3 text-center">
                                <h4 class="card-title h5 mb-1">Jerome Bell</h4>
                                <p class="card-text text-muted">Founder and Program Director</p>
                            </div>
                        </div>
                        <div class="card team bg-transparent">
                            <div class="card-img">
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/about/team/03.jpg" alt="Team member" />
                                <div class="card-floating-links text-end">
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-facebook"></i>
                                    </a>
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-instagram"></i>
                                    </a>
                                    <a class="btn-social bs-light" href="#">
                                        <i class="ci-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body py-3 text-center">
                                <h4 class="card-title h5 mb-1">Kristin Watson</h4>
                                <p class="card-text text-muted">Marketer, Curator of Marketing Course</p>
                            </div>
                        </div>
                        <div class="card team bg-transparent">
                            <div class="card-img">
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/about/team/04.jpg" alt="Team member" />
                                <div class="card-floating-links text-end">
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-facebook"></i>
                                    </a>
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-instagram"></i>
                                    </a>
                                    <a class="btn-social bs-light" href="#">
                                        <i class="ci-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body py-3 text-center">
                                <h4 class="card-title h5 mb-1">Marvin McKinney</h4>
                                <p class="card-text text-muted">PM, Curator of Management Course</p>
                            </div>
                        </div>
                        <div class="card team bg-transparent">
                            <div class="card-img">
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/about/team/05.jpg" alt="Team member" />
                                <div class="card-floating-links text-end">
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-facebook"></i>
                                    </a>
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-instagram"></i>
                                    </a>
                                    <a class="btn-social bs-light" href="#">
                                        <i class="ci-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body py-3 text-center">
                                <h4 class="card-title h5 mb-1">Leslie Alexander Li</h4>
                                <p class="card-text text-muted">Curator of HR & Recruting Course</p>
                            </div>
                        </div>
                        <div class="card team bg-transparent">
                            <div class="card-img">
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/about/team/06.jpg" alt="Team member" />
                                <div class="card-floating-links text-end">
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-facebook"></i>
                                    </a>
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-instagram"></i>
                                    </a>
                                    <a class="btn-social bs-light" href="#">
                                        <i class="ci-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body py-3 text-center">
                                <h4 class="card-title h5 mb-1">Kathryn Murphy</h4>
                                <p class="card-text text-muted">Analyst and Marketing specialist</p>
                            </div>
                        </div>
                        <div class="card team bg-transparent">
                            <div class="card-img">
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/about/team/07.jpg" alt="Team member" />
                                <div class="card-floating-links text-end">
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-facebook"></i>
                                    </a>
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-instagram"></i>
                                    </a>
                                    <a class="btn-social bs-light" href="#">
                                        <i class="ci-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body py-3 text-center">
                                <h4 class="card-title h5 mb-1">Brooklyn Simmons</h4>
                                <p class="card-text text-muted">Curator of Development Course</p>
                            </div>
                        </div>
                        <div class="card team bg-transparent">
                            <div class="card-img">
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/about/team/08.jpg" alt="Team member" />
                                <div class="card-floating-links text-end">
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-facebook"></i>
                                    </a>
                                    <a class="btn-social bs-light me-2" href="#">
                                        <i class="ci-instagram"></i>
                                    </a>
                                    <a class="btn-social bs-light" href="#">
                                        <i class="ci-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body py-3 text-center">
                                <h4 class="card-title h5 mb-1">Cody Fisher</h4>
                                <p class="card-text text-muted">UX Designer, Curator of Design Course</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Testimonials -->
            <section class="container pt-5 pb-lg-5 pb-4">
                <h3 class="h6 mb-2 text-uppercase text-sm-center">Testimoni</h3>
                <h2 class="h1 mb-lg-5 pb-md-2 text-sm-center">Apa kata mereka </h2>

                <!-- Carousel -->
                <div class="tns-carousel-wrapper tns-nav-outside tns-controls-outside pb-4">
                    <div class="tns-carousel-inner" data-carousel-options='{
              "autoHeight": true,
              "responsive": {
                "0": {
                  "controls": false
                },
                "768": {
                  "controls": true
                }
              }
            }'>

                        <!-- Carousel item -->
                        <div class="px-md-4">
                            <div class="blockquote-card card border-0 mb-md-4">
                                <div class="card-body mt-sm-4 mx-xl-5 mx-sm-4 pb-0">
                                    <blockquote class="blockquote">
                                        <p class="lead">Vero dolores exercitationem quidem eum sit accusamus. Quisquam cumque nesciunt fugiat quae delectus quo earum deleniti, labore odio sint recusandae aperiam aut nemo placeat pariatur beatae dignissimos amet quos! A ipsam soluta possimus quisquam commodi natus nam aperiam ratione deleniti.</p>
                                    </blockquote>
                                </div>
                                <div class="card-footer mb-sm-4 mx-xl-5 mx-sm-4 pt-0 border-0 d-flex align-items-center">
                                    <img class="me-3 rounded-circle" src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/testimonials/01.jpg" width="72" alt="Author">
                                    <div>
                                        <h3 class="h6 mb-0">Courtney Alexander</h3>
                                        <span class="fs-sm text-muted">Position, Company </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carousel item -->
                        <div class="px-md-4">
                            <div class="blockquote-card card border-0 mb-md-4">
                                <div class="card-body mt-sm-4 mx-xl-5 mx-sm-4 pb-0">
                                    <blockquote class="blockquote">
                                        <p class="lead">Optio deleniti eos harum minus mollitia aut labore maxime rem ex dolores, dignissimos quidem exercitationem dicta praesentium quasi quia nam expedita sed blanditiis alias facere magnam pariatur asperiores. Ad et ullam eos maiores culpa reiciendis delectus ipsa. Eveniet tempora vel quo repellendus nihil, veniam numquam.</p>
                                    </blockquote>
                                </div>
                                <div class="card-footer mb-sm-4 mx-xl-5 mx-sm-4 pt-0 border-0 d-flex align-items-center">
                                    <img class="me-3 rounded-circle" src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/testimonials/02.jpg" width="72" alt="Author">
                                    <div>
                                        <h3 class="h6 mb-0">Eleanor Pena</h3>
                                        <span class="fs-sm text-muted">Position, Course</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div> <!-- / Parallax wrapper -->


        <!-- Blog -->
        <section class="container py-lg-6 py-5">
            <h3 class="h6 mb-2 text-uppercase">Blog Kami</h3>
            <div class="d-flex align-items-center justify-content-between mb-lg-5 mb-4 pb-md-2">
                <h2 class="h1 mb-0">Berita Terbaru</h2>
                <div class="d-sm-block d-none">
                    <a href="blog.html" class="btn btn-lg btn-gradient btn-hover-shadow">Lihat Semua</a>
                </div>
            </div>

            <!-- Carousel -->
            <div class="tns-carousel-wrapper tns-nav-outside">
                <div class="tns-carousel-inner" data-carousel-options='{
            "gutter": 30,
            "controls": false,
            "responsive": {
              "0": {
                "items": 1
              },
              "576": {
                "items": 2
              },
              "768": {
                "items": 3
              }
            }
          }'>
                    <div>
                        <!-- Post preview: card -->
                        <article class="image-scale card border-0">
                            <a class="image-inner card-header mb-3 p-0 border-0 rounded" href="blog-single.html">
                                <span class="badge bg-light badge-floating m-1">
                                    <i class="ci-mic align-middle me-1 fs-base"></i>
                                    Podcast
                                </span>
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/blog/01.jpg" alt="Blog card image">
                            </a>
                            <div class="card-body p-0">
                                <ul class="nav nav-muted mb-2">
                                    <li class="nav-item me-2">
                                        <a class="nav-link d-inline-block me-2 p-0 fs-sm fw-normal" href="#">
                                            Marketing
                                        </a>
                                        <span class="text-border px-1">|</span>
                                    </li>
                                    <li class="nav-item me-2">
                                        <a class="nav-link d-inline-block me-2 p-0 fs-sm fw-normal" href="#">
                                            <i class="ci-clock mt-n1 me-2 fs-base align-middle"></i>
                                            September 4, 2020
                                        </a>
                                        <span class="text-border px-1">|</span>
                                    </li>
                                    <li class="nav-item me-2">
                                        <span class="fs-sm text-muted">
                                            <i class="ci-clock mt-n1 me-2 fs-base align-middle"></i>
                                            36 min
                                        </span>
                                    </li>
                                </ul>
                                <h3 class="h5 mb-2 nav-dark">
                                    <a class="nav-link" href="blog-single.html">What is traffic arbitrage and does it really make money?</a>
                                </h3>
                                <p class="mb-3">Pharetra, ullamcorper iaculis viverra parturient sed id sed. Convallis proin dignissim lacus, purus gravida...</p>
                            </div>
                            <div class="card-footer p-0 border-0">
                                <div class="h6 mb-0">
                                    <a class="nav-link py-3" href="blog-single.html">Listen</a>
                                    <i class="ci-arrow-right text-primary align-middle h5 mb-0 ms-2"></i>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div>
                        <!-- Post preview: card -->
                        <article class="image-scale card border-0">
                            <a class="image-inner card-header mb-3 p-0 border-0 rounded" href="blog-single.html">
                                <span class="badge bg-light badge-floating m-1">
                                    <i class="ci-play-outline align-middle me-1 fs-base"></i>
                                    Video
                                </span>
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/blog/02.jpg" alt="Blog card image">
                            </a>
                            <div class="card-body p-0">
                                <ul class="nav nav-muted mb-2">
                                    <li class="nav-item me-2">
                                        <a class="nav-link d-inline-block me-2 p-0 fs-sm fw-normal" href="#">
                                            Management
                                        </a>
                                        <span class="text-border px-1">|</span>
                                    </li>
                                    <li class="nav-item me-2">
                                        <a class="nav-link d-inline-block me-2 p-0 fs-sm fw-normal" href="#">
                                            <i class="ci-clock mt-n1 me-2 fs-base align-middle"></i>
                                            August 25, 2020
                                        </a>
                                        <span class="text-border px-1">|</span>
                                    </li>
                                    <li class="nav-item me-2">
                                        <span class="fs-sm text-muted">
                                            <i class="ci-clock mt-n1 me-2 fs-base align-middle"></i>
                                            45 min
                                        </span>
                                    </li>
                                </ul>
                                <h3 class="h5 mb-2 nav-dark">
                                    <a class="nav-link" href="blog-single.html">What to do and who to talk to if you want to get feedback on the product</a>
                                </h3>
                                <p class="mb-3">Neque a, senectus consectetur odio in aliquet nec eu. Ultricies ac nibh urna urna sagittis faucibus...</p>
                            </div>
                            <div class="card-footer p-0 border-0">
                                <div class="h6 mb-0">
                                    <a class="nav-link py-3" href="blog-single.html">Watch</a>
                                    <i class="ci-arrow-right text-primary align-middle h5 mb-0 ms-2"></i>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div>
                        <!-- Post preview: card -->
                        <article class="image-scale card border-0">
                            <a class="image-inner card-header mb-3 p-0 border-0 rounded" href="blog-single.html">
                                <span class="badge bg-light badge-floating m-1">
                                    <i class="ci-files align-middle me-1 fs-base"></i>
                                    Article
                                </span>
                                <img src="<?= base_url('assets/themes/createx/'); ?>img/online-courses/blog/03.jpg" alt="Blog card image">
                            </a>
                            <div class="card-body p-0">
                                <ul class="nav nav-muted mb-2">
                                    <li class="nav-item me-2">
                                        <a class="nav-link d-inline-block me-2 p-0 fs-sm fw-normal" href="#">
                                            Design
                                        </a>
                                        <span class="text-border px-1">|</span>
                                    </li>
                                    <li class="nav-item me-2">
                                        <a class="nav-link d-inline-block me-2 p-0 fs-sm fw-normal" href="#">
                                            <i class="ci-clock mt-n1 me-2 fs-base align-middle"></i>
                                            August 8, 2020
                                        </a>
                                    </li>
                                </ul>
                                <h3 class="h5 mb-2 nav-dark">
                                    <a class="nav-link" href="blog-single.html">Should you choose a creative profession if you are attracted to creativity?</a>
                                </h3>
                                <p class="mb-3">Curabitur nisl tincidunt eros venenatis vestibulum ac placerat. Tortor, viverra sed vulputate ultrices...</p>
                            </div>
                            <div class="card-footer p-0 border-0">
                                <div class="h6 mb-0">
                                    <a class="nav-link py-3" href="blog-single.html">Read</a>
                                    <i class="ci-arrow-right text-primary align-middle h5 mb-0 ms-2"></i>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>


        <!-- Subscribe -->
        <section class="py-lg-6 py-5 bg-faded-primary bg-repeat-0 bg-position-center-bottom bg-size-cover" style="background-image: url(<?= base_url('assets/themes/createx/'); ?>img/online-courses/subscribe-bg.png);">
            <div class="container pt-md-4 pt-3 pb-md-5 pb-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <h3 class="h6 mb-2 text-uppercase text-center">Jangan sampai ketinggalan</h3>
                        <h2 class="h1 mb-lg-5 pb-md-2 text-center">Gabung bersama kami yuk dan kurangi angka pengangguran.</h2>
                    </div>
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <form class="input-group needs-validation" novalidate>
                            <input class="form-control rounded bg-light" type="email" placeholder="ketik emailmu..." required>
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

    <!-- Main theme script-->
    <script src="<?= base_url('assets/themes/createx/'); ?>js/theme.min.js"></script>
</body>

<!-- Mirrored from createx.createx.studio/online-courses/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 10 Jul 2022 01:50:26 GMT -->

</html>