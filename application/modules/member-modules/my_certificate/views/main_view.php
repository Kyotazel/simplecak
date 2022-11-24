<h2>Daftar Pelatihan</h2>

<div class="row">
    <?php foreach ($batch_course as $value) : ?>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h4><?= $value->title ?></h4>
                            <h6 class="text-muted"><?= $value->category_name ?></h6>
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
                            <button data-id="<?= urlencode($this->encrypt->encode($value->id)) ?>" class="btn btn-outline-primary btn-block btn-rounded btn_check">Lihat Sertifikat</button>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>