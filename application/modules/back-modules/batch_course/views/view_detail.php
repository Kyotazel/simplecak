<div class="container" id="here">
    <!-- Detail Batch Course -->
    <div class="row">
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="text-uppercase"><i class="fas fa-book-open"></i> NAMA PELATIHAN : <?= $data_detail->title ?></h5>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h6 class="text-uppercase">Tanggal Pendaftaran : </h6>
                        <div class="row">
                            <div class="col-md-6 pr-0">
                                <div class="p-2 bd" style="border-style: dashed;">
                                    <p class="text-muted mb-0"><i class="fa fa-calendar-alt"></i> Awal Pendaftaran</p>
                                    <h6 class="text-uppercase"><?= Modules::run("helper/date_indo", $data_detail->opening_registration_date, '-') ?></h6>
                                </div>
                            </div>
                            <div class="col-md-6 pl-0">
                                <div class="p-2 bd" style="border-style: dashed;">
                                    <p class="text-muted mb-0"><i class="fa fa-calendar-alt"></i> Akhir Pendaftaran</p>
                                    <h6 class="text-uppercase"><?= Modules::run("helper/date_indo", $data_detail->closing_registration_date, '-') ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-uppercase">Tanggal Pelatihan : </h6>
                        <div class="row">
                            <div class="col-md-6 pr-0">
                                <div class="p-2 bd" style="border-style: dashed;">
                                    <p class="text-muted mb-0"><i class="fa fa-calendar-alt"></i> Awal Pelatihan</p>
                                    <h6 class="text-uppercase"><?= Modules::run("helper/date_indo", $data_detail->starting_date, '-') ?></h6>
                                </div>
                            </div>
                            <div class="col-md-6 pl-0">
                                <div class="p-2 bd" style="border-style: dashed;">
                                    <p class="text-muted mb-0"><i class="fa fa-calendar-alt"></i> Akhir Pelatihan</p>
                                    <h6 class="text-uppercase"><?= Modules::run("helper/date_indo", $data_detail->ending_date, '-') ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <h6 class="text-uppercase">TIPE PELATIHAN : </h6>
                        <div class="p-2 bd" style="border-style: dashed;">
                            <h6 class="text-uppercase text-center"><?= $course->name ?></h6>
                        </div>
                    </div>
                    <div class="col-md-4 border-left border-right">
                        <div class="row">
                            <div class="col-md-8">
                                <p>Kuota Peserta : </p>
                                <h1><?= $data_detail->target_registrant - $count->total ?><span class="text-success" style="font-size: 16px;"> PESERTA</span></h1>
                            </div>
                            <div class="col-md-4">
                                <p style="font-size: 12px;" class="mb-0">Total Kuota</p>
                                <h6><?= $data_detail->target_registrant ?> Peserta</h6>
                                <p style="font-size: 12px;" class="mb-0">Total Terdaftar</p>
                                <h6><?= $count->total ?> Peserta</h6>
                            </div>
                            <?php
                            $kuota = ($count->total / $data_detail->target_registrant) * 100;
                            $kuota = number_format($kuota);
                            ?>
                            <div class="col-md-12">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" role="progressbar" style="width: <?= $kuota ?>%;" aria-valuenow="<?= $kuota ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <p style="font-size: 12px; color:gray;" class="m-0">Presentase Kuota Terdaftar</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p style="font-size: 12px; color:gray;" class="text-right"><?= $kuota ?>%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>BATAS PENDAFTARAN</h5>
                            </div>
                        </div>
                        <input type="hidden" name="end_date" id="end_date" value="<?= $data_detail->closing_registration_date ?>">
                        <div class="row expired d-none mt-4">
                            <div class="text-center">
                                <h2 class="text-danger">E X P I R E D</h2>
                            </div>
                        </div>
                        <div class="row not_expired mt-4">
                            <div class="col-md-3 p-0 border">
                                <div class="card-body py-1 px-0 text-center">
                                    <h4 class="text-primary"><span class="day"></span></h4>
                                    <h6 class="mb-0" style="font-size: 12px;">Hari</h6>
                                </div>
                            </div>
                            <div class="col-md-3 p-0 border">
                                <div class="card-body py-1 px-0 text-center">
                                    <h4 class="text-primary"><span class="hour"></span></h4>
                                    <h6 class="mb-0" style="font-size: 12px;">Jam</h6>
                                </div>
                            </div>
                            <div class="col-md-3 p-0 border">
                                <div class="card-body py-1 px-0 text-center">
                                    <h4 class="text-primary"><span class="minute"></span></h4>
                                    <h6 class="mb-0" style="font-size: 12px;">Menit</h6>
                                </div>
                            </div>
                            <div class="col-md-3 p-0 border">
                                <div class="card-body py-1 px-0 text-center">
                                    <h4 class="text-primary"><span class="second"></span></h4>
                                    <h6 class="mb-0" style="font-size: 12px;">Detik</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Detail Batch Course -->
    <!-- Description Batch Course -->
    <div class="row mt-4">
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h5 class="text-uppercase"><i class="fas fa-book-open"></i> KONTEN PELATIHAN :</h5>
                    </div>
                </div>
                <?= $data_detail->description ?>
            </div>
        </div>
    </div>
    <!-- End Description Batch Course -->
    <!-- Peserta Batch Course -->
    <div class="row my-3">
        <?php foreach ($data_profile as $value) : ?>
            <?php
            if ($value->confirm_batch == 1) {
                $btn_confirm    = "<button class='btn btn-block btn-success'><i class='fa fa-check'></i> Sudah Dikonfirmasi</button>";
            } else if($value->confirm_batch == 0) {
                $btn_confirm    = "<button class='btn btn-block btn-warning'><i class='fa fa-clock'></i> Belum Dikonfimasi</button>
                <button class='btn btn-block btn-primary' data-id='$value->batch_account_id' id='confirm_detail'><i class='fa fa-check'></i> Klik Untuk Konfirmasi</button>
                ";
            }
            ?>

            <div class="col-md-4 my-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-uppercase text-center"><i class="fa fa-user"></i> <?= $value->name ?> </h4>
                    </div>
                    <div class="card-body">
                        <div class="main-profile-overview text-center">
                            <div class="main-img-user profile-user">
                                <img alt="" src="<?= base_url('upload/member/') . $value->image ?>">
                            </div>
                            <div class=" mg-b-20">
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-12 border text-left">
                                    <div class="row p-2">
                                        <div class="col-md-4">
                                            <i class="fa fa-envelope"></i> Email :
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <?= $value->email ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- End Peserta Batch Course -->
</div>