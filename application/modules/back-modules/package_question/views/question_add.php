<form class="form_input">
    <div class="row row-sm main-content-mail mb-5">
        <div class="col-md-12 container_list">
            <div class="card mb-5">
                <div class="card-header">
                    <h2>Bank Soal</h2>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="code">Kode Registrasi</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" autocomplete="off" id="code" name="code" class="form-control" readonly value="<?= isset($data_detail->code) ? $data_detail->code : "PK" . time() ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="name">Nama Bank Soal</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" autocomplete="off" id="name" name="name" class="form-control" placeholder="Masukkan Nama Bank Soal..." value="<?= isset($data_detail->name) ? $data_detail->name : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="media">Tipe Paket Soal</label>
                        </div>
                        <div class="col-md-9">
                            <select name="media" id="media" class="form-control select2">
                                <?php
                                foreach ($type_package as $value) {
                                    if (isset($data_detail->id_type_package)) {
                                        $selected = ($value->id == $data_detail->id_type_package) ? 'selected' : '';
                                        echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
                                    } else {
                                        echo "<option value='$value->id'>$value->name</option>";
                                    }
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="creator_name">Pembuat Soal</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" autocomplete="off" id="creator_name" name="creator_name" class="form-control" placeholder="Masukkan Pembuat Soal..." value="<?= isset($data_detail->creator_name) ? $data_detail->creator_name : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="min_value_graduation">Nilai Minimal Kelulusan</label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" autocomplete="off" id="min_value_graduation" name="min_value_graduation" class="form-control" placeholder="0 - 100" value="<?= isset($data_detail->min_value_graduation) ? $data_detail->min_value_graduation : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-right mt-3">
                <button type="submit" class="btn btn-primary btn_save" data-id="<?= isset($data_detail->id) ? $data_detail->id : ''; ?>" data-method="<?= $method ?>"><i class="fa fa-save"></i> Simpan Data</button>
            </div>
        </div>
    </div>
</form>