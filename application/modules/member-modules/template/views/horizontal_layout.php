<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

    <!-- Title -->
    <title><?= $page_title; ?> </title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/themes/valex/'); ?>img/brand/favicon.png" type="image/x-icon" />

    <!-- Icons css -->
    <link href="<?= base_url('assets/themes/valex/'); ?>css/icons.css" rel="stylesheet">

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

    <!-- Internal Spectrum-colorpicker css -->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/spectrum-colorpicker/spectrum.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css" rel="stylesheet">

    <!--Internal   Notify -->
    <link href="<?= base_url('assets/themes/valex/') ?>plugins/notify/css/notifIt.css" rel="stylesheet" />

    <!--  Right-sidemenu css -->
    <link rel="stylesheet" href="<?= base_url('assets/themes/valex/') ?>css/chosen.min.css">
    <link href="<?= base_url('assets/themes/valex/'); ?>plugins/sidebar/sidebar.css" rel="stylesheet">

    <!--  Custom Scroll bar-->
    <link href="<?= base_url('assets/themes/valex/'); ?>plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" />

    <!--- Style css-->
    <link href="<?= base_url('assets/themes/valex/'); ?>css/style.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/valex/'); ?>css/style-dark.css" rel="stylesheet">

    <!-- Interenal Accordion Css -->
    <link href="<?= base_url('assets/themes/valex/'); ?>plugins/accordion/accordion.css" rel="stylesheet" />

    <!---Skinmodes css-->
    <link href="<?= base_url('assets/themes/valex/'); ?>css/skin-modes.css" rel="stylesheet" />

    <!--- Animations css-->
    <link href="<?= base_url('assets/themes/valex/'); ?>css/animate.css" rel="stylesheet">
    <link href="<?= base_url('assets/themes/valex/') ?>css/custom.css" rel="stylesheet">


</head>
<script>
    //configuration
    var _token_user = '<?= urlencode($this->encrypt->encode($this->session->userdata('us_token_login'))); ?>';
    var _controller = '<?= $this->router->fetch_class(); ?>';
    var _base_url = '<?= substr(base_url(), 0, strlen(base_url()) - 1); ?>';
</script>

<body class="main-body">

    <!-- Loader -->
    <div id="global-loader" style="display: none;">
        <img src="<?= base_url('assets/themes/valex/'); ?>img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <!-- main-header opened -->
        <div class="main-header nav nav-item hor-header">
            <div class="container">
                <div class="main-header-left ">
                    <a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a><!-- sidebar-toggle-->
                    <a class="header-brand" href="<?= Modules::run('helper/create_url', '/'); ?>">
                        <img src="<?= base_url('assets/themes/valex/'); ?>img/brand/logo-white.png" class="desktop-dark">
                        <img src="<?= base_url('assets/themes/valex/'); ?>img/logo-ivoyages.png" class="desktop-logo">
                        <img src="<?= base_url('assets/themes/valex/'); ?>img/brand/favicon.png" class="desktop-logo-1">
                        <img src="<?= base_url('assets/themes/valex/'); ?>img/brand/favicon-white.png" class="desktop-logo-dark">
                    </a>
                    <?php $this->load->view('_partials/search_bar'); ?>
                </div><!-- search -->
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

                        <?php $this->load->view('_partials/notification'); ?>
                        <!-- <div class="nav-item full-screen fullscreen-button">
                            <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize">
                                    <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                                </svg></a>
                        </div> -->
                        <?php $this->load->view('_partials/account_header_menu'); ?>
                        <!-- <div class="dropdown main-header-message right-toggle">
                            <a class="nav-link pr-0" data-toggle="sidebar-right" data-target=".sidebar-right">
                                <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                    <line x1="3" y1="12" x2="21" y2="12"></line>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <line x1="3" y1="18" x2="21" y2="18"></line>
                                </svg>
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /main-header -->

        <!--Horizontal-main -->
        <?php $this->load->view('_partials/horizontal_main_menu'); ?>
        <!--Horizontal-main -->
        <!-- main-content opened -->
        <div class="main-content horizontal-content">
            <!-- container opened -->
            <div class="container">
                <!-- breadcrumb -->
                <?php $this->load->view('_partials/breadcrumb'); ?>
                <!-- breadcrumb -->
                <?php
                $this->load->view($module_directory . '/' . $view_file);
                ?>
            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->
        <?php $this->load->view('_partials/right_toggle_menu'); ?>

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

    <!--Internal  Datepicker js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/jquery-ui/ui/widgets/datepicker.js"></script>

    <!-- Bootstrap Bundle js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Ionicons js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/ionicons/ionicons.js"></script>

    <!-- Moment js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/moment/moment.js"></script>

    <!-- Internal Select2 js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/select2/js/select2.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>js/chosen.jquery.min.js"></script>

    <!-- P-scroll js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/perfect-scrollbar/p-scroll.js"></script>

    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/jquery.maskedinput/jquery.maskedinput.js"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/spectrum-colorpicker/spectrum.js"></script>

    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
    <!-- Ionicons js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js"></script>

    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/owl-carousel/owl.carousel.js"></script>

    <!-- Internal Select2 js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/select2/js/select2.min.js"></script>
    <!-- Internal Input tags js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/inputtags/inputtags.js"></script>

    <!--Internal Fileuploads js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/fileuploads/js/fileupload.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/fileuploads/js/file-upload.js"></script>

    <!--Internal Fancy uploader js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/fancyuploder/jquery.ui.widget.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/fancyuploder/jquery.fileupload.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/fancyuploder/jquery.iframe-transport.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/fancyuploder/fancy-uploader.js"></script>

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

    <!-- Rating js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/rating/jquery.rating-stars.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/rating/jquery.barrating.js"></script>

    <!-- Custom Scroll bar Js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Horizontalmenu js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

    <!-- Sticky js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>js/sticky.js"></script>

    <!-- Right-sidebar js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/sidebar/sidebar.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/sidebar/sidebar-custom.js"></script>

    <!--- Internal Accordion Js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/accordion/accordion.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>js/accordion.js"></script>

    <!--Internal  Notify js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/notify/js/notifIt.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/notify/js/notifit-custom.js"></script>

    <!--Internal  spectrum-colorpicker js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/spectrum-colorpicker/spectrum.js"></script>

    <!-- eva-icons js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>js/eva-icons.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/sweet-alert/jquery.sweet-alert.js"></script>

    <!-- custom js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>js/custom.js"></script>
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

</html>