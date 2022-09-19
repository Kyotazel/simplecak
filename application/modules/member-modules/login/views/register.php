<div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
    <div class="mt-5 pt-4 p-2 pos-absolute">
        <img src="<?= base_url('assets/') ?>img/logo3.png" style="width:50%;" class="header-brand-img mb-4" alt="logo">
        <div class="clearfix"></div>
        <img src="<?= base_url('assets/img/logo-pemkot-sby.png'); ?>" class="ht-200 mb-0" alt="user">
        <h5 class="mt-4 text-white"><?= $company_name; ?></h5>
        <span class="tx-white-6 tx-13 mb-5 mt-xl-0"><?= $company_tagline; ?></span>
    </div>
</div>
<div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form " style="min-height: 500px;">
    <div class="container-fluid">
        <div class="row row-sm">
            <div class="card-body mt-2 mb-2">
                <img src="<?= base_url('assets/') ?>img/logo3-color.png" class=" d-lg-none header-brand-img text-left float-left mb-4" alt="logo">
                <div class="clearfix"></div>
                <form class="form-register">
                    <h5 class="text-left mb-2">Selamat Datang</h5>
                    <p class="mb-4 text-muted tx-13 ml-0 text-left">Silahkan masukan email untuk mendaftarkan akun.</p>

                    <div class="col-12 text-center p-2">
                        <span class="text-danger text-message"></span>
                    </div>
                    <div class="form-group text-left">
                        <label>Email</label>
                        <input class="form-control" name="email" autofocus placeholder="email.." type="text">
                        <span class="help-block"></span>
                    </div>

                    <button class="btn ripple btn-main-primary btn-block btn-sign-up">Register</button>
                </form>
                <div class="text-left mt-5 ml-0">
                    <p>Lupa pasword ? <a href="<?= Modules::run('helper/create_url', 'login/forgot_password') ?>">Klik Disini</a></p>
                    <p>Sudah punya akun ? <a href="#">Klik Disini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>