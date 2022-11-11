<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codeigniter.spruko.com/spruha/spruha-ltr/pages/horizontallight by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 30 Jun 2022 06:38:35 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="Spruha - Codeigniter Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin template, admin dashboard, bootstrap dashboard template, bootstrap 4 admin template, codeigniter 4 admin panel, template codeigniter bootstrap, php, codeigniter, php framework, web template, html5 template, php code, php html, codeigniter 4, codeigniter mvc">

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/') ?>img/logo-mini.png" type="image/x-icon" />

    <!-- Title -->
    <title><?= $page_title; ?> </title>

    <!-- Bootstrap css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Icons css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/web-fonts/icons.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/web-fonts/plugin.css" rel="stylesheet" />

    <!-- Style css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/style.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/skins.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/dark-style.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/colors/default.css" rel="stylesheet">

    <!-- Color css-->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="<?= base_url('assets/themes/spruhha/') ?>css/colors/color.css">

    <!---Select2 css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/select2/css/select2.min.css" rel="stylesheet">

    <!-- Mutipleselect css-->
    <link rel="stylesheet" href="<?= base_url('assets/themes/spruhha/') ?>plugins/multipleselect/multiple-select.css">

    <!-- Switcher css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>switcher/css/switcher.css" rel="stylesheet">

    <!-- Internal Sweet-Alert css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/sweet-alert/sweetalert.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />

    <!-- Jrsoftmedia -->
    <link href="<?= base_url('assets/plugin/'); ?>notify/css/notifIt.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/plugin/jquery.ui/') ?>css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugin/dropzone/dropzone.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugin/dropzone/basic.min.css') ?>">
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/custom.css" rel="stylesheet">
</head>
<script>
    //configuration
    var _token_user = '<?= urlencode($this->encrypt->encode($this->session->userdata('us_token_login'))); ?>';
    var _controller = '<?= $this->router->fetch_class(); ?>';
    var _base_url = '<?= substr(base_url(), 0, strlen(base_url()) - 1); ?>';
</script>

