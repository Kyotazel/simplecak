<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Daftar Batch Pelatihan</h3>
                    <div class="col-md-4 text-right">
                        <a href="javascript:void(0)" class="btn btn-primary btn_tambah"><i class="fa fa-plus-circle"></i> Tambah Batch Pelatihan </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_data" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><span>No</span></th>
                                <th><span>Judul Pelatihan</span></th>
                                <th><span>Tipe Pelatihan</span></th>
                                <th><span>Deskripsi Pelatihan</span></th>
                                <th><span>Peserta Pelatihan</span></th>
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
                        <div class="form-group col-md-12">
                            <label for="id_course">Tipe Pelatihan</label>
                            <select name="id_course" id="id_course" class="form-control">
                                <option value="">-- Pilih Tipe Pelatihan --</option>
                                <?php
                                foreach ($course as $value) {
                                    echo "<option value=$value->id>$value->name</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="title">Judul Batch Pelatihan</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan Judul Batch Pelatihan...">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi Batch Pelatihan</label>
                            <textarea cols="30" rows="5" type="text" id="description" name="description" class="form-control" placeholder="Masukkan Deskripsi Batch Pelatihan"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="target_registrant">Kuota Peserta</label>
                            <input type="number" id="target_registrant" name="target_registrant" class="form-control" placeholder="Jumlah Peserta">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="opening_registration_date">Awal Pendaftaran</label>
                            <input type="date" name="opening_registration_date" id="opening_registration_date" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="closing_registration_date">Akhir Pendaftaran</label>
                            <input type="date" name="closing_registration_date" id="closing_registration_date" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="starting_date">Awal Batch Pelatihan</label>
                            <input type="date" name="starting_date" id="starting_date" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ending_date">Akhir Batch Pelatihan</label>
                            <input type="date" name="ending_date" id="ending_date" class="form-control">
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

<div class="modal" id="modal_tambah" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambahkan peserta</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <!-- <div class="input-group">
                    <input class="form-control" placeholder="Search for..." type="text">
                    <span class="input-group-btn"><button class="btn ripple btn-primary" type="button">
                            <span class="input-group-btn"><i class="fa fa-search"></i></span></button></span>
                </div>
                <br><br> -->
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table_add" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th><span>No</span></th>
                                    <th><span>Nama Akun</span></th>
                                    <th><span>keahlian</span></th>
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
</div>

<div class="modal" id="modal_peserta" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Daftar peserta</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <!-- <div class="input-group">
                    <input class="form-control" placeholder="Search for..." type="text">
                    <span class="input-group-btn"><button class="btn ripple btn-primary" type="button">
                            <span class="input-group-btn"><i class="fa fa-search"></i></span></button></span>
                </div>
                <br><br> -->
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table_peserta" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th><span>No</span></th>
                                    <th><span>Nama Akun</span></th>
                                    <th><span>keahlian</span></th>
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
</div>