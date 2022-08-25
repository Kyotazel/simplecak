<?php
$btn_back   = "<a href='" . Modules::run('helper/create_url', '/package_question') . "' class='btn btn-primary'><i class='fa fa-arrow-circle-left'></i> Lihat Data</a>";
$btn_edit   = Modules::run('security/edit_access', '<a href="' . Modules::run('helper/create_url', 'package_question/edit?data=' . urlencode($this->encrypt->encode($data_detail->id))) . '" class="btn btn-success mr-2"><i class="fa fa-edit"></i> Edit Data</a>');
$btn_delete = Modules::run('security/delete_access', '<a href="javascript:void(0)" data-id="' . urlencode($this->encrypt->encode($data_detail->id)) . '" data-redirect="1" class="btn_delete btn btn-danger"><i class="fa fa-trash"></i> Hapus Data</a>');
?>
<div class="row">
    <div class="col-md-6">
        <?= $btn_back; ?>
    </div>
    <div class="col-md-6 text-right">
        <?= $btn_edit . $btn_delete ?>
    </div>
</div>
<div class="card mt-2">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <div class="row py-2">
                    <div class="col-md-3">Nama</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-8"><?= $data_detail->name ?></div>
                </div>
                <div class="row py-2">
                    <div class="col-md-3">Tipe Soal</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-8"><?= $type ?></div>
                </div>
                <div class="row py-2 mb-3">
                    <div class="col-md-3">Dibuat Oleh</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-8"><?= $data_detail->creator_name ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row mt-4">
                            <div class="col-md-4"><i class="fas fa-graduation-cap text-primary" style="font-size: 48px;"></i></div>
                            <div class="col-md-8">
                                <p class="mb-0">Nilai Lulus</p>
                                <h4><?= $data_detail->min_value_graduation ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mt-4">
                            <div class="col-md-3"><i class="fa fa-question text-primary" style="font-size: 48px;"></i></div>
                            <div class="col-md-9">
                                <p class="mb-0">Jumlah Soal</p>
                                <h4><?= $count->total ?> Soal</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mt-4">
                            <div class="col-md-4"><i class="fa fa-users text-primary" style="font-size: 48px;"></i></div>
                            <div class="col-md-8">
                                <p class="mb-0">Telah Diujikan</p>
                                <h4>20 Peserta</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <input type="hidden" name="id_parent" id="id_parent" value="<?= $data_detail->id ?>">
        <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', "package_question/question/add/$data_detail->id") . '" class="btn btn-primary my-1 "> <i class="fa fa-plus-circle"></i> Tambah Soal</a>'); ?>
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover" id="table_question" style="width: 100%;">
                <thead>
                    <tr>
                        <th><span>No</span></th>
                        <th><span>Pertanyaan</span></th>
                        <th><span>Aksi</span></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>