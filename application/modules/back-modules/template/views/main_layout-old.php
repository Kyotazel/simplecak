<!doctype html>
<html lang="en" dir="ltr">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="<?= $company_tagline; ?>">
    <meta name="Author" content="<?= $company_name; ?>">
    <meta name="Keywords" content="<?= $company_tagline; ?>" />

    <!-- Title -->
    <title><?= $page_title; ?> </title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/themes/valex/') ?>img/logo.png" type="image/x-icon" />
    <!-- Icons css -->
    <link href="<?= base_url('assets/themes/valex/') ?>css/icons.css" rel="stylesheet">

    <!---Internal  Owl Carousel css-->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/owl-carousel/owl.carousel.css" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/multislider/multislider.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/sweet-alert/sweetalert.css" rel="stylesheet">

    <!---Internal  Prism css-->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/prism/prism.css" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/inputtags/inputtags.css" rel="stylesheet">

    <link href="<?= base_url('assets/themes/valex/') ?>plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/pickerjs/picker.min.css" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/spectrum-colorpicker/spectrum.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css" rel="stylesheet">

    <!---Internal Fileupload css-->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/fancyuploder/fancy_fileupload.css" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="<?= base_url('assets/themes/valex/') ?>plugins/sumoselect/sumoselect.css">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="<?= base_url('assets/themes/valex/') ?>plugins/telephoneinput/telephoneinput.css">

    <link href="<?= base_url('assets/themes/valex/') ?>plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">

    <!-- dropzoves -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugin/dropzone/dropzone.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugin/dropzone/basic.min.css') ?>">

    <!--  Right-sidemenu css -->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/sidebar/sidebar.css" rel="stylesheet">
    <!-- P-scroll bar css-->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/perfect-scrollbar/p-scrollbar.css" rel="stylesheet" />
    <!--Internal   Notify -->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/notify/css/notifIt.css" rel="stylesheet" />
    <!--  Left-Sidebar css -->
    <link rel="stylesheet" href="<?= base_url('assets/themes/valex/') ?>css/chosen.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/themes/valex/') ?>css/sidemenu.css">
    <!--- Style css --->
    <link rel="stylesheet" href="<?= base_url('assets/themes/valex/') ?>css/jquery-ui.css">
    <link href="<?= base_url('assets/themes/valex/') ?>css/style.css" rel="stylesheet">

    <!--- Dark-mode css --->
    <link href="<?= base_url('assets/themes/valex/') ?>css/style-dark.css" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="<?= base_url('assets/themes/valex/') ?>css/skin-modes.css" rel="stylesheet" />
    <!--- Animations css-->
    <link href="<?= base_url('assets/themes/valex/') ?>css/animate.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/valex/') ?>css/custom.css" rel="stylesheet">
</head>

<script>
    //configuration
    var _token_user = '<?= urlencode($this->encrypt->encode($this->session->userdata('us_token_login'))); ?>';
    var _controller = '<?= $this->router->fetch_class(); ?>';
    var _base_url = '<?= substr(base_url(), 0, strlen(base_url()) - 1); ?>';
</script>

