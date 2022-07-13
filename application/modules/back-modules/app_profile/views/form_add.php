<div class="row row-sm">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card  box-shadow-0">
            <div class="card-header">
                <h4 class="card-title mb-1">INPUT USER</h4>
                <p class="mb-2">silahkan isi form dengan benar.</p>
            </div>
            <div class="card-body pt-0">
                <form class="form-horizontal form-input">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mb-2">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" placeholder="nama lengkap..">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" placeholder="Email...">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right">Telp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="phone_number" placeholder="telp..">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right">Alamat Lengkap</label>
                                <div class="col-sm-10">
                                    <textarea name="address" class="form-control" i cols="30" rows="10"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-2">
                                <label for="inputEmail3" class="col-sm-3 control-label text-right">Credential</label>
                                <div class="col-sm-9">
                                    <select name="credential" class="form-control">
                                        <?php
                                        foreach ($all_credential as $item_credential) {
                                            echo '
                                                    <option value="' . $item_credential->id . '">' . $item_credential->name . '</option>
                                                ';
                                        }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row mb-2">
                                <label for="inputEmail3" class="col-sm-3 control-label text-right">username</label>
                                <div class="col-sm-9">
                                    <input type="text" name="username" class="form-control" id="inputEmail3" placeholder="username..">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="inputPassword3" class="col-sm-3 control-label text-right">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row mb-2 ">
                                <label for="inputPassword3" class="col-sm-3 control-label text-right">Ulangi Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="re_password" placeholder="Password">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group mb-2 text-right mt-3">
                                <a href="<?= Modules::run('helper/create_url', 'app_user') ?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                                &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-primary btn_save" data-method="add"><i class="fa fa-save"></i> Simpan User</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>