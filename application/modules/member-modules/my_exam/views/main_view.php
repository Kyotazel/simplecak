<?php if (!empty($examination)) : ?>
    <div class="row">
        <?php foreach ($examination as $value) : ?>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center text-uppercase text-primary mb-4"><?= $value->name ?></h5>
                        <div class="row mt-3">
                            <div class="col-md-3">Oleh</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8"><b class="badge badge-sm badge-primary text-light"><?= $value->creator_name ?></b></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-3">Soal</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8">
                                <div class="badge badge-sm badge-primary"><?= $value->course_name ?></div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-3">Waktu</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8">
                                <div class="badge badge-sm badge-primary"><?= $value->processing_time ?> Menit</div>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button onclick="show_exam(<?= $value->id ?>)" class="btn btn-outline-primary px-4"><i class="fa fa-paper-plane"></i> Masuk Ujian</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php else : ?>
    <div class="card">
        <div class="card-body">
            <h2 class="text-center">TIDAK ADA UJIAN BERLANGSUNG</h2>
        </div>
    </div>
<?php endif ?>

<div class="modal fade" id="modal_start" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modal">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="html_start"></div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>