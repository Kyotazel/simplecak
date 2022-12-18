<style>
    @media (max-width: 576px) {
        .vacancy_profile {
            height: 150px;
        }
        .job-desc {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
    }
</style>
<div class="container">
    <div class="row row-sm">
        <div class="col-sm-12 col-md-8 mb-3">
            <div class="card">
                <div class="card-header mb-0">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 vacancy_profile">
                            <img src="<?= base_url('upload/company/') . $company->image ?>" alt="Logo <?= $company->name ?>" class="img-rounded-circle border-3 rounded-circle shadow-lg" style="position: absolute; margin-left: auto; margin-right: auto;right: 0;left: 0;width: 150px;height: 150px;">
                        </div>
                        <div class="col-sm-12 col-md-8">
                            <h3><?= $detail_vacancy->job_name ?></h2>
                        </div>
                        <div class="pos-absolute r-5 t-10">
                            <a class="btn btn-outline-primary btn-rounded" href="<?= base_url('industry-area/job_vacancy/edit?data=') . $this->encrypt->encode($detail_vacancy->id) ?>"><i class="mdi mdi-wrench mr-2"></i>Edit</a>
                        </div>
                        <div class="pos-absolute l-5 t-10">
                            <a class="btn float-start mr-2 text-dark btn-rounded tx-18" href="<?= base_url('industry-area/job_vacancy') ?>">
                                <i class="mdi mdi-arrow-left-thick"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-1">
                    <div class="row">
                        <div class="col-sm-12 col-md-4"></div>
                        <div class="col-sm-12 col-md-8">
                            <p class="text-muted m-0"><?= $company->name ?></p>
                            <p class="text-muted">
                                <i class="zmdi zmdi-pin mr-2"></i>
                                <?= $detail_vacancy->job_address ?>
                            </p>
                        </div>
                    </div>
                    <div class="row mt-5 pt-3 job-desc">
                        <div class="col-12">
                            <?= $detail_vacancy->job_desc ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>
                                        <i class="fa fa-industry"></i>
                                        Info Perusahaan
                                    </h5>
                                </div>
                                <div class="col-12 ht-100 overflow-hidden">
                                    <?= empty($company->description) ? 
                                        '<p class="text-muted mb-0">Profil kosong...</p>' : 
                                        $company->description . '<br><a class="btn btn-rounded-circle btn-gradient-primary d-none" href="#profile">Lihat Perusahaan</a>' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Info Tambahan</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 d-flex justify-content-between">
                                    <div class="flex-end">
                                        <p class="mb-0 tx-bold">Status Lowongan</p>
                                        <small class="text-danger">* Check untuk aktifkan lowongan</small>
                                    </div>
                                    <div class="flex-start">
                                        <div data-status="status" data-id="<?= $this->encrypt->encode($detail_vacancy->id) ?>" class="main-toggle main-toggle-dark ml-auto change_status <?= $detail_vacancy->vacancy_status ? 'on' : '' ?> <?= $disabled ?>">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0 tx-bold">
                                        <i class="mdi mdi-backup-restore mr-1"></i>
                                        Lowongan ditutup
                                    </p>
                                    <p class="mb-1 <?= !empty($disabled) ? 'text-danger' : 'text-success' ?>">
                                    <?php 
                                            echo Modules::run('helper/date_indo', $end_vacancy, '-') ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-12">
                                    <p class="mb-0 tx-bold">
                                        <i class="mdi mdi-account-location mr-1"></i>
                                        Posisi</p>
                                </div>
                                <div class="col-sm-12">
                                    <span class="badge badge-primary"><?= $detail_vacancy->position ?></span>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-12">
                                    <p class="mb-0 tx-bold">
                                        <i class="si si-wallet mr-1"></i>
                                        Gaji
                                    </p>
                                </div>
                                <div class="col-sm-12">
                                    <?php if ($detail_vacancy->minimum_salary == $detail_vacancy->maximum_salary) : ?>
                                        <p class="mb-0 tx-bold"><?= 'Rp ' . number_format($detail_vacancy->minimum_salary, 0, '', '.') ?></p>
                                    <?php else : ?>
                                        <p class="mb-0 tx-bold"><?= 'Rp ' . number_format($detail_vacancy->minimum_salary, 0, '', '.') . ' - ' . number_format($detail_vacancy->maximum_salary, 0, '', '.') ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-12">
                                    <p class="mb-0 tx-bold">
                                        <i class="fa fa-graduation-cap"></i>
                                        Minimal Pendidikan</p>
                                </div>
                                <div class="col-sm-12 text-light">
                                    <?php foreach ($education as $value) : ?>
                                        <?php if ($value->education == 0) : ?>
                                            <span class="badge bg-primary">Tidak dibatasi</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary"><?= Modules::run('database/find', 'tb_education', ['id' => $value->education])->row()->name; ?></span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-12">
                                    <p class="mb-0 tx-bold">
                                        <i class="fa fa-street-view"></i>
                                         Bidang pekerjaan</p>
                                </div>
                                <div class="col-sm-12">
                                    <span class="badge badge-primary"><?= Modules::run('database/find', 'tb_work_field', ['id' => $detail_vacancy->work_field])->row()->name ?></span>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-12">
                                    <p class="mb-0 tx-bold">
                                        <i class="zmdi zmdi-flare"></i>
                                        Keahlian yang dibutuhkan</p>
                                </div>
                                <div class="col-sm-12 text-light">
                                    <?php foreach ($skill as $value) : ?>
                                        <span class="badge bg-primary"><?= Modules::run('database/find', 'tb_skill', ['id' => $value->skill])->row()->name ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-12">
                                    <p class="mb-0 tx-bold">
                                        <i class="mdi mdi-account-card-details"></i>
                                         Jenis pekerjaan</p>
                                </div>
                                <div class="col-sm-12">
                                    <span class="badge badge-primary"><?= $employment ?></span>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-12">
                                    <p class="mb-0 tx-bold">
                                        <i class="zmdi zmdi-hourglass-alt"></i>
                                         Min. Pengalaman</p>
                                </div>
                                <div class="col-sm-12">
                                    <span class="badge badge-primary">
                                    <?php if ((int) $detail_vacancy->experience == 0) : ?>
                                        Fresh Graduate
                                    <?php else : ?>
                                        <?= $detail_vacancy->experience . ' Tahun' ?>
                                    <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-12">
                                    <p class="mb-0 tx-bold">
                                        <i class="si si-people"></i>
                                        Gender</p>
                                </div>
                                <div class="col-sm-12">
                                    <span class="badge badge-primary"><?= $gender ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>