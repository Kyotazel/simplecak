<div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form ">
    <div class="container-fluid">
        <div class="row row-sm">
            <div class="card-body mt-2 mb-2">
                <!-- <img src="<?= base_url('assets/') ?>img/logo3-color.png" class=" d-lg-none header-brand-img text-left float-left mb-4" alt="logo"> -->
                <div class="clearfix"></div>
                <div class="html_respon">
                    <div class="form-reset-password">
                        <h5 class="text-left mb-2">RESET PASSWORD</h5>
                        <p class="mb-4 text-muted tx-13 ml-0 text-left">masukan password baru.</p>
                        <div class="col-12 text-center p-2">
                            <span class="text-danger text-message"></span>
                        </div>
                        <div class="form-group">
                            <label>password Baru</label>
                            <input class="form-control" id="password" name="password" autofocus placeholder="masukan pasword.." type="password">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Ulangi password</label>
                            <input class="form-control" id="re_password" name="re_password" autofocus placeholder="masukan pasword.." type="password">
                            <span class="invalid-feedback"></span>
                        </div>

                        <button class="btn ripple btn-main-primary btn-block btn-reset-password" data-id="<?= $this->encrypt->encode($data_user->id); ?>">Simpan Password <i class="fa fa-sign-in"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>