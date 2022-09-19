<h2>Daftar Pelatihan</h2>

<div class="row">
    <?php foreach ($batch_course as $value) : ?>
        <?php
            if ($value->course_status == 0){
                $color  = 'danger';
                $status = 'Belum Dikonfirmasi';
                $button = '<button href="#" class="btn btn-block btn-warning btn-rounded" disabled><i class="fa fa-times"></i> Sedang menunggu konfirmasi</button>';
            } else if($value->course_status == 1) {
                $color  = 'warning';
                $status = 'Seleksi Administrasi';
                $button = '<button href="#" class="btn btn-block btn-warning btn-rounded" disabled><i class="fa fa-book"></i> Seleksi Administrasi</button>';
            } else if ($value->course_status == 2) {
                $color  = 'warning';
                $status = 'Seleksi Ujian Online';
                $button = '<button href="#" class="btn btn-block btn-primary btn-rounded btn_join"><i class="fa fa-pen"></i> Ikuti Ujian</button>';
                $button = '<button href="#" class="btn btn-block btn-danger btn-rounded" disabled><i class="fa fa-times"></i> Ujian Belum Dimulai</button>';
            } else if ($value->course_status == 3) {
                $color  = 'warning';
                $status = 'Seleksi Wawancara';
                $button = '<button href="#" class="btn btn-block btn-warning btn-rounded" disabled><i class="fa fa-book"></i> Seleksi Wawancara</button>';
            } else if ($value->course_status == 4) {
                $color  = 'warning';
                $status = 'Menunggu Konfirmasi daftar ulang';
                $button = '<button href="#" class="btn btn-block btn-warning btn-rounded" disabled><i class="fa fa-check"></i> Seleksi Selesai, menunggu konfirmasi daftar ulamg</button>';
            } else if ($value->course_status == 5) {
                $color  = 'success';
                $status = 'Diterima ';
                $button = '<button href="#" class="btn btn-block btn-success btn-rounded" disabled><i class="fa fa-check"></i> Seleksi telah selesai, anda telah diterima</button>';
            } else if ($value->course_status == 10) {
                $color  = 'danger';
                $status = 'Ditolak';
                $button = '<button href="#" class="btn btn-block btn-danger btn-rounded" disabled><i class="fa fa-times"></i> Mohon Maaf, anda belum bisa melanjutkan</button>';
            }
        ?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h4><?= $value->title ?></h4>
                            <h6 class="text-muted"><?= $value->category_name ?></h6>
                        </div>
                        <div class="col-md-3">
                            <div class="btn btn-rounded btn-<?= $color ?> btn-block"><?= $status ?></div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted m-1"><i class="fa fa-clock"></i> Pelatihan : <?= Modules::run('helper/date_indo', $value->starting_date, '-') ?> - <?= Modules::run('helper/date_indo', $value->ending_date, '-') ?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted m-1"><i class="fa fa-users"></i> Kuota : <?= $value->target_registrant ?> Peserta</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <a href="<?= Modules::run('helper/create_url', 'my_course/detail?data=' . urlencode($this->encrypt->encode($value->id))) ?>" class="btn btn-outline-primary btn-block btn-rounded">Detail Status Pelatihan</a>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>