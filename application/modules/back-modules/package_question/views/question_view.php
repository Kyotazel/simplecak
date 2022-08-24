<?php
    $btn_back = "<a href='" . Modules::run('helper/create_url', '/package_question') . "' class='btn btn-primary'><i class='fa fa-arrow-circle-left'></i> Lihat Data</a>";
?>
<div class="row">
    <div class="col-md-12">
    <?= $btn_back; ?>
    </div>
</div>
<div class="card mt-2">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row py-2">
                    <div class="col-md-3">Nama</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-8"><?= $name ?></div>
                </div>
                <div class="row py-2">
                    <div class="col-md-3">Tipe Soal</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-8"><?= $type ?></div>
                </div>
                <div class="row py-2">
                    <div class="col-md-3">Dibuat Oleh</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-8"><?= $creator ?></div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
    </div>
</div>