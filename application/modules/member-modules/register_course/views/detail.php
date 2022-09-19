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
                    <div class="col-md-6">
                        <h6 class="text-uppercase">TIPE PELATIHAN : </h6>
                        <div class="p-2 bd" style="border-style: dashed;">
                            <h6 class="text-uppercase text-center"><?= $course->name ?></h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>BATAS PENDAFTARAN</h5>
                            </div>
                        </div>
                        <input type="hidden" name="end_date" id="end_date" value="<?= $data_detail->closing_registration_date ?>">
                        <div class="row expired d-none">
                            <div class="text-center">
                                <h2 class="text-danger">E X P I R E D</h2>
                            </div>
                        </div>
                        <div class="row not_expired">
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
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-block btn-primary mt-2" id="daftar" data-id="<?= $data_detail->id ?>"><i class="fab fa-telegram-plane"></i> IKUTI PELATIHAN</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Detail Batch Course -->
    <!-- Description Batch Course -->
    <div class="row mt-4 mb-3">
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h5 class="text-uppercase"><i class="fas fa-book-open"></i> KONTEN PELATIHAN :</h5>
                    </div>
                </div>
                <div>
                    <img src="<?= base_url('upload/batch/') . $data_detail->image ?>" class="mb-5" style="height: 400px; width: 100%; object-fit:cover; border-radius: 5%;">
                </div>
                <?= $data_detail->description ?>
            </div>
        </div>
    </div>
    <!-- End Description Batch Course -->
</div>