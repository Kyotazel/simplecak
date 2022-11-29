<style>
    .content_detail {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }

    .jsplus_ui_toolbar_line,
    .cke_bottom,
    .n1ed_top_right_block {
        display: none !important
    }
</style>

<?php
if ($data_account->gender == 1) {
    $gender = "Laki Laki";
} else {
    $gender = "Perempuan";
}
?>
<div class="card mb-2">
    <div class="card-body">
        <div style="float: left;">
            <h2>Curriculum Vitae</h2>
        </div>
        <div class="text-right">
            <a class="btn btn-light" target="_blank" href="<?= Modules::run('helper/create_url', 'for_alumni/print_cv') ?>"><i class="fa fa-print"></i> Export ke Pdf</a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <img src="<?= base_url("upload/member/$data_account->image") ?>" style="height: 140px;" class="rounded-circle ml-5" alt="">
            </div>
            <div class="col-md-9">
                <h2 style="margin-bottom: 24px;" class="text-uppercase"><?= $data_account->name ?>
                    <span style="font-size: 16px; margin-left: 12px; float: right;">
                        <button class="btn btn-outline-primary btn_edit_salary"><i class="fa fa-pen"></i> Edit Gaji dan Link Portofolio</button>
                    </span>
                </h2>
                <div class="row">
                    <div class="col-md-6">
                        <div style="margin-bottom: 16px;">
                            <h5 class="text-dark text-uppercase mb-0">Alamat</h5>
                            <p class="content_detail"><?= $data_account->address_current ?></p>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <h5 class="text-dark text-uppercase mb-0">Usia, Jenis Kelamin</h5>
                            <p class="content_detail"><?= date_diff(date_create($data_account->birth_date), date_create(date('Y-m-d')))->format('%y') ?> Tahun, <?= $gender ?></p>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <h5 class="text-dark text-uppercase mb-0">Gaji yang diinginkan</h5>
                            <p class="content_detail">Rp. <?= number_format($intern_cv->expected_salary) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="margin-bottom: 16px;">
                            <h5 class="text-dark text-uppercase mb-0">Email</h5>
                            <p class="content_detail"><?= $data_account->email ?></p>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <h5 class="text-dark text-uppercase mb-0">No Telepon</h5>
                            <p class="content_detail"><?= $data_account->phone_number ?></p>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <h5 class="text-dark text-uppercase mb-0">Link Portofolio</h5>
                            <a target="_blank" href="https://<?= $intern_cv->link_portfolio ?>" class="content_detail"><?= $intern_cv->link_portfolio ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-5">
    <div class="card-body">
        <div style="margin-bottom: 100px;">
            <h3>TENTANG SAYA
                <span style="font-size: 16px; margin-left: 12px; float: right;">
                    <button class="btn btn-outline-primary btn_edit_about_me"><i class="fa fa-pen"></i> Edit</button>
                </span>
            </h3>
            <hr>
            <p><?= $intern_cv->about_me ?></p>
        </div>
        <div style="margin-bottom: 100px;">
            <h3>Kemampuan & Keahlian
                <span style="font-size: 16px; margin-left: 12px; float: right;">
                    <button class="btn btn-outline-primary btn_add_skill"><i class="fa fa-plus"></i> Tambah Kemampuan</button>
                </span>
            </h3>
            <hr>
            <?php foreach (Modules::run('database/find', 'tb_cv_intern_has_skill', ['id_cv_intern' => $intern_cv->id])->result() as $value) : ?>
                <div style="margin-left: 24px; margin-bottom: 16px">
                    <h4><?= $value->skill ?>
                        <span style="font-size: 16px; margin-left: 12px; float: right;">
                            <button class="btn btn-link text-info btn_edit_skill" data-id="<?= $value->id ?>"><i class="fa fa-pen"></i> EDIT</button>
                            <button class="btn btn-link text-danger btn_delete_skill" data-id="<?= $value->id ?>"><i class="fa fa-trash"></i> DELETE</button>
                        </span>
                    </h4>
                </div>
            <?php endforeach ?>
        </div>
        <div style="margin-bottom: 100px;">
            <h3>PENGALAMAN
                <span style="font-size: 16px; margin-left: 12px; float: right;">
                    <button class="btn btn-outline-primary btn_add_experience"><i class="fa fa-plus"></i> Tambah Pengalaman</button>
                </span>
            </h3>
            <hr>
            <?php foreach (Modules::run('database/find', 'tb_cv_intern_has_experience', ['id_cv_intern' => $intern_cv->id])->result() as $value) : ?>
                <div style="margin-left: 24px; margin-bottom: 16px">
                    <h4><?= $value->company_name ?>
                        <span style="font-size: 16px; margin-left: 12px; float: right;">
                            <button class="btn btn-link text-info btn_edit_experience" data-id="<?= $value->id ?>"><i class="fa fa-pen"></i> EDIT</button>
                            <button class="btn btn-link text-danger btn_delete_experience" data-id="<?= $value->id ?>"><i class="fa fa-trash"></i> DELETE</button>
                        </span>
                    </h4>
                    <h6><?= $value->position ?></h6>
                    <?php
                    $date1 = new DateTime($value->end_date);
                    $date2 = new DateTime($value->started_date);
                    $diff = $date1->diff($date2);
                    $get_diff = ($diff->format('%y') * 12) + $diff->format('%m');
                    ?>
                    <p class="mb-1"><?= Modules::run('helper/month_indo', $value->started_date, '-') ?> - <?= Modules::run('helper/month_indo', $value->end_date, '-') ?> (<?= $get_diff ?> Bulan)</p>
                    <div class="ml-2">
                        <?= $value->description ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div style="margin-bottom: 100px;">
            <h3>PENDIDIKAN
                <span style="font-size: 16px; margin-left: 12px; float: right;">
                    <button class="btn btn-outline-primary btn_add_education"><i class="fa fa-plus"></i> Tambah Pendidikan</button>
                </span>
            </h3>
            <hr>
            <?php foreach (Modules::run('database/find', 'tb_cv_intern_has_education', ['id_cv_intern' => $intern_cv->id])->result() as $value) : ?>
                <div style="margin-left: 24px; margin-bottom: 16px">
                    <h4><?= $value->school_name ?>
                        <span style="font-size: 16px; margin-left: 12px; float: right;">
                            <button class="btn btn-link text-info btn_edit_education" data-id="<?= $value->id ?>"><i class="fa fa-pen"></i> EDIT</button>
                            <button class="btn btn-link text-danger btn_delete_education" data-id="<?= $value->id ?>"><i class="fa fa-trash"></i> DELETE</button>
                        </span>
                    </h4>
                    <h6><?= $value->study_program ?></h6>
                    <p class="mb-1"><?= $value->started_date ?> - <?= $value->end_date ?> (<?= $value->end_date - $value->started_date ?> Tahun)</p>
                    <div class="ml-2">
                        <?= $value->description ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_salary" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form_input_salary">
                    <div>
                        <div class="form-group">
                            <label for="name">Gaji yang diinginkan</label>
                            <input type="number" class="form-control" name="expected_salary" value="<?= $intern_cv->expected_salary ?>">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="name">Link Portofolio</label>
                            <input type="text" class="form-control" name="link_portfolio" value="<?= $intern_cv->link_portfolio ?>">
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3 mb-0 btn_save_salary"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_about_me" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form_input_about_me">
                    <div>
                        <div class="form-group">
                            <label for="name">Tentang Saya</label>
                            <textarea name="description_about_me" id="description_about_me" class="ckeditor_forma" rows="10"><?= $intern_cv->about_me ?></textarea>
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3 mb-0 btn_save_about_me"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_experience" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form_input_experience">
                    <div>
                        <div class="form-group">
                            <label for="company_name">Nama Perusahaan</label>
                            <input type="text" class="form-control" name="company_name">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="position">Posisi</label>
                            <input type="text" class="form-control" name="position">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="start_month">Tanggal Mulai</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="start_month" class="form-control" id="start_month">
                                        <option value="">Bulan</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="col-md-6">
                                    <select name="start_year" id="start_year" class="form-control">
                                        <option value="">Tahun</option>
                                        <?php for ($i = date('Y'); $i >= date('Y') - 50; $i--) : ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor ?>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end_month">Tanggal Selesai</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="end_month" class="form-control" id="end_month">
                                        <option value="">Bulan</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="col-md-6">
                                    <select name="end_year" id="end_year" class="form-control">
                                        <option value="">Tahun</option>
                                        <?php for ($i = date('Y'); $i >= date('Y') - 50; $i--) : ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor ?>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description_experience">Deskripsi Pengalaman (Opsional)</label>
                            <textarea name="description_experience" id="description_experience" class="ckeditor_forma" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3 mb-0 btn_save_experience"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_education" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form_input_education">
                    <div>
                        <div class="form-group">
                            <label for="school_name">Nama Sekolah</label>
                            <input type="text" class="form-control" name="school_name">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="study_program">Jurusan</label>
                            <input type="text" class="form-control" name="study_program">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="start_month">Tahun Mulai</label>
                                    <select name="start_year" id="start_year" class="form-control">
                                        <option value="">Tahun</option>
                                        <?php for ($i = date('Y'); $i >= date('Y') - 50; $i--) : ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor ?>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="start_month">Tahun Selesai</label>
                                    <select name="end_year" id="end_year" class="form-control">
                                        <option value="">Tahun</option>
                                        <?php for ($i = date('Y'); $i >= date('Y') - 50; $i--) : ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor ?>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description_education">Deskripsi Pengalaman (Opsional)</label>
                            <textarea name="description_education" id="description_education" class="ckeditor_forma" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3 mb-0 btn_save_education"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_skill" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form_input_skill">
                    <div>
                        <div class="form-group">
                            <label for="skill">Nama Keahlian</label>
                            <input type="text" class="form-control" name="skill">
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3 mb-0 btn_save_skill"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>