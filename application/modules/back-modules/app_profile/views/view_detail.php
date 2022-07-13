<?php
$active         = $data_user->status ? 'on' : '';
$active_create  = $data_user->access_create ? 'on' : '';
$active_update  = $data_user->access_update ? 'on' : '';
$active_delete  = $data_user->access_delete ? 'on' : '';
?>
<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="mb-1">
                    <a href="<?= Modules::run('helper/create_url', 'app_user'); ?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>
                <div class="pl-0">
                    <div class="main-profile-overview text-center">
                        <div class="main-img-user profile-user">
                            <img alt="" src="<?= base_url('assets/themes/valex/') ?>img/faces/6.jpg">
                        </div>
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
                            <div class="col-12 border">
                                <table class=" text-left mt-2">
                                    <tr>
                                        <td style="width: 150px;padding:5px"><i class="fa fa-circle"></i> Status Aktif</td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <div data-status="status" data-id="<?= $data_user->id; ?>" class="main-toggle main-toggle-dark change_status_detail <?= $active; ?>"><span></span></div>
                                        </td>
                                    </tr>
                                    <tr class="mb-1">
                                        <td style="width: 150px;padding:5px"><i class="fa fa-circle"></i> is create</td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <div data-status="create" data-id="<?= $data_user->id; ?>" class="main-toggle main-toggle-dark change_status_detail <?= $active_create; ?>"><span></span></div>
                                        </td>
                                    </tr>
                                    <tr class="mb-1">
                                        <td style="width: 150px;padding:5px"> <i class="fa fa-circle"></i> is update</td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <div data-status="update" data-id="<?= $data_user->id; ?>" class="main-toggle main-toggle-dark change_status_detail <?= $active_update; ?>"><span></span></div>
                                        </td>
                                    </tr>
                                    <tr class="mb-1">
                                        <td style="width: 150px;padding:5px"><i class="fa fa-circle"></i> is delete</td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <div data-status="delete" data-id="<?= $data_user->id; ?>" class="main-toggle main-toggle-dark change_status_detail <?= $active_delete; ?>"><span></span></div>
                                        </td>
                                    </tr>
                                </table>
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
                                <label for="inputEmail3" class="col-sm-3 control-label text-right">Credential</label>
                                <div class="col-sm-9">
                                    <select name="credential" class="form-control">
                                        <?php
                                        foreach ($all_credential as $item_credential) {
                                            $selected = $item_credential->id == $data_user->id_credential ? 'selected' : '';
                                            echo '
                                                    <option ' . $selected . ' value="' . $item_credential->id . '">' . $item_credential->name . '</option>
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