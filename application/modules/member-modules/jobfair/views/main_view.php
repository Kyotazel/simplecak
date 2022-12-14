<?php if($vacancy) : ?>
<div class="container">
    <div class="row row-sm">
        <?php foreach ($vacancy as $value) : ?>
            <?php
            $company = Modules::run('database/find', 'tb_industry', ['id' => $value->id_industry])->row();
            $date = date_diff(date_create($value->created_date), date_create(date('Y-m-d')));
            ?>
            <div class="col-sm-12 col-md-3">
                <a href="<?= Modules::run('helper/create_url', 'jobfair/detail/' . $value->id) ?>" class="card text-primary">
                    <div class="card-header text-center mb-0">
                        <img src="<?= base_url('upload/company/') . $company->image ?>" alt="company profile <?= $company->image ?>" class="rounded-circle shadow-lg" style="width: 100px; height: 100px;">
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
<?php else: ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2>Tidak ada lowongan tersedia</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif ?>