<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Daftar Member</h3>
                    <div class="col-md-4 text-right">
                        <a href="javascript:void(0)" class="btn btn-primary btn_tambah"><i class="fa fa-plus-circle"></i> Tambah Member </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_data" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><span>No</span></th>
                                <th><span>Nama</span></th>
                                <th><span>Email</span></th>
                                <th><span>Keahlian</span></th>
                                <th><span>Status Konfirmasi</span></th>
                                <th><span>Action</span></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_form" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form-input">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="no_ktp">NIK</label>
                            <input type="number" id="no_ktp" name="no_ktp" class="form-control" placeholder="Masukkan No KTP...">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="no_kk">No. KK</label>
                            <input type="number" id="no_kk" name="no_kk" class="form-control" placeholder="Masukkan No KK...">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="id_skill">Keahlian</label>
                            <select name="id_skill" id="id_skill" class="form-control">
                                <option value="">-- Keahlian --</option>
                                <?php
                                foreach ($skill as $value) {
                                    echo "<option value='$value->id'>$value->name</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama Lengkap">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="id_last_education">Pendidikan</label>
                            <select name="id_last_education" id="id_last_education" class="form-control">
                                <option value="">-- Pendidikan --</option>
                                <?php
                                foreach ($last_education as $value) {
                                    echo "<option value='$value->id'>$value->name</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="last_school">Asal Sekolah</label>
                            <input type="text" id="last_school" name="last_school" class="form-control" placeholder="Masukkan Asal Sekolah">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan Email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="birth_place">Tempat Lahir</label>
                            <input type="text" id="birth_place" name="birth_place" class="form-control" placeholder="Tempat Lahir">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="birth_date">Tanggal Lahir</label>
                            <input type="date" id="birth_date" name="birth_date" class="form-control js-datepicker" placeholder="Tanggal Lahir">
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
                            <label for="religion">Agama</label>
                            <input type="text" id="religion" name="religion" class="form-control" placeholder="Masukkan Agama">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="married_status">Status Menikah</label>
                            <select name="married_status" id="married_status" class="form-control">
                                <option value="">-- Status Menikah --</option>
                                <option value="1">Sudah Menikah</option>
                                <option value="2">Belum Menikah</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_province">Provinsi Asal</label>
                            <select name="id_province" id="id_province" class="form-control">
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
                            <label for="id_city">Kota Asal</label>
                            <select name="id_city" id="id_city" class="form-control">
                                <option value="">-- Pilih Kota Asal -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_regency">Kecamatan Asal</label>
                            <select name="id_regency" id="id_regency" class="form-control">
                                <option value="">-- Pilih Kecamatan Asal -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_village">Desa Asal</label>
                            <select name="id_village" id="id_village" class="form-control">
                                <option value="">-- Pilih Desa Asal -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="address">Alamat Lengkap Asal</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Masukkan Alamat Lengkap Asal">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_province_current">Provinsi Sekarang</label>
                            <select name="id_province_current" id="id_province_current" class="form-control">
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
                            <label for="id_city_current">Kota Sekarang</label>
                            <select name="id_city_current" id="id_city_current" class="form-control">
                                <option value="">-- Pilih Kota Sekarang -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_regency_current">Kecamatan Sekarang</label>
                            <select name="id_regency_current" id="id_regency_current" class="form-control">
                                <option value="">-- Pilih Kecamatan Sekarang -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_village_current">Desa Sekarang</label>
                            <select name="id_village_current" id="id_village_current" class="form-control">
                                <option value="">-- Pilih Desa Sekarang -- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="address_current">Alamat Lengkap Sekarang</label>
                            <input type="text" id="address_current" name="address_current" class="form-control" placeholder="Masukkan Alamat Lengkap Asal">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="image">Foto Profil</label>
                            <input type="file" id="image" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success btn_save"><i class="fa fa-save"></i> Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>