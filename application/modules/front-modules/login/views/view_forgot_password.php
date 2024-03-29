<style>
    .main-img-user::after {
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
</style>
<div class="container-fluid p-0">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-900" style="background: url(<?= base_url('upload/banner/' . $login_background); ?>);background-position:center;">
            <?php
            if (isset($_GET['update_background'])) {
                echo '
                        <form class="form_update_background mt-2" style="z-index:1000;">
                            <div class="main-img-user profile-user">
                                <a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                                <input type="file" class="profile-edit upload_form upload_background" name="upload_background" data-type="admin">
                                <a class="btn btn-danger btn-pill btn-sm btn-icon rounded-50 btn_remove_image" href="JavaScript:void(0);" data-type="background" style="margin-left:50px;height:33px;width:33px;"><i class="fa fa-trash tx-12"></i></a>
                            </div>
                        </form>
                    ';
            }
            ?>
            <div class="row wd-100p mx-auto text-center">
                <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p" style="width: 70%;">
                    <?php
                    $dir = realpath(APPPATH . '../upload/banner');
                    if (file_exists($dir . '/' . $login_image) && $login_image != '') {
                        echo '
                            <img src="' . base_url('upload/banner/' . $login_image) . '" class="my-auto ht-xl-80p wd-md-100p wd-xl-60p mx-auto" alt="logo">
                        ';
                    }

                    if (isset($_GET['update_background'])) {
                        echo '
                        <form class="form_update_image">
                            <div class="main-img-user profile-user">
                                <a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                                <input type="file" class="profile-edit upload_form upload_image" name="upload_image" data-type="admin">
                                <a class="btn btn-danger btn-pill btn-sm btn-icon rounded-50 btn_remove_image" href="JavaScript:void(0);" data-type="image" style="margin-left:50px;height:33px;width:33px;"><i class="fa fa-trash tx-12"></i></a>
                            </div>
                        </form>
                    ';
                    }
                    ?>

                </div>
                <div class="col-12 text-center">

                </div>
                <div class="col-12 text-white">
                    <h4 class="text-capitalize font-weight-bold"><?= $company_name; ?></h4>
                    <p><?= $company_address; ?></p>
                    <div class="mt-4 d-flex mx-auto text-center justify-content-center">
                        <button class="btn btn-icon btn-facebook" type="button">
                            <span class="btn-inner--icon"> <i class="bx bxl-facebook tx-20 tx-facebook"></i> </span>
                        </button>
                        <button class="btn btn-icon" type="button">
                            <span class="btn-inner--icon"> <i class="bx bxl-twitter tx-20 tx-info"></i> </span>
                        </button>
                        <button class="btn btn-icon" type="button">
                            <span class="btn-inner--icon"> <i class="bx bxl-linkedin tx-20 tx-indigo"></i> </span>
                        </button>
                        <button class="btn btn-icon" type="button">
                            <span class="btn-inner--icon"> <i class="bx bxl-instagram tx-20 tx-pink"></i> </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- The content half -->
        <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
            <div class="login d-flex align-items-center py-2">
                <!-- Demo content-->
                <div class="container p-0">
                    <div class="row">
                        <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                            <div class="card-sigin">
                                <div class="mb-5 d-flex"> <a href="index.html"><img src="<?= base_url('assets/themes/valex/'); ?>img/logo-ivoyages.png" class="sign-favicon ht-70" alt="logo"></a>
                                </div>
                                <div class="card-sigin">
                                    <div class="main-signup-header">
                                        <h2>Lupa Password</h2>
                                        <h5 class="font-weight-semibold mb-4">masukan emailmu untuk reset password.</h5>

                                        <div class="col-12 text-center p-2">
                                            <span class="text-danger text-message"></span>
                                        </div>

                                        <div class="html_respon">
                                            <form class="form-reset">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control" name="email" autofocus placeholder="masukan email.." type="text">
                                                    <span class="help-block"></span>
                                                </div>
                                                <button class="btn btn-main-primary btn-block btn-send-email">Kirim Email <i class="fa fa-sign-in"></i></button>
                                            </form>
                                        </div>
                                        <div class="main-signin-footer mt-5">
                                            <p>Login kembali ? <a href="<?= Modules::run('helper/create_url', 'login') ?>">Klik Disini</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End -->
            </div>
        </div><!-- End -->
    </div>
</div>