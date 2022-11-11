<?php
$media = '';
if ($data_detail->media == 1) {
    $media .= '<span class="ml-3 badge badge-lg badge-success">O N L I N E</span>';
} else {
    $media .= '<span class="ml-3 badge badge-lg badge-primary">TATAP MUKA</span>';
}

$status     = '';

if (date($data_detail->starting_time) > date('Y-m-d H:i:sa')) {
    $status .= '<div class="btn btn-primary btn-block"><i class="fa fa-clock"></i> Belum Dimulai</div>';
} elseif (date($data_detail->ending_type) < date('Y-m-d H:i:sa')) {
    $status .= '<div class="btn btn-success btn-block"><i class="fa fa-check"></i> Sudah Selesai</div>';
} elseif (date($data_detail->starting_time < date('Y-m-d H:i:sa')) and date($data_detail->ending_type > date('Y-m-d H:i:sa'))) {
    $status .= '<div class="btn btn-warning btn-block"><i class="fa fa-history"></i> Sedang berlangsung</div>';
}

?>
<div class="container">
    <div class="row">
        <div class="card" id="here" style="width: 100%;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="text-uppercase"><i class="fa fa-book"></i> JUDUL PERTEMUAN : <?= $data_detail->title . " " . $media ?> </h5>
                    </div>
                    <div class="col-md-3">
                        <?= $status ?>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4 mr-0">
                        <h6 class="text-uppercase">Tanggal Pertemuan</h6>
                        <div class="pr-0">
                            <div class="p-2 bd" style="border-style: dashed;">
                                <p class="text-muted mb-0"><i class="fa fa-calendar-alt"></i> Tanggal Pertemuan</p>
                                <h6 class="text-uppercase mt-1"><?= Modules::run('helper/date_indo', $data_detail->date, '-') ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 mr-0 ml-0">
                        <h6 class="text-uppercase">Jam Pertemuan : </h6>
                        <div class="row">
                            <div class="col-md-6 pr-0">
                                <div class="p-2 bd" style="border-style: dashed;">
                                    <p class="text-muted mb-0"><i class="fa fa-clock"></i> Jam Mulai</p>
                                    <h6 class="text-uppercase mt-1"><?= $starting_time ?> WIB</h6>
                                </div>
                            </div>
                            <div class="col-md-6 pl-0">
                                <div class="p-2 bd" style="border-style: dashed;">
                                    <p class="text-muted mb-0"><i class="fa fa-clock"></i> Jam Selesai</p>
                                    <h6 class="text-uppercase mt-1"><?= $ending_time ?> WIB</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <h6 class="text-uppercase">JENIS PELATIHAN : </h6>
                        <div class="p-2 bd" style="border-style: dashed;">
                            <h6 class="text-uppercase text-center"><?= $batch_course->title ?></h6>
                        </div>
                    </div>
                    <div class="col-md-4 border-left border-right">
                        <div class="row">
                            <div class="col-md-8">
                                <p>Resume Absensi : </p>
                                <h1><?= $count_batch->total - $count->total ?><span class="text-success" style="font-size: 16px;"> PESERTA</span></h1>
                            </div>
                            <div class="col-md-4">
                                <p style="font-size: 12px;" class="mb-0">Total Peserta</p>
                                <h6><?= $count_batch->total ?> Peserta</h6>
                                <p style="font-size: 12px;" class="mb-0">Sudah Absen</p>
                                <h6><?= $count->total ?> Peserta</h6>
                            </div>
                            <?php
                            if ($count->total == 0) $count->total = 1;
                            $absensi = ($count->total / $count_batch->total) * 100;
                            $absensi = number_format($absensi);
                            ?>
                            <div class="col-md-12">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" role="progressbar" style="width: <?= $absensi ?>%;" aria-valuenow="<?= $absensi ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <p style="font-size: 12px; color:gray;" class="m-0">Presentase Sudah Absensi</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p style="font-size: 12px; color:gray;" class="text-right"><?= $absensi ?>%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="<?= base_url('upload/barcode/' . $data_detail->id . ".png") ?>" class="popupqrcode" style="width: 160px;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h5 class="text-uppercase"><i class="fas fa-book-open"></i> DESKRIPSI PERTEMUAN :</h5>
                    </div>
                </div>
                <?= $data_detail->description ?>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" id="id" value="<?= $data_detail->id ?>">

    <?php if (date($data_detail->starting_time) <= date('Y-m-d H:i:sa')) : ?>
        <div class="row mt-4">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h3>DAFTAR PESERTA</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="table_absensi" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th><span>No</span></th>
                                    <th><span>Nama Peserta</span></th>
                                    <th><span>Absensi</span></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="modal_absensi">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Absensi Peserta</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h6>Pilih Absensi</h6>
                <!-- Select2 -->
                <select class="form-control select2" id="status_attendance">
                    <?php foreach ($attendance as $value) : ?>
                        <option value="<?= $value->value ?>"><?= $value->label ?></option>
                    <?php endforeach; ?>
                </select>
                <!-- Select2 -->
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary btn_save" type="button">Save changes</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="popup">
    <div class="modal-dialog">
        <div class="modal-content">
            <img src="" class="img-responsive" style="width: 100%;"/>
        </div>
    </div>
</div>