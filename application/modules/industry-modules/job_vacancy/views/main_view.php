<div class="container">
    <div class="row row-sm">
        <div class="col-12 text-right">
            <a class="btn btn-rounded btn-primary d-none btn_create">
                <i class="si si-paper-plane"></i>
                Buat Lowongan
            </a>
            <button class="btn btn-rounded btn-pink d-none">
                <i class="si si-trash"></i>
                Hapus Lowongan
            </button>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-sm-12 col-md-3">
            <a href="<?= base_url('industry-area/job_vacancy/create') ?>" class="card text-primary shadow-lg btn_create">
                <div class="card-body text-center">
                    <i class="si si-briefcase tx-50"></i>
                    <p class="mt-2 text-card align-self-center fw-bold">
                        Buat Lowongan
                    </p>
                </div>
            </a>
        </div>
        <?php foreach ($vacancy as $value) : ?>
            <?php 
            $company = Modules::run('database/find', 'tb_industry', ['id' => $value->id_industry])->row(); 
            $date = date_diff(date_create($value->created_date), date_create(date('Y-m-d'))); 
            ?>
            <div class="col-sm-12 col-md-3">
                <?php if ($value->vacancy_status) : ?>
                    <div class="pos-absolute t-10 l-20 z-index-10 text-success">
                        <span class="d-inline-block rounded-circle bg-success" style="width: 18px;height: 18px;"></span>
                        <p class="text-muted d-inline ml-1 pb-2" style="vertical-align: top;">Aktif</p>
                    </div>
                <?php else: ?>
                    <div class="pos-absolute t-10 l-20 z-index-10 text-danger">
                        <span class="d-inline-block rounded-circle bg-danger" style="width: 18px;height: 18px;"></span>
                        <p class="text-muted d-inline ml-1 pb-2" style="vertical-align: top;">Non-Aktif</p>
                    </div>
                <?php endif; ?>
                <button class="btn btn-rounded text-danger tx-20 bd-none pos-absolute r-10 t-0 btn_delete z-index-10" data-id="<?= $this->encrypt->encode($value->id) ?>">
                    <i class="si si-close tx-bold"></i>
                </button>
                <a href="<?= base_url('industry-area/job_vacancy/detail?data=') . $this->encrypt->encode($value->id) ?>" class="card text-primary shadow-lg">
                    <div class="card-header text-center mb-0">
                        <img src="<?= base_url('upload/company/') .$company->image ?>" alt="company profile <?= $company->image ?>" class="rounded-circle shadow-lg" style="width: 100px; height: 100px;">
                        <h5><?= $value->job_name ?></h5>
                        <p class="text-muted m-0"><?= $company->name ?></p>
                        <p class="text-muted">
                            <i class="zmdi zmdi-pin mr-2"></i>
                            <?= $value->job_address ?>
                        </p>
                    </div>
                    <div class="card-body text-center pt-0 pb-0">
                        <p class="text-card mb-0">
                            <i class="si si-wallet mr-1"></i>
                            <?php if ($value->minimum_salary == $value->maximum_salary) : ?>
                                <?= 'Rp ' . number_format($value->minimum_salary, 0, '', '.') ?>
                            <?php else : ?>
                                <?= 'Rp ' . number_format($value->minimum_salary, 0, '', '.') . ' - ' . number_format($value->maximum_salary, 0, '', '.') ?>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="card-footer text-right">
                        <p class="text-muted">
                            <i class="mdi mdi-update"></i>
                            <?= $date->format("%a Hari yang lalu") ?> 
                        </p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="container d-none">
    <div class="row row-sm">
        <div class="col-sm-12 col-md-3 text-center">
            <button class="btn btn-primary btn-rounded">
                <i class="si si-paper-plane"></i>
                Buat
            </button>
            <button class="btn btn-pink btn-rounded">
                <i class="si si-trash"></i>
                Hapus
            </button>
        </div>
        <div class="col-sm-12 col-md-9">
            <input type="text" name="search_job" id="search_job" class="form-control bd bd-primary rounded-5" placeholder="Cari Lowongan">
            <button class="btn">
                <i class="fe fe-search pos-absolute r-20 t-10 text-primary"></i>
            </button>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-sm-12 col-md-3"></div>
        <div class="col-sm-12 col-md-9"></div>
    </div>
</div>