<body class="main-body app sidebar-mini">

    <!-- Loader -->
    <div id="global-loader" style="display: none;">
        <img src="<?= base_url('assets/themes/valex/'); ?>img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <!-- main-sidebar -->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar sidebar-scroll">
            <div class="main-sidebar-header active">
                <a class="desktop-logo logo-light active" href="<?= Modules::run('helper/create_url', '/'); ?>"><img src="<?= base_url('assets/themes/valex/'); ?>img/logo.png" class="main-logo" alt="logo"></a>
                <a class="desktop-logo logo-dark active" href="<?= Modules::run('helper/create_url', '/'); ?>"><img src="<?= base_url('assets/themes/valex/'); ?>img/logo.png" class="main-logo dark-theme" alt="logo"></a>
                <a class="logo-icon mobile-logo icon-light active" href="<?= Modules::run('helper/create_url', '/'); ?>"><img src="<?= base_url('assets/themes/valex/'); ?>img/logo.png" class="logo-icon" alt="logo"></a>
                <a class="logo-icon mobile-logo icon-dark active" href="<?= Modules::run('helper/create_url', '/'); ?>"><img src="<?= base_url('assets/themes/valex/'); ?>img/logo.png" class="logo-icon dark-theme" alt="logo"></a>
            </div>
            <?php $this->load->view('_partials/sidebar_main_menu'); ?>
        </aside>
        <!-- main-sidebar -->

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- main-header -->
            <div class="main-header sticky side-header nav nav-item">
                <div class="container-fluid">
                    <div class="main-header-left ">
                        <div class="responsive-logo">
                            <a href="<?= Modules::run('helper/create_url', '/'); ?>"><img src="<?= base_url('assets/themes/valex/'); ?>img/brand/logo.png" class="logo-1" alt="logo"></a>
                            <a href="<?= Modules::run('helper/create_url', '/'); ?>"><img src="<?= base_url('assets/themes/valex/'); ?>img/brand/logo-white.png" class="dark-logo-1" alt="logo"></a>
                            <a href="<?= Modules::run('helper/create_url', '/'); ?>"><img src="<?= base_url('assets/themes/valex/'); ?>img/brand/favicon.png" class="logo-2" alt="logo"></a>
                            <a href="<?= Modules::run('helper/create_url', '/'); ?>"><img src="<?= base_url('assets/themes/valex/'); ?>img/brand/favicon.png" class="dark-logo-2" alt="logo"></a>
                        </div>
                        <div class="app-sidebar__toggle" data-toggle="sidebar">
                            <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                            <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
                        </div>
                        <?php $this->load->view('_partials/search_bar'); ?>
                    </div>
                    <div class="main-header-right">
                        <?php
                        //$this->load->view('_partials/language'); 
                        ?>
                        <div class="nav nav-item  navbar-nav-right ml-auto">
                            <!-- <div class="nav-link" id="bs-example-navbar-collapse-1">
                                <form class="navbar-form" role="search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search">
                                        <span class="input-group-btn">
                                            <button type="reset" class="btn btn-default">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button type="submit" class="btn btn-default nav-link resp-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                                </svg>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div> -->
                            <?php
                            $this->load->view('_partials/notification');
                            ?>

                            <!-- <div class="nav-item full-screen fullscreen-button">
                                <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize">
                                        <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                                    </svg></a>
                            </div> -->
                            <?php $this->load->view('_partials/account_header_menu'); ?>
                            <?php
                            if ($this->session->userdata('us_credential_admin')) {
                                echo '
                                    <div class="dropdown main-header-message right-toggle">
                                        <a class="nav-link pr-0" data-toggle="sidebar-right" data-target=".sidebar-right">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                                <line x1="3" y1="18" x2="21" y2="18"></line>
                                            </svg>
                                        </a>
                                    </div>
                                    ';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /main-header -->

            <!-- container -->
            <div class="container-fluid">
                <?php $this->load->view('_partials/breadcrumb'); ?>
                <!-- row -->
                <div class="mb-1">
                    <?php

                    if ($this->session->flashdata('success_message')) {
                        echo '
                            <div class="alert alert-success" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                ' . $this->session->flashdata('success_message') . '
                            </div>
                            ';
                    }

                    if ($this->session->flashdata('error_message')) {
                        echo '
                            <div class="alert alert-dangeralert-success" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                ' . $this->session->flashdata('error_message') . '
                            </div>
                            ';
                    }

                    ?>
                </div>

                <?php
                $this->load->view($module_directory . '/' . $view_file);
                ?>

                <div class="modal fade" tabindex="-1" id="modal_print">
                    <div class="modal-dialog" style="max-width: 90%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                            </div>
                            <div class="modal-body">
                                <div class="html_respon_print" style="min-height: 90%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- row closed -->
            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->

        <!-- Sidebar-right-->
        <?php
        $this->load->view('_partials/right_toggle_menu');
        ?>
        <!--/Sidebar-right-->

        <!-- Footer opened -->
        <div class="main-footer ht-40">
            <div class="container-fluid pd-t-0-f ht-100p">
                <span>Copyright © <?= date('Y'); ?> <a href="#"><?= $company_name; ?></a>. All rights reserved.</span>
            </div>
        </div>
        <!-- Footer closed -->
    </div>
    <!-- End Page -->

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
    <!-- JQuery min js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap Bundle js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!--Internal  Datepicker js -->
    <!-- Ionicons js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/ionicons/ionicons.js"></script>
    <!-- Moment js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/moment/moment.js"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/jquery.maskedinput/jquery.maskedinput.js"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/spectrum-colorpicker/spectrum.js"></script>
    <!-- Ionicons js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js"></script>

    <!-- chart -->
    <!--Internal Apexchart js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>js/apexcharts.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/chart.js/Chart.bundle.min.js"></script>


    <!-- P-scroll js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/perfect-scrollbar/p-scroll.js"></script>
    <!-- Sticky js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>js/sticky.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>js/chosen.jquery.min.js"></script>
    <!-- eva-icons js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>js/eva-icons.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>js/shortcut.js"></script>
    <!-- Rating js-->
    <!-- Internal Owl Carousel js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/owl-carousel/owl.carousel.js"></script>
    <!-- Internal Input tags js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/inputtags/inputtags.js"></script>

    <!--Internal Fileuploads js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/fileuploads/js/fileupload.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/fileuploads/js/file-upload.js"></script>

    <!--Internal  Form-elements js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>js/advanced-form-elements.js"></script>

    <!--Internal Sumoselect js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/sumoselect/jquery.sumoselect.js"></script>

    <!-- Internal TelephoneInput js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/telephoneinput/telephoneinput.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/telephoneinput/inttelephoneinput.js"></script>

    <script src="<?= base_url('assets/themes/valex/'); ?>/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/datatable/js/dataTables.dataTables.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/datatable/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/datatable/js/responsive.dataTables.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/datatable/js/jquery.dataTables.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/datatable/js/dataTables.bootstrap4.js"></script>


    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/rating/jquery.rating-stars.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/rating/jquery.barrating.js"></script>
    <!-- Sidebar js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/side-menu/sidemenu.js"></script>
    <!-- Right-sidebar js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/sidebar/sidebar.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/sidebar/sidebar-custom.js"></script>

    <!--Internal  Notify js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/notify/js/notifIt.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/notify/js/notifit-custom.js"></script>

    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/sweet-alert/jquery.sweet-alert.js"></script>

    <script src="<?= base_url('assets/plugin/'); ?>jQuery-Scanner/jquery.scannerdetection.js" type="text/javascript"></script>

    <!-- <link href="<?= base_url('assets/plugin/') ?>print_js/print.min.css" rel="stylesheet"> -->
    <script src="<?php echo base_url('assets/plugin/'); ?>print_js/print.min.js"></script>

    <!-- <script src="<?= base_url('assets/themes/valex/'); ?>js/form-elements.js"></script> -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/darggable/jquery-ui-darggable.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!--   ckeditor -->
    <script type="text/javascript" src="<?php echo base_url('assets/plugin/'); ?>ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugin/'); ?>ckeditor/adapters/jquery.js"></script>
    <!--   Dropzones -->
    <script type="text/javascript" src="<?php echo base_url('assets/plugin/'); ?>dropzone/dropzone.min.js"></script>
    <!-- additional js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>js/responsive-paginate.js"></script>

    <script script src="<?= base_url('assets/themes/valex/'); ?>js/custom.js"></script>
    <?php
    echo '
        <script src="' . base_url('application/modules/back-modules/template/js/js-module-configuration.js') . '"></script>
    ';
    foreach ($module_js as $item_js) {
        echo '
                <script src="' . base_url('application/modules/back-modules/' . $module_directory . '/js/' . $item_js . '.js') . '"></script>
            ';
    }
    ?>
</body>

</html>