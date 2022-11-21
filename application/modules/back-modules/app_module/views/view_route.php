<div class="col-12 row p-2 border-dashed">
    <div class="col-md-8 border-right">
        <small class="text-muted"><i class="fa fa-tv"></i> Module :</small>
        <label class="m-0 p-0 tx-16 d-block font-weight-bold"><?= $data_module->name; ?></label>
        <p class="m-0 p-0 tx-12"><?= $data_module->description; ?></p>
    </div>
    <div class="col-md-4">
        <small class="text-muted"><i class="fa fa-folder"></i> Lokasi Folder :</small>
        <label for="" class="font-weight-bold tx-16 d-block"><?= $data_module->directory; ?></label>
    </div>
</div>

<div class="col-12 mb-2 mt-3">
    <a href="javascript:void(0)" class="btn btn-rounded btn-warning-gradient btn_sync_module" data-module="<?= $data_module->id; ?>"><i class="fa fa-sync"></i> Sync General Data ( config.php )</a>
    <small class="text-muted">(* proses ini akan merubah data keterangan modul dan daftar routing)</small>
</div>

<form class="form-routing">
    <div class="col-12 mt-2 shadow-3 row p-2 rounded">
        <label for="" class="col-12 font-weight-bold">Form Tambah Routing Module</label>
        <div class="col-md-7">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><?= base_url() . PREFIX_CREDENTIAL_DIRECTORY . '/' . $data_module->directory . '/'; ?></span>
                </div>
                <input class="form-control" name="route" type="text">
            </div>
            <span class="help-block notif_route text-danger text-center"></span>
        </div>
        <div class="col-md-3">
            <select name="credential_access" class="form-control" id="">
                <?php
                foreach ($credential_access as $key => $value) {
                    echo '
                            <option value="' . $key . '">' . $value . '</option>
                        ';
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary-gradient btn-rounded btn-block btn_save_routing" data-id="<?= $data_module->id; ?>"><i class="fa fa-plus-circle"></i> Tambah</button>
        </div>
    </div>
</form>

<div class="col-md-12 mt-2 p-0">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Routing</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($data_route as $item_route) {
                $html_option = '';
                foreach ($credential_access as $key => $value) {
                    $selected = $key ==  $item_route->credential_access_type ? 'selected' : '';
                    $html_option .= '
                                <option ' . $selected . ' value="' . $key . '">' . $value . '</option>
                            ';
                }
                echo '
                        <tr>
                            <td>
                                <div class="col-12 row p-2 rounded">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">' . base_url() . PREFIX_CREDENTIAL_DIRECTORY . '/' . $data_module->directory . '/' . '</span>
                                            </div>
                                            <input class="form-control route_' . $item_route->id . '" value="' . $item_route->route . '" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="credential_access" class="form-control access_route_' . $item_route->id . '" >
                                            ' . $html_option . '
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-warning-gradient btn-rounded btn_update_routing" data-id="' . $item_route->id . '"><i class="fa fa-paper-plane"></i> Update</button>
                                        <button class="btn btn-danger-gradient btn-rounded btn_delete_routing" data-id="' . $item_route->id . '"><i class="fa fa-trash"></i> Hapus</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    ';
            }

            if (empty($data_route)) {
                echo '
                    <tr>
                        <td>
                            <div class="col-12 text-center">
                                <div class="plan-card text-center">
                                    <i class="fas fa-tv plan-icon text-primary"></i>
                                    <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                    <small class="text-muted">Tidak ada Routing.</small>
                                </div>
                            </div>
                        </td>
                    </tr>
                ';
            }

            ?>
        </tbody>
    </table>
</div>