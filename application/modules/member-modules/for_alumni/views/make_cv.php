<style>
    .content_detail {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }
</style>

<?php
if ($data_account->gender == 1) {
    $gender = "Laki Laki";
} else {
    $gender = "Perempuan";
}
?>
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
            <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe perspiciatis quas itaque ullam, maiores vitae asperiores! Eligendi optio, laboriosam, ab nesciunt possimus officia blanditiis inventore dignissimos quo, deleniti delectus quis! Ullam vero temporibus earum ad ut? Alias omnis laborum laudantium delectus sapiente ab eaque, voluptates qui molestias est libero doloribus unde deleniti veniam facere explicabo consequatur? Magnam similique nisi, non recusandae incidunt ex unde obcaecati blanditiis. Earum sit quis, officiis ea voluptas sequi amet quae atque esse sint cumque nulla voluptatum asperiores ipsum ipsam dolorem nihil ullam ut minima dolores repellat. Voluptates eveniet consectetur iste quas vel, quasi nihil quis!</p> -->
        </div>
        <div style="margin-bottom: 100px;">
            <h3>PENGALAMAN
                <span style="font-size: 16px; margin-left: 12px; float: right;">
                    <button class="btn btn-outline-primary"><i class="fa fa-plus"></i> Tambah Pengalaman Kerja</button>
                </span>
            </h3>
            <hr>
            <div style="margin-left: 24px; margin-bottom: 16px">
                <h4>PT Dummy 1 Testing
                    <span style="font-size: 16px; margin-left: 12px; float: right;">
                        <button class="btn btn-link text-info"><i class="fa fa-pen"></i> EDIT</button>
                        <button class="btn btn-link text-danger"><i class="fa fa-trash"></i> DELETE</button>
                    </span>
                </h4>
                <h6>Web Programmer</h6>
                <p class="mb-1">Januari 2021 - Desember 2021 (12 Bulan)</p>
                <div class="ml-2">
                    - Mengerjakan abc menggunakan def <br>
                    - Tes Abcdefghi dengan asdasd
                </div>
            </div>
            <div style="margin-left: 24px; margin-bottom: 16px">
                <h4>PT Dummy 1 Testing
                    <span style="font-size: 16px; margin-left: 12px; float: right;">
                        <button class="btn btn-link text-info"><i class="fa fa-pen"></i> EDIT</button>
                        <button class="btn btn-link text-danger"><i class="fa fa-trash"></i> DELETE</button>
                    </span>
                </h4>
                <h6>Web Programmer</h6>
                <p class="mb-1">Januari 2021 - Desember 2021 (12 Bulan)</p>
                <div class="ml-2">
                    - Mengerjakan abc menggunakan def <br>
                    - Tes Abcdefghi dengan asdasd
                </div>
            </div>
        </div>
        <div style="margin-bottom: 100px;">
            <h3>PENDIDIKAN
                <span style="font-size: 16px; margin-left: 12px; float: right;">
                    <button class="btn btn-outline-primary"><i class="fa fa-plus"></i> Tambah Pendidikan</button>
                </span>
            </h3>
            <hr>
            <div style="margin-left: 24px; margin-bottom: 16px">
                <h4>Universitas Brawijaya
                    <span style="font-size: 16px; margin-left: 12px; float: right;">
                        <button class="btn btn-link text-info"><i class="fa fa-pen"></i> EDIT</button>
                        <button class="btn btn-link text-danger"><i class="fa fa-trash"></i> DELETE</button>
                    </span>
                </h4>
                <h6>Teknik Informatika</h6>
                <p class="mb-1">2012 - 2016 (4 Tahun)</p>
                <div class="ml-2">
                    - Mengerjakan abc menggunakan def <br>
                    - Tes Abcdefghi dengan asdasd
                </div>
            </div>
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
                            <textarea name="about_me" id="about_me" class="asdasd form-control" cols="30" rows="10"><?= $intern_cv->about_me ?></textarea>
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