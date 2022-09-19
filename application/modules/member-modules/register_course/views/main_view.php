<!-- 
<style>
    .parent {
  margin:100px 0 0;
  width:100%;
  border-bottom:2px solid #CCC;
  position:relative;
  z-index:-1;
}

.parent:before,.parent:after,.child {
  background:#CCC;
  width:15px;
  height:15px;
  border-radius:50%;
  border:1px solid #CCC;
  position:absolute;
  content:'';
  top:-8px;
}

.parent:before {
  left:0;
}

.parent:after {
  right:0;
}

.child {
  left:50%;
  margin-left:-8px;
}
</style> -->

<h2>Daftar Pelatihan</h2>

<div class="row">
    <?php foreach ($batch_course as $value) : ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h4><?= $value->title ?></h4>
                            <h6 class="text-muted"><?= $value->category_name ?></h6>
                        </div>
                        <div class="col-md-3">
                            <?= ($value->closing_registration_date > date('Y-m-d')) ? '<div class="btn btn-rounded btn-outline-success px-4">Dibuka</div>' : '<div class="btn btn-rounded btn-outline-danger px-4">Ditutup</div>' ?>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted m-1"><i class="fa fa-clock"></i> Registrasi : <?= Modules::run('helper/date_indo', $value->opening_registration_date, '-') ?> - <?= Modules::run('helper/date_indo', $value->closing_registration_date, '-') ?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted m-1"><i class="fa fa-users"></i> Kuota : <?= $value->target_registrant ?> Peserta</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <a href="<?= Modules::run('helper/create_url', 'register_course/detail?data=' . urlencode($this->encrypt->encode($value->id))) ?>" class="btn btn-outline-primary btn-block btn-rounded">Lihat Informasi</a>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>