<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="<?= $company_tagline; ?>">
    <meta name="Author" content="<?= $company_name; ?>">
    <meta name="Keywords" content="<?= $company_tagline; ?>" />

    <!-- Title -->
    <title> <?= $page_title; ?> </title>
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/themes/valex/'); ?>img/brand/favicon.png" type="image/x-icon" />
    <!-- Icons css -->
    <link href="<?= base_url('assets/themes/valex/'); ?>css/icons.css" rel="stylesheet">
    <!--  Right-sidemenu css -->
    <link href="<?= base_url('assets/themes/valex/'); ?>plugins/sidebar/sidebar.css" rel="stylesheet">
    <!-- P-scroll bar css-->
    <link href="<?= base_url('assets/themes/valex/'); ?>plugins/perfect-scrollbar/p-scrollbar.css" rel="stylesheet" />
    <!--  Left-Sidebar css -->
    <link rel="stylesheet" href="<?= base_url('assets/themes/valex/'); ?>css/sidemenu.css">
    <!--- Style css --->
    <link href="<?= base_url('assets/themes/valex/'); ?>css/style.css" rel="stylesheet">
    <!--- Dark-mode css --->
    <link href="<?= base_url('assets/themes/valex/'); ?>css/style-dark.css" rel="stylesheet">
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

<body class="error-page1  bg-light">

    <!-- Loader -->
    <div id="global-loader" style="display: none;">
        <img src="<?= base_url('assets/themes/valex/'); ?>img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">
        <?php
        $this->load->view($module_directory . '/' . $view_file);
        ?>
    </div>
    <!-- End Page -->

    <!-- JQuery min js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Bundle js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Ionicons js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/ionicons/ionicons.js"></script>

    <!-- Moment js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/moment/moment.js"></script>

    <!-- eva-icons js -->
    <script src="<?= base_url('assets/themes/valex/'); ?>js/eva-icons.min.js"></script>

    <!-- Rating js-->
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/rating/jquery.rating-stars.js"></script>
    <script src="<?= base_url('assets/themes/valex/'); ?>plugins/rating/jquery.barrating.js"></script>

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