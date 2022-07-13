<?php
$active         = $data_user->status ? 'on' : '';
$active_create  = $data_user->access_create ? 'on' : '';
$active_update  = $data_user->access_update ? 'on' : '';
$active_delete  = $data_user->access_delete ? 'on' : '';

$image = base_url('assets/themes/valex/img/faces/6.jpg');
if (!empty($data_user->image)) {
    $base_dir = str_replace(PREFIX_CREDENTIAL_DIRECTORY . '/', '', BASE_DIR);
    $dir = $base_dir . 'upload/user/' . $data_user->image;
    if (file_exists($dir)) {
        $image = base_url('upload/user/' . $data_user->image);
    }
}

?>
<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="pl-0">
                    <div class="main-profile-overview text-center">
                        <form class="form_update_image_profile">
                            <div class="main-img-user profile-user">
                                <img alt="" src="<?= $image; ?>">
                                <a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                                <input type="file" class="profile-edit upload_form" name="upload_profile">
                            </div>
                        </form>
                        <div class=" mg-b-20">
                            <div>
                                <h5 class="main-profile-name"><?= $data_user->name; ?></h5>
                                <p class="main-profile-name-text"><?= $data_user->email; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 border p-2">
                                <h6><i class="fa fa-map-marker"></i> Alamat :</h6>
                                <div class="main-profile-bio     ">
                                    <?= nl2br($data_user->address); ?>
                                </div>
                            </div>
                            <div class="col-md-6 border p-2">
                                <h6><i class="fa fa-tv"></i> Credential :</h6>
                                <h5 class="text-info"><span class="badge badge-dark text-uppercase"><?= $data_user->credential_name; ?></span></h5>
                            </div>
                        </div>
                    </div><!-- main-profile-overview -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">

        <div class="card">
            <div class="card-body">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                        <li class="">
                            <a href="#home" data-toggle="tab" aria-expanded="true" class="active"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">Update Data</span> </a>
                        </li>
                        <li class="">
                            <a href="#profile" data-toggle="tab" aria-expanded="false" class=""> <span class="visible-xs"><i class="las la-images tx-15 mr-1"></i></span> <span class="hidden-xs">Update Login</span> </a>
                        </li>
                        <!-- <li class="">
                            <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-cog tx-16 mr-1"></i></span> <span class="hidden-xs">Log Activity</span> </a>
                        </li> -->
                    </ul>
                </div>
                <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                    <div class="tab-pane active" id="home">
                        <form class="form-update-profile">
                            <div class="form-group row mb-2">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="<?= $data_user->name; ?>" placeholder="nama lengkap..">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" value="<?= $data_user->email; ?>" placeholder="Email...">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right">Telp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="phone_number" value="<?= $data_user->phone_number; ?>" placeholder="telp..">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right">Alamat Lengkap</label>
                                <div class="col-sm-10">
                                    <textarea name="address" class="form-control" i cols="30" rows="10"><?= $data_user->address; ?> </textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group  mb-1 text-right">
                                <button type="submit" data-id="<?= $data_user->id; ?>" class="btn btn-primary btn_update_profile"><i class="fa fa-send"></i> Simpan Data</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="profile">
                        <form class="form-login">
                            <div class="form-group row mb-2">
                                <label for="inputEmail3" class="col-sm-3 control-label text-right">username</label>
                                <div class="col-sm-5">
                                    <input type="text" name="username" value="<?= $data_user->username; ?>" class="form-control" id="inputEmail3" placeholder="username..">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <small>(optional), silahkan di isi jika anda ingin update data</small>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row mb-2">
                                <label for="inputPassword3" class="col-sm-3 control-label text-right">Password</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <small>(optional), silahkan di isi jika anda ingin update data</small>
                                </div>
                            </div>
                            <div class="form-group row mb-2 ">
                                <label for="inputPassword3" class="col-sm-3 control-label text-right">Ulangi Password</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="re_password" placeholder="Password">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <small>(optional), silahkan di isi jika anda ingin update data</small>
                                </div>
                            </div>
                            <div class="form-group  mb-1 text-right">
                                <button type="submit" data-id="<?= $data_user->id; ?>" class="btn btn-primary btn_save_login"><i class="fa fa-send"></i> Simpan Data</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane " id="settings">
                        <h2>Log User</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>