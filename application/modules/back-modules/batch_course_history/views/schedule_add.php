<form class="form_input">
    <div class="row row-sm main-content-mail mb-5">
        <div class="col-md-12 container_list">
            <div class="card mb-5">
                <div class="card-header">
                    <h2>Jadwal Pertemuan</h2>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="id_batch_course">Tipe Gelombang Pelatihan</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_batch_course" id="id_batch_course" class="form-control select2">
                                <option value="<?= $batch_course->id ?>"><?= $batch_course->title ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="media">Media Pertemuan</label>
                        </div>
                        <div class="col-md-9">
                            <select name="media" id="media" class="form-control select2">
                                <option value="">Online / Offline</option>
                                <?php
                                foreach ($media as $value) {
                                    if (isset($data_detail->media)) {
                                        $selected = ($value->value == $data_detail->media) ? 'selected' : '';
                                        echo '<option value="' . $value->value . '" ' . $selected . '>' . $value->label . '</option>';
                                    } else {
                                        echo "<option value='$value->value'>$value->label</option>";
                                    }
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="title">Judul Jadwal Pertemuan</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" autocomplete="off" id="title" name="title" class="form-control" placeholder="Masukkan Judul Pertemuan..." value="<?= isset($data_detail->title) ? $data_detail->title : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="date">Tanggal Jadwal</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" autocomplete="off" name="date" id="date" class="form-control datepickera" placeholder="Masukkan Tanggal Jadwal" value="<?= isset($data_detail->date) ? $data_detail->date : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="starting_time">Waktu Mulai</label>
                        </div>
                        <div class="col-md-9">
                            <input type="time" autocomplete="off" name="starting_time" class="form-control" value="<?= isset($data_detail->starting_time) ? date('H:i' ,strtotime($data_detail->starting_time)) : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="ending_type">Waktu Selesai</label>
                        </div>
                        <div class="col-md-9">
                            <input type="time" autocomplete="off" name="ending_type" id="ending_type" class="form-control" value="<?= isset($data_detail->ending_type) ? date('H:i' ,strtotime($data_detail->ending_type)) : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Deskripsi Jadwal Pertemuan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <textarea name="description" id="description" class="ckeditor_form" cols="30" rows="10"><?= isset($data_detail->description) ? $data_detail->description : ''; ?></textarea>
                            </div>
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