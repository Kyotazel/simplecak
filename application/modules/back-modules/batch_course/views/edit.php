<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card mb-5">
            <div class="card-header">
                <h2>Pendaftaran Batch Pelatihan</h2>
            </div>
            <div class="card-body">
                <form id="form-input">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="id_course">Tipe Pelatihan</label>
                            <select name="id_course" id="id_course" class="form-control">
                                <?php
                                    foreach($course as $value) {
                                        echo "<option value=$value->id>$value->name</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="title">Judul Batch Pelatihan</label>
                            <input type="text" id="title" name="title" class="form-control" value="<?= $batch->title ?>" placeholder="Masukkan Judul Batch Pelatihan...">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi Batch Pelatihan</label>
                            <textarea cols="30" rows="5" type="text" id="description" name="description" class="form-control" placeholder="Masukkan Deskripsi Batch Pelatihan"><?= $batch->description ?></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="target_registrant">Kuota Peserta</label>
                            <input type="number" id="target_registrant" name="target_registrant" class="form-control" value="<?= $batch->target_registrant ?>" placeholder="Jumlah Peserta">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="opening_registration_date">Awal Pendaftaran</label>
                            <input type="date" name="opening_registration_date" id="opening_registration_date" class="form-control" value="<?= $batch->opening_registration_date ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="closing_registration_date">Akhir Pendaftaran</label>
                            <input type="date" name="closing_registration_date" id="closing_registration_date" class="form-control" value="<?= $batch->closing_registration_date ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="starting_date">Awal Batch Pelatihan</label>
                            <input type="date" name="starting_date" id="starting_date" class="form-control" value="<?= $batch->starting_date ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ending_date">Akhir Batch Pelatihan</label>
                            <input type="date" name="ending_date" id="ending_date" class="form-control" value="<?= $batch->ending_date ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="image">Thumbnail Batch Pelatihan</label>
                            <div class="main-img-user profile-user">
                                <img alt="" src="<?= base_url("upload/batch/") . $batch->image . ".png"; ?>">
                                <!-- <a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a> -->
                                <input type="file" class="profile-edit upload_form" name="image">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success btn_save" data-id="<?= $batch->id; ?>"><i class="fa fa-save"></i> Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>