<body class="horizontalmenu">

    <!-- Loader -->
    <div id="global-loader" style="display:none;">
        <img src="https://codeigniter.spruko.com/spruha/spruha-ltr/public/assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- End Loader -->

    <!-- Page -->
    <div class="page">

        <!-- Main Header-->
        <div class="main-header side-header">
            <div class="container">
                <div class="main-header-left">
                    <a class="main-header-menu-icon d-lg-none" href="#" id="mainNavShow"><span></span></a>
                    <a class="main-logo" href="<?= Modules::run('helper/create_url', '/'); ?>">
                        <img src="<?= base_url('assets/') ?>img/logo3-color.png" class="header-brand-img desktop-logo" alt="logo">
                        <img src="<?= base_url('assets/') ?>img/logo3-color.png" class="header-brand-img desktop-logo theme-logo" alt="logo">
                    </a>
                </div>
                <div class="main-header-center">
                    <div class="responsive-logo">
                        <a href="<?= Modules::run('helper/create_url', '/'); ?>"><img src="<?= base_url('assets/') ?>img/logo3-color.png" class="mobile-logo" alt="logo"></a>
                        <a href="<?= Modules::run('helper/create_url', '/'); ?>"><img src="<?= base_url('assets/') ?>img/logo3-color.png" class="mobile-logo-dark" alt="logo"></a>
                    </div>
                    <div class="input-group">
                        <?php $this->load->view('_partials/search_bar'); ?>
                    </div>
                </div>
                <div class="main-header-right">
                    <?php
                    //$this->load->view('_partials/language'); 
                    $this->load->view('_partials/notification');
                    ?>

                    <?php $this->load->view('_partials/account_header_menu'); ?>

                    <!-- <?php
                    if ($this->session->userdata('us_credential_admin')) {
                        echo '
                                <div class="dropdown d-md-flex header-settings">
                                    <a href="#" class="nav-link icon" data-toggle="sidebar-right" data-target=".sidebar-right">
                                        <i class="fe fe-align-right header-icons"></i>
                                    </a>
                                </div>
                                <button class="navbar-toggler navresponsive-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                                    <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
                                </button>
                            ';
                    }
                    ?> -->
                </div>
            </div>
        </div>
        <!-- End Main Header-->

        <!-- Mobile-header -->
        <div class="mobile-main-header">
            <div class="mb-1 navbar navbar-expand-lg  nav nav-item  navbar-nav-right responsive-navbar navbar-dark  ">
                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                    <div class="d-flex order-lg-2 mr-auto">
                        <div class="dropdown header-search">
                            <a class="nav-link icon header-search">
                                <i class="fe fe-search"></i>
                            </a>
                            <div class="dropdown-menu">
                                <div class="main-form-search p-2">
                                    <div class="input-group">
                                        <div class="input-group-btn search-panel">
                                            <select class="form-control select2-no-search">
                                                <option label="All categories">
                                                </option>
                                                <option value="IT Projects">
                                                    IT Projects
                                                </option>
                                                <option value="Business Case">
                                                    Business Case
                                                </option>
                                                <option value="Microsoft Project">
                                                    Microsoft Project
                                                </option>
                                                <option value="Risk Management">
                                                    Risk Management
                                                </option>
                                                <option value="Team Building">
                                                    Team Building
                                                </option>
                                            </select>
                                        </div>
                                        <input type="search" class="form-control" placeholder="Search for anything...">
                                        <button class="btn search-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown main-header-notification flag-dropdown">
                            <a class="nav-link icon country-Flag">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <circle cx="256" cy="256" r="256" fill="#f0f0f0" />
                                    <g fill="#0052b4">
                                        <path d="M52.92 100.142c-20.109 26.163-35.272 56.318-44.101 89.077h133.178L52.92 100.142zM503.181 189.219c-8.829-32.758-23.993-62.913-44.101-89.076l-89.075 89.076h133.176zM8.819 322.784c8.83 32.758 23.993 62.913 44.101 89.075l89.074-89.075H8.819zM411.858 52.921c-26.163-20.109-56.317-35.272-89.076-44.102v133.177l89.076-89.075zM100.142 459.079c26.163 20.109 56.318 35.272 89.076 44.102V370.005l-89.076 89.074zM189.217 8.819c-32.758 8.83-62.913 23.993-89.075 44.101l89.075 89.075V8.819zM322.783 503.181c32.758-8.83 62.913-23.993 89.075-44.101l-89.075-89.075v133.176zM370.005 322.784l89.075 89.076c20.108-26.162 35.272-56.318 44.101-89.076H370.005z" />
                                    </g>
                                    <g fill="#d80027">
                                        <path d="M509.833 222.609H289.392V2.167A258.556 258.556 0 00256 0c-11.319 0-22.461.744-33.391 2.167v220.441H2.167A258.556 258.556 0 000 256c0 11.319.744 22.461 2.167 33.391h220.441v220.442a258.35 258.35 0 0066.783 0V289.392h220.442A258.533 258.533 0 00512 256c0-11.317-.744-22.461-2.167-33.391z" />
                                        <path d="M322.783 322.784L437.019 437.02a256.636 256.636 0 0015.048-16.435l-97.802-97.802h-31.482v.001zM189.217 322.784h-.002L74.98 437.019a256.636 256.636 0 0016.435 15.048l97.802-97.804v-31.479zM189.217 189.219v-.002L74.981 74.98a256.636 256.636 0 00-15.048 16.435l97.803 97.803h31.481zM322.783 189.219L437.02 74.981a256.328 256.328 0 00-16.435-15.047l-97.802 97.803v31.482z" />
                                    </g>
                                </svg>
                            </a>
                            <div class="dropdown-menu">
                                <a href="#" class="dropdown-item d-flex ">
                                    <span class="avatar  ml-3 align-self-center bg-transparent"><img src="<?= base_url('assets/themes/spruhha/') ?>img/flags/french_flag.jpg" alt="img"></span>
                                    <div class="d-flex">
                                        <span class="mt-2">French</span>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex">
                                    <span class="avatar  ml-3 align-self-center bg-transparent"><img src="<?= base_url('assets/themes/spruhha/') ?>img/flags/germany_flag.jpg" alt="img"></span>
                                    <div class="d-flex">
                                        <span class="mt-2">Germany</span>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex">
                                    <span class="avatar ml-3 align-self-center bg-transparent"><img src="<?= base_url('assets/themes/spruhha/') ?>img/flags/italy_flag.jpg" alt="img"></span>
                                    <div class="d-flex">
                                        <span class="mt-2">Italy</span>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex">
                                    <span class="avatar ml-3 align-self-center bg-transparent"><img src="<?= base_url('assets/themes/spruhha/') ?>img/flags/russia_flag.jpg" alt="img"></span>
                                    <div class="d-flex">
                                        <span class="mt-2">Russia</span>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex">
                                    <span class="avatar  ml-3 align-self-center bg-transparent"><img src="<?= base_url('assets/themes/spruhha/') ?>img/flags/spain_flag.jpg" alt="img"></span>
                                    <div class="d-flex">
                                        <span class="mt-2">spain</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="dropdown ">
                            <a class="nav-link icon full-screen-link">
                                <i class="fe fe-maximize fullscreen-button fullscreen header-icons"></i>
                                <i class="fe fe-minimize fullscreen-button exit-fullscreen header-icons"></i>
                            </a>
                        </div>
                        <div class="dropdown main-header-notification">
                            <a class="nav-link icon" href="#">
                                <i class="fe fe-bell header-icons"></i>
                                <span class="badge badge-danger nav-link-badge">4</span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="header-navheading">
                                    <p class="main-notification-text">You have 1 unread notification<span class="badge badge-pill badge-primary mr-3">View all</span></p>
                                </div>
                                <div class="main-notification-list">
                                    <div class="media new">
                                        <div class="main-img-user online"><img alt="avatar" src="<?= base_url('assets/themes/spruhha/') ?>img/users/5.jpg"></div>
                                        <div class="media-body">
                                            <p>Congratulate <strong>Olivia James</strong> for New template start</p><span>Oct 15 12:32pm</span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="main-img-user"><img alt="avatar" src="<?= base_url('assets/themes/spruhha/') ?>img/users/2.jpg"></div>
                                        <div class="media-body">
                                            <p><strong>Joshua Gray</strong> New Message Received</p><span>Oct 13 02:56am</span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="main-img-user online"><img alt="avatar" src="<?= base_url('assets/themes/spruhha/') ?>img/users/3.jpg"></div>
                                        <div class="media-body">
                                            <p><strong>Elizabeth Lewis</strong> added new schedule realease</p><span>Oct 12 10:40pm</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-footer">
                                    <a href="#">View All Notifications</a>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown main-header-notification">
                            <a class="nav-link icon" href="#">
                                <i class="fe fe-message-square header-icons"></i>
                                <span class="badge badge-success nav-link-badge">3</span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="header-navheading">
                                    <p class="main-notification-text tx-medium text-left"> 3 New messages </p>
                                </div>
                                <div class="main-notification-list">
                                    <div class="media new">
                                        <div class="main-img-user online"><img alt="avatar" src="<?= base_url('assets/themes/spruhha/') ?>img/users/10.jpg"></div>
                                        <div class="media-body">
                                            <p>Paul Molive <span>I'm sorry but i'm not sure how...</span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="main-img-user online"><img alt="avatar" src="<?= base_url('assets/themes/spruhha/') ?>img/users/8.jpg"></div>
                                        <div class="media-body">
                                            <p>Sahar DaryAll<span> set ! Now, time to get to you now......</span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="main-img-user online"><img alt="avatar" src="<?= base_url('assets/themes/spruhha/') ?>img/users/11.jpg"></div>
                                        <div class="media-body">
                                            <p>Barney Cull</p><span>Here are some products ...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-footer">
                                    <a href="#">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown main-profile-menu">
                            <a class="d-flex" href="#">
                                <span class="main-img-user"><img alt="avatar" src="<?= base_url('assets/themes/spruhha/') ?>img/users/1.jpg"></span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="header-navheading">
                                    <h6 class="main-notification-title">Sonia Taylor</h6>
                                    <p class="main-notification-text">Web Designer</p>
                                </div>
                                <a class="dropdown-item border-top" href="profile.html">
                                    <i class="fe fe-user"></i> My Profile
                                </a>
                                <a class="dropdown-item" href="profile.html">
                                    <i class="fe fe-edit"></i> Edit Profile
                                </a>
                                <a class="dropdown-item" href="profile.html">
                                    <i class="fe fe-settings"></i> Account Settings
                                </a>
                                <a class="dropdown-item" href="profile.html">
                                    <i class="fe fe-settings"></i> Support
                                </a>
                                <a class="dropdown-item" href="profile.html">
                                    <i class="fe fe-compass"></i> Activity
                                </a>
                                <a class="dropdown-item" href="signin.html">
                                    <i class="fe fe-power"></i> Sign Out
                                </a>
                            </div>
                        </div>
                        <div class="dropdown  header-settings">
                            <a href="#" class="nav-link icon" data-toggle="sidebar-right" data-target=".sidebar-right">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-right header-icons">
                                    <line x1="21" y1="10" x2="7" y2="10"></line>
                                    <line x1="21" y1="6" x2="3" y2="6"></line>
                                    <line x1="21" y1="14" x2="3" y2="14"></line>
                                    <line x1="21" y1="18" x2="7" y2="18"></line>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile-header closed -->

        <!-- Horizonatal menu-->
        <div class="main-navbar hor-menu sticky">
            <div class="container">
                <?php $this->load->view('_partials/horizontal_main_menu'); ?>
            </div>
        </div>
        <!--End  Horizonatal menu-->

        <!-- Main Content-->
        <div class="main-content pt-0">

            <div class="container">
                <div class="inner-body">
                    <!-- Page Header -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title text-uppercase tx-24 mg-b-5"><?= $page_title; ?></h2>
                            <?php $this->load->view('_partials/breadcrumb'); ?>
                        </div>
                        <div class="d-flex">
                        </div>
                    </div>
                    <!-- End Page Header -->
                    <?php
                    $this->load->view($module_directory . '/' . $view_file);
                    ?>
                </div>
            </div>
        </div>

        <!-- Main Footer-->
        <div class="footer main-footer text-center mt-auto navbar-fixed-bottom">
            <div class="container">
                <div class="row row-sm">
                    <div class="col-md-12">
                        <span>Copyright © <?= date('Y'); ?> <a href="#"><?= $company_name; ?></a>. All rights reserved.</span>
                    </div>
                </div>
            </div>
        </div>
        <!--End Footer-->

        <!-- Sidebar -->
        <!-- End Sidebar -->


    </div>

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>

    <!-- Jquery js-->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap js-->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Perfect-scrollbar js -->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!-- Sidemenu js -->
    <!-- <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/sidemenu/sidemenu.js"></script> -->

    <!-- Sidebar js -->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/sidebar/sidebar.js"></script>

    <!-- Select2 js-->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/select2/js/select2.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>js/select2.js"></script>

    <!-- Sticky js -->
    <script src="<?= base_url('assets/themes/spruhha/') ?>js/sticky.js"></script>

    <!-- Switcher js -->
    <script src="<?= base_url('assets/themes/spruhha/') ?>switcher/js/switcher.js"></script>

    <!-- Internal Sweet-Alert js-->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/sweet-alert/jquery.sweet-alert.js"></script>

    <!-- Internal Data Table js -->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/fileexport/jszip.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/fileexport/pdfmake.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/fileexport/vfs_fonts.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/fileexport/buttons.html5.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/fileexport/buttons.print.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/datatable/fileexport/buttons.colVis.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/summernote/summernote-bs4.js"></script>
    
    <!-- jrsoftmedia setting -->
    <script src="<?= base_url('assets/plugin/'); ?>notify/js/notifIt.js"></script>
    <script src="<?= base_url('assets/plugin/'); ?>jQuery-Scanner/jquery.scannerdetection.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/plugin/'); ?>chosen.jquery.min.js"></script>
    <script src="<?php echo base_url('assets/plugin/'); ?>print_js/print.min.js"></script>

    <script src="<?= base_url('assets/plugin/'); ?>darggable/jquery-ui-darggable.min.js"></script>

    <!-- Custom js -->
    <script src="<?= base_url('assets/themes/spruhha/') ?>js/custom.js"></script>

    <!--   ckeditor -->
    <script type="text/javascript" src="<?php echo base_url('assets/plugin/'); ?>ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugin/'); ?>ckeditor/adapters/jquery.js"></script>
    <!--   Dropzones -->
    <script type="text/javascript" src="<?php echo base_url('assets/plugin/'); ?>dropzone/dropzone.min.js"></script>
    <!-- additional js -->
    <script src="<?= base_url('assets/plugin/'); ?>responsive-paginate.js"></script>

    <?php
    echo '
            <script src="' . base_url('application/modules/member-modules/template/js/js-module-configuration.js') . '"></script>
        ';
    foreach ($module_js as $item_js) {
        echo '
                    <script src="' . base_url('application/modules/member-modules/' . $module_directory . '/js/' . $item_js . '.js') . '"></script>
                ';
    }
    ?>


</body>

<!-- Mirrored from codeigniter.spruko.com/spruha/spruha-ltr/pages/horizontallight by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 30 Jun 2022 06:38:37 GMT -->

</html>