<form class="form_input">
    <div class="row row-sm main-content-mail mb-5">
        <div class="col-md-12 container_list">
            <div class="card mb-5">
                <div class="card-header">
                    <h2>Gelombang Pelatihan</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="id_course">Tipe Pelatihan</label>
                            <select name="id_course" id="id_course" class="form-control select2">
                                <?php
                                foreach ($course as $value) {
                                    if (isset($data_detail->id_course)) {
                                        $selected = ($value->id == $data_detail->id_course) ? 'selected' : '';
                                        echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
                                    } else {
                                        echo "<option value='$value->id'>$value->name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="title">Judul Gelombang Pelatihan</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan Judul Batch Pelatihan..." value="<?= isset($data_detail->title) ? $data_detail->title : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="target_registrant">Kuota Peserta</label>
                            <input type="number" id="target_registrant" name="target_registrant" class="form-control" placeholder="Jumlah Peserta" value="<?= isset($data_detail->target_registrant) ? $data_detail->target_registrant : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="opening_registration_date">Awal Pendaftaran</label>
                            <input type="text" name="opening_registration_date" id="opening_registration_date" class="form-control datepicker" placeholder="Awal pendaftaran" value="<?= isset($data_detail->opening_registration_date) ? $data_detail->opening_registration_date : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="closing_registration_date">Akhir Pendaftaran</label>
                            <input type="text" name="closing_registration_date" id="closing_registration_date" class="form-control datepicker" value="<?= isset($data_detail->closing_registration_date) ? $data_detail->closing_registration_date : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="starting_date">Awal Batch Pelatihan</label>
                            <input type="text" name="starting_date" id="starting_date" class="form-control datepicker" value="<?= isset($data_detail->starting_date) ? $data_detail->starting_date : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ending_date">Akhir Batch Pelatihan</label>
                            <input type="text" name="ending_date" id="ending_date" class="form-control datepicker" value="<?= isset($data_detail->ending_date) ? $data_detail->ending_date : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="image">Thumbnail Batch Pelatihan</label>
                            <div class="main-img-user profile-user">
                                <!-- <img alt="" src=""> -->
                                <input type="file" class="profile-edit upload_form" name="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Content Gelombang Pelatihan</h3>
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