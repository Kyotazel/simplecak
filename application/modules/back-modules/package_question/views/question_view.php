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

<div class="row mt-2">
    <div class="col-md-5">
        <div class="card" style="min-height: 160px;">
            <div class="card-body">
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
                <div class="row py-2">
                    <div class="col-md-3">Dibuat Oleh</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-8"><?= $data_detail->creator_name ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card" style="min-height: 160px;">
            <div class="card-body">
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
                            <div class="col-md-4"><i class="fa fa-question text-primary" style="font-size: 48px;"></i></div>
                            <div class="col-md-8">
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
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', "package_question/question/add/$data_detail->id") . '" class="btn btn-primary my-1 "> <i class="fa fa-plus-circle"></i> Tambah Soal</a>'); ?>
    </div>
</div>

<?php foreach ($answer as $question) : ?>

    <?php
    $all_answer = json_decode($question->json_answer, true);
    ?>

    <div class="card mt-2">
        <div class="card-header bg-primary text-light">
            <h4 id="no_soal">Soal No. <?= $no_soal++ ?></h4>
        </div>
        <div class="card-body">
            <input type="hidden" name="id_parent" id="id_parent" value="<?= $data_detail->id ?>">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12" id="soal">
                            <?= $question->text_question ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11 ml-4">
                            <label class="rdiobox mt-2"><input name="answer_<?= $question->id ?>" value="1" type="radio">
                                <span id="answer_1">
                                    <?= $all_answer[1] ?>
                                </span>
                            </label>
                            <label class="rdiobox mt-2"><input name="answer_<?= $question->id ?>" value="2" type="radio">
                                <span id="answer_2">
                                    <?= $all_answer[2] ?>
                                </span>
                            </label>
                            <label class="rdiobox mt-2"><input name="answer_<?= $question->id ?>" value="3" type="radio">
                                <span id="answer_3">
                                    <?= $all_answer[3] ?>
                                </span>
                            </label>
                            <label class="rdiobox mt-2"><input name="answer_<?= $question->id ?>" value="4" type="radio">
                                <span id="answer_4">
                                    <?= $all_answer[4] ?>
                                </span>
                            </label>
                            <label class="rdiobox mt-2"><input name="answer_<?= $question->id ?>" value="5" type="radio">
                                <span id="answer_5">
                                    <?= $all_answer[5] ?>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-right">
                    <div class="btn btn-primary btn-block m-0">Jawaban : </div>
                    <div class="btn btn-success btn-block m-0 mb-5"><?= $all_answer[$question->answer] ?></div>
                    <?= Modules::run('security/edit_access', ' <a href="' . Modules::run('helper/create_url', "package_question/question/edit/$id?data=" . urlencode($this->encrypt->encode($question->id))) . '" class="btn btn btn-secondary btn-block"><i class="fas fa-edit"></i> Edit Soal</a>'); ?>
                </div>
            </div>
        </div>
    </div>

<?php endforeach ?>

<div class="row mt-2">
    <div class="col-md-12">
        <?= $this->pagination->create_links(); ?>
    </div>
</div>