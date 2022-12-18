<?php
    switch ($job->employment_status) {
        case '0':
            $employment = 'Fulltime';
            break;
        case '1':
            $employment = 'Parttime';
            break;
        case '2':
            $employment = 'Kontrak';
            break;
        case '3':
            $employment = 'Magang';
            break;
        default:
            
            break;
    }

    switch ($job->applicant_gender) {
        case '0':
            $gender = 'Perempuan';
            break;
        case '1':
            $gender = 'Laki-Laki';
            break;        
        case '2':
            $gender = 'Laki-Laki & Perempuan';
            break;    
        default:
            # code...
            break;
    }
?>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="main-profile-overview text-center">
                    <div class="main-img-user profile-user">
                        <img alt="" src="<?= base_url('upload/company/') . $job->image ?>">
                    </div>
                    <div class=" mg-b-20">
                        <div>
                            <h5 class="text-dark"><?= $job->job_name; ?></h5>
                            <p class="text-muted m-0"><?= $job->company_name ?></p>
                            <p class="text-muted">
                                <i class="zmdi zmdi-pin mr-2"></i>
                                <?= $job->job_address ?>
                            </p>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12 border text-left">
                            <div class="row p-2">
                                <div class="col-md-4">
                                    <i class="si si-wallet mr-1"></i> Gaji :
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <?php if ($job->minimum_salary == $job->maximum_salary) : ?>
                                            <?= 'Rp ' . number_format($job->minimum_salary, 0, '', '.') ?>
                                        <?php else : ?>
                                            <?= 'Rp ' . number_format($job->minimum_salary, 0, '', '.') . ' - ' . number_format($job->maximum_salary, 0, '', '.') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 border text-left">
                            <div class="row p-2">
                                <div class="col-md-4">
                                    <i class="si si-briefcase mr-1"></i> Bidang :
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <?= $job->work_field_name ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 border text-left">
                            <div class="row p-2">
                                <div class="col-md-12">
                                    <button class="btn btn-block btn-primary">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-3">
                <nav class="nav nav-tabs">
                    <a class="btn btn-outline-primary active mr-3" data-toggle="tab" href="#tabCont1">Detail Pekerjaan</a>
                    <a class="btn btn-outline-primary" data-toggle="tab" href="#tabCont2">Keterangan</a>
                </nav>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabCont1">
                        <div>
                            <b style="font-size: 16px;">Minimal Pendidikan</b><br>
                            <span>
                                <ul style="padding: 0px">
                                    <?php foreach (Modules::run('database/find', 'tb_job_vacancy_has_education', ['id_job_vacancy' => $job->job_id])->result() as $value) : ?>
                                        <?php if ($value->education == 0) : ?>
                                            <li>- Tidak dibatasi</li>
                                        <?php else : ?>
                                            <li>- <?= Modules::run('database/find', 'tb_education', ['id' => $value->education])->row()->name ?></li>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </ul>
                            </span>
                            <hr>
                        </div>
                        <div class="mt-4">
                            <b style="font-size: 16px;">Jenis Pekerjaan</b><br>
                            <span>
                                <?= $employment ?>
                            </span>
                            <hr>
                        </div>
                        <div class="mt-4">
                            <b style="font-size: 16px;">Jenis Kelamin</b><br>
                            <span>
                                <?= $gender ?>
                            </span>
                            <hr>
                        </div>
                        <div class="mt-4">
                            <b style="font-size: 16px;">Minimal Pengalaman</b><br>
                            <span>
                                <?= $job->experience ?> Tahun
                            </span>
                            <hr>
                        </div>
                        <div class="mt-4">
                            <b style="font-size: 16px;">Lamaran Ditutup</b><br>
                            <span>
                                <?= Modules::run('helper/date_indo', $job->end_vacancy, '-') ?>
                            </span>
                            <hr>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabCont2">
                        <?= $job->job_desc ?>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>