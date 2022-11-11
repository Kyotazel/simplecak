<?php
$btn_edit   = Modules::run('security/edit_access', '<a href="' . Modules::run('helper/create_url', 'course/edit?data=' . urlencode($this->encrypt->encode($data_detail->id))) . '" class="btn btn-success btn-rounded mr-3"><i class="fa fa-edit"></i> Edit Data</a>');
$btn_delete = Modules::run('security/delete_access', '<a href="javascript:void(0)" data-id="' . urlencode($this->encrypt->encode($data_detail->id)) . '" data-redirect="1" class="btn_delete btn btn-danger btn-rounded mr-3"><i class="fa fa-trash"></i> Hapus Data</a>');
?>

<style>
    .dz-remove {
        display: block !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="row mb-5">
                <div class="col-md-12">
                    <h1><?= $data_detail->title ?></h1>
                    <p><?= $category->name ?></p>
                </div>
            </div>
            <div class="row">
                <div>
                    <img src="<?= base_url('upload/batch/') . $data_detail->image ?>" class="mb-5" style="height: 300px; width: 650px; object-fit:cover; border-radius: 5%;">
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <?= $data_detail->description ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2>Ikuti Pelatihan</h2>
                    <p class="mt-1 mb-0">Registrasi : </p>
                    <p><?= Modules::run("helper/date_indo", $data_detail->opening_registration_date, '-') . ' - ' . Modules::run("helper/date_indo", $data_detail->closing_registration_date, '-') ?></p>
                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card custom-card">
                                    <input type="hidden" name="end_date" id="end_date" value="<?= $data_detail->closing_registration_date ?>">
                                    <div class="row expired d-none">
                                        <div class="text-center">
                                            <h2 class="text-danger">E X P I R E D</h2>
                                        </div>
                                    </div>
                                    <div class="row not_expired">
                                        <div class="col-xl-3 col-lg-6 col-sm-6 p-0 border">
                                            <div class="card-body py-1 text-center">
                                                <h4 class="text-primary"><span class="day"></span></h4>
                                                <h6 class="mb-0" style="font-size: 12px;">Hari</h6>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-6 p-0 border">
                                            <div class="card-body py-1 text-center">
                                                <h4 class="text-primary"><span class="hour"></span></h4>
                                                <h6 class="mb-0" style="font-size: 12px;">Jam</h6>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-6 p-0 border">
                                            <div class="card-body py-1 text-center">
                                                <h4 class="text-primary"><span class="minute"></span></h4>
                                                <h6 class="mb-0" style="font-size: 12px;">Menit</h6>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-6 p-0 border">
                                            <div class="card-body py-1 text-center">
                                                <h4 class="text-primary"><span class="second"></span></h4>
                                                <h6 class="mb-0" style="font-size: 12px;">Detik</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-rounded" id="daftar">Daftar Pelatihan</button>
                    </div>
                    <hr>
                    <div class="row py-1">
                        <div class="col-md-2"><i class="fa fa-clock bg-primary  p-2 text-light" style="border-radius: 100%; font-size: 16px;"></i></div>
                        <div class="col-md-9">
                            <h4>Jadwal Pelatihan</h4>
                            <p><?= Modules::run("helper/date_indo", $data_detail->starting_date, '-') . ' - ' . Modules::run("helper/date_indo", $data_detail->ending_date, '-') ?></p>
                        </div>
                    </div>
                    <div class="row py-1">
                        <div class="col-md-2"><i class="fa fa-user bg-primary  p-2 text-light" style="border-radius: 100%; font-size: 16px;"></i></div>
                        <div class="col-md-9">
                            <h4>Kuota Peserta</h4>
                            <p><?= $data_detail->target_registrant ?> Peserta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>