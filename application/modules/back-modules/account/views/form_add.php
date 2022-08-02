<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card mb-5">
            <div class="card-header">
                <h2>Biodata</h2>
            </div>
            <div class="card-body">
                <form class="form-input">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class for="no_ktp">NIK</label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" id="no_ktp" name="no_ktp" class="form-control" placeholder="Masukkan No KTP..." value="<?= isset($data_detail->no_ktp) ? $data_detail->no_ktp : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="no_kk">No. KK</label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" id="no_kk" name="no_kk" class="form-control" placeholder="Masukkan No KK..." value="<?= isset($data_detail->no_kk) ? $data_detail->no_kk : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="skill">Keahlian</label>
                        </div>
                        <div class="col-md-9">
                            <select name="skill[]" id="skill" class="form-control select2" multiple="multiple">
                                <?php
                                foreach ($skill as $value) {
                                    $selected = (in_array($value->id, $detail_skill)) ? 'selected' : '';
                                    echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="name">Nama Lengkap</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama Lengkap" value="<?= isset($data_detail->name) ? $data_detail->name : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="id_last_education">Pendidikan</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_last_education" id="id_last_education" class="form-control select2">
                                <?php
                                foreach ($last_education as $value) {
                                    if (isset($data_detail->id_last_education)) {
                                        $selected = ($value->id == $data_detail->id_last_education) ? 'selected' : '';
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
                            <label for="last_school">Asal Sekolah</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="last_school" name="last_school" class="form-control" placeholder="Masukkan Asal Sekolah" value="<?= isset($data_detail->last_school) ? $data_detail->last_school : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan Email" value="<?= isset($data_detail->email) ? $data_detail->email : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="birth_place">Tempat Lahir</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="birth_place" name="birth_place" class="form-control" placeholder="Tempat Lahir" value="<?= isset($data_detail->birth_place) ? $data_detail->birth_place : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="birth_date">Tanggal Lahir</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="birth_date" name="birth_date" class="form-control datepicker" placeholder="Tanggal Lahir" value="<?= isset($data_detail->birth_date) ? $data_detail->birth_date : '' ?>">
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="gender">Jenis Kelamin</label>
                        </div>
                        <div class="col-md-9">
                            <select name="gender" id="gender" class="form-control select2">
                                <?php
                                foreach ($gender as $value) {
                                    if (isset($data_detail->gender)) {
                                        $selected = ($value->value == $data_detail->gender) ? 'selected' : '';
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
                            <label for="religion">Agama</label>
                        </div>
                        <div class="col-md-9">
                            <select name="religion" id="religion" class="form-control select2">
                                <?php
                                foreach ($religion as $value) {
                                    if (isset($data_detail->religion)) {
                                        $selected = ($value->value == $data_detail->religion) ? 'selected' : '';
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
                            <label for="married_status">Status Menikah</label>
                        </div>
                        <div class="col-md-9">
                            <select name="married_status" id="married_status" class="form-control select2">
                                <?php
                                foreach ($married as $value) {
                                    if (isset($data_detail->married_status)) {
                                        $selected = ($value->value == $data_detail->married_status) ? 'selected' : '';
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
                            <label for="id_province">Provinsi Asal</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_province" id="id_province" class="form-control select2">
                                <?php
                                foreach ($provinsi as $value) {
                                    if (isset($data_detail->id_province)) {
                                        $selected = ($value->id == $data_detail->id_province) ? 'selected' : '';
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
                            <label for="id_city">Kota Asal</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_city" id="id_city" class="form-control select2">
                                <option value="">-- Pilih Kota Asal -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="id_regency">Kecamatan Asal</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_regency" id="id_regency" class="form-control select2">
                                <option value="">-- Pilih Kecamatan Asal -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="id_village">Desa Asal</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_village" id="id_village" class="form-control select2">
                                <option value="">-- Pilih Desa Asal -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="address">Alamat Lengkap Asal</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="address" name="address" class="form-control" placeholder="Masukkan Alamat Lengkap Asal" value="<?= isset($data_detail->address) ? $data_detail->address : '' ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="id_province_current">Provinsi Sekarang</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_province_current" id="id_province_current" class="form-control select2">
                                <?php
                                foreach ($provinsi as $value) {
                                    if (isset($data_detail->id_province_current)) {
                                        $selected = ($value->id == $data_detail->id_province_current) ? 'selected' : '';
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
                            <label for="id_city_current">Kota Sekarang</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_city_current" id="id_city_current" class="form-control select2">
                                <option value="">-- Pilih Kota Sekarang -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="id_regency_current">Kecamatan Sekarang</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_regency_current" id="id_regency_current" class="form-control select2">
                                <option value="">-- Pilih Kecamatan Sekarang -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="id_village_current">Desa Sekarang</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_village_current" id="id_village_current" class="form-control select2">
                                <option value="">-- Pilih Desa Sekarang -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="address_current">Alamat Lengkap Sekarang</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="address_current" name="address_current" class="form-control" placeholder="Masukkan Alamat Lengkap Asal" value="<?= isset($data_detail->address_current) ? $data_detail->address_current : '' ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="image">Foto Profil</label>
                        </div>
                        <div class="col-md-9">
                            <input type="file" id="image" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-success btn_save" data-id="<?= isset($data_detail->id) ? $data_detail->id : ''; ?>" data-method="<?= $method ?>"><i class="fa fa-save"></i> Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>