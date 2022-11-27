<?php

$button = '';

if ($account->status == 0){
    $color  = 'danger';
    $status = 'Belum Dikonfirmasi';
    $button = '<button href="#" class="btn btn-block btn-warning btn-rounded" disabled><i class="fa fa-times"></i> Sedang menunggu konfirmasi</button>';
} else if($account->status == 1) {
    $color  = 'warning';
    $status = 'Seleksi Administrasi';
    $button = '<button href="#" class="btn btn-block btn-warning btn-rounded" disabled><i class="fa fa-book"></i> Seleksi Administrasi</button>';
} else if ($account->status == 2) {
    $color  = 'warning';
    $status = 'Seleksi Ujian Online';
    if(isset($examination)) {
        $button = '<a href="' . Modules::run('helper/create_url', '/my_exam') . '" class="btn btn-block btn-primary btn-rounded"><i class="fa fa-pen"></i> Ikuti Ujian</a>';
    } else {
        $button = '<button href="#" class="btn btn-block btn-danger btn-rounded" disabled><i class="fa fa-times"></i> Ujian Tidak Tersedia</button>';
    }
} else if ($account->status == 3) {
    $color  = 'warning';
    $status = 'Seleksi Wawancara';
    $button = '<button href="#" class="btn btn-block btn-warning btn-rounded" disabled><i class="fa fa-book"></i> Seleksi Wawancara</button>';
} else if ($account->status == 4) {
    $color  = 'warning';
    $status = 'Menunggu Konfirmasi daftar ulang';
    $button = '<button href="#" class="btn btn-block btn-warning btn-rounded" disabled><i class="fa fa-check"></i> Seleksi Selesai, menunggu konfirmasi daftar ulamg</button>';
} else if ($account->status == 5) {
    $color  = 'success';
    $status = 'Diterima ';
    $button = '<button href="#" class="btn btn-block btn-success btn-rounded" disabled><i class="fa fa-check"></i> Seleksi telah selesai, anda telah diterima</button>';
} else if ($account->status == 10) {
    $color  = 'danger';
    $status = 'Ditolak';
    $button = '<button href="#" class="btn btn-block btn-danger btn-rounded" disabled><i class="fa fa-times"></i> Mohon Maaf, anda belum bisa melanjutkan</button>';
}

?>
<div class="container mb-3" id="here">
    <!-- Detail Batch Course -->
    <div class="row">
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="text-uppercase"><?= $data_detail->title ?></h2>
                        <h5 class="text-muted mt-2 mb-4"><?= $category_course->name ?></h5>
                    </div>
                    <div class="col-md-3">
                        <div class="btn btn-<?= $color ?> btn-block btn-rounded"><?= $status ?></div>
                    </div>
                </div>
                <div class="row mt-5 mx-5">
                    <div class="col-md-12 mb-2">
                        <h6 class="text-uppercase text-muted">Tipe Pelatihan : </h6>
                        <p style="font-size: 16px;"><?= $course->name ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted">Jadwal Pelatihan</h6>
                        <p style="font-size: 16px;"><?= Modules::run('helper/date_indo', $data_detail->starting_date, '-') ?> - <?= Modules::run('helper/date_indo', $data_detail->ending_date, '-') ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted">Kuota Pelatihan</h6>
                        <p style="font-size: 16px;"><?= $data_detail->target_registrant ?> Peserta</p>
                    </div>
                </div>
                <div class="row mt-5 mb-3">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <?= $button ?>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <hr class="my-5">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <img src="<?= base_url('upload/batch/') . $data_detail->image ?>" class="mb-5" style="height: 400px; width: 100%; object-fit:cover; border-radius: 5%;">
                    </div>
                    <?= $data_detail->description ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Description Batch Course -->
</div>