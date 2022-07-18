<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card mb-5">
            <div class="card-header">
                <h2>Biodata</h2>
            </div>
            <div class="card-body">
                <form id="form-input">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="ktp">No. KTP</label>
                            <input type="text" id="ktp" name="ktp" class="form-control" placeholder="Masukkan No KTP...">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kk">No. KK</label>
                            <input type="text" id="kk" name="kk" class="form-control" placeholder="Masukkan No KK...">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama Lengkap">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name">Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan Email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control js-flatpickr" placeholder="Tanggal Lahir">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="gender">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="">-- Jenis Kelamin --</option>
                                <option value="L">Laki Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="agama">Agama</label>
                            <input type="text" id="agama" name="agama" class="form-control" placeholder="Masukkan Agama">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="married">Status Menikah</label>
                            <select name="married" id="married" class="form-control">
                                <option value="">-- Status Menikah --</option>
                                <option value="1">Sudah Menikah</option>
                                <option value="2">Belum Menikah</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="provinsi_asal">Provinsi Asal</label>
                            <select name="provinsi_asal" id="provinsi_asal" class="form-control">
                                <option value="">-- Pilih Provinsi Asal --</option>
                                <?php
                                foreach ($provinsi as $value) {
                                    echo "<option value='$value->id'>$value->name</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kota_asal">Kota Asal</label>
                            <select name="kota_asal" id="kota_asal" class="form-control">
                                <option value="">-- Pilih Kota Asal -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kecamatan_asal">Kecamatan Asal</label>
                            <select name="kecamatan_asal" id="kecamatan_asal" class="form-control">
                                <option value="">-- Pilih Kecamatan Asal -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="desa_asal">Desa Asal</label>
                            <select name="desa_asal" id="desa_asal" class="form-control">
                                <option value="">-- Pilih Desa Asal -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="alamat_lengkap">Alamat Lengkap Sekarang</label>
                            <input type="text" id="alamat_lengkap" name="alamat_lengkap" class="form-control" placeholder="Masukkan Alamat Lengkap">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="provinsi_sekarang">Provinsi Asal</label>
                            <select name="provinsi_sekarang" id="provinsi_sekarang" class="form-control">
                                <option value="">-- Pilih Provinsi Sekarang --</option>
                                <?php
                                foreach ($provinsi as $value) {
                                    echo "<option value='$value->id'>$value->name</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kota_sekarang">Kota Sekarang</label>
                            <select name="kota_sekarang" id="kota_sekarang" class="form-control">
                                <option value="">-- Pilih Kota Sekarang -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kecamatan_sekarang">Kecamatan Sekarang</label>
                            <select name="kecamatan_sekarang" id="kecamatan_sekarang" class="form-control">
                                <option value="">-- Pilih Kecamatan Sekarang -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="desa_sekarang">Desa Sekarang</label>
                            <select name="desa_sekarang" id="desa_sekarang" class="form-control">
                                <option value="">-- Pilih Desa Sekarang -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>