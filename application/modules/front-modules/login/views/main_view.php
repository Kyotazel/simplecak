<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
            <div class="row wd-100p mx-auto text-center">
                <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                    <img src="<?= base_url('assets/themes/valex/'); ?>img/media/login.png" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
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
                                <div class="mb-5 d-flex"> <a href="index.html"><img src="<?= base_url('assets/themes/valex/'); ?>img/brand/favicon.png" class="sign-favicon ht-40" alt="logo"></a>
                                    <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Va<span>le</span>x</h1>
                                </div>
                                <div class="card-sigin">
                                    <div class="main-signup-header">
                                        <h2>Welcome back!</h2>
                                        <h5 class="font-weight-semibold mb-4">Please sign in to continue.</h5>

                                        <div class="col-12 text-center p-2">
                                            <span class="text-danger text-message"></span>
                                        </div>

                                        <form class="form-login">
                                            <div class="form-group">
                                                <label>Username atau Email</label>
                                                <input class="form-control" name="username" autofocus placeholder="masukan username atau email.." type="text">
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input class="form-control" name="password" placeholder="masukan password" type="password">
                                                <span class="help-block"></span>
                                            </div>
                                            <button class="btn btn-main-primary btn-block btn-sign-in">Login <i class="fa fa-sign-in"></i></button>
                                            <!-- <div class="row row-xs">
                                                <div class="col-sm-6">
                                                    <button class="btn btn-block"><i class="fab fa-facebook-f"></i> Signup with Facebook</button>
                                                </div>
                                                <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                                                    <button class="btn btn-info btn-block"><i class="fab fa-twitter"></i> Signup with Twitter</button>
                                                </div>
                                            </div> -->
                                        </form>
                                        <div class="main-signin-footer mt-5">
                                            <p>Lupa pasword ? <a href="<?= Modules::run('helper/create_url', 'login/forgot_password') ?>">Klik Disini</a></p>
                                            <p>Belum punya akun ? <a href="#">Silahkan hubungi admin</a></p>
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