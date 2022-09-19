<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codeigniter.spruko.com/spruha/spruha-ltr/pages/signin by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 30 Jun 2022 06:40:14 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="Spruha - Codeigniter Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin template, admin dashboard, bootstrap dashboard template, bootstrap 4 admin template, codeigniter 4 admin panel, template codeigniter bootstrap, php, codeigniter, php framework, web template, html5 template, php code, php html, codeigniter 4, codeigniter mvc">

    <!-- Favicon -->
    <link rel="icon" href="https://codeigniter.spruko.com/spruha/spruha-ltr/public/assets/img/brand/favicon.ico" type="image/x-icon" />

    <!-- Title -->
    <title>Spruha - Codeigniter Admin & Dashboard Template</title>

    <!-- Bootstrap css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Icons css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/web-fonts/icons.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/web-fonts/plugin.css" rel="stylesheet" />

    <!-- Style css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/style.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/skins.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/dark-style.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/colors/default.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/sweet-alert/sweetalert.css" rel="stylesheet">

    <!-- Color css-->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="<?= base_url('assets/themes/spruhha/') ?>css/colors/color.css" />

    <!-- Select2 css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>plugins/select2/css/select2.min.css" rel="stylesheet">

    <!-- Sidemenu css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/sidemenu/sidemenu.css" rel="stylesheet">

    <!-- Sidemenu css-->
    <link href="<?= base_url('assets/themes/spruhha/') ?>css/custom.css" rel="stylesheet">

</head>

<script>
    //configuration
    var _token_user = '<?= urlencode($this->encrypt->encode($this->session->userdata('us_token_login'))); ?>';
    var _controller = '<?= $this->router->fetch_class(); ?>';
    var _base_url = '<?= substr(base_url(), 0, strlen(base_url()) - 1); ?>';
</script>

<body class="main-body leftmenu">

    <!-- Loader -->
    <div id="global-loader" style="display:none;">
        <img src="https://codeigniter.spruko.com/spruha/spruha-ltr/public/assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- End Loader -->

    <!-- Page -->
    <div class="page main-signin-wrapper">

        <!-- Row -->
        <div class="row signpages text-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row row-sm">
                        <?php
                        $this->load->view($module_directory . '/' . $view_file);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->

    </div>
    <!-- End Page -->

    <!-- Jquery js-->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap js-->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/bootstrap/js/bootstrap.min.js"></script>

    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/sweet-alert/jquery.sweet-alert.js"></script>

    <!-- Select2 js-->
    <script src="<?= base_url('assets/themes/spruhha/') ?>plugins/select2/js/select2.min.js"></script>
    <script src="<?= base_url('assets/plugin/'); ?>bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

    <!-- Custom js -->
    <script src="<?= base_url('assets/themes/spruhha/') ?>js/custom.js"></script>
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

<!-- Mirrored from codeigniter.spruko.com/spruha/spruha-ltr/pages/signin by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 30 Jun 2022 06:40:14 GMT -->

</html>